<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\LocationGroup;
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
        $query = ServiceEvent::with('locations.company');


        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('service_date')) {
            $query->whereDate('service_date', $request->service_date);
        }
        if ($request->filled('next_service_date')) {
            $query->whereDate('next_service_date', $request->next_service_date);
        }
        if ($request->filled('evid_number')) {
            $query->where('evid_number', 'like', '%' . $request->evid_number . '%');
        }
        if ($request->filled('company')) {
            $query->whereHas('locations', function ($q) use ($request) {
                $q->where('company_id', $request->company);
            });
        }
        if ($request->filled('year') && $request->filled('month')) {
            $firstDay = \Carbon\Carbon::create($request->year, $request->month, 1)->toDateString();
            $lastDay  = \Carbon\Carbon::create($request->year, $request->month, 1)->endOfMonth()->toDateString();
            $query->whereBetween('next_service_date', [$firstDay, $lastDay]);
        } elseif ($request->filled('next_service_date')) {
            $query->whereDate('next_service_date', $request->next_service_date);
        }
        if ($request->filled('location')) {
            $query->whereHas('locations', function ($q) use ($request) {
                $q->where('id', $request->location);
            });
        }

        $serviceEvents = $query->orderBy('service_date', 'desc')
            ->paginate(10)
            ->appends($request->query());

        $allEvents = (clone $query)->get();
        $locationIds = $allEvents->pluck('locations')->flatten()->pluck('id')->unique();
        $companies = Company::whereIn('id', function ($q) use ($locationIds) {
            $q->select('company_id')->from('locations')->whereIn('id', $locationIds);
        })->orderBy('name')->get();
        $locations = Location::whereIn('id', $locationIds)->orderBy('name')->get();

        return view('admin.service-events.index', compact('serviceEvents', 'companies', 'locations'));
    }

    public function create()
    {
        $locations = Location::all();
        $companies  = Company::all();
        return view('admin.service-events.create', compact('locations', 'companies'));
    }
    public function show(ServiceEvent $serviceEvent)
    {
        $user = auth()->user();

        // Učitaj uvek samo priloge
        $serviceEvent->load('attachments');

        // SUPER_ADMIN vidi sve lokacije i pripadajuće relacije
        if ($user->hasRole('super_admin')) {
            $serviceEvent->load([
                'locations.company',
                'locations.devices',
                'locations.hydrants',
            ]);
            $locationsGrouped = $serviceEvent->locations->groupBy(function($loc) {
                return $loc->company->name;
            });

            return view('admin.service-events.show', [
                'serviceEvent'      => $serviceEvent,
                'locationsGrouped'  => $locationsGrouped,
            ]);
        }

        // COMPANY vidi samo sopstvene lokacije
        if ($user->hasRole('company')) {
            $companyId = $user->company_id;

            // Dohvati samo lokacije servisa koje pripadaju toj kompaniji
            $locations = $serviceEvent->locations()
                ->where('company_id', $companyId)
                ->with(['company','devices','hydrants'])
                ->get();

            // Ako ne postoji nijedna, nemaš pristup
            if ($locations->isEmpty()) {
                abort(403, 'Nemate pristup ovom servisu.');
            }

            // Zameni relaciju locations filtriranim setom
            $serviceEvent->setRelation('locations', $locations);
            $locationsGrouped = $serviceEvent->locations->groupBy(function($loc) {
                return $loc->company->name;
            });

            return view('admin.service-events.show', [
                'serviceEvent'      => $serviceEvent,
                'locationsGrouped'  => $locationsGrouped,
            ]);
        }

        // Ostali nemaju pristup
        abort(403, 'Nemate pristup ovom servisu.');
    }



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
            // Pretpostavljamo da lokacije dolaze kao niz ID-jeva
            'locations'          => 'required|array',
        ]);

        $newLocationIds = collect($data['locations'])->map(function ($id) {
            return (int) $id;
        });
        $activeServiceEvents = ServiceEvent::where('status', 'active')
            ->where('category', $data['category'])
            ->with('locations')
            ->get();

        foreach ($activeServiceEvents as $activeEvent) {
            $activeLocationIds = $activeEvent->locations->pluck('id')->map(function ($id) {
                return (int) $id;
            });
            if ($activeLocationIds->diff($newLocationIds)->isEmpty() && $activeLocationIds->isNotEmpty()) {
                $activeEvent->update(['status' => 'inactive']);
                foreach ($activeEvent->locations as $location) {
                    $activeEvent->locations()->updateExistingPivot($location->id, ['status' => 'inactive']);
                }
            }
        }

        $data['status'] = 'active';
        $serviceEvent = ServiceEvent::create($data);

        foreach ($newLocationIds as $locationId) {
            $serviceEvent->locations()->attach($locationId, [
                'status' => 'active',
            ]);
        }

        return redirect()->route('service-events.index')
            ->with('success', 'Service event created successfully.');
    }

    public function edit(ServiceEvent $serviceEvent)
    {
        $serviceEvent->load('locations.company');

        $companies   = Company::all();
        $allLocations = Location::orderBy('name')->get();
        return view('admin.service-events.edit', compact(
            'serviceEvent',
            'companies',
            'allLocations'
        ));
    }


    public function update(Request $request, ServiceEvent $serviceEvent)
    {
// dd($request);
        $data = $request->validate([
            'category'           => 'required|in:pp_device,hydrant',
            'service_date'       => 'required|date',
            'next_service_date'  => 'required|date',
            'evid_number'        => 'required|string',
            'user_id'            => 'required|integer',
            'description'        => 'nullable|string',
            'cost'               => 'required|numeric',
            'status'             => 'required|in:active,inactive',
            'locations'          => 'required|array',
        ]);

        $serviceEvent->update($data);
        $serviceEvent->locations()->sync($data['locations']);

        return redirect()->route('service-events.index')
            ->with('success', 'Service event updated successfully.');
    }

    public function destroy(ServiceEvent $serviceEvent)
    {
        $serviceEvent->delete();
        return redirect()->route('service-events.index')
            ->with('success', 'Service event deleted successfully.');
    }
    public function groupService($locationGroupId)
    {
        $locationGroup = LocationGroup::with('locations.company')->findOrFail($locationGroupId);

        $companies = Company::all();
        $allLocations = Location::orderBy('name')->get();
        $selectedLocationIds = $locationGroup->locations->pluck('id')->toArray();
        $selectedCompanyIds = $locationGroup->locations->pluck('company_id')->unique()->toArray();

        return view('admin.service-events.create-group', compact(
            'locationGroup',
            'allLocations',
            'companies',
            'selectedLocationIds',
            'selectedCompanyIds'
        ));
    }
}
