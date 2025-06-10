<?php

namespace App\Http\Controllers;

use App\Models\Hydrant;
use App\Models\Location;
use Illuminate\Http\Request;

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

    public function store(Request $request, Location $location)
    {
        $data = $request->validate([
            'serial_number'     => 'nullable|string|max:255',
            'type'              => 'nullable|string|max:255',
            'model'             => 'nullable|string|max:255',
            'manufacturer'      => 'nullable|string|max:255',
            'manufacture_date'  => 'nullable|date',
            'next_service_date' => 'nullable|date',
            'position'          => 'nullable|string|max:255',
            'hvp'               => 'nullable|date',
            'static_pressure'   => 'nullable|numeric',
            'dynamic_pressure'  => 'nullable|numeric',
            'flow'              => 'nullable|numeric',
            'status'            => 'nullable|string|max:255',
        ]);

        $location->hydrants()->create($data);

        return redirect()->route('locations.hydrants.index', $location)->with('success', 'Hydrant created.');
    }
}
