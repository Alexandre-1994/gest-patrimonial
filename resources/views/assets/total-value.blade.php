@extends('layouts.app')

@section('title', 'Valor Total dos Ativos')

@section('content')
    <div class="container-fluid px-4">
        <!-- Cabeçalho -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Valor Total dos Ativos</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Valor Total dos Ativos</li>
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
                                <h3 class="mb-1">MZN {{ number_format($summary['total_value'], 2, ',', '.') }}</h3>
                                <div class="text-muted">Valor Atual Total</div>
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
                                <h3 class="mb-1">MZN {{ number_format($summary['total_purchase_value'], 2, ',', '.') }}
                                </h3>
                                <div class="text-muted">Valor de Compra Total</div>
                            </div>
                            <div class="text-success">
                                <i class="fas fa-shopping-cart fa-2x"></i>
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
                                <h3 class="mb-1">{{ number_format($summary['total_assets']) }}</h3>
                                <div class="text-muted">Total de Ativos</div>
                            </div>
                            <div class="text-info">
                                <i class="fas fa-boxes fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Valor por Categoria -->
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Valor por Categoria</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-vcenter">
                        <thead>
                            <tr>
                                <th>Categoria</th>
                                <th>Quantidade</th>
                                <th>Valor Total</th>
                                <th>% do Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- No loop das categorias -->
                            @foreach ($valuesByCategory as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->assets_count }}</td>
                                    <td>MZN {{ number_format($category->assets_sum_current_value, 2, ',', '.') }}</td>
                                    <td>
                                        @php
                                            $percentage =
                                                ($category->assets_sum_current_value / $summary['total_value']) * 100;
                                        @endphp
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                {{ number_format($percentage, 1) }}%
                                            </div>
                                            <div class="col">
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar" style="width: {{ $percentage }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Valor por Status -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Valor por Status</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-vcenter">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Quantidade</th>
                                <th>Valor Total</th>
                                <th>% do Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($valuesByStatus as $status)
                                <tr>
                                    <td>
                                        @php
                                            $statusClasses = [
                                                'active' => 'success',
                                                'maintenance' => 'warning',
                                                'inactive' => 'danger',
                                                'disposed' => 'secondary',
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusClasses[$status->status] ?? 'secondary' }}">
                                            {{ ucfirst($status->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $status->total_assets }}</td>
                                    <td>MZN {{ number_format($status->total_value, 2, ',', '.') }}</td>
                                    <td>
                                        @php
                                            $percentage = ($status->total_value / $summary['total_value']) * 100;
                                        @endphp
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                {{ number_format($percentage, 1) }}%
                                            </div>
                                            <div class="col">
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar" style="width: {{ $percentage }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
