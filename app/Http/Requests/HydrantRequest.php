<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class HydrantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'serial_number'     => 'nullable|string|max:255',
            'type'              => 'nullable|string|max:255',
            'model'             => 'nullable|string|max:255',
            'manufacturer'      => 'nullable|string|max:255',
            'manufacture_date'  => 'nullable|date',
            'next_service_date' => 'nullable|date',
            'position'          => 'nullable|string|max:255',
            'hvp'               => 'nullable|date',
            'static_pressure'   => 'nullable|numeric',
            'dynamic_pressure'  => 'nullable|numeric',
            'flow'              => 'nullable|numeric',
            'status'            => 'nullable|string|max:255',
        ];
    }
}
