@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.medicalReport.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.medical-reports.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="appointment_id">{{ trans('cruds.medicalReport.fields.appointment') }}</label>
                <select class="form-control select2 {{ $errors->has('appointment') ? 'is-invalid' : '' }}" name="appointment_id" id="appointment_id">
                    @foreach($appointments as $id => $entry)
                        <option value="{{ $id }}" {{ old('appointment_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('appointment'))
                    <span class="text-danger">{{ $errors->first('appointment') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.medicalReport.fields.appointment_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.medicalReport.fields.report_type') }}</label>
                <select class="form-control {{ $errors->has('report_type') ? 'is-invalid' : '' }}" name="report_type" id="report_type">
                    <option value disabled {{ old('report_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\MedicalReport::REPORT_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('report_type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('report_type'))
                    <span class="text-danger">{{ $errors->first('report_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.medicalReport.fields.report_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="file">{{ trans('cruds.medicalReport.fields.file') }}</label>
                <div class="needsclick dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}" id="file-dropzone">
                </div>
                @if($errors->has('file'))
                    <span class="text-danger">{{ $errors->first('file') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.medicalReport.fields.file_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="observations">{{ trans('cruds.medicalReport.fields.observations') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('observations') ? 'is-invalid' : '' }}" name="observations" id="observations">{!! old('observations') !!}</textarea>
                @if($errors->has('observations'))
                    <span class="text-danger">{{ $errors->first('observations') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.medicalReport.fields.observations_helper') }}</span>
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
    var uploadedFileMap = {}
Dropzone.options.fileDropzone = {
    url: '{{ route('admin.medical-reports.storeMedia') }}',
    maxFilesize: 200, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 200
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="file[]" value="' + response.name + '">')
      uploadedFileMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedFileMap[file.name]
      }
      $('form').find('input[name="file[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($medicalReport) && $medicalReport->file)
          var files =
            {!! json_encode($medicalReport->file) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="file[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
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
                xhr.open('POST', '{{ route('admin.medical-reports.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $medicalReport->id ?? 0 }}');
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