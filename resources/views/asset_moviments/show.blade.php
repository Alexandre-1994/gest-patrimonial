@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Asset Movement Details</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Asset: {{ $assetMovement->asset->name }}</h5>
                <p class="card-text"><strong>Old Location:</strong> {{ $assetMovement->old_location }}</p>
                <p class="card-text"><strong>New Location:</strong> {{ $assetMovement->new_location }}</p>
                <p class="card-text"><strong>Moved At:</strong> {{ $assetMovement->moved_at->format('d/m/Y H:i') }}</p>
                <p class="card-text"><strong>Notes:</strong> {{ $assetMovement->notes }}</p>
                <a href="{{ route('asset_movements.edit', $assetMovement) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('asset_movements.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
@endsection
