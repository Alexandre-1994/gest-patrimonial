@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Asset</h1>
        <form action="{{ route('ativos.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="serial_number">Serial Number:</label>
                <input type="text" id="serial_number" name="serial_number" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="acquisition_date">Acquisition Date:</label>
                <input type="date" id="acquisition_date" name="acquisition_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="acquisition_value">Acquisition Value:</label>
                <input type="number" id="acquisition_value" name="acquisition_value" step="0.01" class="form-control"
                    required>
            </div>
            <div class="form-group">
                <label for="useful_life">Useful Life (in years):</label>
                <input type="number" id="useful_life" name="useful_life" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" id="category" name="category" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="supplier">Supplier:</label>
                <input type="text" id="supplier" name="supplier" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="state">State:</label>
                <select id="state" name="state" class="form-control">
                    <option value="in_use">In Use</option>
                    <option value="stored">Stored</option>
                    <option value="to_be_scrapped">To Be Scrapped</option>
                </select>
            </div>
            <div class="form-group">
                <label for="user_id">User:</label>
                <select id="user_id" name="user_id" class="form-control">
                    <option value="">None</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="user_id">User:</label>
                <select id="user_id" name="user_id" class="form-control">
                    <option value="">None</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create Asset</button>
        </form>
    </div>
@endsection
