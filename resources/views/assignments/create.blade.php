@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-5">
        <br>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('assignments.store') }}">
                    {{ csrf_field() }}
                    <h5 class="card-title"><b>New Assignment</b></h5>
                    <hr>
                    <div class="form-group">
                        <label for="user" class="form-label text-md-right">User</label>
                        <select id="user" class="form-control{{ $errors->has('user') ? ' is-invalid' : '' }}" name="user">
                            <option value="">Select</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->first_name . ' ' . $user->last_name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('user'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('user') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="asset" class="form-label text-md-right">Asset</label>
                        <select id="asset" class="form-control{{ $errors->has('asset') ? ' is-invalid' : '' }}" name="asset">
                            <option value="">Select</option>
                            @foreach ($assets as $asset)
                            <option value="{{ $asset->id }}">{{ $asset->name . ' (' . $asset->assetCategory->name . ')' }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('asset'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('asset') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="comment" class="form-label text-md-right">Comment <small>(Optional)</small></label>
                        <input id="comment" type="text" class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" name="comment" value="{{ old('comment') }}" placeholder="e.g. To be returned after ICT Conference 2018">
                        @if ($errors->has('comment'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('comment') }}</strong>
                        </span>
                        @endif
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Create Assignment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
