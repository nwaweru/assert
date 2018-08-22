@extends('layouts.basic')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="clearfix">
                <h1 class="float-left display-1 mr-4">404</h1>
                <h1 class="pt-3">Oops! You're lost.</h1>
                <p class="text-muted"><a href="{{ route('dashboard') }}">Go to Dashboard</a></p>
            </div>
        </div>
    </div>
</div>
@endsection