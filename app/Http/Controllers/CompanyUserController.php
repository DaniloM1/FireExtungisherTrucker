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

        // Lokacije koje pripadaju kompaniji korisnika
        $locations = Location::where('company_id', $companyId)
            ->withCount('devices', 'hydrants')
            ->orderBy('name')
            ->get();

        // Poslednjih 5 servisnih događaja
        $recentServiceEvents = ServiceEvent::whereHas('locations', function ($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })
            ->with('locations')
            ->orderBy('service_date', 'desc')
            ->take(5)
            ->get();

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

        $serviceEvent->load('locations.company', 'locations.devices', 'locations.hydrants');

        return view('admin.companyuser.show', compact('serviceEvent'));
    }
}
