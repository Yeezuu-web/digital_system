@extends('layouts.admin')

@section('content')
@can('department_show')

@include('partials.flash-message')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.department.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-success" href="{{ route('admin.departments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.department.fields.title') }}
                        </th>
                        <td>
                            {{ $department->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.department.fields.description') }}
                        </th>
                        <td>
                            {{ $department->description ?? ''}}
                        </td>
                    </tr>
                    @if ($department->parent)
                    <tr>
                        <th>
                            {{ trans('cruds.department.fields.head') }}
                        </th>
                        <td>
                            {{ $department->parent->title ?? ''}}
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <br>
            <!-- <div class="form-group">
                <a class="btn btn-success" href="{{ route('admin.departments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div> -->
        </div>
    </div>
</div>

@endcan
@endsection
