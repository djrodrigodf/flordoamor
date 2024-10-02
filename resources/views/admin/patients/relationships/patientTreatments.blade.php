<div class="m-3">
    @can('treatment_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.treatments.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.treatment.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.treatment.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-patientTreatments">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.treatment.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.treatment.fields.patient') }}
                            </th>
                            <th>
                                {{ trans('cruds.treatment.fields.start_date') }}
                            </th>
                            <th>
                                {{ trans('cruds.treatment.fields.end_date') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($treatments as $key => $treatment)
                            <tr data-entry-id="{{ $treatment->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $treatment->id ?? '' }}
                                </td>
                                <td>
                                    {{ $treatment->patient->name ?? '' }}
                                </td>
                                <td>
                                    {{ $treatment->start_date ?? '' }}
                                </td>
                                <td>
                                    {{ $treatment->end_date ?? '' }}
                                </td>
                                <td>
                                    @can('treatment_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.treatments.show', $treatment->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('treatment_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.treatments.edit', $treatment->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('treatment_delete')
                                        <form action="{{ route('admin.treatments.destroy', $treatment->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('treatment_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.treatments.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-patientTreatments:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection