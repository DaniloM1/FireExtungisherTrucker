<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\LocationCheck;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;

class LocationCheckController extends Controller
{
    public function index(Request $request)
    {
        $query = LocationCheck::with(['location.company', 'inspector']);

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhereHas('location', function($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhereHas('company', function($q3) use ($search) {
                                $q3->where('name', 'like', "%{$search}%");
                            });
                    });
            });
        }

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        $locationChecks = $query->paginate(12);

        return view('admin.location_checks.index', compact('locationChecks'));
    }


    public function create()
    {
        $companies = Company::orderBy('name')->get();
        $inspectors = User::orderBy('name')->get(); // ili filter inspektora ako imaš rolove

        return view('admin.location_checks.create', compact('companies', 'inspectors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'location_id' => 'required|exists:locations,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:inspection,test',
            'description' => 'nullable|string',
            'last_performed_date' => 'nullable|date',
            'next_due_date' => 'nullable|date',
            'inspector_id' => 'nullable|exists:users,id',
        ]);

        // Automatski izračun sledećeg termina ako nije unet
        if (!isset($validated['next_due_date']) && !empty($validated['last_performed_date'])) {
            $lastDate = \Carbon\Carbon::parse($validated['last_performed_date']);
            $yearsToAdd = ($validated['type'] === 'inspection') ? 3 : 5;
            $validated['next_due_date'] = $lastDate->copy()->addYears($yearsToAdd)->format('Y-m-d');
        }

        LocationCheck::create($validated);

        return redirect()->route('location_checks.index')->with('success', 'Location Check uspešno kreiran.');
    }


    public function show(LocationCheck $locationCheck)
    {
        return view('location_checks.show', compact('locationCheck'));
    }

    public function edit(LocationCheck $locationCheck)
    {
        $locations = Location::all();
        $inspectors = User::all();
        return view('location_checks.edit', compact('locationCheck', 'locations', 'inspectors'));
    }

    public function update(Request $request, LocationCheck $locationCheck)
    {
        $data = $request->validate([
            'location_id' => 'required|exists:locations,id',
            'type' => 'required|in:inspection,test',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'last_performed_date' => 'nullable|date',
            'next_due_date' => 'nullable|date',
            'inspector_id' => 'nullable|exists:users,id',
        ]);

        $locationCheck->update($data);

        return redirect()->route('location_checks.index')->with('success', 'Location check updated.');
    }

    public function destroy(LocationCheck $locationCheck)
    {
        $locationCheck->delete();
        return redirect()->route('location_checks.index')->with('success', 'Location check deleted.');
    }
}
