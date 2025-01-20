@extends('layouts.app')

@section('title', 'Editar Ativo')

@section('content')
    <div class="container-fluid px-4">
        <!-- Cabeçalho -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Editar Ativo</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('assets.index') }}">Ativos</a></li>
                            <li class="breadcrumb-item active">Editar {{ $asset->name }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-auto">
                    <div class="btn-list">
                        <a href="{{ route('assets.show', $asset) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('assets.update', $asset) }}" method="POST">
            @csrf
            @method('PUT')

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
                                    <label class="form-label required">Código</label>
                                    <input type="text" name="code" class="form-control" value="{{ $asset->code }}"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Nome</label>
                                    <input type="text" name="name" class="form-control" value="{{ $asset->name }}"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Categoria</label>
                                    <select name="category_id" class="form-control" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $asset->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Centro de Custo</label>
                                    <select name="cost_center_id" class="form-control" required>
                                        @foreach ($costCenters as $costCenter)
                                            <option value="{{ $costCenter->id }}"
                                                {{ $asset->cost_center_id == $costCenter->id ? 'selected' : '' }}>
                                                {{ $costCenter->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Localização</label>
                                    <input type="text" name="location" class="form-control"
                                        value="{{ $asset->location }}" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Descrição</label>
                                    <textarea name="description" class="form-control" rows="3">{{ $asset->description }}</textarea>
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
                                    <label class="form-label">Número de Série</label>
                                    <input type="text" name="serial_number" class="form-control"
                                        value="{{ $asset->serial_number }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Marca</label>
                                    <input type="text" name="brand" class="form-control" value="{{ $asset->brand }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Modelo</label>
                                    <input type="text" name="model" class="form-control" value="{{ $asset->model }}">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Especificações Técnicas</label>
                                    <textarea name="technical_specifications" class="form-control" rows="3">{{ $asset->technical_specifications }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informações Financeiras -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Informações Financeiras</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Valor de Compra (MZN)</label>
                                    <input type="number" name="purchase_value" class="form-control"
                                        value="{{ $asset->purchase_value }}" step="0.01" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Valor Atual (MZN)</label>
                                    <input type="number" name="current_value" class="form-control"
                                        value="{{ $asset->current_value }}" step="0.01" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Data de Compra</label>
                                    <input type="date" name="purchase_date" class="form-control"
                                        value="{{ $asset->purchase_date->format('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Taxa de Depreciação (%)</label>
                                    <input type="number" name="depreciation_rate" class="form-control"
                                        value="{{ $asset->depreciation_rate }}" step="0.01" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Vida Útil (meses)</label>
                                    <input type="number" name="life_span_months" class="form-control"
                                        value="{{ $asset->life_span_months }}" required>
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
                                <label class="form-label required">Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="active" {{ $asset->status == 'active' ? 'selected' : '' }}>Ativo
                                    </option>
                                    <option value="maintenance" {{ $asset->status == 'maintenance' ? 'selected' : '' }}>Em
                                        Manutenção</option>
                                    <option value="inactive" {{ $asset->status == 'inactive' ? 'selected' : '' }}>Inativo
                                    </option>
                                    <option value="disposed" {{ $asset->status == 'disposed' ? 'selected' : '' }}>
                                        Descartado</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Estado de Conservação</label>
                                <select name="conservation_status" class="form-control" required>
                                    <option value="excellent"
                                        {{ $asset->conservation_status == 'excellent' ? 'selected' : '' }}>Excelente
                                    </option>
                                    <option value="good" {{ $asset->conservation_status == 'good' ? 'selected' : '' }}>
                                        Bom</option>
                                    <option value="fair" {{ $asset->conservation_status == 'fair' ? 'selected' : '' }}>
                                        Regular</option>
                                    <option value="poor" {{ $asset->conservation_status == 'poor' ? 'selected' : '' }}>
                                        Ruim</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Nível de Criticidade</label>
                                <select name="criticality_level" class="form-control" required>
                                    <option value="low" {{ $asset->criticality_level == 'low' ? 'selected' : '' }}>
                                        Baixo</option>
                                    <option value="medium" {{ $asset->criticality_level == 'medium' ? 'selected' : '' }}>
                                        Médio</option>
                                    <option value="high" {{ $asset->criticality_level == 'high' ? 'selected' : '' }}>
                                        Alto</option>
                                    <option value="critical"
                                        {{ $asset->criticality_level == 'critical' ? 'selected' : '' }}>Crítico</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Responsável</label>
                                <select name="responsible_user_id" class="form-control" required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $asset->responsible_user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Garantia -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Garantia</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Data Início da Garantia</label>
                                <input type="date" name="warranty_start" class="form-control"
                                    value="{{ $asset->warranty_start ? $asset->warranty_start->format('Y-m-d') : '' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Data Fim da Garantia</label>
                                <input type="date" name="warranty_end" class="form-control"
                                    value="{{ $asset->warranty_end ? $asset->warranty_end->format('Y-m-d') : '' }}">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Salvar Alterações
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
