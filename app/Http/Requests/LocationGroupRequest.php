<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'locations'   => 'nullable|array',
            'locations.*' => 'exists:locations,id'
        ];
    }
}

