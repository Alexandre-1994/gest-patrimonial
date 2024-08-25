@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Asset Movements</h1>
        <a href="{{ route('asset_movements.create') }}" class="btn btn-primary">Register New Movement</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Asset</th>
                    <th>Old Location</th>
                    <th>New Location</th>
                    <th>Moved At</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($movements as $movement)
                    <tr>
                        <td>{{ $movement->asset->name }}</td>
                        <td>{{ $movement->old_location }}</td>
                        <td>{{ $movement->new_location }}</td>
                        <td>{{ $movement->moved_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $movement->notes }}</td>
                        <td>
                            <a href="{{ route('asset_movements.show', $movement) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('asset_movements.edit', $movement) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('asset_movements.destroy', $movement) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this movement?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
