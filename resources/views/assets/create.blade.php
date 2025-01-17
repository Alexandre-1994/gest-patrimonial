@extends('layouts.app')

@section('title', 'Criar Novo Ativo')

@section('content')
    <div class="container-fluid px-4">
        <!-- Cabeçalho da Página -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Cadastrar Novo Ativo</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Início</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/assets') }}">Ativos</a></li>
                            <li class="breadcrumb-item active">Novo Ativo</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-auto">
                    <a href="{{ url('/assets') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Voltar
                    </a>
                </div>
            </div>
        </div>

        <!-- Alertas de Erro -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulário -->
        <div class="card">
            <div class="card-body">
                <form action="{{ route('assets.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <!-- Informações Básicas -->
                    <div class="form-section mb-4">
                        <h3 class="form-section-title">Informações Básicas</h3>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" id="code" name="code"
                                        class="form-control @error('code') is-invalid @enderror" value="{{ $code }}"
                                        placeholder="Código" readonly>
                                    <label for="code">Código</label>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" id="name" name="name"
                                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                        placeholder="Nome" required>
                                    <label for="name">Nome</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select id="category_id" name="category_id"
                                        class="form-select @error('category_id') is-invalid @enderror" required>
                                        <option value="">Selecione uma categoria</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="category_id">Categoria</label>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select id="cost_center_id" name="cost_center_id"
                                        class="form-select @error('cost_center_id') is-invalid @enderror" required>
                                        <option value="">Selecione um centro de custo</option>
                                        @foreach ($costCenters as $costCenter)
                                            <option value="{{ $costCenter->id }}"
                                                {{ old('cost_center_id') == $costCenter->id ? 'selected' : '' }}>
                                                {{ $costCenter->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="cost_center_id">Centro de Custo</label>
                                    @error('cost_center_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" id="location" name="location"
                                        class="form-control @error('location') is-invalid @enderror"
                                        value="{{ old('location') }}" placeholder="Localização" required>
                                    <label for="location">Localização</label>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informações Técnicas -->
                    <div class="form-section mb-4">
                        <h3 class="form-section-title">Informações Técnicas</h3>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" id="serial_number" name="serial_number"
                                        class="form-control @error('serial_number') is-invalid @enderror"
                                        value="{{ old('serial_number') }}">
                                    <label for="serial_number">Número de Série</label>
                                    @error('serial_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" id="brand" name="brand"
                                        class="form-control @error('brand') is-invalid @enderror"
                                        value="{{ old('brand') }}">
                                    <label for="brand">Marca</label>
                                    @error('brand')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" id="model" name="model"
                                        class="form-control @error('model') is-invalid @enderror"
                                        value="{{ old('model') }}">
                                    <label for="model">Modelo</label>
                                    @error('model')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="number" id="life_span_months" name="life_span_months"
                                        class="form-control @error('life_span_months') is-invalid @enderror"
                                        value="{{ old('life_span_months') }}" required>
                                    <label for="life_span_months">Vida Útil (meses)</label>
                                    @error('life_span_months')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informações Financeiras -->
                    <div class="form-section mb-4">
                        <h3 class="form-section-title">Informações Financeiras</h3>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="number" step="0.01" id="purchase_value" name="purchase_value"
                                        class="form-control @error('purchase_value') is-invalid @enderror"
                                        value="{{ old('purchase_value') }}" required>
                                    <label for="purchase_value">Valor de Compra</label>
                                    @error('purchase_value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="date" id="purchase_date" name="purchase_date"
                                        class="form-control @error('purchase_date') is-invalid @enderror"
                                        value="{{ old('purchase_date') }}" required>
                                    <label for="purchase_date">Data de Compra</label>
                                    @error('purchase_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="number" step="0.01" id="depreciation_rate" name="depreciation_rate"
                                        class="form-control @error('depreciation_rate') is-invalid @enderror"
                                        value="{{ old('depreciation_rate') }}" required>
                                    <label for="depreciation_rate">Taxa de Depreciação (%)</label>
                                    @error('depreciation_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status e Controle -->
                    <div class="form-section mb-4">
                        <h3 class="form-section-title">Status e Controle</h3>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select id="status" name="status"
                                        class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="">Selecione o status</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Ativo
                                        </option>
                                        <option value="maintenance"
                                            {{ old('status') == 'maintenance' ? 'selected' : '' }}>Em Manutenção</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                            Inativo</option>
                                        <option value="disposed" {{ old('status') == 'disposed' ? 'selected' : '' }}>
                                            Descartado</option>
                                    </select>
                                    <label for="status">Status</label>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select id="conservation_status" name="conservation_status"
                                        class="form-select @error('conservation_status') is-invalid @enderror" required>
                                        <option value="">Selecione o estado</option>
                                        <option value="excellent"
                                            {{ old('conservation_status') == 'excellent' ? 'selected' : '' }}>Excelente
                                        </option>
                                        <option value="good"
                                            {{ old('conservation_status') == 'good' ? 'selected' : '' }}>Bom</option>
                                        <option value="regular"
                                            {{ old('conservation_status') == 'regular' ? 'selected' : '' }}>Regular
                                        </option>
                                        <option value="poor"
                                            {{ old('conservation_status') == 'poor' ? 'selected' : '' }}>Ruim</option>
                                    </select>
                                    <label for="conservation_status">Estado de Conservação</label>
                                    @error('conservation_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select id="responsible_user_id" name="responsible_user_id"
                                        class="form-select @error('responsible_user_id') is-invalid @enderror" required>
                                        <option value="">Selecione o responsável</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('responsible_user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="responsible_user_id">Responsável</label>
                                    @error('responsible_user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select id="criticality_level" name="criticality_level"
                                        class="form-select @error('criticality_level') is-invalid @enderror" required>
                                        <option value="">Selecione o nível de criticidade</option>
                                        <option value="low" {{ old('criticality_level') == 'low' ? 'selected' : '' }}>
                                            Baixo</option>
                                        <option value="medium"
                                            {{ old('criticality_level') == 'medium' ? 'selected' : '' }}>Médio</option>
                                        <option value="high" {{ old('criticality_level') == 'high' ? 'selected' : '' }}>
                                            Alto</option>
                                        <option value="critical"
                                            {{ old('criticality_level') == 'critical' ? 'selected' : '' }}>Crítico</option>
                                    </select>
                                    <label for="criticality_level">Nível de Criticidade</label>
                                    @error('criticality_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Salvar Ativo
                        </button>
                        <button type="reset" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-undo me-2"></i>Limpar Formulário
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .page-header {
            margin-bottom: 1.5rem !important;
            padding: 1.5rem 0 !important;
        }

        .page-title {
            font-size: 1.5rem !important;
            font-weight: 600 !important;
            margin-bottom: 0.5rem !important;
            color: #2c3e50 !important;
        }

        .breadcrumb {
            margin-bottom: 0 !important;
        }

        .form-section {
            border-bottom: 1px solid #e9ecef !important;
            padding-bottom: 1.5rem !important;
        }

        .form-section:last-child {
            border-bottom: none !important;
        }

        .form-section-title {
            font-size: 1.1rem !important;
            font-weight: 600 !important;
            margin-bottom: 1.5rem !important;
            color: #495057 !important;
        }

        .form-floating {
            margin-bottom: 1rem !important;
        }

        .form-floating>label {
            padding-left: 1rem !important;
        }

        .form-control,
        .form-select {
            padding: 1rem !important;
            border-radius: 0.5rem !important;
            border-color: #dee2e6 !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #3498db !important;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25) !important;
        }

        .invalid-feedback {
            font-size: 0.875rem !important;
        }

        .form-actions {
            padding-top: 1.5rem !important;
            border-top: 1px solid #e9ecef !important;
        }

        .btn {
            padding: 0.5rem 1rem !important;
            border-radius: 0.5rem !important;
            font-weight: 500 !important;
        }

        .btn-primary {
            background-color: #3498db !important;
            border-color: #3498db !important;
        }

        .btn-primary:hover {
            background-color: #2980b9 !important;
            border-color: #2980b9 !important;
        }

        .card {
            border: none !important;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
            border-radius: 0.5rem !important;
        }

        .card-body {
            padding: 2rem !important;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem !important;
            }

            .form-section-title {
                font-size: 1rem !important;
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        // Validação do formulário
        document.addEventListener('DOMContentLoaded', function() {
            fetch('{{ route('assets.next-code') }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('code_display').value = data.code;
                    document.getElementById('code').value = data.code;
                })
                .catch(error => console.error('Erro ao gerar código:', error));
        });
        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
@endsection
