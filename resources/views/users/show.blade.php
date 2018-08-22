@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-6">
        <br>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title"><b>User</b></h5>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-right" style="width: 35%"><b>Username:</b></td>
                                    <td style="width: 65%">{{ $user->username }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right"><b>First Name:</b></td>
                                    <td>{{ $user->first_name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right"><b>Last Name:</b></td>
                                    <td>{{ $user->last_name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right"><b>Email:</b></td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right"><b>Status:</b></td>
                                    <td>{{ ($user->active) ? 'Active' : 'Disabled' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col">
                        <h5 class="card-title"><b>Roles</b></h5>
                        <hr>
                        <ol>
                            @foreach ($user->roles as $role)
                            <li>{{ $role->display_name }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>
                <br>
                <p><a href="{{ route('users.edit', ['uuid' => $user->uuid]) }}" class="btn btn-primary btn-block">Edit User</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
