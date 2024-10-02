<?php

namespace App\Http\Requests;

use App\Models\MedicalReport;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

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
