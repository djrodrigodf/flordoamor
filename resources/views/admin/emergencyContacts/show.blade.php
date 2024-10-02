@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.emergencyContact.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.emergency-contacts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.emergencyContact.fields.id') }}
                        </th>
                        <td>
                            {{ $emergencyContact->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.emergencyContact.fields.patient') }}
                        </th>
                        <td>
                            {{ $emergencyContact->patient->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.emergencyContact.fields.name') }}
                        </th>
                        <td>
                            {{ $emergencyContact->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.emergencyContact.fields.relationship') }}
                        </th>
                        <td>
                            {{ $emergencyContact->relationship }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.emergencyContact.fields.phone') }}
                        </th>
                        <td>
                            {{ $emergencyContact->phone }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.emergency-contacts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection