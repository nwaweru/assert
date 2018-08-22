@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col">
        <br>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center"><b>Users</b></h3>
                @permission('create-user')
                <p class="text-right">
                    <a href="{{ route('users.create') }}" class=" btn btn-primary"><i class="fas fa-plus-circle"></i> New User</a>
                </p>
                @endpermission
                <div class="table-responsive">
                    <table id="users-table" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Verified</th>
                                <th>Status</th>
                                <th>Log</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        let url = '{!! route('users', ['api_token' => Auth::user()->api_token]) !!}';

        let options = {
            processing: true,
            serverSide: true,
            ajax: url,
            columns: [
                {data: 'DT_Row_Index', name: 'DT_Row_Index'},
                {data: 'username', name: 'username'},
                {data: 'first_name', name: 'first_name'},
                {data: 'last_name', name: 'last_name'},
                {data: 'email', name: 'email'},
                {data: 'verified', name: 'verified'},
                {data: 'active', name: 'active'},
                {data: 'audit_log', name: 'audit_log'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        };

        $('#users-table').DataTable(options);
    });
</script>
@endpush