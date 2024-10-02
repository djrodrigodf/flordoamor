<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAppointmentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('appointment_edit');
    }

    public function rules()
    {
        return [
            'patient_id' => [
                'required',
                'integer',
            ],
            'appointment_date' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
            'doctor_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
