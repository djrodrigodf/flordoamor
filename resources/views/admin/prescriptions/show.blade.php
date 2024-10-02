@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.prescription.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.prescriptions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.prescription.fields.id') }}
                        </th>
                        <td>
                            {{ $prescription->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.prescription.fields.appointment') }}
                        </th>
                        <td>
                            {{ $prescription->appointment->appointment_date ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.prescription.fields.medication') }}
                        </th>
                        <td>
                            {!! $prescription->medication !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.prescription.fields.dosage') }}
                        </th>
                        <td>
                            {!! $prescription->dosage !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.prescription.fields.duration') }}
                        </th>
                        <td>
                            {!! $prescription->duration !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.prescriptions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection