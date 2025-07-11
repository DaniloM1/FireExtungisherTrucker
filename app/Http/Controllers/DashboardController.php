<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Device;
use App\Models\Hydrant;
use App\Models\Location;
use App\Models\ServiceEvent;
use App\Models\ElectricalInspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $fifteenDays = $now->copy()->addDays(15);
        $threeMonths = $now->copy()->addMonths(3);

        $this->consolidateActiveServiceEvents($now, $fifteenDays);

        // Učitavanje aktivnih servisnih događaja za narednih 15 dana
        $serviceEvents = ServiceEvent::with(['locations.company'])
            ->where('status', 'active')
            ->whereBetween('next_service_date', [$now->toDateString(), $fifteenDays->toDateString()])
            ->orderBy('next_service_date', 'asc')
            ->paginate(12);
        $serviceEvents->getCollection()->each(function ($event) {
            $this->calculateActiveDevices($event);
        });

        // Učitavanje električnih inspekcija za narednih 15 dana
        $electricalInspections = ElectricalInspection::with('location.company')
            ->whereBetween('next_inspection_date', [$now->toDateString(), $fifteenDays->toDateString()])
            ->get();

        // Kompanije koje zahtevaju servis u narednih 15 dana
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
            ->where('service_events.status', 'active')
            ->whereBetween('service_events.next_service_date', [$now->toDateString(), $fifteenDays->toDateString()])
            ->groupBy('companies.id', 'companies.name', 'companies.city', 'companies.pib')
            ->orderBy('next_service_date', 'asc')
            ->get();

        // Grupisanje po gradovima – koristi samo lokacije gde pivot status iz service_event_locations je "active"
        [$cities, $citySummaries] = $this->groupByCities($serviceEvents);

        $serviceTrends = $this->getServiceTrends($now, $threeMonths);
        $deviceTrends = $this->getDeviceTrends($now, $threeMonths);

        // Dodajemo važne datume za celu godinu (servisi + inspekcije)
        $yearStart = $now->copy()->startOfYear()->toDateString();
        $yearEnd = $now->copy()->endOfYear()->toDateString();

        $serviceEventsForYear = ServiceEvent::with(['locations.company'])
            ->where('status', 'active')
            ->whereBetween('next_service_date', [$yearStart, $yearEnd])
            ->orderBy('next_service_date')
            ->get();

        $electricalInspectionsForYear = ElectricalInspection::with('location.company')
            ->whereBetween('next_inspection_date', [$yearStart, $yearEnd])
            ->orderBy('next_inspection_date')
            ->get();

        $importantDates = [];

        foreach ($serviceEventsForYear as $event) {
            $importantDates[] = [
                'id' => 'service-' . $event->id,
                'date' => $event->next_service_date->format('Y-m-d'),
                'type' => 'Servis',
                'description' => "Servis #{$event->id} - {$event->category}",
            ];
        }

        foreach ($electricalInspectionsForYear as $inspection) {
            $importantDates[] = [
                'id' => 'inspection-' . $inspection->id,
                'date' => $inspection->next_inspection_date->format('Y-m-d'),
                'type' => 'Inspekcija',
                'description' => "Inspekcija #{$inspection->id} - {$inspection->location->name}",
            ];
        }

        // Sortiraj po datumu rastuće
        usort($importantDates, function ($a, $b) {
            return strcmp($a['date'], $b['date']);
        });
//        dd($importantDates);

        return view('admin.dashboard.index', compact(
            'serviceEvents',
            'electricalInspections',
            'companiesNeedingService',
            'cities',
            'citySummaries',
            'serviceTrends',
            'deviceTrends',
            'importantDates'
        ));
    }


    /**
     * Konsoliduje aktivne servisne događaje na osnovu preklapanja lokacija.
     */
    private function consolidateActiveServiceEvents(Carbon $start, Carbon $end)
    {
        $activeEvents = ServiceEvent::where('status', 'active')
            ->whereBetween('next_service_date', [$start->toDateString(), $end->toDateString()])
            ->with('locations')
            ->orderBy('next_service_date', 'asc')
            ->get();

        $grouped = $activeEvents->groupBy('category');

        foreach ($grouped as $category => $events) {
            $events = $events->values();
            for ($i = 0; $i < count($events); $i++) {
                $newEvent = $events[$i];
                $newLocations = $newEvent->locations->pluck('id');

                for ($j = $i + 1; $j < count($events); $j++) {
                    $existingEvent = $events[$j];
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

    /**
     * Izračunava broj aktivnih uređaja/hidranta za dati servisni događaj.
     */
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
                ->where('status', 'active')
                ->count()
            : 0;
    }

    /**
     * Grupisanje servisnih događaja po gradovima koristeći samo lokacije sa aktivnim pivot zapisima.
     * Izračunava se minimalni next_service_date (najraniji datum) za svaki grad samo iz aktivnih zapisa.
     *
     * @param \Illuminate\Support\Collection $serviceEvents
     * @return array [ $cities, $citySummaries ]
     */
    private function groupByCities($serviceEvents)
    {
        $cities = [];
        $citySummaries = [];
        $cityEventIds = [];

        foreach ($serviceEvents as $event) {
            $eventDate = Carbon::parse($event->next_service_date);
            foreach ($event->locations as $location) {
                if (!isset($location->pivot) || $location->pivot->status !== 'active') {
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
