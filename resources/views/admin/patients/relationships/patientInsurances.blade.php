<div class="m-3">
    @can('insurance_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.insurances.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.insurance.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.insurance.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-patientInsurances">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.insurance.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.insurance.fields.patient') }}
                            </th>
                            <th>
                                {{ trans('cruds.insurance.fields.insurance_name') }}
                            </th>
                            <th>
                                {{ trans('cruds.insurance.fields.policy_number') }}
                            </th>
                            <th>
                                {{ trans('cruds.insurance.fields.valid_until') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($insurances as $key => $insurance)
                            <tr data-entry-id="{{ $insurance->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $insurance->id ?? '' }}
                                </td>
                                <td>
                                    {{ $insurance->patient->name ?? '' }}
                                </td>
                                <td>
                                    {{ $insurance->insurance_name ?? '' }}
                                </td>
                                <td>
                                    {{ $insurance->policy_number ?? '' }}
                                </td>
                                <td>
                                    {{ $insurance->valid_until ?? '' }}
                                </td>
                                <td>
                                    @can('insurance_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.insurances.show', $insurance->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('insurance_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.insurances.edit', $insurance->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('insurance_delete')
                                        <form action="{{ route('admin.insurances.destroy', $insurance->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('insurance_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.insurances.massDestroy') }}",
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
  let table = $('.datatable-patientInsurances:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection