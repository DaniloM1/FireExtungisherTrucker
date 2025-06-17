<?php
namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;


use App\Models\Attachment;

class AttachmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10000',
            'type' => 'nullable|string|max:40',
            'location_id' => 'nullable|exists:locations,id',
            'service_event_id' => 'nullable|exists:service_events,id',
        ]);

        $file = $request->file('file');
        $path = $file->store('attachments', 'public');

        Attachment::create([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'type' => $request->input('type'),
            'location_id' => $request->input('location_id'),
            'service_event_id' => $request->input('service_event_id'),
        ]);

        return back()->with('success', 'Prilog dodat.');
    }

    public function destroy(Attachment $attachment)
    {
        $attachment->delete(); // Soft delete
        return back()->with('success', 'Prilog obrisan (soft delete).');
    }

    public function restore($id)
    {
        $att = Attachment::withTrashed()->findOrFail($id);
        $att->restore();
        return back()->with('success', 'Prilog vraćen.');
    }

    public function forceDelete($id)
    {
        $att = Attachment::withTrashed()->findOrFail($id);
        \Storage::disk('public')->delete($att->path);
        $att->forceDelete();
        return back()->with('success', 'Prilog trajno obrisan.');
    }
    public function storeForLocation(Request $request, Location $location)
    {
        $validated = $request->validate([
            'attachment' => 'required|file|max:10240', // max 10MB
            'name' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
        ]);

        $file = $request->file('attachment');
        $path = $file->store('attachments', 'public');

        \App\Models\Attachment::create([
            'location_id' => $location->id,
            'name' => $validated['name'] ?: $file->getClientOriginalName(),
            'type' => $validated['type'] ?? $file->getClientOriginalExtension(),
            'path' => $path,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('locations.show', $location)->with('success', 'Prilog dodat.');
    }
    public function storeForServiceEvent(Request $request, $serviceEventId)
    {
        $request->validate([
            'attachment' => 'required|file|max:10240',
            'name'       => 'required|string|max:255',
            'type'       => 'nullable|string|max:50',
        ]);

        $serviceEvent = \App\Models\ServiceEvent::findOrFail($serviceEventId);

        // Upload
        $file = $request->file('attachment');
        $path = $file->store('attachments', 'public');

        $attachment = new \App\Models\Attachment([
            'name'            => $request->name,
            'type'            => $request->type,
            'path'            => $path,
            'service_event_id'=> $serviceEvent->id,
            'location_id'     => null, // Ostavljaš null jer je vezan za service event
        ]);
        $attachment->save();

        return back()->with('success', 'Prilog dodat!');
    }


}
