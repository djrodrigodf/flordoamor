<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreMedicalReportRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('medical_report_create');
    }

    public function rules()
    {
        return [
            'file' => [
                'array',
            ],
        ];
    }
}
