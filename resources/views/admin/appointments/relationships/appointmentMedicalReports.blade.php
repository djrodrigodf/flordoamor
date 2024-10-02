<div class="m-3">
    @can('medical_report_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.medical-reports.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.medicalReport.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.medicalReport.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-appointmentMedicalReports">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.medicalReport.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.medicalReport.fields.appointment') }}
                            </th>
                            <th>
                                {{ trans('cruds.medicalReport.fields.report_type') }}
                            </th>
                            <th>
                                {{ trans('cruds.medicalReport.fields.file') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medicalReports as $key => $medicalReport)
                            <tr data-entry-id="{{ $medicalReport->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $medicalReport->id ?? '' }}
                                </td>
                                <td>
                                    {{ $medicalReport->appointment->appointment_date ?? '' }}
                                </td>
                                <td>
                                    {{ App\Models\MedicalReport::REPORT_TYPE_SELECT[$medicalReport->report_type] ?? '' }}
                                </td>
                                <td>
                                    @foreach($medicalReport->file as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank">
                                            {{ trans('global.view_file') }}
                                        </a>
                                    @endforeach
                                </td>
                                <td>
                                    @can('medical_report_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.medical-reports.show', $medicalReport->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('medical_report_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.medical-reports.edit', $medicalReport->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('medical_report_delete')
                                        <form action="{{ route('admin.medical-reports.destroy', $medicalReport->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('medical_report_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.medical-reports.massDestroy') }}",
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
  let table = $('.datatable-appointmentMedicalReports:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection