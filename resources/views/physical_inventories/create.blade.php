@extends('layouts.app')

@section('title', 'Criar Novo Inventário Físico')

@section('content')
    <div class="container">
        <h1>Criar Novo Inventário Físico</h1>
        <form action="{{ route('physical_inventories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="inventory_date">Data do Inventário:</label>
                <input type="date" id="inventory_date" name="inventory_date" class="form-control"
                    value="{{ old('inventory_date') }}" required>
                @error('inventory_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="notes">Notas:</label>
                <textarea id="notes" name="notes" class="form-control">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Criar Inventário</button>
        </form>
    </div>
@endsection
