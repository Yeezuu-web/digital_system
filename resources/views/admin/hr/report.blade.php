@extends('layouts.admin')

@section('styles')
    <style>
        thead input {
            width: 100%;
        }
    </style>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <h6 class="card-title">Report</h6>
        <div class="table-responsive">
            <table class="display table table-bordered table-striped table-hover datatable datatable-LeaveRequest" style="width:100%">
                <thead>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.empId') }}
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
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaveRequests as $key => $leaveRequest)
                        <tr data-entry-id="{{ $leaveRequest->id }}">
                            <td>
                                {{ $leaveRequest->employee->empId ?? '' }}
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
                                {{ $leaveRequest->no_of_day ?? '' }} {{ $leaveRequest->no_of_day ? 'day(s)' : '' }}
                            </td>
                            <td>
                                {{ $leaveRequest->reason ?? '' }}
                            </td>
                            <td>
                                @if ($leaveRequest->status == '0')
                                    <span class="badge badge-info">In Review</span>
                                @elseif ($leaveRequest->status == '1')
                                    <span class="badge badge-warning">First Approved</span>
                                @elseif ($leaveRequest->status == '2')
                                    <span class="badge badge-success">Approved</span>
                                @else
                                    <span class="badge badge-danger">First Approved</span>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
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
        orderCellsTop: true,
        dom: 'Bfrtip<"actions">',
        lengthMenu: [
            [ 10, 25, 50, 100, -1 ],
            [ '10 rows', '25 rows', '50 rows', '1000 rows', 'Show all' ]
        ],
        initComplete: function () {
            var api = this.api();

            // For each column
            api
                .columns()
                .eq(0)
                .each(function (colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" placeholder="'+ title.replaceAll(' ','') +'" />');
                    // On every keypress in this input
                    $(
                        'input',
                        $('.filters th').eq($(api.column(colIdx).header()).index())
                    )
                        .off('keyup change')
                        .on('keyup change', function (e) {
                            e.stopPropagation();

                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();

                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();

                            $(this)
                                .focus()[0]
                                .setSelectionRange(cursorPosition, cursorPosition);
                        });
                });
        },
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
          },
          {
            extend: 'excel',
            className: 'btn-default',
            text: excelButtonTrans,
            exportOptions: {
              columns: ':visible'
            }
          },
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
        // Setup - add a text input to each footer cell
        $('.datatable-LeaveRequest:not(.ajaxTable) thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('.datatable-LeaveRequest:not(.ajaxTable) thead');
    
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