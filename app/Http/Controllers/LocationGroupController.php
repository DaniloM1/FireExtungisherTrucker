<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Company;
use App\Models\LocationGroup;
use Illuminate\Http\Request;

class LocationGroupController extends Controller
{
    /**
     * Prikazuje listu svih lokacijskih grupa.
     */
    public function index()
    {
        $locationGroups = LocationGroup::with('locations')->paginate(10);
        return view('admin.location_groups.index', compact('locationGroups'));
    }

    /**
     * Prikazuje formu za kreiranje nove lokacijske grupe.
     */
    public function create()
    {
        // Dohvati sve lokacije radi mogućeg izbora članova grupe
        $locations = Location::all();
        $companies = Company::all();
        return view('admin.location_groups.create', compact('locations', 'companies'));
    }

    /**
     * Sprema novu lokacijsku grupu i povezuje odabrane lokacije.
     */
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

        // Ako su poslani ID-jevi lokacija, prikačite ih na grupu
        if (isset($validated['locations'])) {
            $locationGroup->locations()->attach($validated['locations']);
        }

        return redirect()->route('location-groups.index')
                         ->with('success', 'Location group created successfully.');
    }

    /**
     * Prikazuje formu za uređivanje postojeće lokacijske grupe.
     */
    public function edit($id)
    {
        $locationGroup = LocationGroup::with('locations')->findOrFail($id);
        $locations = Location::all();
        return view('admin.location_groups.edit', compact('locationGroup', 'locations'));
    }

    /**
     * Ažurira podatke o lokacijskoj grupi, uključujući i članove.
     */
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

        // Sinkroniziraj (update) pivot tabelu – ako nije poslano ništa, detach sve
        if (isset($validated['locations'])) {
            $locationGroup->locations()->sync($validated['locations']);
        } else {
            $locationGroup->locations()->detach();
        }

        return redirect()->route('location-groups.index')
                         ->with('success', 'Location group updated successfully.');
    }

    /**
     * Briše odabranu lokacijsku grupu.
     */
    public function destroy($id)
    {
        $locationGroup = LocationGroup::findOrFail($id);
        $locationGroup->delete();

        return redirect()->route('location-groups.index')
                         ->with('success', 'Location group deleted successfully.');
    }
}
