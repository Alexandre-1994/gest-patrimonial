@extends('layouts.app')

@section('title', 'Centros de Custo')

@section('content')
    <div class="container-fluid px-4">
        <!-- Cabeçalho -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Centros de Custo</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Início</a></li>
                            <li class="breadcrumb-item active">Centros de Custo</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-auto">
                    <a href="{{ route('cost-centers.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Novo Centro de Custo
                    </a>
                </div>
            </div>
        </div>

        <!-- Alertas -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Filtros -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('cost-centers.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="search" name="search"
                                value="{{ request('search') }}" placeholder="Buscar...">
                            <label for="search">Buscar por código ou nome</label>
                        </div>
                    </div>
                    <div class="col-md-auto align-self-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Filtrar
                        </button>
                        <a href="{{ route('cost-centers.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-undo me-2"></i>Limpar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lista de Centros de Custo -->
        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Qtd. Ativos</th>
                            <th class="w-1">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($costCenters as $costCenter)
                            <tr>
                                <td>{{ $costCenter->code }}</td>
                                <td>{{ $costCenter->name }}</td>
                                <td>{{ Str::limit($costCenter->description, 50) }}</td>
                                <td>{{ $costCenter->assets->count() }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('cost-centers.edit', $costCenter) }}"
                                            class="btn btn-outline-primary btn-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('cost-centers.destroy', $costCenter) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Tem certeza que deseja excluir este centro de custo?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Excluir"
                                                {{ $costCenter->assets->count() > 0 ? 'disabled' : '' }}>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="empty">
                                        <i class="fas fa-search mb-3" style="font-size: 3rem;"></i>
                                        <p class="empty-title">Nenhum centro de custo encontrado</p>
                                        <p class="empty-subtitle text-muted">
                                            Comece cadastrando um novo centro de custo.
                                        </p>
                                        <div class="empty-action">
                                            <a href="{{ route('cost-centers.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-2"></i>Novo Centro de Custo
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            @if ($costCenters->hasPages())
                <div class="card-footer d-flex align-items-center">
                    <p class="m-0 text-muted">
                        Mostrando <span>{{ $costCenters->firstItem() }}</span> até
                        <span>{{ $costCenters->lastItem() }}</span> de
                        <span>{{ $costCenters->total() }}</span> registros
                    </p>
                    <div class="pagination m-0 ms-auto">
                        {{ $costCenters->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
