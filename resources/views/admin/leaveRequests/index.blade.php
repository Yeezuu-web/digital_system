@extends('layouts.admin')

@section('content')
@can('leave_request_create')

@include('partials.flash-message')

<div class="mt-2">
    <a class="btn btn-success" href="{{ route('admin.leaveRequests.create') }}">
        {{ trans('global.add') }} {{ trans('cruds.leaveRequest.title_singular') }}
    </a>
</div>
<div class="card mt-3">
    <div class="card-body">
        <h6 class="card-title">Leave Type List</h6>
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-LeaveRequest">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.leaveRequest.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveRequest.fields.employee') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveRequest.fields.leave_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveRequest.fields.commencement_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveRequest.fields.resumption_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveRequest.fields.no_of_day') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveRequest.fields.reason') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveRequest.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaveRequests as $key => $leaveRequest)
                        <tr data-entry-id="{{ $leaveRequest->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $leaveRequest->id ?? '' }}
                            </td>
                            <td>
                                {{ $leaveRequest->employee->first_name ?? '' }} {{ $leaveRequest->employee->last_name ?? '' }}
                            </td>
                            <td>
                                {{ $leaveRequest->leaveType->title ?? '' }}
                            </td>
                            <td>
                                {{ $leaveRequest->commencement_date ?? '' }}
                            </td>
                            <td>
                                {{ $leaveRequest->resumption_date ?? '' }}
                            </td>
                            <td>
                                {{ $leaveRequest->no_of_day ?? '' }}
                            </td>
                            <td>
                                {{ $leaveRequest->reason ?? '' }}
                            </td>
                            <td>
                                {{ $leaveRequest->status ?? '' }}
                            </td>
                            <td>
                                @can('leave_request_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.leaveRequests.show', $leaveRequest->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('leave_request_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.leaveRequests.edit', $leaveRequest->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('leave_request_delete')
                                    <form action="{{ route('admin.leaveRequests.destroy', $leaveRequest->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@endcan
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
            orderable: false,
            className: 'dtr-control',
            targets: 0
        }, 
        {
            orderable: false,
            searchable: false,
            targets: -1
        }],
        select: {
          style:    'multi+shift',
          selector: 'td:first-child'
        },
        order: [],
        scroller: true,
        scrollX: false,
        pageLength: 100,
        dom: 'Bfrtip<"actions">',
        lengthMenu: [
            [ 10, 25, 50, 100, -1 ],
            [ '10 rows', '25 rows', '50 rows', '1000 rows', 'Show all' ]
        ],
        buttons: [
          'pageLength',
          {
            extend: 'selectAll',
            className: 'btn-primary',
            text: selectAllButtonTrans,
            exportOptions: {
              columns: ':visible'
            },
            action: function(e, dt) {
              e.preventDefault()
              dt.rows().deselect();
              dt.rows({ search: 'applied' }).select();
            }
          },
          {
            extend: 'selectNone',
            className: 'btn-primary',
            text: selectNoneButtonTrans,
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
        @can('leave_request_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.leaveRequests.massDestroy') }}",
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
                .done(function () { table.ajax.reload(); })
            }
            }
        }
        dtButtons.push(deleteButton)
        @endcan

        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[ 1, 'desc' ]],
            select: false,
            pageLength: 100,
            select: true
        });
        let table = $('.datatable-LeaveRequest:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
        
    })
</script>

@endsection