<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class AttachmentRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file'       => 'required_without:attachment|file|max:10240',
            'attachment' => 'required_without:file|file|max:10240',
            'name'             => 'nullable|string|max:255',
            'type'             => 'nullable|string|max:255',
            'location_id'      => 'nullable|exists:locations,id',
            'service_event_id' => 'nullable|exists:service_events,id',
        ];
    }
}
