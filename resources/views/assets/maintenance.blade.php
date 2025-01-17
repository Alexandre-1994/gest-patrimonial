@extends('layouts.app')

@section('title', 'Ativos em Manutenção')

@section('content')
    <div class="container-fluid px-4">
        <!-- Cabeçalho -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Ativos em Manutenção</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Em Manutenção</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Cards Resumo -->
        <div class="row">
            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-1">{{ $summary['total_in_maintenance'] }}</h3>
                                <div class="text-muted">Ativos em Manutenção</div>
                            </div>
                            <div class="text-warning">
                                <i class="fas fa-tools fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-1">MZN {{ number_format($summary['total_maintenance_value'], 2, ',', '.') }}
                                </h3>
                                <div class="text-muted">Valor Total dos Ativos</div>
                            </div>
                            <div class="text-primary">
                                <i class="fas fa-dollar-sign fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-1">MZN {{ number_format($summary['total_maintenance_cost'], 2, ',', '.') }}
                                </h3>
                                <div class="text-muted">Custo Total de Manutenção</div>
                            </div>
                            <div class="text-danger">
                                <i class="fas fa-wrench fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Ativos em Manutenção -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ativos em Manutenção</h3>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Localização</th>
                            <th>Responsável</th>
                            <th>Valor Atual</th>
                            <th>Última Manutenção</th>
                            <th class="w-1">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assetsInMaintenance as $asset)
                            <tr>
                                <td>{{ $asset->code }}</td>
                                <td>{{ $asset->name }}</td>
                                <td>
                                    <span class="badge bg-blue-lt">
                                        {{ $asset->category->name }}
                                    </span>
                                </td>
                                <td>
                                    <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                    {{ $asset->location }}
                                </td>
                                <td>
                                    {{ $asset->responsibleUser->name ?? 'N/A' }}
                                </td>
                                <td>MZN {{ number_format($asset->current_value, 2, ',', '.') }}</td>
                                <td>
                                    @if ($asset->maintenances->isNotEmpty())
                                        {{ $asset->maintenances->first()->created_at->format('d/m/Y') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('assets.show', $asset) }}"
                                            class="btn btn-outline-secondary btn-sm" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('assets.edit', $asset) }}"
                                            class="btn btn-outline-secondary btn-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="empty">
                                        <i class="fas fa-tools mb-3" style="font-size: 3rem;"></i>
                                        <p class="empty-title">Nenhum ativo em manutenção</p>
                                        <p class="empty-subtitle text-muted">
                                            Não há ativos em manutenção no momento.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Paginação -->
            @if ($assetsInMaintenance->hasPages())
                <div class="card-footer d-flex align-items-center">
                    <p class="m-0 text-muted">
                        Mostrando <span>{{ $assetsInMaintenance->firstItem() }}</span> até
                        <span>{{ $assetsInMaintenance->lastItem() }}</span> de
                        <span>{{ $assetsInMaintenance->total() }}</span> registros
                    </p>
                    <div class="pagination m-0 ms-auto">
                        {{ $assetsInMaintenance->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
