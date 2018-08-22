@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-6">
        <br>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('roles.update', ['uuid' => $role->uuid]) }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title"><b>Role</b></h5>
                            <hr>
                            <div class="form-group">
                                <label for="name" class="form-label text-md-right">Name</label>
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') ? old('name') : $role->name }}" placeholder="e.g. admin" autofocus>
                                @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="display_name" class="form-label text-md-right">Display Name</label>
                                <input id="display_name" type="text" class="form-control{{ $errors->has('display_name') ? ' is-invalid' : '' }}" name="display_name" value="{{ old('display_name') ? old('display_name') : $role->display_name }}" placeholder="e.g. Administrator">
                                @if ($errors->has('display_name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('display_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="description" class="form-label text-md-right">Description</label>
                                <textarea rows="5" id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description"  placeholder="e.g. The system administrator.">{{ old('description') ? old('description') : $role->description }}</textarea>
                                @if ($errors->has('description'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col">
                            <h5 class="card-title"><b>Permissions</b></h5>
                            <hr>
                            @foreach ($permissions as $permission)
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" {{ (in_array($permission->id, $currentPermissions)) ? 'checked' : '' }}> {{ $permission->display_name . ' - ' . $permission->description }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Update Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
