<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'latitude'      => 'nullable|numeric',
            'longitude'     => 'nullable|numeric',
            'city'          => 'required|string|max:255',
            'pib'           => 'nullable|string|max:50',
            'maticni'       => 'nullable|string|max:50',
            'contact'       => 'nullable|string|max:255',
            'kontakt_broj'  => 'nullable|string|max:50',
        ];
    }

}
