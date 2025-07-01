<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceEventRequest;
use App\Models\Company;
use App\Models\LocationGroup;
use Illuminate\Http\Request;
use App\Models\ServiceEvent;
use App\Models\Location;

class ServiceEventController extends Controller
{

    public function index(Request $request)
    {
        $query = ServiceEvent::with('locations.company');

        // Filters
        $filters = [
            'category'   => fn($q, $v) => $q->where('category', $v),
            'service_date' => fn($q, $v) => $q->whereDate('service_date', $v),
            'next_service_date' => fn($q, $v) => $q->whereDate('next_service_date', $v),
            'evid_number' => fn($q, $v) => $q->where('evid_number', 'like', "%$v%"),
            'company' => fn($q, $v) => $q->whereHas('locations', fn($qq) => $qq->where('company_id', $v)),
            'location' => fn($q, $v) => $q->whereHas('locations', fn($qq) => $qq->where('id', $v)),
        ];

        foreach ($filters as $key => $callback) {
            if ($request->filled($key)) {
                $callback($query, $request->input($key));
            }
        }
        if ($request->filled('year') && $request->filled('month')) {
            $firstDay = \Carbon\Carbon::create($request->year, $request->month, 1)->toDateString();
            $lastDay  = \Carbon\Carbon::create($request->year, $request->month, 1)->endOfMonth()->toDateString();
            $query->whereBetween('next_service_date', [$firstDay, $lastDay]);
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

        $serviceEvent->load('attachments');

        if ($user->hasRole('super_admin')) {
            $serviceEvent->load([
                'locations.company',
                'locations.devices',
                'locations.hydrants',
            ]);
            $locationsGrouped = $serviceEvent->locations->groupBy(function($loc) {
                return $loc->company->name;
            });

            return view('admin.service-events.show', ['serviceEvent'=> $serviceEvent, 'locationsGrouped'=> $locationsGrouped,]);
        }

        if ($user->hasRole('company')) {
            $companyId = $user->company_id;

            $locations = $serviceEvent->locations()
                ->where('company_id', $companyId)
                ->with(['company','devices','hydrants'])
                ->get();

            if ($locations->isEmpty()) {
                abort(403, 'Nemate pristup ovom servisu.');
            }

            $serviceEvent->setRelation('locations', $locations);
            $locationsGrouped = $serviceEvent->locations->groupBy(function($loc) {
                return $loc->company->name;
            });

            return view('admin.service-events.show', ['serviceEvent' => $serviceEvent, 'locationsGrouped' => $locationsGrouped,]);
        }

        abort(403, 'Nemate pristup ovom servisu.');
    }


    public function store(ServiceEventRequest $request)
    {
        $data = $request->validated();

        $newLocationIds = collect($data['locations'])->map(fn($id) => (int)$id);

        $activeServiceEvents = ServiceEvent::where('status', 'active')
            ->where('category', $data['category'])
            ->with('locations')
            ->get();

        foreach ($activeServiceEvents as $activeEvent) {
            $activeLocationIds = $activeEvent->locations->pluck('id')->map(fn($id) => (int)$id);
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
            $serviceEvent->locations()->attach($locationId, ['status' => 'active']);
        }

        return redirect()->route('service-events.index')
            ->with('success', 'Service event created successfully.');
    }

    public function edit(ServiceEvent $serviceEvent)
    {
        $serviceEvent->load('locations.company');

        $companies   = Company::all();
        $allLocations = Location::orderBy('name')->get();
        return view('admin.service-events.edit', compact('serviceEvent', 'companies', 'allLocations'));
    }


    public function update(ServiceEventRequest $request, ServiceEvent $serviceEvent)
    {
        $data = $request->validated();
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

        return view('admin.service-events.create-group', compact('locationGroup', 'allLocations', 'companies', 'selectedLocationIds', 'selectedCompanyIds'));
    }
    // ServiceEventLocationController.php

    public function markDone($serviceEventId, $locationId)
    {
        $serviceEvent = \App\Models\ServiceEvent::findOrFail($serviceEventId);

        if (!$serviceEvent->locations()->where('locations.id', $locationId)->exists()) {
            abort(404, 'Lokacija nije deo ovog servisa.');
        }
        $serviceEvent->locations()->updateExistingPivot($locationId, [
            'status'       => 'done',
        ]);

        return back()->with('success', 'Lokacija je označena kao završena!');
    }


}
