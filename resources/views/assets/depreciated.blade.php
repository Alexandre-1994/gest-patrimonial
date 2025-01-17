@extends('layouts.app')

@section('title', 'Ativos Depreciados')

@section('content')
    <div class="container-fluid px-4">
        <!-- Cabeçalho -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Ativos Depreciados</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Ativos Depreciados</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Cards Resumo -->
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-1">{{ $summary['total_depreciated'] }}</h3>
                                <div class="text-muted">Ativos Depreciados</div>
                            </div>
                            <div class="text-danger">
                                <i class="fas fa-chart-line fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-1">MZN {{ number_format($summary['total_original_value'], 2, ',', '.') }}
                                </h3>
                                <div class="text-muted">Valor Original</div>
                            </div>
                            <div class="text-primary">
                                <i class="fas fa-dollar-sign fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-1">MZN {{ number_format($summary['total_current_value'], 2, ',', '.') }}
                                </h3>
                                <div class="text-muted">Valor Atual</div>
                            </div>
                            <div class="text-success">
                                <i class="fas fa-coins fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-1">MZN {{ number_format($summary['total_depreciation'], 2, ',', '.') }}</h3>
                                <div class="text-muted">Depreciação Total</div>
                            </div>
                            <div class="text-warning">
                                <i class="fas fa-arrow-down fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Ativos Depreciados -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ativos Depreciados</h3>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Valor Original</th>
                            <th>Valor Atual</th>
                            <th>Depreciação</th>
                            <th>Taxa</th>
                            <th class="w-1">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($depreciatedAssets as $asset)
                            <tr>
                                <td>{{ $asset->code }}</td>
                                <td>{{ $asset->name }}</td>
                                <td>
                                    <span class="badge bg-blue-lt">
                                        {{ $asset->category->name }}
                                    </span>
                                </td>
                                <td>MZN {{ number_format($asset->purchase_value, 2, ',', '.') }}</td>
                                <td>MZN {{ number_format($asset->current_value, 2, ',', '.') }}</td>
                                <td>
                                    @php
                                        $depreciation = $asset->purchase_value - $asset->current_value;
                                    @endphp
                                    MZN {{ number_format($depreciation, 2, ',', '.') }}
                                </td>
                                <td>
                                    @php
                                        $depreciation_rate =
                                            (($asset->purchase_value - $asset->current_value) /
                                                $asset->purchase_value) *
                                            100;
                                    @endphp
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            {{ number_format($depreciation_rate, 1) }}%
                                        </div>
                                        <div class="col">
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-danger"
                                                    style="width: {{ $depreciation_rate }}%"></div>
                                            </div>
                                        </div>
                                    </div>
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
                                        <i class="fas fa-chart-line mb-3" style="font-size: 3rem;"></i>
                                        <p class="empty-title">Nenhum ativo depreciado</p>
                                        <p class="empty-subtitle text-muted">
                                            Não há ativos com depreciação significativa no momento.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Paginação -->
            @if ($depreciatedAssets->hasPages())
                <div class="card-footer d-flex align-items-center">
                    <p class="m-0 text-muted">
                        Mostrando <span>{{ $depreciatedAssets->firstItem() }}</span> até
                        <span>{{ $depreciatedAssets->lastItem() }}</span> de
                        <span>{{ $depreciatedAssets->total() }}</span> registros
                    </p>
                    <div class="pagination m-0 ms-auto">
                        {{ $depreciatedAssets->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
