@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Asset</h1>
        <form action="{{ route('assets.update', $asset) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- Same fields as create.blade.php -->
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ $asset->name }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control">{{ $asset->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="serial_number">Serial Number:</label>
                <input type="text" id="serial_number" name="serial_number" class="form-control"
                    value="{{ $asset->serial_number }}" required>
            </div>
            <div class="form-group">
                <label for="acquisition_date">Acquisition Date:</label>
                <input type="date" id="acquisition_date" name="acquisition_date" class="form-control"
                    value="{{ $asset->acquisition_date->format('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label for="acquisition_value">Acquisition Value:</label>
                <input type="number" id="acquisition_value" name="acquisition_value" step="0.01" class="form-control"
                    value="{{ $asset->acquisition_value }}" required>
            </div>
            <div class="form-group">
                <label for="useful_life">Useful Life (in years):</label>
                <input type="number" id="useful_life" name="useful_life" class="form-control"
                    value="{{ $asset->useful_life }}" required>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" class="form-control" value="{{ $asset->location }}"
                    required>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" id="category" name="category" class="form-control" value="{{ $asset->category }}"
                    required>
            </div>
            <div class="form-group">
                <label for="supplier">Supplier:</label>
                <input type="text" id="supplier" name="supplier" class="form-control" value="{{ $asset->supplier }}"
                    required>
            </div>
            <div class="form-group">
                <label for="state">State:</label>
                <select id="state" name="state" class="form-control">
                    <option value="in_use" {{ $asset->state == 'in_use' ? 'selected' : '' }}>In Use</option>
                    <option value="stored" {{ $asset->state == 'stored' ? 'selected' : '' }}>Stored</option>
                    <option value="to_be_scrapped" {{ $asset->state == 'to_be_scrapped' ? 'selected' : '' }}>To Be Scrapped
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="user_id">User:</label>
                <select id="user_id" name="user_id" class="form-control">
                    <option value="">None</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $user->id == $asset->user_id ? 'selected' : '' }}>
                            {{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="user_id">User:</label>
                <select id="user_id" name="user_id" class="form-control">
                    <option value="">None</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $user->id == $asset->user_id ? 'selected' : '' }}>
                            {{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Asset</button>
        </form>
    </div>
@endsection
