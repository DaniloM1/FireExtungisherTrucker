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

        // Nadolazeći servis događaji (narednih 15 dana)
        $serviceEvents = ServiceEvent::with(['locations.company'])
            ->whereBetween('next_service_date', [$now->toDateString(), $fifteenDays->toDateString()])
            ->get()
            ->each(function ($event) {
                $this->calculateActiveDevices($event);
            });

        // Nadolazeće električne inspekcije
        $electricalInspections = ElectricalInspection::with('location.company')
            ->whereBetween('next_inspection_date', [$now->toDateString(), $fifteenDays->toDateString()])
            ->get();

        // Kompanije koje zahtevaju servis
        $companiesNeedingService = Company::whereHas('locations.serviceEvents', function ($query) use ($now, $fifteenDays) {
            $query->whereBetween('next_service_date', [$now->toDateString(), $fifteenDays->toDateString()]);
        })->get();

        // Grupisanje po gradovima
        [$cities, $citySummaries] = $this->groupByCities($serviceEvents);

        // Trendovi za servise
        $serviceTrends = $this->getServiceTrends($now, $threeMonths);
        $deviceTrends = $this->getDeviceTrends($now, $threeMonths);
        // dd($citySummaries);

        return view('admin.dashboard.index', compact(
            'serviceEvents',
            'electricalInspections',
            'companiesNeedingService',
            'cities',
            'citySummaries',
            'serviceTrends',
            'deviceTrends'
        ));
    }

    private function calculateActiveDevices($event)
    {
        $locationIds = $event->locations->pluck('id');
        $model = match ($event->category) {
            'pp_device' => Device::class,
            'hydrant' => Hydrant::class,
            default => null,
        };

        $event->activeDevices = $model
            ? $model::whereIn('location_id', $locationIds)
                ->where('status', 'active')
                ->count()
            : 0;
    }

    private function groupByCities($serviceEvents)
    {
        $cities = [];
        $citySummaries = [];

        foreach ($serviceEvents as $event) {
            foreach ($event->locations as $location) {
                $city = $location->city;
                
                // Grupisanje lokacija
                if (!isset($cities[$city])) {
                    $cities[$city] = collect();
                }
                if (!$cities[$city]->contains('id', $location->id)) {
                    $cities[$city]->push($location);
                }

                // Sažetak po gradu
                $this->updateCitySummary($citySummaries, $city, $event);
            }
        }
        uasort($citySummaries, function($a, $b) {
            return $a['next_service_date']->timestamp <=> $b['next_service_date']->timestamp;
        });
        return [$cities, $citySummaries];
    }

    private function updateCitySummary(&$summaries, $city, $event)
    {
        if (!isset($summaries[$city])) {
            $summaries[$city] = [
                'event_count' => 0,
                'next_service_date' => null,
            ];
        }

        $summaries[$city]['event_count']++;
        $eventDate = Carbon::parse($event->next_service_date);

        if (!$summaries[$city]['next_service_date'] || $eventDate->lessThan($summaries[$city]['next_service_date'])) {
            $summaries[$city]['next_service_date'] = $eventDate;
        }
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
                'year' => $date->year,
                'month' => $date->month,
                'total_devices' => 0
            ];
        }
        
        $trends[$key]['total_devices'] += $event->activeDevices;
    }

    ksort($trends);
    return array_values($trends);
}
}