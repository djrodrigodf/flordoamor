<div>
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.document.title_singular') }}
        </div>

        <div class="card-body">
            <form wire:submit.prevent="submit">
                <div class="form-group">
                    <label for="patient_id">{{ trans('cruds.document.fields.patient') }}</label>
                    <select class="form-control" wire:model="patient_id" id="patient_id">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                        @foreach($patients as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('patient_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>{{ trans('cruds.document.fields.document_type') }}</label>
                    <select class="form-control" wire:model="document_type" id="document_type">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\Document::DOCUMENT_TYPE_SELECT as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('document_type') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="file">{{ trans('cruds.document.fields.file') }}</label>
                    <input type="file" wire:model="file" class="form-control-file" id="file">
                    @error('file') <span class="text-danger">{{ $message }}</span> @enderror

                    @if ($file)
                        <div class="mt-2">
                            <strong>{{ trans('global.selected_file') }}:</strong> {{ $file->getClientOriginalName() }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="description">{{ trans('cruds.document.fields.description') }}</label>
                    <textarea class="form-control" wire:model="description" id="description"></textarea>
                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                    <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">
                        {{ trans('global.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
