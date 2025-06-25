<?php
namespace App\Http\Controllers;

use App\Models\Hydrant;
use App\Models\Location;
use App\Http\Requests\HydrantRequest;

class HydrantController extends Controller
{
    public function index(Location $location)
    {
        $hydrants = $location->hydrants()->paginate(10);
        return view('admin.hydrants.index', compact('location', 'hydrants'));
    }

    public function create(Location $location)
    {
        return view('admin.hydrants.create', compact('location'));
    }

    public function store(HydrantRequest $request, Location $location)
    {
        $location->hydrants()->create($request->validated());

        return redirect()->route('locations.hydrants.index', $location)
            ->with('success', 'Hydrant created.');
    }

    public function edit(Location $location, Hydrant $hydrant)
    {
        return view('admin.hydrants.edit', compact('location', 'hydrant'));
    }

    public function update(HydrantRequest $request, Location $location, Hydrant $hydrant)
    {
        $hydrant->update($request->validated());

        return redirect()->route('locations.hydrants.index', $location)
            ->with('success', 'Hydrant ažuriran.');
    }

    public function destroy(Location $location, Hydrant $hydrant)
    {
        $hydrant->delete();

        return redirect()->route('locations.hydrants.index', $location)
            ->with('success', 'Hydrant obrisan.');
    }
}
