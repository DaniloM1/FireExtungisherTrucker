<?php
namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Attachment;
use App\Models\ServiceEvent;

use App\Http\Requests\AttachmentRequest;

class AttachmentController extends Controller
{
    public function store(AttachmentRequest $request)
    {
        $validated = $request->validated();

        $file = $validated['file'];
        $path = $file->store('attachments', 'public');

        $attachment = Attachment::create([
            'name'             => $validated['name'] ?? $file->getClientOriginalName(),
            'type'             => $validated['type'] ?? $file->getClientOriginalExtension(),
            'path'             => $path,
            'location_id'      => $validated['location_id'] ?? null,
            'service_event_id' => $validated['service_event_id'] ?? null,
            'user_id'          => auth()->id(),
        ]);

        return back()->with('success', 'Prilog dodat.');
    }

    public function destroy(Attachment $attachment)
    {
        $attachment->delete(); // Soft delete
        return back()
            ->with('success', 'Prilog obrisan (soft delete).');
    }

    public function restore($id)
    {
        $att = Attachment::withTrashed()->findOrFail($id);
        $att->restore();
        return back()
            ->with('success', 'Prilog vraćen.');
    }

    public function forceDelete($id)
    {
        $att = Attachment::withTrashed()->findOrFail($id);
        \Storage::disk('public')->delete($att->path);
        $att->forceDelete();
        return back()
            ->with('success', 'Prilog trajno obrisan.');
    }
    public function storeForLocation(AttachmentRequest $request, Location $location)
    {
        $validated = $request->validated();

        $file = $validated['attachment'] ?? $validated['file'];
        $path = $file->store('attachments', 'public');

       Attachment::create([
            'location_id' => $location->id,
            'name'        => $validated['name'] ?? $file->getClientOriginalName(),
            'type'        => $validated['type'] ?? $file->getClientOriginalExtension(),
            'path'        => $path,
            'user_id'     => auth()->id(),
        ]);

        return redirect()->route('locations.show', $location)
            ->with('success', 'Prilog dodat.');
    }

    public function storeForServiceEvent(AttachmentRequest $request, $serviceEventId)
    {
        $validated = $request->validated();

        $serviceEvent = ServiceEvent::findOrFail($serviceEventId);

        $file = $validated['attachment'] ?? $validated['file'];
        $path = $file->store('attachments', 'public');

        $attachment = new \App\Models\Attachment([
            'name'            => $validated['name'] ?? $file->getClientOriginalName(),
            'type'            => $validated['type'] ?? $file->getClientOriginalExtension(),
            'path'            => $path,
            'service_event_id'=> $serviceEvent->id,
            'location_id'     => null,
            'user_id'         => auth()->id(),
        ]);
        $attachment->save();

        return back()
            ->with('success', 'Prilog dodat!');
    }
    public function storeForServiceEventLocation(AttachmentRequest $request, $serviceEventId, $locationId)
    {
        $validated = $request->validated();

        $serviceEvent = ServiceEvent::findOrFail($serviceEventId);
        $location     = Location::findOrFail($locationId);

        $file = $validated['attachment'] ?? $validated['file'];
        $path = $file->store('attachments', 'public');

        $attachment = new \App\Models\Attachment([
            'name'             => $validated['name'] ?? $file->getClientOriginalName(),
            'type'             => $validated['type'] ?? $file->getClientOriginalExtension(),
            'path'             => $path,
            'service_event_id' => $serviceEvent->id,
            'location_id'      => $location->id,
            'user_id'          => auth()->id(),
        ]);
        $attachment->save();

        return back()->with('success', 'Prilog dodat!');
    }


}
