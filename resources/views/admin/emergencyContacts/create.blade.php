@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.emergencyContact.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.emergency-contacts.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="patient_id">{{ trans('cruds.emergencyContact.fields.patient') }}</label>
                <select class="form-control select2 {{ $errors->has('patient') ? 'is-invalid' : '' }}" name="patient_id" id="patient_id">
                    @foreach($patients as $id => $entry)
                        <option value="{{ $id }}" {{ old('patient_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('patient'))
                    <span class="text-danger">{{ $errors->first('patient') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.emergencyContact.fields.patient_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name">{{ trans('cruds.emergencyContact.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.emergencyContact.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="relationship">{{ trans('cruds.emergencyContact.fields.relationship') }}</label>
                <input class="form-control {{ $errors->has('relationship') ? 'is-invalid' : '' }}" type="text" name="relationship" id="relationship" value="{{ old('relationship', '') }}">
                @if($errors->has('relationship'))
                    <span class="text-danger">{{ $errors->first('relationship') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.emergencyContact.fields.relationship_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">{{ trans('cruds.emergencyContact.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}">
                @if($errors->has('phone'))
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.emergencyContact.fields.phone_helper') }}</span>
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