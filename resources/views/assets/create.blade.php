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

        <!-- Formulário -->
        <div class="card">
            <div class="card-body">
                <form action="{{ url('assets/store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <!-- Informações Básicas -->
                    <div class="form-section mb-4">
                        <h3 class="form-section-title">Informações Básicas</h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" id="name" name="name" class="form-control"
                                        placeholder="Nome do ativo" required>
                                    <label for="name">Nome do Ativo</label>
                                    <div class="invalid-feedback">
                                        Por favor, informe o nome do ativo.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" id="serial_number" name="serial_number" class="form-control"
                                        placeholder="Número de série" required>
                                    <label for="serial_number">Número de Série</label>
                                    <div class="invalid-feedback">
                                        Por favor, informe o número de série.
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea id="description" name="description" class="form-control" style="height: 100px" placeholder="Descrição"></textarea>
                                    <label for="description">Descrição</label>
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
                                    <input type="date" id="acquisition_date" name="acquisition_date" class="form-control"
                                        required>
                                    <label for="acquisition_date">Data de Aquisição</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="number" id="acquisition_value" name="acquisition_value" step="0.01"
                                        class="form-control" placeholder="Valor" required>
                                    <label for="acquisition_value">Valor de Aquisição (R$)</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="number" id="useful_life" name="useful_life" class="form-control"
                                        placeholder="Vida útil" required>
                                    <label for="useful_life">Vida Útil (anos)</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Localização e Categorização -->
                    <div class="form-section mb-4">
                        <h3 class="form-section-title">Localização e Categorização</h3>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" id="location" name="location" class="form-control"
                                        placeholder="Localização" required>
                                    <label for="location">Localização</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" id="category" name="category" class="form-control"
                                        placeholder="Categoria" required>
                                    <label for="category">Categoria</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" id="supplier" name="supplier" class="form-control"
                                        placeholder="Fornecedor" required>
                                    <label for="supplier">Fornecedor</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status e Responsável -->
                    <div class="form-section mb-4">
                        <h3 class="form-section-title">Status e Responsável</h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select id="state" name="state" class="form-select" required>
                                        <option value="">Selecione o status</option>
                                        <option value="in_use">Em Uso</option>
                                        <option value="stored">Armazenado</option>
                                        <option value="to_be_scrapped">Para Descarte</option>
                                    </select>
                                    <label for="state">Status</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select id="user_id" name="user_id" class="form-select">
                                        <option value="">Selecione o responsável</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="user_id">Responsável</label>
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
