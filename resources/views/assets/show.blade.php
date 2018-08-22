@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-5">
        <br>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><b>Asset</b></h5>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-right" style="width: 35%"><b>Name:</b></td>
                            <td style="width: 65%">{{ $asset->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-right"><b>Category:</b></td>
                            <td>{{ $asset->assetCategory->name }}</td>
                        </tr>
                    </table>
                </div>
                <br>
                <p><a href="{{ route('assets.edit', ['uuid' => $asset->uuid]) }}" class="btn btn-primary btn-block">Edit Asset</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
