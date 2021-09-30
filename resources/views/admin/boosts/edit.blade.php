@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Edit Request</div>

        <div class="card-body">
            <form action="{{ route('admin.boosts.update', [$boost->id]) }}" method="post">
                @method('PUT')
                @csrf
                @can('boost_admin_edit')
                <div class="form-group">
                    <label for="actual_cost">Status</label>
                    <select class="js-example-basic-single w-100 select2-hidden-accessible" name="status" data-width="100%" aria-hidden="true">
                        <option value="0" {{ old('status', $boost->status) == '1' ? 'selected' : ''}} >In Review</option>
                        <option value="1" {{ old('status', $boost->status) == '1' ? 'selected' : ''}} >Reviewed</option>
                        <option value="2" {{ old('status', $boost->status) == '2' ? 'selected' : ''}} >Approved</option>
                        <option value="3" {{ old('status', $boost->status) == '3' ? 'selected' : ''}} >Running</option>
                        <option value="4" {{ old('status', $boost->status) == '4' ? 'selected' : ''}} >Rejected</option>
                        <option value="5" {{ old('status', $boost->status) == '5' ? 'selected' : ''}} >Completed</option>
                    </select>
                    <input type="text" class="form-control" name="user_id" id="user_id" hidden value="{{ auth()->user()->id }}">
                    <input type="text" class="form-control" name="approve_id" id="approve_id" hidden value="{{ auth()->user()->id }}">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-danger btn-sm">Save</button>
                </div>
                @endcan
                @can('boost_reviewer_edit')
                    @if($boost->status == '0' || $boost->status == '1' || $boost->status == '4' && $boost->approve == null )
                    <div class="form-group">
                        <label for="actual_cost">Status</label>
                        <select class="js-example-basic-single w-100 select2-hidden-accessible" name="status" data-width="100%" aria-hidden="true">
                            <option value="1" {{ old('status', $boost->status) == '1' ? 'selected' : ''}} >Reviewed</option>
                            <option value="4" {{ old('status', $boost->status) == '4' ? 'selected' : ''}} >Rejected</option>
                        </select>
                        <input type="text" class="form-control" name="user_id" id="user_id" hidden value="{{ auth()->user()->id }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger btn-sm">Save</button>
                    </div>
                    @endif
                @endcan
                @can('boost_approver_edit')
                    @if($boost->status == '1' || $boost->status == '2' || $boost->status == '4' && $boost->user != null)
                    <div class="form-group">
                        <label for="actual_cost">Status</label>
                        <select class="js-example-basic-single w-100 select2-hidden-accessible" name="status" data-width="100%" aria-hidden="true">
                            <option value="2" {{ old('status', $boost->status) == '2' ? 'selected' : ''}} >Approved</option>
                            <option value="4" {{ old('status', $boost->status) == '4' ? 'selected' : ''}} >Rejected</option>
                        </select>
                        <input type="text" class="form-control" name="approve_id" id="approve_id" hidden value="{{ auth()->user()->id }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger btn-sm">Save</button>
                    </div>
                    @endif
                @endcan
            </form>
        </div>
    </div>
@endsection