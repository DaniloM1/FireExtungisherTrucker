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
    public function index(Request $request)
    {
        $query = ServiceEvent::with('locations');

        // Filter po kategoriji (npr. "pp_device" ili "hydrant")
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter po datumu servisa (možeš proširiti na opseg datuma ako je potrebno)
        if ($request->filled('service_date')) {
            $query->whereDate('service_date', $request->service_date);
        }
        if ($request->filled('next_service_date')) {
            $query->whereDate('next_service_date', $request->next_service_date);
        }

        // Filter po evid broju (koristi LIKE za delimično podudaranje)
        if ($request->filled('evid_number')) {
            $query->where('evid_number', 'like', '%' . $request->evid_number . '%');
        }

        // Filter po kompaniji: pretraga se vrši preko povezanih lokacija koje imaju dati company_id
        if ($request->filled('company')) {
            $companyId = $request->company;
            $query->whereHas('locations', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });

        }

        // Filter po lokaciji (po location id)
        if ($request->filled('location')) {
            $locationId = $request->location;
            $query->whereHas('locations', function ($q) use ($locationId) {
                $q->where('locations.id', $locationId);
            });
        }
        $companies = Company::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();


        // Finalno, sortiranje i paginacija (dodajemo appends() da se query parametri sačuvaju pri paginaciji)
        $serviceEvents = $query->orderBy('service_date', 'desc')->paginate(10)->appends($request->query());

        return view('admin.service-events.index', compact('serviceEvents', 'companies', 'locations'));
    }

//    public function test()
//    {
//        $serviceEvents = ServiceEvent::with('locations')->orderBy('service_date', 'desc')->get();
//        $companies = Company::all();
//        return view('admin.service-events.test', compact('serviceEvents', 'companies'));
//    }

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
//        dd($request);
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
        $companies = Company::all();
        return view('admin.service-events.edit', compact('serviceEvent', 'locations', 'companies'));
    }

    /**
     * Ažurira servisni događaj.
     */
    public function update(Request $request, ServiceEvent $serviceEvent)
    {
dd($request);
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
        return redirect()->route('service-events.index')
            ->with('success', 'Service event deleted successfully.');
    }
}
