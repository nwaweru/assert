@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-5">
        <br>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('requests.reject', ['uuid' => $request->uuid]) }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <h5 class="card-title"><b>Reject Request</b></h5>
                    <hr>
                    <div class="form-group">
                        <label for="user" class="form-label text-md-right">User</label>
                        <input class="form-control" type="text" value="{{ $request->user->first_name . ' ' . $request->user->last_name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-label text-md-right">Asset</label>
                        <input class="form-control" type="text" value="{{ $request->asset->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="rejection_reason" class="form-label text-md-right">Rejection Reason</label>
                        <textarea id="rejection_reason" class="form-control{{ $errors->has('rejection_reason') ? ' is-invalid' : '' }}" name="rejection_reason" rows="5" placeholder="e.g. Beyond pay grade.">{{ old('rejection_reason') }}</textarea>
                        @if ($errors->has('rejection_reason'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('rejection_reason') }}</strong>
                        </span>
                        @endif
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Reject Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
