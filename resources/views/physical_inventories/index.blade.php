@extends('layouts.app')

{{-- @section('title', 'Inventários Físicos') --}}

@section('content')
    <div class="container">
        <h1>Inventários Físicos</h1>
        <a href="{{ route('physical_inventories.create') }}" class="btn btn-primary">Novo Inventário</a>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Notas</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inventories as $inventory)
                    <tr>
                        <td>{{ $inventory->inventory_date->format('d/m/Y') }}</td>
                        <td>{{ $inventory->notes }}</td>
                        <td>
                            <a href="{{ route('physical_inventories.show', $inventory) }}" class="btn btn-info">Ver</a>
                            <a href="{{ route('physical_inventories.edit', $inventory) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('physical_inventories.destroy', $inventory) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
