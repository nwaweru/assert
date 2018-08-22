@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-5">
        <br>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('assignments.clear', ['uuid' => $assignment->uuid]) }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <h5 class="card-title"><b>Clear Assignment</b></h5>
                    <hr>
                    <div class="form-group">
                        <label for="user" class="form-label text-md-right">User</label>
                        <input class="form-control" type="text" value="{{ $assignment->user->first_name . ' ' . $assignment->user->last_name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="user" class="form-label text-md-right">Asset</label>
                        <input class="form-control" type="text" value="{{ $assignment->asset->name . ' (' . $assignment->asset->assetCategory->name . ')' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="clearance_comment" class="form-label text-md-right">Clearance Comment <small>(Optional)</small></label>
                        <input id="clearance_comment" type="text" class="form-control{{ $errors->has('clearance_comment') ? ' is-invalid' : '' }}" name="clearance_comment" value="{{ old('clearance_comment') ? old('clearance_comment') : $assignment->clearance_comment }}" placeholder="e.g. Everything checked out.">
                        @if ($errors->has('clearance_comment'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('clearance_comment') }}</strong>
                        </span>
                        @endif
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Clear Assignment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
