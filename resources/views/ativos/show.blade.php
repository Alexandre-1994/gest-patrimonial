@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Asset Details</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $asset->name }}</h5>
                <p class="card-text"><strong>Description:</strong> {{ $asset->description }}</p>
                <p class="card-text"><strong>Serial Number:</strong> {{ $asset->serial_number }}</p>
                <p class="card-text"><strong>Acquisition Date:</strong> {{ $asset->acquisition_date->format('d/m/Y') }}</p>
                <p class="card-text"><strong>Acquisition Value:</strong> {{ $asset->acquisition_value }}</p>
                <p class="card-text"><strong>Useful Life:</strong> {{ $asset->useful_life }} years</p>
                <p class="card-text"><strong>Location:</strong> {{ $asset->location }}</p>
                <p class="card-text"><strong>Category:</strong> {{ $asset->category }}</p>
                <p class="card-text"><strong>Supplier:</strong> {{ $asset->supplier }}</p>
                <p class="card-text"><strong>State:</strong> {{ ucfirst(str_replace('_', ' ', $asset->state)) }}</p>
                <p class="card-text"><strong>User:</strong> {{ $asset->user ? $asset->user->name : 'None' }}</p>
                <p class="card-text"><strong>Scrapped:</strong> {{ $asset->is_scrapped ? 'Yes' : 'No' }}</p>
                <a href="{{ route('assets.edit', $asset) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('assets.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
@endsection
