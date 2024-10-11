<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreInsuranceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('insurance_create');
    }

    public function rules()
    {
        return [
            'insurance_name' => [
                'string',
                'nullable',
            ],
            'policy_number' => [
                'string',
                'nullable',
            ],
            'valid_until' => [
                'date_format:'.config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
