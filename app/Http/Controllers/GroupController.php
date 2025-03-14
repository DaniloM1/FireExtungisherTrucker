<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Device;

class GroupController extends Controller
{

    public function index(Location $location)
    {
        $groups = $location->groups()->paginate(10);

        return view('admin.groups.index', compact('location', 'groups'));
    }

    public function create(Location $location)
    {
        return view('admin.groups.create', compact('location'));
    }

    public function store(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'nullable|string',
            'next_service_date' => 'nullable|date',
        ]);

        $validated['location_id'] = $location->id;

        Group::create($validated);

        return redirect()->route('locationsx.groups.index', $location->id)
            ->with('success', 'Group created successfully.');
    }

    public function show(Group $group)
    {

        return view('admin.groups.show', compact('group'));
    }

    public function edit(Group $group)
    {
//        dd($group);
        return view('admin.groups.edit', compact('group'));
    }


    public function update(Request $request, Group $group)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'nullable|string',
            'next_service_date' => 'nullable|date',
        ]);

        $group->update($validated);

        return redirect()->route('groups.update', $group->id)
            ->with('success', 'Group updated successfully.');
    }

    public function destroy(Group $group)
    {
        $locationId = $group->location_id;
        $group->delete();

        return redirect()->route('locations.groups.index', $locationId)
            ->with('success', 'Group deleted successfully.');
    }
    public function addDevice(Group $group)
    {
        $location = $group->location;
        $devices = $location->devices()->whereNull('group_id')->get();

        return view('admin.groups.add-device', compact('group', 'devices'));
    }

    public function storeDevice(Request $request, Group $group)
    {
        $validated = $request->validate([
            'device_id' => 'required|exists:devices,id',
        ]);

        $device = Device::find($validated['device_id']);

        if ($device->location_id != $group->location_id || !is_null($device->group_id)) {
            return redirect()->back()
                ->withErrors(['device_id' => 'Odabrani uređaj nije validan ili je već dodijeljen nekoj grupi.'])
                ->withInput();
        }

        $device->update(['group_id' => $group->id]);

        return redirect()->route('groups.show', $group->id)
            ->with('success', 'Uređaj je uspješno dodan u grupu.');
    }
}
