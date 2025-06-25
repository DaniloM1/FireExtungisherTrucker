<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category'           => 'required|in:pp_device,hydrant',
            'service_date'       => 'required|date',
            'next_service_date'  => 'required|date',
            'evid_number'        => 'required|string',
            'user_id'            => 'required|integer',
            'description'        => 'nullable|string',
            'cost'               => 'required|numeric',
            'status'             => 'sometimes|in:active,inactive',
            'locations'          => 'required|array',
            'locations.*'        => 'exists:locations,id',
        ];
    }
}
