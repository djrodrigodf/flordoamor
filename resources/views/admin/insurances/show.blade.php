@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.insurance.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.insurances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.insurance.fields.id') }}
                        </th>
                        <td>
                            {{ $insurance->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.insurance.fields.patient') }}
                        </th>
                        <td>
                            {{ $insurance->patient->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.insurance.fields.insurance_name') }}
                        </th>
                        <td>
                            {{ $insurance->insurance_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.insurance.fields.policy_number') }}
                        </th>
                        <td>
                            {{ $insurance->policy_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.insurance.fields.valid_until') }}
                        </th>
                        <td>
                            {{ $insurance->valid_until }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.insurances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection