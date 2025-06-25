<?php
namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Company;
use App\Models\LocationGroup;
use App\Http\Requests\LocationGroupRequest;
use Illuminate\Http\Request;

class LocationGroupController extends Controller
{
    public function index(Request $request)
    {
        $query = LocationGroup::with('locations.company');

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }

        if ($companyId = $request->input('company_id')) {
            $query->whereHas('locations', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });
        }

        $locationGroups = $query->paginate(10)->appends($request->query());
        $companies = Company::orderBy('name')->get();

        return view('admin.location_groups.index', compact('locationGroups', 'companies'));
    }

    public function create()
    {
        $locations = Location::all();
        $companies = Company::all();
        return view('admin.location_groups.create', compact('locations', 'companies'));
    }

    public function store(LocationGroupRequest $request)
    {
        $validated = $request->validated();

        $locationGroup = LocationGroup::create([
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        if (!empty($validated['locations'])) {
            $locationGroup->locations()->attach($validated['locations']);
        }

        return redirect()->route('location-groups.index')
            ->with('success', 'Location group created successfully.');
    }

    public function edit(LocationGroup $locationGroup)
    {
        $locationGroup->load('locations');
        $locations = Location::all();
        return view('admin.location_groups.edit', compact('locationGroup', 'locations'));
    }

    public function update(LocationGroupRequest $request, LocationGroup $locationGroup)
    {
        $validated = $request->validated();

        $locationGroup->update([
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        $locationGroup->locations()->sync($validated['locations'] ?? []);

        return redirect()->route('location-groups.index')
            ->with('success', 'Location group updated successfully.');
    }

    public function destroy(LocationGroup $locationGroup)
    {
        $locationGroup->delete();

        return redirect()->route('location-groups.index')
            ->with('success', 'Location group deleted successfully.');
    }
}
