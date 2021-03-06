@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.boost.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group mb-2">
                <a class="btn btn-secondary" href="{{ route('admin.boosts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="50">
                            {{ trans('cruds.boost.fields.id') }}
                        </th>
                        <td>
                            {{ $boost->id }}
                        </td>
                    </tr>
                    <tr>
                        <th width="50">
                            {{ trans('cruds.boost.fields.requester_name') }}
                        </th>
                        <td>
                            {{ $boost->requester_name }}
                        </td>
                    </tr>
                    <tr>
                        <th width="50">
                            {{ trans('cruds.boost.fields.company_name') }}
                        </th>
                        <td>
                            {{ $boost->company_name }}
                        </td>
                    </tr>
                    <tr>
                        <th width="50">
                            {{ trans('cruds.boost.fields.group') }}
                        </th>
                        <td>
                            {{ $boost->group }}
                        </td>
                    </tr>
                    <tr>
                        <th width="50">
                            {{ trans('cruds.boost.fields.budget') }}
                        </th>
                        <td>
                            {{ $boost->budget }}
                        </td>
                    </tr>
                    <tr>
                        <th width="50">
                            {{ trans('cruds.boost.fields.program_name') }}
                        </th>
                        <td>
                            {{ $boost->program_name }}
                        </td>
                    </tr>
                    <tr>
                        <th width="50">
                            {{ trans('cruds.boost.fields.target_url') }}
                        </th>
                        <td>
                            {{ $boost->target_url }}
                        </td>
                    </tr>
                    <tr>
                        <th width="50">
                            {{ trans('cruds.boost.fields.boost_start') }}
                        </th>
                        <td>
                            {{ $boost->boost_start }}
                        </td>
                    </tr>
                    <tr>
                        <th width="50">
                            {{ trans('cruds.boost.fields.channel') }}
                        </th>
                        <td>
                            @foreach ($boost->channels as $channel)
                                <span class="badge badge-info">{{ $channel->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th width="50">
                            {{ trans('cruds.boost.fields.detail') }}
                        </th>
                        <td>
                            {{ $boost->detail }}
                        </td>
                    </tr>
                    <tr>
                        <th width="50">
                            {{ trans('cruds.boost.fields.reference') }}
                        </th>
                        <td>
                            @if ($boost->reference)
                                <a href="{{ $boost->reference->url }}" target="_blank" rel="noopener noreferrer">
                                    <img src="{{$boost->reference->thumbnail}}" alt="reference">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th width="50">
                            {{ trans('cruds.boost.fields.status') }}
                        </th>
                        <td>
                            @if($boost->status == '0')
                                <span class="badge badge-success">In Review</span>
                            @elseif($boost->status == '1')
                                <span class="badge badge-info">Reviewed</span>
                            @elseif($boost->status == '2')
                                <span class="badge badge-info">Approved</span>
                            @elseif($boost->status == '3')
                                <span class="badge badge-success">Running</span>
                            @elseif($boost->status == '4')
                                <span class="badge badge-danger">Rejected</span>
                            @elseif($boost->status == '5')
                                <span class="badge badge-secondary">Completed</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        @if($boost->status == '1' || $boost->status == '2' || $boost->status == '3')
                            <th width="50">
                                {{ trans('cruds.boost.fields.review_by') }}
                            </th>
                            <td>
                                {{ $boost->user->name ?? '' }}
                            </td>
                        @elseif($boost->status == '4')
                            <th width="50">
                                {{ trans('cruds.boost.fields.reject_by') }}
                            </th>
                            <td>
                                {{ $boost->user->name ?? '' }}
                            </td>
                        @endif
                    </tr>
                </tbody>
            </table>
            <div class="form-group mt-2">
                <a class="btn btn-secondary" href="{{ route('admin.boosts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection