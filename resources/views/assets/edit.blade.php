@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-5">
        <br>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('assets.update', ['uuid' => $asset->uuid]) }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <h5 class="card-title"><b>Asset</b></h5>
                    <hr>
                    <div class="form-group">
                        <label for="name" class="form-label text-md-right">Name</label>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') ? old('name') : $asset->name }}" placeholder="e.g. Jane" autofocus>
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
                            <option value="{{ $category->id }}" {{ ($category->id === $asset->assetCategory->id) ? 'selected' : '' }}>{{ $category->name }}</option>
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
                        <button type="submit" class="btn btn-primary btn-block">Update Asset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
