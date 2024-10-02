<?php

namespace App\Http\Requests;

use App\Models\MedicalReport;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyMedicalReportRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('medical_report_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:medical_reports,id',
        ];
    }
}