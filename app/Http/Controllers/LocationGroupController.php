<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Company;
use App\Models\LocationGroup;
use Illuminate\Http\Request;

class LocationGroupController extends Controller
{
    public function index(Request $request)
    {
        $query = LocationGroup::with('locations.company');

        // Filter po nazivu grupe
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Opcionalno: filter po kompaniji (preko lokacija)
        if ($request->filled('company_id')) {
            $query->whereHas('locations', function ($q) use ($request) {
                $q->where('company_id', $request->company_id);
            });
        }

        $locationGroups = $query->paginate(10)->appends($request->query());

        // Za dropdown kompanija
        $companies = \App\Models\Company::orderBy('name')->get();

        return view('admin.location_groups.index', compact('locationGroups', 'companies'));
    }


    public function create()
    {
        $locations = Location::all();
        $companies = Company::all();
        return view('admin.location_groups.create', compact('locations', 'companies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'locations'   => 'nullable|array',
            'locations.*' => 'exists:locations,id'
        ]);

        $locationGroup = LocationGroup::create([
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        if (isset($validated['locations'])) {
            $locationGroup->locations()->attach($validated['locations']);
        }

        return redirect()->route('location-groups.index')
                         ->with('success', 'Location group created successfully.');
    }

    public function edit($id)
    {
        $locationGroup  = LocationGroup::with('locations')->findOrFail($id);
        $locations      = Location::all();
        return view('admin.location_groups.edit', compact('locationGroup', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $locationGroup = LocationGroup::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'locations'   => 'nullable|array',
            'locations.*' => 'exists:locations,id'
        ]);

        $locationGroup->update([
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);
        if (isset($validated['locations'])) {
            $locationGroup->locations()->sync($validated['locations']);
        } else {
            $locationGroup->locations()->detach();
        }

        return redirect()->route('location-groups.index')
                         ->with('success', 'Location group updated successfully.');
    }

    public function destroy($id)
    {
        $locationGroup = LocationGroup::findOrFail($id);
        $locationGroup->delete();

        return redirect()->route('location-groups.index')
                         ->with('success', 'Location group deleted successfully.');
    }
}
