@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col">
        <br>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center"><b>Roles</b></h3>
                @permission('create-role')
                <p class="text-right">
                    <a href="{{ route('roles.create') }}" class=" btn btn-primary"><i class="fas fa-plus-circle"></i> New Role</a>
                </p>
                @endpermission
                <div class="table-responsive">
                    <table id="roles-table" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Display Name</th>
                                <th>Description</th>
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
        let url = '{!! route('roles', ['api_token' => Auth::user()->api_token]) !!}';

        let options = {
            processing: true,
            serverSide: true,
            ajax: url,
            columns: [
                {data: 'DT_Row_Index', name: 'DT_Row_Index'},
                {data: 'name', name: 'name'},
                {data: 'display_name', name: 'display_name'},
                {data: 'description', name: 'description'},
                {data: 'audit_log', name: 'audit_log'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        };

        $('#roles-table').DataTable(options);
    });
</script>
@endpush