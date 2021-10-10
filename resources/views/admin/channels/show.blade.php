@extends('layouts.admin')

@section('content')
@can('channel_show')

@include('partials.flash-message')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.channel.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-success" href="{{ route('admin.channels.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.channel.fields.title') }}
                        </th>
                        <td>
                            {{ $channel->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.channel.fields.description') }}
                        </th>
                        <td>
                            {{ $channel->description ?? ''}}
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <!-- <div class="form-group">
                <a class="btn btn-success" href="{{ route('admin.channels.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div> -->
        </div>
    </div>
</div>

@endcan
@endsection
