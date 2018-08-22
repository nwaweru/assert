@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-8">
        <br>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('requests.store') }}">
                    {{ csrf_field() }}
                    <h5 class="card-title"><b>New Request</b></h5>
                    <hr>
                    <div class="form-group row">
                        @foreach ($assets as $asset)
                        <div class="checkbox col-3">
                            <label>
                                <input type="checkbox" name="assets[]" value="{{ $asset->id }}"> {{ $asset->name . ' (' . $asset->assetCategory->name . ')' }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-6">
                            <label for="comment" class="form-label text-md-right">Comment <small>(Optional)</small></label>
                            <textarea id="comment" class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" name="comment" rows="5" placeholder="e.g. To be returned after ICT Conference 2018">{{ old('comment') }}</textarea>
                            @if ($errors->has('comment'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('comment') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Make Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
