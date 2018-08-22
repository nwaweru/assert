@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-6">
        <br>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('users.store') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-7">
                            <h5 class="card-title"><b>User</b></h5>
                            <hr>
                            <div class="form-group">
                                <label for="username" class="form-label text-md-right">Username</label>
                                <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="e.g. jdoe" autofocus>
                                @if ($errors->has('username'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="first_name" class="form-label text-md-right">First Name</label>
                                <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" placeholder="e.g. Jane">
                                @if ($errors->has('first_name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="last_name" class="form-label text-md-right">Last Name</label>
                                <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" placeholder="e.g. Doe">
                                @if ($errors->has('last_name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label text-md-right">Email</label>
                                <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="e.g. jdoe@example.com">
                                @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col">
                            <h5 class="card-title"><b>Roles</b></h5>
                            <hr>
                            @foreach ($roles as $role)
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="roles[]" value="{{ $role->id }}"> {{ $role->display_name }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
