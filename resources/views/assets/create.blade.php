@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-5">
        <br>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('assets.store') }}">
                    {{ csrf_field() }}
                    <h5 class="card-title"><b>New Asset</b></h5>
                    <hr>
                    <div class="form-group">
                        <label for="name" class="form-label text-md-right">Name</label>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="e.g. jdoe" autofocus>
                        @if ($errors->has('name'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="category" class="form-label text-md-right">Category</label>
                        <select id="category" class="form-control{{ $errors->has('category') ? ' is-invalid' : '' }}" name="category">
                            <option value="">Select</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('category'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('category') }}</strong>
                        </span>
                        @endif
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Create Asset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
