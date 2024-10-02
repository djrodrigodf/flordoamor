@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.insurance.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.insurances.update", [$insurance->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="patient_id">{{ trans('cruds.insurance.fields.patient') }}</label>
                <select class="form-control select2 {{ $errors->has('patient') ? 'is-invalid' : '' }}" name="patient_id" id="patient_id">
                    @foreach($patients as $id => $entry)
                        <option value="{{ $id }}" {{ (old('patient_id') ? old('patient_id') : $insurance->patient->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('patient'))
                    <span class="text-danger">{{ $errors->first('patient') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.insurance.fields.patient_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="insurance_name">{{ trans('cruds.insurance.fields.insurance_name') }}</label>
                <input class="form-control {{ $errors->has('insurance_name') ? 'is-invalid' : '' }}" type="text" name="insurance_name" id="insurance_name" value="{{ old('insurance_name', $insurance->insurance_name) }}">
                @if($errors->has('insurance_name'))
                    <span class="text-danger">{{ $errors->first('insurance_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.insurance.fields.insurance_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="policy_number">{{ trans('cruds.insurance.fields.policy_number') }}</label>
                <input class="form-control {{ $errors->has('policy_number') ? 'is-invalid' : '' }}" type="text" name="policy_number" id="policy_number" value="{{ old('policy_number', $insurance->policy_number) }}">
                @if($errors->has('policy_number'))
                    <span class="text-danger">{{ $errors->first('policy_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.insurance.fields.policy_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="valid_until">{{ trans('cruds.insurance.fields.valid_until') }}</label>
                <input class="form-control date {{ $errors->has('valid_until') ? 'is-invalid' : '' }}" type="text" name="valid_until" id="valid_until" value="{{ old('valid_until', $insurance->valid_until) }}">
                @if($errors->has('valid_until'))
                    <span class="text-danger">{{ $errors->first('valid_until') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.insurance.fields.valid_until_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection