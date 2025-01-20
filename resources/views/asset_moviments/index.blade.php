@extends('layouts.app')

@section('title', 'Movimentações de Ativos')

@section('content')
    <div class="container-fluid px-4">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Movimentações de Ativos</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Movimentações</li>
                        </ol>
                    </nav>
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

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Ativo</th>
                                <th>De</th>
                                <th>Para</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($movements as $movement)
                                <tr>
                                    <td>{{ $movement->movement_date->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="avatar me-2 bg-blue-lt">
                                                {{ substr($movement->asset->name, 0, 2) }}
                                            </span>
                                            <div>
                                                <div>{{ $movement->asset->name }}</div>
                                                <div class="text-muted">{{ $movement->asset->code }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>{{ $movement->from_user->name }}</div>
                                        <div class="text-muted">{{ $movement->from_location }}</div>
                                    </td>
                                    <td>
                                        <div>{{ $movement->to_user->name }}</div>
                                        <div class="text-muted">{{ $movement->to_location }}</div>
                                    </td>
                                    <td>
                                        @php
                                            $statusClasses = [
                                                'pending' => 'warning',
                                                'approved' => 'success',
                                                'completed' => 'info',
                                                'cancelled' => 'danger',
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusClasses[$movement->status] ?? 'secondary' }}">
                                            {{ ucfirst($movement->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-list">
                                            <a href="{{ route('asset-movements.show', $movement) }}"
                                                class="btn btn-icon btn-outline-secondary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="empty">
                                            <div class="empty-img">
                                                <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                                            </div>
                                            <p class="empty-title">Nenhuma movimentação encontrada</p>
                                            <p class="empty-subtitle text-muted">
                                                Comece criando uma nova movimentação de ativo.
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

                @if ($movements->hasPages())
                    <div class="card-footer d-flex align-items-center">
                        <p class="m-0 text-muted">
                            Mostrando <span>{{ $movements->firstItem() }}</span> até
                            <span>{{ $movements->lastItem() }}</span> de
                            <span>{{ $movements->total() }}</span> registros
                        </p>
                        <div class="pagination m-0 ms-auto">
                            {{ $movements->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
