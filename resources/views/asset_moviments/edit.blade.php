@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Asset Movement</h1>
        <form action="{{ route('asset_movements.update', $assetMovement) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="asset_id">Asset:</label>
                <select id="asset_id" name="asset_id" class="form-control" required>
                    @foreach ($assets as $asset)
                        <option value="{{ $asset->id }}" {{ $assetMovement->asset_id == $asset->id ? 'selected' : '' }}>
                            {{ $asset->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="old_location">Old Location:</label>
                <input type="text" id="old_location" name="old_location" class="form-control"
                    value="{{ $assetMovement->old_location }}" required>
            </div>
            <div class="form-group">
                <label for="new_location">New Location:</label>
                <input type="text" id="new_location" name="new_location" class="form-control"
                    value="{{ $assetMovement->new_location }}" required>
            </div>
            <div class="form-group">
                <label for="moved_at">Moved At:</label>
                <input type="datetime-local" id="moved_at" name="moved_at" class="form-control"
                    value="{{ $assetMovement->moved_at->format('Y-m-d\TH:i') }}" required>
            </div>
            <div class="form-group">
                <label for="notes">Notes:</label>
                <textarea id="notes" name="notes" class="form-control">{{ $assetMovement->notes }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Movement</button>
        </form>
    </div>
@endsection
