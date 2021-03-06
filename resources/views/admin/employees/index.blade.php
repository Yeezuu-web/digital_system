@extends('layouts.admin')

@section('content')
@can('employee_create')

@include('partials.flash-message')

<div class="mt-2">
    <a class="btn btn-success" href="{{ route('admin.employees.create') }}">
        {{ trans('global.add') }} {{ trans('cruds.employee.title_singular') }}
    </a>
</div>
<div class="card mt-3">
    <div class="card-body">
        <h6 class="card-title">Employee List</h6>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable-Employee">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.empId') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.first_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.last_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.gender') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.eligible') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.unpaid') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.hire_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.position') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.departement') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.user') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $key => $employee)
                        <tr data-entry-id="{{ $employee->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $employee->id ?? '' }}
                            </td>
                            <td>
                                {{ $employee->empId ?? '' }}
                            </td>
                            <td>
                                {{ $employee->first_name ?? '' }}
                            </td>
                            <td>
                                {{ $employee->last_name ?? '' }}
                            </td>
                            <td>
                                {{ $employee->gender ?? '' }}
                            </td>
                            <td>
                                {{ $employee->eligible_leave ?? ''}} {{ $employee->eligible_leave >= 0 ? 'Day(s)' : '' }}
                            </td>
                            <td>
                                {{ $employee->leave_taken ?? ''}} {{ $employee->leave_taken >= 0 ? 'Day(s)' : '' }}
                            </td>
                            <td>
                                {{ $employee->hire_date ?? ''}}
                            </td>
                            <td>
                                {{ $employee->position->title ?? '' }}
                            </td>
                            <td>
                                {{ $employee->department->title ?? '' }}
                            </td>
                            <td>
                                {{ $employee->user->name ?? '' }}
                            </td>
                            <td>
                                @can('employee_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.employees.show', $employee) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('employee_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.employees.edit', $employee) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('employee_delete')
                                    <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
        autoWidth: true,
        pageLength: 50,
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
        @can('employee_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.employees.massDestroy') }}",
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
            pageLength: 50,
            select: true
        });
        let table = $('.datatable-Employee:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
        
    })
</script>

@endsection