<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreTreatmentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('treatment_create');
    }

    public function rules()
    {
        return [
            'start_date' => [
                'required',
                'date_format:'.config('panel.date_format'),
            ],
            'end_date' => [
                'date_format:'.config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
