<?php

namespace App\Http\Controllers;

use App\Models\ServiceEvent;
use App\Models\Location;
use Illuminate\Http\Request;

class CompanyUserController extends Controller
{
    public function index(Request $request)
    {
        $companyId = auth()->user()->company_id;

        // Priprema query-a za filtriranje
        $locationsQuery = Location::where('company_id', $companyId)
            ->withCount('devices', 'hydrants');

        if ($request->filled('name')) {
            $locationsQuery->where('name', 'LIKE', '%' . $request->name . '%');
        }
        if ($request->filled('address')) {
            $locationsQuery->where('address', 'LIKE', '%' . $request->address . '%');
        }
        if ($request->filled('city')) {
            $locationsQuery->where('city', 'LIKE', '%' . $request->city . '%');
        }

        $locations = $locationsQuery
            ->orderBy('name')
            ->paginate(10);

        // Poslednjih 5 servisnih događaja
        $recentServiceEvents = ServiceEvent::whereHas('locations', function ($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })
            ->with('locations')
            ->orderBy('service_date', 'desc')
            ->paginate(8);

        // Brojač po kategorijama
        $serviceStats = [
            'total' => ServiceEvent::whereHas('locations', fn ($q) => $q->where('company_id', $companyId))->count(),
            'pp_devices' => ServiceEvent::where('category', 'pp_device')->whereHas('locations', fn ($q) => $q->where('company_id', $companyId))->count(),
            'hydrants' => ServiceEvent::where('category', 'hydrant')->whereHas('locations', fn ($q) => $q->where('company_id', $companyId))->count(),
        ];

        return view('admin.companyuser.index', compact('locations', 'recentServiceEvents', 'serviceStats'));
    }


    public function show(ServiceEvent $serviceEvent)
    {
        $companyId = auth()->user()->company_id;
        $relatedCompanyIds = $serviceEvent->locations->pluck('company_id')->unique();

        if (!$relatedCompanyIds->contains($companyId)) {
            abort(403, 'Nemate pristup ovom servisu.');
        }

        $serviceEvent->load([
            'locations.company',
            'locations.devices',
            'locations.hydrants',
            'attachments' // Eager load attachments
        ]);

        return view('admin.companyuser.show', compact('serviceEvent'));
    }
    public function locationShow(Location $location)
    {
        $companyId = auth()->user()->company_id;

        if ($location->company_id !== $companyId) {
            abort(403, 'Nemate pristup ovoj lokaciji.');
        }

        // Učitaj sve uređaje, hidrante, i servise za lokaciju
        $location->load(['devices', 'hydrants', 'serviceEvents' => function($q) {
            $q->orderBy('service_date', 'desc');
        }]);
//        dd($location);

        return view('admin.companyuser.location_show', compact('location'));
    }

}
