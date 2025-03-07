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

        return redirect()->route('companies.locations', $company->id)->with('success', 'Location created successfully.');
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
       
       // Učitaj relacije
       $query->with(['company', 'serviceEvents', 'devices']);

       // Filter po nazivu lokacije
       if ($request->filled('name')) {
           $query->where('name', 'like', '%' . $request->name . '%');
       }
       
       // Filter po adresi
       if ($request->filled('address')) {
           $query->where('address', 'like', '%' . $request->address . '%');
       }
       
       // Filter po gradu
       if ($request->filled('city')) {
           $query->where('city', 'like', '%' . $request->city . '%');
       }
       
       // Filter po kompaniji (koristi se select dropdown s ID-jevom)
       if ($request->filled('company') && $request->company != '') {
           $query->where('company_id', $request->company);
       }
       
       // Filter po datumu servisa – traži se barem jedan servisni događaj s tim datumom
       if ($request->filled('next_service_date')) {
           $query->whereHas('serviceEvents', function ($q) use ($request) {
               $q->whereDate('next_service_date', $request->next_service_date);
           });
       }
       
       $locations = $query->paginate(9);
       
       // Dohvati sve kompanije za select filter
       $companies = Company::all();
       
       return view('admin.locations.test', compact('locations', 'companies'));
   }
   
   // Vaša test metoda, ako je potrebna:
  

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
