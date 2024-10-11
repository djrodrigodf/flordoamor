<div>
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.document.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            @can('document_create')
                <div class="row mb-3">
                    <div class="col">
                        <a class="btn btn-success" href="{{ route('admin.documents.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.document.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan

            <div class="row mb-2">
                <div class="col">
                    <input type="text" wire:model.debounce.300ms="search" class="form-control" placeholder="Pesquisar...">
                </div>
            </div>

            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>{{ trans('cruds.document.fields.id') }}</th>
                    <th>{{ trans('cruds.document.fields.patient') }}</th>
                    <th>{{ trans('cruds.document.fields.document_type') }}</th>
                    <th>{{ trans('cruds.document.fields.description') }}</th>
                    <th>{{ trans('cruds.document.fields.file') }}</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @forelse($documents as $document)
                    <tr>
                        <td>{{ $document->id }}</td>
                        <td>{{ $document->patient->name ?? '' }}</td>
                        <td>{{ App\Models\Document::DOCUMENT_TYPE_SELECT[$document->document_type] ?? '' }}</td>
                        <td>{{ $document->description }}</td>
                        <td>
                            @if($document->file)
                                <a href="{{ $document->file->getUrl() }}" target="_blank">{{ trans('global.downloadFile') }}</a>
                            @endif
                        </td>
                        <td>
                            @can('document_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.documents.show', $document->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan

                            @can('document_edit')
                                <a class="btn btn-xs btn-info" href="{{ route('admin.documents.edit', $document->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan

                            @can('document_delete')
                                <button class="btn btn-xs btn-danger" wire:click="delete({{ $document->id }})" onclick="confirm('{{ trans('global.areYouSure') }}') || event.stopImmediatePropagation()">
                                    {{ trans('global.delete') }}
                                </button>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">{{ trans('global.no_entries_in_table') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{ $documents->links() }}
        </div>
    </div>
</div>
