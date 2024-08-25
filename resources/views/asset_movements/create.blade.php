@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Register New Asset Movement</h1>
        <form action="{{ route('asset_movements.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="asset_id">Asset:</label>
                <select id="asset_id" name="asset_id" class="form-control" required>
                    @foreach ($assets as $asset)
                        <option value="{{ $asset->id }}">{{ $asset->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="old_location">Old Location:</label>
                <input type="text" id="old_location" name="old_location" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="new_location">New Location:</label>
                <input type="text" id="new_location" name="new_location" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="moved_at">Moved At:</label>
                <input type="datetime-local" id="moved_at" name="moved_at" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="notes">Notes:</label>
                <textarea id="notes" name="notes" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Register Movement</button>
        </form>
    </div>
@endsection
