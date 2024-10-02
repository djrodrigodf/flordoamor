@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.appointment.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.appointments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.appointment.fields.id') }}
                        </th>
                        <td>
                            {{ $appointment->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.appointment.fields.patient') }}
                        </th>
                        <td>
                            {{ $appointment->patient->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.appointment.fields.appointment_date') }}
                        </th>
                        <td>
                            {{ $appointment->appointment_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.appointment.fields.doctor') }}
                        </th>
                        <td>
                            {{ $appointment->doctor->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.appointment.fields.reason') }}
                        </th>
                        <td>
                            {!! $appointment->reason !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.appointment.fields.diagnosis') }}
                        </th>
                        <td>
                            {!! $appointment->diagnosis !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.appointments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#appointment_prescriptions" role="tab" data-toggle="tab">
                {{ trans('cruds.prescription.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#appointment_diagnosis" role="tab" data-toggle="tab">
                {{ trans('cruds.diagnosi.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#appointment_medical_reports" role="tab" data-toggle="tab">
                {{ trans('cruds.medicalReport.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="appointment_prescriptions">
            @includeIf('admin.appointments.relationships.appointmentPrescriptions', ['prescriptions' => $appointment->appointmentPrescriptions])
        </div>
        <div class="tab-pane" role="tabpanel" id="appointment_diagnosis">
            @includeIf('admin.appointments.relationships.appointmentDiagnosis', ['diagnosis' => $appointment->appointmentDiagnosis])
        </div>
        <div class="tab-pane" role="tabpanel" id="appointment_medical_reports">
            @includeIf('admin.appointments.relationships.appointmentMedicalReports', ['medicalReports' => $appointment->appointmentMedicalReports])
        </div>
    </div>
</div>

@endsection