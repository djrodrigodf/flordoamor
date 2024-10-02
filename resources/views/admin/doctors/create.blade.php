@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.doctor.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.doctors.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.doctor.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.doctor.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="specialty">{{ trans('cruds.doctor.fields.specialty') }}</label>
                <input class="form-control {{ $errors->has('specialty') ? 'is-invalid' : '' }}" type="text" name="specialty" id="specialty" value="{{ old('specialty', '') }}">
                @if($errors->has('specialty'))
                    <span class="text-danger">{{ $errors->first('specialty') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.doctor.fields.specialty_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="crm">{{ trans('cruds.doctor.fields.crm') }}</label>
                <input class="form-control {{ $errors->has('crm') ? 'is-invalid' : '' }}" type="text" name="crm" id="crm" value="{{ old('crm', '') }}">
                @if($errors->has('crm'))
                    <span class="text-danger">{{ $errors->first('crm') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.doctor.fields.crm_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">{{ trans('cruds.doctor.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}">
                @if($errors->has('phone'))
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.doctor.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.doctor.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}">
                @if($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.doctor.fields.email_helper') }}</span>
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