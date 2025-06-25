<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $companyId = $this->route('company')?->id ?? null;

        return [
            'name'          => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'contact_email' => [
                'required',
                'email',
                Rule::unique('companies', 'contact_email')->ignore($companyId),
            ],
            'contact_phone' => 'required|string|max:20',
            'city'          => 'required|string|max:255',
            'pib'           => [
                'required',
                'string',
                'max:20',
                Rule::unique('companies', 'pib')->ignore($companyId),
            ],
            'maticni_broj'  => [
                'required',
                'string',
                'max:20',
                Rule::unique('companies', 'maticni_broj')->ignore($companyId),
            ],
            'website'       => 'nullable|url',
        ];
    }
}
