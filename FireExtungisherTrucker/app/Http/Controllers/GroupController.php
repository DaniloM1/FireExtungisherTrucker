<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Device;

class GroupController extends Controller
{
    /**
     * Prikaz liste grupa za zadanu lokaciju.
     */
    public function index(Location $location)
    {
        $groups = $location->groups()->paginate(10);
        return view('admin.groups.index', compact('location', 'groups'));
    }

    /**
     * Prikaz forme za kreiranje nove grupe unutar lokacije.
     */
    public function create(Location $location)
    {
        return view('admin.groups.create', compact('location'));
    }

    /**
     * Sprema novu grupu u bazu.
     */
    public function store(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'nullable|string',
            'next_service_date' => 'nullable|date',
        ]);

        $validated['location_id'] = $location->id;

        Group::create($validated);

        return redirect()->route('locations.groups.index', $location->id)
            ->with('success', 'Group created successfully.');
    }

    /**
     * Prikaz detalja o grupi (ako je potrebno).
     */
    public function show(Group $group)
    {
        return view('admin.groups.show', compact('group'));
    }

    /**
     * Prikaz forme za uređivanje grupe.
     */
    public function edit(Group $group)
    {
//        dd($group);
        return view('admin.groups.edit', compact('group'));
    }

    /**
     * Sprema izmjene grupe.
     */
    public function update(Request $request, Group $group)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'nullable|string',
            'next_service_date' => 'nullable|date',
        ]);

        $group->update($validated);

        return redirect()->route('locations.groups.index', $group->location_id)
            ->with('success', 'Group updated successfully.');
    }

    /**
     * Briše grupu.
     */
    public function destroy(Group $group)
    {
        $locationId = $group->location_id;
        $group->delete();

        return redirect()->route('locations.groups.index', $locationId)
            ->with('success', 'Group deleted successfully.');
    }
    public function addDevice(Group $group)
    {
        // Učitaj lokaciju grupe
        $location = $group->location;

        // Dohvati uređaje koji pripadaju toj lokaciji i nemaju dodijeljenu grupu (group_id je null)
        $devices = $location->devices()->whereNull('group_id')->get();

        return view('admin.groups.add-device', compact('group', 'devices'));
    }

    /**
     * Sprema odabran uređaj u grupu.
     */
    public function storeDevice(Request $request, Group $group)
    {
        $validated = $request->validate([
            'device_id' => 'required|exists:devices,id',
        ]);

        // Učitaj uređaj
        $device = Device::find($validated['device_id']);

        // Provjeri da uređaj pripada istoj lokaciji kao i grupa te da trenutno nema grupu
        if ($device->location_id != $group->location_id || !is_null($device->group_id)) {
            return redirect()->back()
                ->withErrors(['device_id' => 'Odabrani uređaj nije validan ili je već dodijeljen nekoj grupi.'])
                ->withInput();
        }

        // Ažuriraj uređaj i postavi group_id na id trenutne grupe
        $device->update(['group_id' => $group->id]);

        return redirect()->route('groups.show', $group->id)
            ->with('success', 'Uređaj je uspješno dodan u grupu.');
    }
}
