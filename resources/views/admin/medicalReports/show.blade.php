@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.medicalReport.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.medical-reports.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.medicalReport.fields.id') }}
                        </th>
                        <td>
                            {{ $medicalReport->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.medicalReport.fields.appointment') }}
                        </th>
                        <td>
                            {{ $medicalReport->appointment->appointment_date ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.medicalReport.fields.report_type') }}
                        </th>
                        <td>
                            {{ App\Models\MedicalReport::REPORT_TYPE_SELECT[$medicalReport->report_type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.medicalReport.fields.file') }}
                        </th>
                        <td>
                            @foreach($medicalReport->file as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.medicalReport.fields.observations') }}
                        </th>
                        <td>
                            {!! $medicalReport->observations !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.medical-reports.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection