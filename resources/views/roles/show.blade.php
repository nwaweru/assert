@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-6">
        <br>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title"><b>Role</b></h5>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-right" style="width: 35%"><b>Name:</b></td>
                                    <td style="width: 65%">{{ $role->name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right"><b>Display Name:</b></td>
                                    <td>{{ $role->display_name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right"><b>Description:</b></td>
                                    <td>{{ $role->description }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col">
                        <h5 class="card-title"><b>Permissions</b></h5>
                        <hr>
                        <ol>
                            @foreach ($role->permissions as $permission)
                            <li>{{ $permission->display_name . ' - ' . $permission->description }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>
                <br>
                <p><a href="{{ route('roles.edit', ['uuid' => $role->uuid]) }}" class="btn btn-primary btn-block">Edit Role</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
