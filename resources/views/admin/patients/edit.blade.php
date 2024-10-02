@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.patient.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.patients.update", [$patient->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.patient.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $patient->name) }}">
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.patient.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="email">{{ trans('cruds.patient.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $patient->email) }}" required>
                @if($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.patient.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">{{ trans('cruds.patient.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $patient->phone) }}">
                @if($errors->has('phone'))
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.patient.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="birth_date">{{ trans('cruds.patient.fields.birth_date') }}</label>
                <input class="form-control date {{ $errors->has('birth_date') ? 'is-invalid' : '' }}" type="text" name="birth_date" id="birth_date" value="{{ old('birth_date', $patient->birth_date) }}">
                @if($errors->has('birth_date'))
                    <span class="text-danger">{{ $errors->first('birth_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.patient.fields.birth_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="rg">{{ trans('cruds.patient.fields.rg') }}</label>
                <input class="form-control {{ $errors->has('rg') ? 'is-invalid' : '' }}" type="text" name="rg" id="rg" value="{{ old('rg', $patient->rg) }}">
                @if($errors->has('rg'))
                    <span class="text-danger">{{ $errors->first('rg') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.patient.fields.rg_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="cpf">{{ trans('cruds.patient.fields.cpf') }}</label>
                <input class="form-control {{ $errors->has('cpf') ? 'is-invalid' : '' }}" type="text" name="cpf" id="cpf" value="{{ old('cpf', $patient->cpf) }}" required>
                @if($errors->has('cpf'))
                    <span class="text-danger">{{ $errors->first('cpf') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.patient.fields.cpf_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.patient.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', $patient->address) }}">
                @if($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.patient.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="number">{{ trans('cruds.patient.fields.number') }}</label>
                <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="text" name="number" id="number" value="{{ old('number', $patient->number) }}">
                @if($errors->has('number'))
                    <span class="text-danger">{{ $errors->first('number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.patient.fields.number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="complement">{{ trans('cruds.patient.fields.complement') }}</label>
                <input class="form-control {{ $errors->has('complement') ? 'is-invalid' : '' }}" type="text" name="complement" id="complement" value="{{ old('complement', $patient->complement) }}">
                @if($errors->has('complement'))
                    <span class="text-danger">{{ $errors->first('complement') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.patient.fields.complement_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="neighborhood">{{ trans('cruds.patient.fields.neighborhood') }}</label>
                <input class="form-control {{ $errors->has('neighborhood') ? 'is-invalid' : '' }}" type="text" name="neighborhood" id="neighborhood" value="{{ old('neighborhood', $patient->neighborhood) }}">
                @if($errors->has('neighborhood'))
                    <span class="text-danger">{{ $errors->first('neighborhood') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.patient.fields.neighborhood_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="city">{{ trans('cruds.patient.fields.city') }}</label>
                <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', $patient->city) }}">
                @if($errors->has('city'))
                    <span class="text-danger">{{ $errors->first('city') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.patient.fields.city_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="state">{{ trans('cruds.patient.fields.state') }}</label>
                <input class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" type="text" name="state" id="state" value="{{ old('state', $patient->state) }}">
                @if($errors->has('state'))
                    <span class="text-danger">{{ $errors->first('state') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.patient.fields.state_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="postal_code">{{ trans('cruds.patient.fields.postal_code') }}</label>
                <input class="form-control {{ $errors->has('postal_code') ? 'is-invalid' : '' }}" type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $patient->postal_code) }}">
                @if($errors->has('postal_code'))
                    <span class="text-danger">{{ $errors->first('postal_code') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.patient.fields.postal_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="observations">{{ trans('cruds.patient.fields.observations') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('observations') ? 'is-invalid' : '' }}" name="observations" id="observations">{!! old('observations', $patient->observations) !!}</textarea>
                @if($errors->has('observations'))
                    <span class="text-danger">{{ $errors->first('observations') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.patient.fields.observations_helper') }}</span>
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

@section('scripts')
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.patients.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $patient->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

@endsection