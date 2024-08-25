@extends('layouts.app')

@section('title', 'Detalhes do Inventário Físico')

@section('content')
    <div class="container">
        <h1>Detalhes do Inventário Físico</h1>
        <div class="card">
            <div class="card-header">
                Inventário realizado em {{ $inventory->inventory_date->format('d/m/Y') }}
            </div>
            <div class="card-body">
                <p><strong>Notas:</strong></p>
                <p>{{ $inventory->notes ?? 'Nenhuma nota disponível.' }}</p>
            </div>
            <div class="card-footer">
                <a href="{{ route('physical_inventories.edit', $inventory) }}" class="btn btn-warning">Editar</a>
                <form action="{{ route('physical_inventories.destroy', $inventory) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                </form>
                <a href="{{ route('physical_inventories.index') }}" class="btn btn-secondary">Voltar para a lista</a>
            </div>
        </div>
    </div>
@endsection
