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
        $company = Company::findOrFail($companyId);
        $locations = $company->locations()->with('serviceEvents')->paginate(10);

        return view('admin.locations.index', compact('company', 'locations'));
    }
    public function api($companyId)
    {
        $company = Company::findOrFail($companyId);
        $locations = $company->locations()->paginate(200);

        return $locations;


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
            'name'      => 'required|string|max:255',
            'address'   => 'required|string|max:255',
            'latitude'  => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'city'      => 'required|string|max:255',
        ]);

        $company->locations()->create($validated);

        return redirect()->route('companies.locations.index', $company->id)->with('success', 'Location created successfully.');
    }

    /**
     * Show the form for editing the specified location.
     */
    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }


   public function test(Request $request)
   {
       $query = Location::query();

       $query->with(['company', 'serviceEvents', 'devices']);

       if ($request->filled('name')) {
           $query->where('name', 'like', '%' . $request->name . '%');
       }

       if ($request->filled('address')) {
           $query->where('address', 'like', '%' . $request->address . '%');
       }

       if ($request->filled('city')) {
           $query->where('city', 'like', '%' . $request->city . '%');
       }

       if ($request->filled('company') && $request->company != '') {
           $query->where('company_id', $request->company);
       }

       if ($request->filled('next_service_date')) {
           $query->whereHas('serviceEvents', function ($q) use ($request) {
               $q->whereDate('next_service_date', $request->next_service_date);
           });
       }

       $locations = $query->paginate(9);

       $companyIds = $locations->pluck('company_id')->unique();
       $companies = Company::whereIn('id', $companyIds)->get();


       return view('admin.locations.test', compact('locations', 'companies'));
   }

    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'address'   => 'required|string|max:255',
            'latitude'  => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $location->update($validated);

        return redirect()->route('companies.locations', $location->company_id)->with('success', 'Location updated successfully.');
    }

    public function destroy(Location $location)
    {
        $companyId = $location->company_id;
        $location->delete();

        return redirect()->route('companies.locations', $companyId)->with('success', 'Location deleted successfully.');
    }

}
