@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.document.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.documents.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.document.fields.id') }}
                        </th>
                        <td>
                            {{ $document->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.document.fields.patient') }}
                        </th>
                        <td>
                            {{ $document->patient->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.document.fields.document_type') }}
                        </th>
                        <td>
                            {{ App\Models\Document::DOCUMENT_TYPE_SELECT[$document->document_type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.document.fields.file') }}
                        </th>
                        <td>
                            @if($document->file)
                                <a href="{{ $document->file->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.document.fields.description') }}
                        </th>
                        <td>
                            {{ $document->description }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.documents.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection