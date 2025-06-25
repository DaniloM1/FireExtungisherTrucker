<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class DeviceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'serial_number'     => 'required|string|max:255',
            'model'             => 'required|string|max:255',
            'manufacturer'      => 'required|string|max:255',
            'manufacture_date'  => 'nullable|date',
            'next_service_date' => 'nullable|date',
            'position'          => 'nullable|string|max:255',
            'status'            => 'required|in:active,inactive,needs_service',
            'group_id'          => 'nullable|exists:groups,id',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $groupId = $this->input('group_id');
            $locationId = $this->route('location')?->id ?? $this->route('device')?->location_id ?? null;

            if ($groupId && $locationId) {
                $group = \App\Models\Group::find($groupId);
                if (!$group || $group->location_id != $locationId) {
                    $validator->errors()->add('group_id', 'Odabrana grupa ne pripada ovoj lokaciji.');
                }
            }
        });
    }
}

