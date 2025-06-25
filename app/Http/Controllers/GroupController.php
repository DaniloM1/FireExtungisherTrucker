<?php
namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Location;
use App\Models\Device;
use App\Http\Requests\GroupRequest;
use App\Http\Requests\DeviceToGroupRequest;

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

    public function store(GroupRequest $request, Location $location)
    {
        $validated = $request->validated();
        $validated['location_id'] = $location->id;
        Group::create($validated);

        return redirect()->route('locations.groups.index', $location->id)
            ->with('success', 'Group created successfully.');
    }

    public function show(Group $group)
    {
        return view('admin.groups.show', compact('group'));
    }

    public function edit(Group $group)
    {
        return view('admin.groups.edit', compact('group'));
    }

    public function update(GroupRequest $request, Group $group)
    {
        $group->update($request->validated());

        return redirect()->route('groups.show', $group->id)
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

    public function storeDevice(DeviceToGroupRequest $request, Group $group)
    {
        $device = Device::find($request->device_id);
        $device->update(['group_id' => $group->id]);

        return redirect()->route('groups.show', $group->id)
            ->with('success', 'Uređaj je uspješno dodat u grupu.');
    }
}
