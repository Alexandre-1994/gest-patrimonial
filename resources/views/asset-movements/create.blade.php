@extends('layouts.app')

@section('title', 'Nova Movimentação')

@section('content')
    <div class="container-fluid px-4">
        <!-- Cabeçalho -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">Gestão de Patrimônio</div>
                    <h2 class="page-title">Nova Movimentação de Ativo</h2>
                </div>
                <div class="col-auto">
                    <a href="{{ route('asset-movements.index') }}" class="btn btn-outline-secondary">
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
                <form action="{{ route('asset-movements.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <!-- Seleção do Ativo -->
                    <div class="form-section mb-4">
                        <h3 class="section-title">Selecionar Ativo</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <select class="form-select @error('asset_id') is-invalid @enderror" id="asset_id"
                                        name="asset_id" required>
                                        <option value="">Selecione um ativo</option>
                                        @foreach ($assets as $asset)
                                            <option value="{{ $asset->id }}"
                                                {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                                                {{ $asset->code }} - {{ $asset->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="asset_id">Ativo</label>
                                    @error('asset_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Origem -->
                    <div class="form-section mb-4">
                        <h3 class="section-title">Origem</h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('from_user_id') is-invalid @enderror"
                                        id="from_user_id" name="from_user_id" required>
                                        <option value="">Selecione o responsável atual</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('from_user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="from_user_id">Responsável Atual</label>
                                    @error('from_user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('from_location') is-invalid @enderror"
                                        id="from_location" name="from_location" value="{{ old('from_location') }}"
                                        required>
                                    <label for="from_location">Localização Atual</label>
                                    @error('from_location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Centro de Custo de Origem -->
                    <div class="form-section mb-4">
                        <h3 class="section-title">Centros de Custo</h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('from_cost_center_id') is-invalid @enderror"
                                        id="from_cost_center_id" name="from_cost_center_id" required>
                                        <option value="">Selecione Centro de Custo de Origem</option>
                                        @foreach ($costCenters as $costCenter)
                                            <option value="{{ $costCenter->id }}"
                                                {{ old('from_cost_center_id') == $costCenter->id ? 'selected' : '' }}>
                                                {{ $costCenter->code }} - {{ $costCenter->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="from_cost_center_id">Centro de Custo de Origem</label>
                                    @error('from_cost_center_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('to_cost_center_id') is-invalid @enderror"
                                        id="to_cost_center_id" name="to_cost_center_id" required>
                                        <option value="">Selecione Centro de Custo de Destino</option>
                                        @foreach ($costCenters as $costCenter)
                                            <option value="{{ $costCenter->id }}"
                                                {{ old('to_cost_center_id') == $costCenter->id ? 'selected' : '' }}>
                                                {{ $costCenter->code }} - {{ $costCenter->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="to_cost_center_id">Centro de Custo de Destino</label>
                                    @error('to_cost_center_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Destino -->
                    <div class="form-section mb-4">
                        <h3 class="section-title">Destino</h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('to_user_id') is-invalid @enderror" id="to_user_id"
                                        name="to_user_id" required>
                                        <option value="">Selecione o novo responsável</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('to_user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="to_user_id">Novo Responsável</label>
                                    @error('to_user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('to_location') is-invalid @enderror"
                                        id="to_location" name="to_location" value="{{ old('to_location') }}" required>
                                    <label for="to_location">Nova Localização</label>
                                    @error('to_location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detalhes da Movimentação -->
                    <div class="form-section mb-4">
                        <h3 class="section-title">Detalhes da Movimentação</h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control @error('movement_date') is-invalid @enderror"
                                        id="movement_date" name="movement_date"
                                        value="{{ old('movement_date', date('Y-m-d')) }}" required>
                                    <label for="movement_date">Data da Movimentação</label>
                                    @error('movement_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('status') is-invalid @enderror" id="status"
                                        name="status" required>
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>
                                            Pendente
                                        </option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                                            Concluído</option>
                                    </select>
                                    <label for="status">Status</label>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason"
                                        style="height: 100px" required>{{ old('reason') }}</textarea>
                                    <label for="reason">Motivo da Movimentação</label>
                                    @error('reason')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes"
                                        style="height: 100px">{{ old('notes') }}</textarea>
                                    <label for="notes">Observações</label>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Salvar Movimentação
                        </button>
                        <a href="{{ route('asset-movements.index') }}" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
