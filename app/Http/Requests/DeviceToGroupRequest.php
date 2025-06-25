<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class DeviceToGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'device_id' => 'required|exists:devices,id',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $deviceId = $this->input('device_id');
            $group = $this->route('group');
            $device = \App\Models\Device::find($deviceId);

            if (!$device || $device->location_id != $group->location_id || !is_null($device->group_id)) {
                $validator->errors()->add('device_id', 'Odabrani uređaj nije validan ili je već dodeljen nekoj grupi.');
            }
        });
    }
}
