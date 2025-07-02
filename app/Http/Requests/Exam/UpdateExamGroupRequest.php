<?php

namespace App\Http\Requests\Exam;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExamGroupRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'       => 'required|string|max:255',
            'start_date' => 'required|date',
            'exam_date'  => 'nullable|date|after_or_equal:start_date',
        ];
    }
}
