@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.prescription.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.prescriptions.update", [$prescription->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="appointment_id">{{ trans('cruds.prescription.fields.appointment') }}</label>
                <select class="form-control select2 {{ $errors->has('appointment') ? 'is-invalid' : '' }}" name="appointment_id" id="appointment_id">
                    @foreach($appointments as $id => $entry)
                        <option value="{{ $id }}" {{ (old('appointment_id') ? old('appointment_id') : $prescription->appointment->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('appointment'))
                    <span class="text-danger">{{ $errors->first('appointment') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.prescription.fields.appointment_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="medication">{{ trans('cruds.prescription.fields.medication') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('medication') ? 'is-invalid' : '' }}" name="medication" id="medication">{!! old('medication', $prescription->medication) !!}</textarea>
                @if($errors->has('medication'))
                    <span class="text-danger">{{ $errors->first('medication') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.prescription.fields.medication_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="dosage">{{ trans('cruds.prescription.fields.dosage') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('dosage') ? 'is-invalid' : '' }}" name="dosage" id="dosage">{!! old('dosage', $prescription->dosage) !!}</textarea>
                @if($errors->has('dosage'))
                    <span class="text-danger">{{ $errors->first('dosage') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.prescription.fields.dosage_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="duration">{{ trans('cruds.prescription.fields.duration') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('duration') ? 'is-invalid' : '' }}" name="duration" id="duration">{!! old('duration', $prescription->duration) !!}</textarea>
                @if($errors->has('duration'))
                    <span class="text-danger">{{ $errors->first('duration') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.prescription.fields.duration_helper') }}</span>
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
                xhr.open('POST', '{{ route('admin.prescriptions.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $prescription->id ?? 0 }}');
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