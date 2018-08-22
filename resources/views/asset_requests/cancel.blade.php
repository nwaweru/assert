@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-5">
        <br>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('requests.cancel', ['uuid' => $request->uuid]) }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <h5 class="card-title"><b>Cancel Request</b></h5>
                    <hr>
                    <div class="form-group">
                        <label for="name" class="form-label text-md-right">Asset</label>
                        <input class="form-control" type="text" value="{{ $request->asset->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="cancellation_reason" class="form-label text-md-right">Reason <small>(Optional)</small></label>
                        <input id="cancellation_reason" type="text" class="form-control{{ $errors->has('cancellation_reason') ? ' is-invalid' : '' }}" name="cancellation_reason" value="{{ old('cancellation_reason') ? old('cancellation_reason') : $request->cancellation_reason }}" placeholder="e.g. I found an alternative.">
                        @if ($errors->has('cancellation_reason'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('cancellation_reason') }}</strong>
                        </span>
                        @endif
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Cancel Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
