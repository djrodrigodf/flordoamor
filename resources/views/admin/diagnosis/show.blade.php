@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.diagnosi.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.diagnosis.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.diagnosi.fields.id') }}
                        </th>
                        <td>
                            {{ $diagnosi->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.diagnosi.fields.appointment') }}
                        </th>
                        <td>
                            {{ $diagnosi->appointment->appointment_date ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.diagnosi.fields.description') }}
                        </th>
                        <td>
                            {!! $diagnosi->description !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.diagnosis.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection