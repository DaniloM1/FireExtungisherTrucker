<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Location;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Prikaz liste uređaja za zadanu lokaciju.
     */
    public function index(Location $location, Request $request)
    {
        $query = $location->devices();

        // Pretraga – tražimo u serial_number, model i manufacturer
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('serial_number', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('manufacturer', 'like', "%{$search}%");
            });
        }

        // Sortiranje po next_service_date
        if ($request->filled('sort')) {
            $sort = $request->input('sort');
            if ($sort === 'next_service_date_asc') {
                $query->orderBy('next_service_date', 'asc');
            } elseif ($sort === 'next_service_date_desc') {
                $query->orderBy('next_service_date', 'desc');
            }
        } else {
            // Redoslijed po defaultu – primjerice rastuće
            $query->orderBy('next_service_date', 'asc');
        }

        $devices = $query->paginate(10)->appends($request->query());

        return view('admin.devices.index', compact('location', 'devices'));
    }


    /**
     * Prikaz forme za kreiranje novog uređaja unutar lokacije.
     */
    public function create(Location $location)
    {
        // Za odabir grupe unutar lokacije, ako postoji potreba:
        $groups = $location->groups()->get();
        return view('admin.devices.create', compact('location', 'groups'));
    }

    /**
     * Sprema novi uređaj u bazu.
     */
// U app/Http/Controllers/DeviceController.php

    public function store(Request $request, Location $location)
    {
        $validated = $request->validate([
            'serial_number'     => 'required|string|max:255',
            'model'             => 'required|string|max:255',
            'manufacturer'      => 'required|string|max:255',
            'manufacture_date'  => 'nullable|date',
            'next_service_date' => 'nullable|date',
            'position'          => 'nullable|string|max:255',
            'status'            => 'required|in:active,inactive,needs_service',
            'group_id'          => 'nullable|exists:groups,id',
        ]);

        // Ako je odabrana grupa, provjeravamo da grupa pripada istoj lokaciji
        if (!empty($validated['group_id'])) {
            $group = \App\Models\Group::find($validated['group_id']);
            if (!$group || $group->location_id != $location->id) {
                return redirect()->back()
                    ->withErrors(['group_id' => 'Odabrana grupa ne pripada ovoj lokaciji.'])
                    ->withInput();
            }
        }

        $validated['location_id'] = $location->id;
        \App\Models\Device::create($validated);

        return redirect()->route('locations.devices.index', $location->id)
            ->with('success', 'Device created successfully.');
    }

    /**
     * Prikaz detalja o uređaju.
     */
    public function show(Group $group)
    {
        // Učitaj i povezan uređaje (ako nisi postavio eager loading u modelu)
        $group->load('devices');
        return view('admin.groups.show', compact('group'));
    }

    /**
     * Prikaz forme za uređivanje uređaja.
     */
    public function edit(Device $device)
    {
        $location = $device->location;
        $groups = $location->groups()->get();
        return view('admin.devices.edit', compact('device', 'groups'));
    }

    /**
     * Sprema izmjene uređaja.
     */
    public function update(Request $request, Device $device)
    {
        $validated = $request->validate([
            'serial_number'     => 'required|string|max:255',
            'model'             => 'required|string|max:255',
            'manufacturer'      => 'required|string|max:255',
            'manufacture_date'  => 'nullable|date',
            'next_service_date' => 'nullable|date',
            'position'          => 'nullable|string|max:255',
            'status'            => 'required|in:active,inactive,needs_service',
            'group_id'          => 'nullable|exists:groups,id',
        ]);

        $device->update($validated);

        return redirect()->route('locations.devices.index', $device->location_id)
            ->with('success', 'Device updated successfully.');
    }

    /**
     * Briše uređaj.
     */
    public function destroy(Device $device)
    {
        $locationId = $device->location_id;
        $device->delete();

        return redirect()->route('locations.devices.index', $locationId)
            ->with('success', 'Device deleted successfully.');
    }

}
