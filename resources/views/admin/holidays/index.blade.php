@extends('layouts.admin')

@section('content')
@include('partials.flash-message')

<div class="mt-2">
    <a class="btn btn-success" href="{{ route('admin.holidays.create') }}">
        {{ trans('global.add') }} {{ trans('cruds.holiday.title_singular') }}
    </a>
</div>
<div class="card mt-3">
    <div class="card-body">
        <h6 class="card-title">Holiday List</h6>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Holiday">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.holiday.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.holiday.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.holiday.fields.dates') }}
                        </th>
                        <th>
                            {{ trans('cruds.holiday.fields.year') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($holidays as $key => $holiday)
                        <tr data-entry-id="{{ $holiday->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $holiday->id ?? '' }}
                            </td>
                            <td>
                                {{ $holiday->title ?? '' }}
                            </td>
                            <td>
                                @foreach ($holiday->dates as $item) 
                                    <span class="badge badge-info">{{ $item }}</span>
                                @endforeach
                            </td>
                            <td>
                                {{ $holiday->year ?? '' }}
                            </td>
                            <td>
                                @can('holiday_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.holidays.show', $holiday) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('holiday_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.holidays.edit', $holiday) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('holiday_delete')
                                    <form action="{{ route('admin.holidays.destroy', $holiday) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
        @can('holiday_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.holidays.massDestroy') }}",
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
        let table = $('.datatable-Holiday:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
        
    })
</script>

@endsection