{{-- resources/views/assets/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ativos</h3>
                <div class="card-tools">
                    <a href="{{ route('assets.create') }}" class="btn btn-primary">Novo Ativo</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Localização</th>
                                <th>Status</th>
                                <th>Responsável</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assets as $asset)
                                <tr>
                                    <td>{{ $asset->code }}</td>
                                    <td>{{ $asset->name }}</td>
                                    <td>{{ $asset->category ? $asset->category->name : 'N/A' }}</td>
                                    <td>{{ $asset->location }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $asset->status === 'active' ? 'success' : ($asset->status === 'maintenance' ? 'warning' : 'danger') }}">
                                            {{ $asset->status }}
                                        </span>
                                    </td>
                                    <td>{{ $asset->responsible ? $asset->responsible->name : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('assets.show', $asset) }}" class="btn btn-sm btn-info">
                                            Ver
                                        </a>
                                        <a href="{{ route('assets.edit', $asset) }}" class="btn btn-sm btn-primary">
                                            Editar
                                        </a>
                                        <form action="{{ route('assets.destroy', $asset) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Tem certeza que deseja excluir este ativo?')">
                                                Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $assets->links() }}
            </div>
        </div>
    </div>
@endsection
