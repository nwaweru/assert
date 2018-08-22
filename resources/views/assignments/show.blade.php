@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-5">
        <br>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><b>Assignment</b></h5>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-right" style="width: 35%"><b>Asset:</b></td>
                            <td style="width: 65%">{{ $assignment->asset->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-right"><b>Category:</b></td>
                            <td>{{ $assignment->asset->assetCategory->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-right"><b>Assigned To:</b></td>
                            <td>{{ $assignment->user->first_name }} {{ $assignment->user->last_name }}</td>
                        </tr>
                        <tr>
                            <td class="text-right"><b>Assignment Comment:</b></td>
                            <td>{{ ($assignment->comment) ? $assignment->comment : 'None' }}</td>
                        </tr>
                        <tr>
                            <td class="text-right"><b>Clearance Status:</b></td>
                            <td>{{ ($assignment->cleared) ? 'Cleared' : 'Pending' }}</td>
                        </tr>
                        <tr>
                            <td class="text-right"><b>Clearance Comment:</b></td>
                            <td>{{ ($assignment->clearance_comment) ? $assignment->clearance_comment : 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
                <br>
                <p><a href="{{ route('assignments.edit', ['uuid' => $assignment->uuid]) }}" class="btn btn-primary btn-block">Edit Assignment</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
