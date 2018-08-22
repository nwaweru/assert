@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-6">
        <br>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('users.update', ['uuid' => $user->uuid]) }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-7">
                            <h5 class="card-title"><b>User</b></h5>
                            <hr>
                            <div class="form-group">
                                <label for="first_name" class="form-label text-md-right">First Name</label>
                                <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') ? old('first_name') : $user->first_name }}" placeholder="e.g. Jane" autofocus>
                                @if ($errors->has('first_name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="last_name" class="form-label text-md-right">Last Name</label>
                                <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') ? old('last_name') : $user->last_name }}" placeholder="e.g. Doe">
                                @if ($errors->has('last_name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col form-group">
                                    <label for="username" class="form-label text-md-right">Username</label>
                                    <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') ? old('username') : $user->username }}" placeholder="e.g. jdoe">
                                    @if ($errors->has('username'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col form-group">
                                    <label for="active" class="form-label text-md-right">Status</label>
                                    <select id="active" name="active" class="form-control{{ $errors->has('active') ? ' is-invalid' : '' }}">
                                        <option value="1" {{ ($user->active) ? 'selected' : '' }}>Active</option>
                                        <option value="2" {{ (!$user->active) ? 'selected' : '' }}>Disabled</option>
                                    </select>
                                    @if ($errors->has('active'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('active') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label text-md-right">Email</label>
                                <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') ? old('email') : $user->email }}" placeholder="e.g. jdoe@example.com">
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
                                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ (in_array($role->id, $currentRoles)) ? 'checked' : '' }}> {{ $role->display_name }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
