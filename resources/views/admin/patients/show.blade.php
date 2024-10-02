@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.patient.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.patients.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.patient.fields.id') }}
                        </th>
                        <td>
                            {{ $patient->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patient.fields.name') }}
                        </th>
                        <td>
                            {{ $patient->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patient.fields.email') }}
                        </th>
                        <td>
                            {{ $patient->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patient.fields.phone') }}
                        </th>
                        <td>
                            {{ $patient->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patient.fields.birth_date') }}
                        </th>
                        <td>
                            {{ $patient->birth_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patient.fields.rg') }}
                        </th>
                        <td>
                            {{ $patient->rg }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patient.fields.cpf') }}
                        </th>
                        <td>
                            {{ $patient->cpf }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patient.fields.address') }}
                        </th>
                        <td>
                            {{ $patient->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patient.fields.number') }}
                        </th>
                        <td>
                            {{ $patient->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patient.fields.complement') }}
                        </th>
                        <td>
                            {{ $patient->complement }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patient.fields.neighborhood') }}
                        </th>
                        <td>
                            {{ $patient->neighborhood }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patient.fields.city') }}
                        </th>
                        <td>
                            {{ $patient->city }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patient.fields.state') }}
                        </th>
                        <td>
                            {{ $patient->state }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patient.fields.postal_code') }}
                        </th>
                        <td>
                            {{ $patient->postal_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.patient.fields.observations') }}
                        </th>
                        <td>
                            {!! $patient->observations !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.patients.index') }}">
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
            <a class="nav-link" href="#patient_appointments" role="tab" data-toggle="tab">
                {{ trans('cruds.appointment.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#patient_documents" role="tab" data-toggle="tab">
                {{ trans('cruds.document.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#patient_treatments" role="tab" data-toggle="tab">
                {{ trans('cruds.treatment.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#patient_insurances" role="tab" data-toggle="tab">
                {{ trans('cruds.insurance.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#patient_emergency_contacts" role="tab" data-toggle="tab">
                {{ trans('cruds.emergencyContact.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="patient_appointments">
            @includeIf('admin.patients.relationships.patientAppointments', ['appointments' => $patient->patientAppointments])
        </div>
        <div class="tab-pane" role="tabpanel" id="patient_documents">
            @includeIf('admin.patients.relationships.patientDocuments', ['documents' => $patient->patientDocuments])
        </div>
        <div class="tab-pane" role="tabpanel" id="patient_treatments">
            @includeIf('admin.patients.relationships.patientTreatments', ['treatments' => $patient->patientTreatments])
        </div>
        <div class="tab-pane" role="tabpanel" id="patient_insurances">
            @includeIf('admin.patients.relationships.patientInsurances', ['insurances' => $patient->patientInsurances])
        </div>
        <div class="tab-pane" role="tabpanel" id="patient_emergency_contacts">
            @includeIf('admin.patients.relationships.patientEmergencyContacts', ['emergencyContacts' => $patient->patientEmergencyContacts])
        </div>
    </div>
</div>

@endsection