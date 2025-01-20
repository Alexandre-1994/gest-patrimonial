@extends('layouts.app')

@section('title', 'Detalhes do Ativo')

@section('content')
    <div class="container-fluid px-4">
        <!-- Cabeçalho -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Detalhes do Ativo</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('assets.index') }}">Ativos</a></li>
                            <li class="breadcrumb-item active">{{ $asset->name }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-auto">
                    <div class="btn-list">
                        <a href="{{ route('assets.edit', $asset) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Editar
                        </a>
                        <a href="{{ route('assets.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Informações Básicas -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Informações Básicas</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Código</label>
                                <div class="form-control-plaintext">{{ $asset->code }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Nome</label>
                                <div class="form-control-plaintext">{{ $asset->name }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Categoria</label>
                                <div class="form-control-plaintext">
                                    <span class="badge bg-blue-lt">{{ $asset->category->name }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Centro de Custo</label>
                                <div class="form-control-plaintext">{{ $asset->costCenter->name }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Localização</label>
                                <div class="form-control-plaintext">
                                    <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                    {{ $asset->location }}
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label text-muted">Descrição</label>
                                <div class="form-control-plaintext">
                                    {{ $asset->description ?? 'Nenhuma descrição fornecida' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informações Técnicas -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Informações Técnicas</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Número de Série</label>
                                <div class="form-control-plaintext">{{ $asset->serial_number ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Marca</label>
                                <div class="form-control-plaintext">{{ $asset->brand ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Modelo</label>
                                <div class="form-control-plaintext">{{ $asset->model ?? 'N/A' }}</div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label text-muted">Especificações Técnicas</label>
                                <div class="form-control-plaintext">
                                    {{ $asset->technical_specifications ?? 'Nenhuma especificação fornecida' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informações Financeiras -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informações Financeiras</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Valor de Compra</label>
                                <div class="form-control-plaintext">MZN
                                    {{ number_format($asset->purchase_value, 2, ',', '.') }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Valor Atual</label>
                                <div class="form-control-plaintext">MZN
                                    {{ number_format($asset->current_value, 2, ',', '.') }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Data de Compra</label>
                                <div class="form-control-plaintext">{{ $asset->purchase_date->format('d/m/Y') }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Taxa de Depreciação</label>
                                <div class="form-control-plaintext">{{ $asset->depreciation_rate }}%</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Vida Útil (meses)</label>
                                <div class="form-control-plaintext">{{ $asset->life_span_months }} meses</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Custo Total de Manutenção</label>
                                <div class="form-control-plaintext">MZN
                                    {{ number_format($asset->maintenance_cost_total, 2, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status e Controle -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Status e Controle</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label text-muted">Status</label>
                            <div>
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
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Estado de Conservação</label>
                            <div>
                                <span
                                    class="badge bg-{{ $asset->conservation_status == 'poor' ? 'danger' : 'success' }}-lt">
                                    {{ ucfirst($asset->conservation_status) }}
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Nível de Criticidade</label>
                            <div>
                                @php
                                    $criticalityClasses = [
                                        'low' => 'success',
                                        'medium' => 'warning',
                                        'high' => 'danger',
                                        'critical' => 'danger',
                                    ];
                                @endphp
                                <span class="badge bg-{{ $criticalityClasses[$asset->criticality_level] }}-lt">
                                    {{ ucfirst($asset->criticality_level) }}
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Responsável</label>
                            <div class="form-control-plaintext">{{ $asset->responsibleUser->name }}</div>
                        </div>
                    </div>
                </div>

                <!-- Garantia -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Garantia</h3>
                    </div>
                    <div class="card-body">
                        @if ($asset->warranty_start && $asset->warranty_end)
                            <div class="mb-3">
                                <label class="form-label text-muted">Início da Garantia</label>
                                <div class="form-control-plaintext">{{ $asset->warranty_start->format('d/m/Y') }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Fim da Garantia</label>
                                <div class="form-control-plaintext">
                                    {{ $asset->warranty_end->format('d/m/Y') }}
                                    @if ($asset->warranty_end->isPast())
                                        <span class="badge bg-danger-lt ms-2">Expirada</span>
                                    @else
                                        <span class="badge bg-success-lt ms-2">
                                            Válida por mais {{ now()->diffInDays($asset->warranty_end) }} dias
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="text-muted">Sem informações de garantia</div>
                        @endif
                    </div>
                </div>

                <!-- Manutenções -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Últimas Manutenções</h3>
                    </div>
                    <div class="card-body">
                        @if ($asset->maintenances->isNotEmpty())
                            @foreach ($asset->maintenances->take(5) as $maintenance)
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="badge bg-blue-lt me-2">{{ $maintenance->type }}</span>
                                        <small class="text-muted">{{ $maintenance->created_at->format('d/m/Y') }}</small>
                                    </div>
                                    <div>{{ Str::limit($maintenance->description, 100) }}</div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-muted">Nenhuma manutenção registrada</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
