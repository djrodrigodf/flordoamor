@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.treatment.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.treatments.update", [$treatment->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="patient_id">{{ trans('cruds.treatment.fields.patient') }}</label>
                <select class="form-control select2 {{ $errors->has('patient') ? 'is-invalid' : '' }}" name="patient_id" id="patient_id">
                    @foreach($patients as $id => $entry)
                        <option value="{{ $id }}" {{ (old('patient_id') ? old('patient_id') : $treatment->patient->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('patient'))
                    <span class="text-danger">{{ $errors->first('patient') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.treatment.fields.patient_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="treatment_plan">{{ trans('cruds.treatment.fields.treatment_plan') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('treatment_plan') ? 'is-invalid' : '' }}" name="treatment_plan" id="treatment_plan">{!! old('treatment_plan', $treatment->treatment_plan) !!}</textarea>
                @if($errors->has('treatment_plan'))
                    <span class="text-danger">{{ $errors->first('treatment_plan') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.treatment.fields.treatment_plan_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="start_date">{{ trans('cruds.treatment.fields.start_date') }}</label>
                <input class="form-control date {{ $errors->has('start_date') ? 'is-invalid' : '' }}" type="text" name="start_date" id="start_date" value="{{ old('start_date', $treatment->start_date) }}" required>
                @if($errors->has('start_date'))
                    <span class="text-danger">{{ $errors->first('start_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.treatment.fields.start_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="end_date">{{ trans('cruds.treatment.fields.end_date') }}</label>
                <input class="form-control date {{ $errors->has('end_date') ? 'is-invalid' : '' }}" type="text" name="end_date" id="end_date" value="{{ old('end_date', $treatment->end_date) }}">
                @if($errors->has('end_date'))
                    <span class="text-danger">{{ $errors->first('end_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.treatment.fields.end_date_helper') }}</span>
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
                xhr.open('POST', '{{ route('admin.treatments.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $treatment->id ?? 0 }}');
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