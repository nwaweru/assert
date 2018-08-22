@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-5">
        <br>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('requests.accept', ['uuid' => $request->uuid]) }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <h5 class="card-title"><b>Accept Request</b></h5>
                    <hr>
                    <div class="form-group">
                        <label for="user" class="form-label text-md-right">User</label>
                        <input class="form-control" type="text" value="{{ $request->user->first_name . ' ' . $request->user->last_name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-label text-md-right">Asset</label>
                        <input class="form-control" type="text" value="{{ $request->asset->name }}" readonly>
                    </div>
                    <br>
                    <div class="form-group">
                        @if(is_null($currentAssignment))
                        <button type="submit" class="btn btn-primary btn-block">Accept Request</button>
                        @else
                        <p class="text-center text-danger">Kindly clear any assignments attached to the asset before accepting this request.</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
