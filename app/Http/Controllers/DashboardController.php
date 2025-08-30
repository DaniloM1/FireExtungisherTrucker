<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Device;
use App\Models\Hydrant;
use App\Models\Location;
use App\Models\LocationCheck;
use App\Models\ServiceEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now         = Carbon::now();
        $fifteenDays = $now->copy()->addDays(15);
        $threeMonths = $now->copy()->addMonths(3);

        $this->consolidateServiceEvents($now, $fifteenDays);

        // 15-day service events (samo active + done)
        $serviceEvents = ServiceEvent::with(['locations.company'])
            ->whereIn('status', ['active','done'])
            ->whereBetween('next_service_date', [$now->toDateString(), $fifteenDays->toDateString()])
            ->orderBy('next_service_date')
            ->paginate(12);

        $serviceEvents->getCollection()->each(fn ($e) => $this->calculateActiveDevices($e));

        // 15-day electrical inspections
        $locationChecks = LocationCheck::with('location.company')
            ->whereIn('type', ['inspection', 'test'])
            ->whereBetween('next_due_date', [$now->toDateString(), $fifteenDays->toDateString()])
            ->orderBy('next_due_date')
            ->get();

        // companies needing service (samo active + done)
        $companiesNeedingService = DB::table('companies')
            ->join('locations', 'companies.id', '=', 'locations.company_id')
            ->join('service_event_locations', 'locations.id', '=', 'service_event_locations.location_id')
            ->join('service_events', 'service_event_locations.service_event_id', '=', 'service_events.id')
            ->select(
                'companies.id',
                'companies.name',
                'companies.city',
                'companies.pib',
                DB::raw('MIN(service_events.next_service_date) as next_service_date')
            )
            ->whereIn('service_events.status', ['active','done'])
            ->whereBetween('service_events.next_service_date', [$now->toDateString(), $fifteenDays->toDateString()])
            ->groupBy('companies.id', 'companies.name', 'companies.city', 'companies.pib')
            ->orderBy('next_service_date')
            ->get();

        // city groups + trends
        [$cities, $citySummaries] = $this->groupByCities($serviceEvents);
        $serviceTrends = $this->getServiceTrends($now, $threeMonths);
        $deviceTrends  = $this->getDeviceTrends($now, $threeMonths);

        // full-year important dates (samo active + done)
        $yearStart = $now->copy()->startOfYear()->toDateString();
        $yearEnd   = $now->copy()->endOfYear()->toDateString();

        $serviceEventsForYear = ServiceEvent::with(['locations.company'])
            ->whereIn('status', ['active','done'])
            ->whereBetween('next_service_date', [$yearStart, $yearEnd])
            ->orderBy('next_service_date')
            ->get();

        $locationChecksForYear = LocationCheck::with('location.company')
            ->whereIn('type', ['inspection', 'test'])
            ->whereBetween('next_due_date', [$yearStart, $yearEnd])
            ->orderBy('next_due_date')
            ->get();

        $importantDates = [];

        foreach ($serviceEventsForYear as $event) {
            $importantDates[] = [
                'id'          => 'service-'.$event->id,
                'date'        => $event->next_service_date->format('Y-m-d'),
                'type'        => 'Servis',
                'label'       => "Servis #{$event->id}",
                'description' => $event->category,
                'url'         => route('service-events.show', $event->id),
            ];
        }

        foreach ($locationChecksForYear as $check) {
            $importantDates[] = [
                'id'          => "{$check->type}-{$check->id}",
                'date'        => Carbon::parse($check->next_due_date)->format('Y-m-d'),
                'type'        => ucfirst($check->type),
                'label'       => ucfirst($check->type) . " #{$check->id}",
                'description' => $check->location->name,
                'url'         => route('location_checks.show', $check->id),
            ];
        }

        usort($importantDates, fn ($a, $b) => strcmp($a['date'], $b['date']));

        return view('admin.dashboard.index', compact(
            'serviceEvents',
            'locationChecks',
            'companiesNeedingService',
            'cities',
            'citySummaries',
            'serviceTrends',
            'deviceTrends',
            'importantDates'
        ));
    }

    /**
     * Konsoliduje servisne događaje na osnovu preklapanja lokacija.
     */
    private function consolidateServiceEvents(Carbon $start, Carbon $end)
    {
        $events = ServiceEvent::whereIn('status', ['active','done'])
            ->whereBetween('next_service_date', [$start->toDateString(), $end->toDateString()])
            ->with('locations')
            ->orderBy('next_service_date', 'asc')
            ->get();

        $grouped = $events->groupBy('category');

        foreach ($grouped as $category => $items) {
            $items = $items->values();
            for ($i = 0; $i < count($items); $i++) {
                $newEvent = $items[$i];
                $newLocations = $newEvent->locations->pluck('id');

                for ($j = $i + 1; $j < count($items); $j++) {
                    $existingEvent = $items[$j];
                    $existingLocations = $existingEvent->locations->pluck('id');
                    $common = $newLocations->intersect($existingLocations);

                    if ($common->isNotEmpty()) {
                        if ($existingLocations->diff($common)->isEmpty()) {
                            $existingEvent->update(['status' => 'inactive']);
                            foreach ($existingEvent->locations as $location) {
                                $existingEvent->locations()->updateExistingPivot($location->id, ['status' => 'inactive']);
                            }
                        } else {
                            foreach ($common as $locationId) {
                                $existingEvent->locations()->updateExistingPivot($locationId, ['status' => 'inactive']);
                            }
                        }
                    }
                }
            }
        }
    }

    private function calculateActiveDevices($event)
    {
        $locationIds = $event->locations->pluck('id');
        $model = match ($event->category) {
            'pp_device' => Device::class,
            'hydrant'   => Hydrant::class,
            default     => null,
        };

        $event->activeDevices = $model
            ? $model::whereIn('location_id', $locationIds)
                ->whereIn('status', ['active','done'])
                ->count()
            : 0;
    }

    private function groupByCities($serviceEvents)
    {
        $cities = [];
        $citySummaries = [];
        $cityEventIds = [];

        foreach ($serviceEvents as $event) {
            $eventDate = Carbon::parse($event->next_service_date);
            foreach ($event->locations as $location) {
                if (!isset($location->pivot) || !in_array($location->pivot->status, ['active','done'])) {
                    continue;
                }

                $city = $location->city;
                if (!isset($cities[$city])) {
                    $cities[$city] = collect();
                    $citySummaries[$city] = [
                        'event_count'       => 0,
                        'next_service_date' => $event->next_service_date,
                    ];
                    $cityEventIds[$city] = [];
                }

                $existing = $cities[$city]->firstWhere('id', $location->id);
                if ($existing) {
                    if ($eventDate->lessThan(Carbon::parse($existing->computed_next_service_date))) {
                        $existing->computed_next_service_date = $event->next_service_date;
                        $existing->service_event_id = $event->id;
                    }
                } else {
                    $location->computed_next_service_date = $event->next_service_date;
                    $location->service_event_id = $event->id;
                    $cities[$city]->push($location);
                }

                if (!in_array($event->id, $cityEventIds[$city])) {
                    $citySummaries[$city]['event_count']++;
                    $cityEventIds[$city][] = $event->id;
                }

                if (Carbon::parse($event->next_service_date)->lessThan(Carbon::parse($citySummaries[$city]['next_service_date']))) {
                    $citySummaries[$city]['next_service_date'] = $event->next_service_date;
                }
            }
        }

        uasort($citySummaries, function ($a, $b) {
            return Carbon::parse($a['next_service_date'])->timestamp <=> Carbon::parse($b['next_service_date'])->timestamp;
        });

        return [$cities, $citySummaries];
    }

    private function getServiceTrends($start, $end)
    {
        return ServiceEvent::select(
            DB::raw('YEAR(next_service_date) as year'),
            DB::raw('MONTH(next_service_date) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereBetween('next_service_date', [$start->toDateString(), $end->toDateString()])
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
    }

    private function getDeviceTrends($start, $end)
    {
        $events = ServiceEvent::with('locations')
            ->whereBetween('next_service_date', [$start->toDateString(), $end->toDateString()])
            ->get()
            ->each(function ($event) {
                $this->calculateActiveDevices($event);
            });

        $trends = [];
        foreach ($events as $event) {
            $date = Carbon::parse($event->next_service_date);
            $key = $date->format('Y-m');

            if (!isset($trends[$key])) {
                $trends[$key] = [
                    'year'          => $date->year,
                    'month'         => $date->month,
                    'total_devices' => 0,
                ];
            }

            $trends[$key]['total_devices'] += $event->activeDevices;
        }

        ksort($trends);
        return array_values($trends);
    }
}
