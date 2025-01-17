@extends('layouts.app')

@section('title', 'Ativos por Categoria')

@section('content')
    <div class="container-fluid px-4">
        <!-- Cabeçalho -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Ativos por Categoria</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Ativos por Categoria</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-auto">
                    <div class="btn-list">
                        <a href="{{ route('assets.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Novo Ativo
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cards Resumo -->
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-1">{{ $categoriesWithAssets->count() }}</h3>
                                <div class="text-muted">Categorias</div>
                            </div>
                            <div class="text-primary">
                                <i class="fas fa-folder fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-1">{{ $categoriesWithAssets->sum('assets_count') }}</h3>
                                <div class="text-muted">Total de Ativos</div>
                            </div>
                            <div class="text-success">
                                <i class="fas fa-boxes fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-1">MZN {{ number_format($totalValue, 2, ',', '.') }}</h3>
                                <div class="text-muted">Valor Total</div>
                            </div>
                            <div class="text-info">
                                <i class="fas fa-dollar-sign fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Categorias -->
        <div class="row">
            @foreach ($categoriesWithAssets as $category)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ $category->name }}
                                <span class="badge bg-blue ms-2">{{ $category->assets_count }} ativos</span>
                            </h3>
                        </div>
                        <div class="card-table table-responsive">
                            <table class="table table-vcenter">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nome</th>
                                        <th>Status</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($category->assets as $asset)
                                        <tr>
                                            <td>{{ $asset->code }}</td>
                                            <td>{{ $asset->name }}</td>
                                            <td>
                                                @php
                                                    $statusClasses = [
                                                        'active' => 'success',
                                                        'maintenance' => 'warning',
                                                        'inactive' => 'danger',
                                                        'disposed' => 'secondary',
                                                    ];
                                                @endphp
                                                <span class="badge bg-{{ $statusClasses[$asset->status] ?? 'secondary' }}">
                                                    {{ ucfirst($asset->status) }}
                                                </span>
                                            </td>
                                            <td>MZN {{ number_format($asset->current_value, 2, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">
                                                Nenhum ativo nesta categoria
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Total: MZN {{ number_format($category->assets->sum('current_value'), 2, ',', '.') }}
                                </div>
                                <a href="{{ route('assets.index', ['category' => $category->id]) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    Ver Todos
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
