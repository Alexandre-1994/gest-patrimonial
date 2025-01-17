@extends('layouts.app')

@section('title', 'Garantias a Vencer')

@section('content')
    <div class="container-fluid px-4">
        <!-- Cabeçalho -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Garantias a Vencer</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Garantias a Vencer</li>
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
                                <h3 class="mb-1">{{ $summary['total_expiring'] }}</h3>
                                <div class="text-muted">Garantias a Vencer (3 meses)</div>
                            </div>
                            <div class="text-warning">
                                <i class="fas fa-clock fa-2x"></i>
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
                                <h3 class="mb-1">{{ $summary['expiring_30_days'] }}</h3>
                                <div class="text-muted">Vencendo em 30 dias</div>
                            </div>
                            <div class="text-danger">
                                <i class="fas fa-exclamation-triangle fa-2x"></i>
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
                                <h3 class="mb-1">MZN {{ number_format($summary['value_at_risk'], 2, ',', '.') }}</h3>
                                <div class="text-muted">Valor em Risco</div>
                            </div>
                            <div class="text-info">
                                <i class="fas fa-dollar-sign fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Ativos com Garantia a Vencer -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Garantias a Vencer</h3>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Data de Compra</th>
                            <th>Fim da Garantia</th>
                            <th>Dias Restantes</th>
                            <th>Status</th>
                            <th class="w-1">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expiringWarranties as $asset)
                            <tr>
                                <td>{{ $asset->code }}</td>
                                <td>{{ $asset->name }}</td>
                                <td>
                                    <span class="badge bg-blue-lt">
                                        {{ $asset->category->name }}
                                    </span>
                                </td>
                                <td>{{ $asset->purchase_date->format('d/m/Y') }}</td>
                                <td>{{ $asset->warranty_end->format('d/m/Y') }}</td>
                                <td>
                                    @php
                                        $daysLeft = now()->diffInDays($asset->warranty_end, false);
                                        $colorClass = $daysLeft <= 30 ? 'danger' : 'warning';
                                    @endphp
                                    <span class="badge bg-{{ $colorClass }}-lt">
                                        {{ $daysLeft }} dias
                                    </span>
                                </td>
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
                                        <i class="fas fa-shield-alt mb-3" style="font-size: 3rem;"></i>
                                        <p class="empty-title">Nenhuma garantia próxima do vencimento</p>
                                        <p class="empty-subtitle text-muted">
                                            Não há ativos com garantia vencendo nos próximos 3 meses.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Paginação -->
            @if ($expiringWarranties->hasPages())
                <div class="card-footer d-flex align-items-center">
                    <p class="m-0 text-muted">
                        Mostrando <span>{{ $expiringWarranties->firstItem() }}</span> até
                        <span>{{ $expiringWarranties->lastItem() }}</span> de
                        <span>{{ $expiringWarranties->total() }}</span> registros
                    </p>
                    <div class="pagination m-0 ms-auto">
                        {{ $expiringWarranties->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
