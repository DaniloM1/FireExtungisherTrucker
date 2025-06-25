<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $query = Company::query();

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        $companies = $query->paginate(10);

        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(CompanyRequest $request)
    {
        $validated = $request->validated();
        Company::create($validated);

        return redirect()->route('companies.index')
            ->with('success', 'Company created successfully.');
    }

    public function show(Company $company)
    {
        // Redirektuj korisnika na index stranicu lokacija te kompanije
        return redirect()->route('companies.locations.index', $company->id);
    }


    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    public function update(CompanyRequest $request, Company $company)
    {
        $validated = $request->validated();
        $company->update($validated);

        return redirect()->route('companies.index')
            ->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('companies.index')
            ->with('success', 'Company deleted successfully.');
    }
    public function locations(Company $company)
    {
        $locations = $company->locations()->paginate(10);
        return view('admin.companies.locations', compact('company', 'locations'));
    }

}
