<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Company;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the locations for a specific company.
     */
    public function index($companyId)
    {

        // Dohvati kompaniju po ID-u
        $company = Company::findOrFail($companyId);

        // Dohvati sve lokacije povezane sa kompanijom
        $locations = $company->locations()->paginate(10);

        // Vrati pogled sa lokacijama
        return view('admin.locations.index', compact('company', 'locations'));


    }

    /**
     * Show the form for creating a new location for a company.
     */
    public function create(Company $company)
    {
        return view('admin.locations.create', compact('company'));
    }

    /**
     * Store a newly created location in storage.
     */
    public function store(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $company->locations()->create($validated);

        return redirect()->route('companies.locations', $company->id)->with('success', 'Location created successfully.');
    }

    /**
     * Show the form for editing the specified location.
     */
    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    /**
     * Update the specified location in storage.
     */
    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $location->update($validated);

        return redirect()->route('companies.locations', $location->company_id)->with('success', 'Location updated successfully.');
    }

    /**
     * Remove the specified location from storage.
     */
    public function destroy(Location $location)
    {
        $companyId = $location->company_id;
        $location->delete();

        return redirect()->route('companies.locations', $companyId)->with('success', 'Location deleted successfully.');
    }

}
