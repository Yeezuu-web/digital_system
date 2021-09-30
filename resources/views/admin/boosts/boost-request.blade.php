@extends('layouts.admin')
@section('styles')
    <style>
      .dataTables_scrollBody {
        overflow-y: visible !important;
        overflow-x: initial !important;
      }
    </style>
@endsection
@section('content')
@include('partials.flash-message')
<a class="btn btn-success mb-3" href="{{ route('admin.boosts.request') }}">Request New Boost</a>
<div class="card">
  <div class="card-header">
      {{ trans('cruds.boost.title_singular') }} {{ trans('global.list') }}
  </div>
  <div class="card-body">
      <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover datatable ajaxTable datatable-Boost">
              <thead>
                  <tr>
                      <th>
                          {{ trans('cruds.boost.fields.id') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.requester_name') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.company_name') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.program_name') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.channel') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.group') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.target_url') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.boost_start') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.boost_end') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.reason') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.budget') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.status') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.reference') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.created_at') }}
                      </th>
                  </tr>
              </thead>
          </table>
      </div>
  </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function() {
      let copyButtonTrans = '{{ trans('global.datatables.copy') }}'
      let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
      let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
      let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
      let printButtonTrans = '{{ trans('global.datatables.print') }}'
      let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'
      let selectAllButtonTrans = '{{ trans('global.select_all') }}'
      let selectNoneButtonTrans = '{{ trans('global.deselect_all') }}'

      let languages = {
        'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
      };

      $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
      $.extend(true, $.fn.dataTable.defaults, {
        language: {
          url: languages['{{ app()->getLocale() }}']
        },
        columnDefs: [
        {
            targets: [ 9, 10, 13 ],
            visible: false
        }],
        select: {
          style:    'multi+shift',
          selector: 'td:first-child'
        },
        autoWidth: true,
        order: [],
        scrollX: true,
        pageLength: 50,
        dom: 'Bfrtip<"actions">',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
          'pageLength',
          {
            extend: 'colvis',
            className: 'btn-default',
            text: colvisButtonTrans,
            exportOptions: {
              columns: ':visible'
            }
          }
        ]
      });

      $.fn.dataTable.ext.classes.sPageButton = '';
    });

</script>
<script>
$(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  @can('user_alert_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let _token= $('input[name="_token"]').val();
  let deleteButton = {
      text: deleteButtonTrans,
      url: "{{ route('admin.boosts.massDestroy') }}",
      className: 'btn-danger',
      action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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
          .done(function () { table.draw(); })
      }
      }
  }
  dtButtons.push(deleteButton)
  @endcan

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.boosts.requestIndex') }}",
    columns: [
        { data: 'id', name: 'id' },
        { data: 'requester_name', name: 'requester_name' },
        { data: 'company_name', name: 'company_name' },
        { data: 'program_name', name: 'program_name' },
        { data: 'channel', name: 'channel.title' },
        { data: 'group', name: 'group' },
        { data: 'target_url', name: 'target_url' },
        { data: 'boost_start', name: 'boost_start' },
        { data: 'boost_end', name: 'boost_end' },
        { data: 'reason', name: 'reason' },
        { data: 'budget', name: 'budget' },
        { data: 'status', name: 'status' },
        { data: 'reference', name: 'reference', sortable: false, searchable: false },
        { data: 'created_at', name: 'created_at' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
    autoWidth: false,
    scrollX: true
  };
  let table = $('.datatable-Boost').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

  $('body').find('.dataTables_scrollBody').wrap('');
  $('.datatable-Boost').doubleScroll();
});

</script>

@endsection