@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col">
        <br>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center"><b>My Requests</b></h3>
                @permission('create-request')
                <p class="text-right">
                    <a href="{{ route('requests.create') }}" class=" btn btn-primary"><i class="fas fa-plus-circle"></i> New Request</a>
                </p>
                @endpermission
                <div class="table-responsive">
                    <table id="requests-table" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Asset</th>
                                <th>Comment</th>
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
        let url = '{!! route('requests', ['api_token' => Auth::user()->api_token]) !!}';

        let options = {
            processing: true,
            serverSide: true,
            ajax: url,
            columns: [
                {data: 'DT_Row_Index', name: 'DT_Row_Index'},
                {data: 'asset.name', name: 'asset.name'},
                {data: 'comment', name: 'comment'},
                {data: 'status', name: 'status'},
                {data: 'audit_log', name: 'audit_log'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        };

        $('#requests-table').DataTable(options);
    });
</script>
@endpush