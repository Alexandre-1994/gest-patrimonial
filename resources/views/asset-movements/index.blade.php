@extends('layouts.app')

@section('title', 'Movimentações')

@section('content')
    <div class="container-fluid px-4">
        <!-- Cabeçalho da Página -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">Gestão de Patrimônio</div>
                    <h2 class="page-title">Movimentações de Ativos</h2>
                </div>
                <div class="col-auto ms-auto">
                    <div class="btn-list">
                        <a href="{{ route('asset-movements.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Nova Movimentação
                        </a>
                    </div>
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

        <!-- Filtros -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('asset-movements.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                                placeholder="Buscar por ativo ou localização">
                            <label>Buscar</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <select class="form-select" name="status">
                                <option value="">Todos</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendente
                                </option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Concluído
                                </option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelado
                                </option>
                            </select>
                            <label>Status</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="date" class="form-control" name="date" value="{{ request('date') }}">
                            <label>Data</label>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lista de Movimentações -->
        <div class="card">
            <div class="table-responsive">
                <table class="table card-table table-vcenter">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Ativo</th>
                            <th>De</th>
                            <th>Para</th>
                            <th>Status</th>
                            <th>Motivo</th>
                            <th class="w-1">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movements as $movement)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($movement->movement_date)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge bg-blue-lt">
                                        {{ $movement->asset->code }} - {{ $movement->asset->name }}
                                    </span>
                                </td>
                                <td>
                                    <div class="text-muted">{{ $movement->from_location }}</div>
                                    <small>{{ $movement->fromUser->name }}</small>
                                </td>
                                <td>
                                    <div class="text-muted">{{ $movement->to_location }}</div>
                                    <small>{{ $movement->toUser->name }}</small>
                                </td>
                                <td>
                                    @php
                                        $statusClasses = [
                                            'pending' => 'warning',
                                            'completed' => 'success',
                                            'cancelled' => 'danger',
                                        ];
                                    @endphp
                                    <span
                                        class="badge @switch($movement->status)
        @case('pending')
            bg-warning
            @break
        @case('completed')
            bg-success
            @break
        @case('cancelled')
            bg-danger
            @break
        @case('in_transit')
            bg-info
            @break
        @default
            bg-secondary
    @endswitch bg-{{ $statusClasses[$movement->status] ?? 'secondary' }}">
                                        {{ ucfirst($movement->status) }}
                                    </span>
                                </td>
                                <td>{{ Str::limit($movement->reason, 30) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('asset-movements.show', $movement) }}"
                                            class="btn btn-outline-secondary btn-sm" title="Detalhes">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if ($movement->status == 'pending')
                                            <a href="{{ route('asset-movements.edit', $movement) }}"
                                                class="btn btn-outline-primary btn-sm" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="empty">
                                        <i class="fas fa-exchange-alt mb-3" style="font-size: 3rem;"></i>
                                        <p class="empty-title">Nenhuma movimentação encontrada</p>
                                        <p class="empty-subtitle text-muted">
                                            Comece adicionando uma nova movimentação de ativo.
                                        </p>
                                        <div class="empty-action">
                                            <a href="{{ route('asset-movements.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-2"></i>Nova Movimentação
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
            @if ($movements->hasPages())
                <div class="card-footer d-flex align-items-center">
                    <p class="m-0 text-muted">
                        Mostrando <span>{{ $movements->firstItem() }}</span> até
                        <span>{{ $movements->lastItem() }}</span> de
                        <span>{{ $movements->total() }}</span> registros
                    </p>
                    <div class="pagination m-0 ms-auto">
                        {{ $movements->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
