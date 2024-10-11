<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicalReportRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('medical_report_edit');
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
