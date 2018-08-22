@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col">
        <br>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center"><b>Assets</b></h3>
                @permission('create-asset')
                <p class="text-right">
                    <a href="{{ route('assets.create') }}" class=" btn btn-primary"><i class="fas fa-plus-circle"></i> New Asset</a>
                </p>
                @endpermission
                <div class="table-responsive">
                    <table id="assets-table" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Allocation</th>
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
        let url = '{!! route('assets', ['api_token' => Auth::user()->api_token]) !!}';

        let options = {
            processing: true,
            serverSide: true,
            ajax: url,
            columns: [
                {data: 'DT_Row_Index', name: 'DT_Row_Index'},
                {data: 'name', name: 'name'},
                {data: 'asset_category.name', name: 'asset_category.name'},
                {data: 'assigned', name: 'assigned'},
                {data: 'audit_log', name: 'audit_log'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        };

        $('#assets-table').DataTable(options);
    });
</script>
@endpush