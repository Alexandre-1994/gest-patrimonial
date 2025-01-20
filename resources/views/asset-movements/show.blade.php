@extends('layouts.app')

@section('title', 'Detalhes da Movimentação')

@section('content')
    <div class="container-fluid px-4">
        <!-- Cabeçalho -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">Gestão de Patrimônio</div>
                    <h2 class="page-title">Detalhes da Movimentação de Ativo</h2>
                </div>
                <div class="col-auto">
                    <a href="{{ route('asset-movements.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Voltar
                    </a>
                </div>
            </div>
        </div>

        <!-- Detalhes da Movimentação -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Informações do Ativo -->
                    <div class="col-md-6 mb-4">
                        <h3 class="card-title">Informações do Ativo</h3>
                        <div class="card">
                            <div class="card-body">
                                <p><strong>Código:</strong> {{ $assetMovement->asset->code }}</p>
                                <p><strong>Nome:</strong> {{ $assetMovement->asset->name }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Detalhes da Movimentação -->
                    <div class="col-md-6 mb-4">
                        <h3 class="card-title">Detalhes da Movimentação</h3>
                        <div class="card">
                            <div class="card-body">
                                <p><strong>Código da Movimentação:</strong> {{ $assetMovement->movement_code }}</p>
                                <p><strong>Data da Movimentação:</strong>
                                    {{ \Carbon\Carbon::parse($assetMovement->movement_date)->format('d/m/Y H:i') }}</p>
                                <p><strong>Status:</strong>
                                    <span
                                        class="badge 
                                    {{ $assetMovement->status == 'pending'
                                        ? 'bg-warning'
                                        : ($assetMovement->status == 'completed'
                                            ? 'bg-success'
                                            : ($assetMovement->status == 'cancelled'
                                                ? 'bg-danger'
                                                : 'bg-secondary')) }}">
                                        {{ __('messages.' . $assetMovement->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Origem -->
                    <div class="col-md-6 mb-4">
                        <h3 class="card-title">Origem</h3>
                        <div class="card">
                            <div class="card-body">
                                <h4>Usuário</h4>
                                <p><strong>Nome:</strong> {{ $assetMovement->fromUser->name }}</p>
                                <p><strong>Localização:</strong> {{ $assetMovement->from_location }}</p>
                                <h4>Centro de Custo</h4>
                                <p><strong>Código:</strong> {{ $assetMovement->fromCostCenter->code }}</p>
                                <p><strong>Nome:</strong> {{ $assetMovement->fromCostCenter->name }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Destino -->
                    <div class="col-md-6 mb-4">
                        <h3 class="card-title">Destino</h3>
                        <div class="card">
                            <div class="card-body">
                                <h4>Usuário</h4>
                                <p><strong>Nome:</strong> {{ $assetMovement->toUser->name }}</p>
                                <p><strong>Localização:</strong> {{ $assetMovement->to_location }}</p>
                                <h4>Centro de Custo</h4>
                                <p><strong>Código:</strong> {{ $assetMovement->toCostCenter->code }}</p>
                                <p><strong>Nome:</strong> {{ $assetMovement->toCostCenter->name }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Informações Adicionais -->
                    <div class="col-md-12 mb-4">
                        <h3 class="card-title">Informações Adicionais</h3>
                        <div class="card">
                            <div class="card-body">
                                <p><strong>Motivo:</strong> {{ $assetMovement->reason }}</p>

                                @if ($assetMovement->notes)
                                    <p><strong>Observações:</strong> {{ $assetMovement->notes }}</p>
                                @endif

                                @if ($assetMovement->is_temporary)
                                    <p><strong>Movimentação Temporária:</strong> Sim</p>
                                    <p><strong>Data de Retorno:</strong>
                                        {{ \Carbon\Carbon::parse($assetMovement->return_date)->format('d/m/Y') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Aprovações -->
                    <!-- Aprovações -->
                    <div class="col-md-12 mb-4">
                        <h3 class="card-title">Aprovações</h3>
                        <div class="card">
                            <div class="card-body">
                                {{-- <p><strong>Solicitado por:</strong> {{ $assetMovement->requestedBy->name }}</p> --}}

                                @switch($assetMovement->status)
                                    @case('pending')
                                        <p><strong>Status de Aprovação:</strong>
                                            <span class="badge bg-warning">Pendente de Aprovação</span>
                                        </p>
                                    @break

                                    @case('completed')
                                        <p><strong>Status de Aprovação:</strong>
                                            <span class="badge bg-success">Aprovado</span>
                                        </p>
                                        @if ($assetMovement->approvedBy)
                                            <p><strong>Aprovado por:</strong> {{ $assetMovement->approvedBy->name }}</p>
                                            <p><strong>Data da Aprovação:</strong>
                                                {{ \Carbon\Carbon::parse($assetMovement->approved_at)->format('d/m/Y H:i') }}</p>
                                        @endif
                                    @break

                                    @case('cancelled')
                                        <p><strong>Status de Aprovação:</strong>
                                            <span class="badge bg-danger">Rejeitado</span>
                                        </p>
                                        @if ($assetMovement->approvedBy)
                                            <p><strong>Rejeitado por:</strong> {{ $assetMovement->approvedBy->name }}</p>
                                            <p><strong>Data da Rejeição:</strong>
                                                {{ \Carbon\Carbon::parse($assetMovement->approved_at)->format('d/m/Y H:i') }}</p>
                                        @endif
                                    @break

                                    @default
                                        <p><strong>Status de Aprovação:</strong>
                                            <span class="badge bg-secondary">Status Desconhecido</span>
                                        </p>
                                @endswitch
                            </div>
                        </div>
                    </div>

                    @if ($assetMovement->status == 'pending')
                        <div class="card-footer">
                            <form method="POST" class="d-inline"
                                action="{{ route('asset-movements.approve', $assetMovement) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success me-2">
                                    <i class="fas fa-check me-2"></i>Aprovar Movimentação
                                </button>
                            </form>
                            <form method="POST" class="d-inline"
                                action="{{ route('asset-movements.reject', $assetMovement) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-times me-2"></i>Rejeitar Movimentação
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
