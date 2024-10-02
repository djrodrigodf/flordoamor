@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.treatment.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.treatments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.treatment.fields.id') }}
                        </th>
                        <td>
                            {{ $treatment->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.treatment.fields.patient') }}
                        </th>
                        <td>
                            {{ $treatment->patient->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.treatment.fields.treatment_plan') }}
                        </th>
                        <td>
                            {!! $treatment->treatment_plan !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.treatment.fields.start_date') }}
                        </th>
                        <td>
                            {{ $treatment->start_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.treatment.fields.end_date') }}
                        </th>
                        <td>
                            {{ $treatment->end_date }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.treatments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection