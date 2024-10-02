<?php

namespace App\Http\Requests;

use App\Models\MedicalReport;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

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
