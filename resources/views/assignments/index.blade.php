@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col">
        <br>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center"><b>Asset Assignments</b></h3>
                @permission('create-asset')
                <p class="text-right">
                    <a href="{{ route('assignments.create') }}" class=" btn btn-primary"><i class="fas fa-plus-circle"></i> New Assignment</a>
                </p>
                @endpermission
                <div class="table-responsive">
                    <table id="assignments-table" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Asset</th>
                                <th>Comment</th>
                                <th>Cleared</th>
                                <th>Clearance Comment</th>
                                <th>Log</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center"><b>Asset Requests</b></h3>
                <div class="table-responsive">
                    <table id="requests-table" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Asset</th>
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
    let url = '{!! route('assignments', ['api_token' => Auth::user()->api_token]) !!}';
    let options = {
    processing: true,
            serverSide: true,
            ajax: url,
            columns: [
            {data: 'DT_Row_Index', name: 'DT_Row_Index'},
            {data: 'user.first_name', name: 'user.first_name'},
            {data: 'user.last_name', name: 'user.last_name'},
            {data: 'asset.name', name: 'asset.name'},
            {data: 'comment', name: 'comment'},
            {data: 'cleared', name: 'cleared'},
            {data: 'clearance_comment', name: 'clearance_comment'},
            {data: 'audit_log', name: 'audit_log'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
    };
    let requestsUrl = '{!! route('assignment_requests', ['api_token' => Auth::user()->api_token]) !!}';
    let requestOptions = {
    processing: true,
            serverSide: true,
            ajax: requestsUrl,
            columns: [
            {data: 'DT_Row_Index', name: 'DT_Row_Index'},
            {data: 'user.first_name', name: 'user.first_name'},
            {data: 'user.last_name', name: 'user.last_name'},
            {data: 'asset.name', name: 'asset.name'},
            {data: 'status', name: 'status'},
            {data: 'audit_log', name: 'audit_log'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
    };
    $('#assignments-table').DataTable(options);
    $('#requests-table').DataTable(requestOptions);
    });
</script>
@endpush