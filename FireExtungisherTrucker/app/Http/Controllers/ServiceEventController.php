<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\ServiceEvent;
use App\Models\Location;

class ServiceEventController extends Controller
{
    /**
     * Prikazuje listu servisnih događaja.
     */
    public function index()
    {
        $serviceEvents = ServiceEvent::with('locations')->orderBy('service_date', 'desc')->get();
        return view('admin.service-events.index', compact('serviceEvents'));
    }

    /**
     * Prikazuje formu za kreiranje novog servisnog događaja.
     */
    public function create()
    {
        // Dohvatamo sve lokacije radi mogućeg odabira
        $locations = Location::all();
        $companies  = Company::all();
        return view('admin.service-events.create', compact('locations', 'companies'));
    }

    /**
     * Čuva novi servisni događaj u bazi.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category'           => 'required|in:pp_device,hydrant',
            'service_date'       => 'required|date',
            'next_service_date'  => 'required|date',
            'evid_number'        => 'required|string',
            'user_id'            => 'required|integer',
            'description'        => 'nullable|string',
            'cost'               => 'required|numeric',
            'locations'          => 'required|array', // niz ID-jeva lokacija
        ]);

        $serviceEvent = ServiceEvent::create($data);
        // Povezivanje servisnog događaja sa odabranim lokacijama
        $serviceEvent->locations()->attach($data['locations']);

        return redirect()->route('service-events.index')
            ->with('success', 'Service event created successfully.');
    }

    /**
     * Prikazuje formu za uređivanje servisnog događaja.
     */
    public function edit(ServiceEvent $serviceEvent)
    {
        $locations = Location::all();
        return view('admin.service-events.edit', compact('serviceEvent', 'locations'));
    }

    /**
     * Ažurira servisni događaj.
     */
    public function update(Request $request, ServiceEvent $serviceEvent)
    {
        $data = $request->validate([
            'category'           => 'required|in:pp_device,hydrant',
            'service_date'       => 'required|date',
            'next_service_date'  => 'required|date',
            'evid_number'        => 'required|string',
            'user_id'            => 'required|integer',
            'description'        => 'nullable|string',
            'cost'               => 'required|numeric',
            'locations'          => 'required|array',
        ]);

        $serviceEvent->update($data);
        $serviceEvent->locations()->sync($data['locations']);

        return redirect()->route('admin.service-events.index')
            ->with('success', 'Service event updated successfully.');
    }

    /**
     * Briše servisni događaj.
     */
    public function destroy(ServiceEvent $serviceEvent)
    {
        $serviceEvent->delete();
        return redirect()->route('admin.service-events.index')
            ->with('success', 'Service event deleted successfully.');
    }
}
