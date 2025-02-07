<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Prikazuje listu svih kompanija.
     */
//    public function index()
//    {
//        $companies = Company::paginate(10); // Paginacija sa 10 kompanija po strani
//        return view('admin.companies.index', compact('companies'));
//    }
    public function index(Request $request)
    {
        $query = Company::query();

        // Ako postoji unos u pretrazi, filtriraj rezultate
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('contact_email', 'like', "%{$search}%")
                    ->orWhere('contact_phone', 'like', "%{$search}%");
            });
        }

        // Paginacija – prilagodi broj rezultata po stranici prema potrebi
        $companies = $query->paginate(10);


        return view('admin.companies.index', compact('companies'));
    }


    /**
     * Prikazuje formu za kreiranje nove kompanije.
     */
    public function create()
    {
        return view('admin.companies.create');
    }

    /**
     * Čuva novu kompaniju u bazi.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_email' => 'required|email|unique:companies',
            'contact_phone' => 'required|string|max:20',
            'pib' => 'required|string|max:20|unique:companies',
            'maticni_broj' => 'required|string|max:20|unique:companies',
            'website' => 'nullable|url',
        ]);

        Company::create($validated);

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    /**
     * Prikazuje detalje jedne kompanije.
     */
    public function show(Company $company)
    {
        $company->load('locations');

        return view('admin.companies.show', compact('company'));
    }

    /**
     * Prikazuje formu za uređivanje postojeće kompanije.
     */
    public function edit(Company $company)
    {
//        dd($company);
        return view('admin.companies.edit', compact('company'));
    }

    /**
     * Ažurira postojeću kompaniju u bazi.
     */
    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_email' => 'required|email|unique:companies,contact_email,' . $company->id,
            'contact_phone' => 'required|string|max:20',
            'pib' => 'required|string|max:20|unique:companies,pib,' . $company->id,
            'maticni_broj' => 'required|string|max:20|unique:companies,maticni_broj,' . $company->id,
            'website' => 'nullable|url',
        ]);

        $company->update($validated);

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    /**
     * Briše kompaniju iz baze.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }
    public function locations(Company $company)
    {
        $locations = $company->locations()->paginate(10); // Pretpostavlja da je relacija "locations" u modelu Company
        return view('admin.companies.locations', compact('company', 'locations'));
    }


}
