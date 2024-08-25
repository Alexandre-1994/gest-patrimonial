@extends('layouts.app')

{{-- @section('title', 'Dashboard') --}}

@section('content')
    <div class="container-fluid">
        <div class="row" style="margin-top: 3.5rem !important;">
            <!-- Painel de Resumo -->
            <div class="col-lg-12">
                <h2 class="mt-4">Dashboard</h2>
                <p>Visão geral das estatísticas dos ativos.</p>
            </div>
        </div>

        <div class="row">
            <!-- Cartão de Resumo -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body">
                        <h5 class="card-title">Total de Ativos</h5>
                        <p class="card-text display-4">{{ $totalAssets }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ url('/assets') }}" class="text-white">Ver Todos</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card bg-success text-white h-100">
                    <div class="card-body">
                        <h5 class="card-title">Ativos por Categoria</h5>
                        <p class="card-text display-4">{{ $totalCategories }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="text-white">Ver Detalhes</a>
                    </div>
                </div>
            </div>

            <!-- Outros Cartões de Resumo -->
            <!-- Adicione mais cartões de resumo conforme necessário -->
        </div>

        <div class="row mt-4">
            <!-- Gráfico de Ativos por Categoria -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        Ativos por Categoria
                    </div>
                    <div class="card-body">
                        <canvas id="assetsByCategoryChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Gráfico de Ativos por Localização -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        Ativos por Localização
                    </div>
                    <div class="card-body">
                        <canvas id="assetsByLocationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Adicione mais gráficos ou seções conforme necessário -->
    </div>
@endsection

@section('scripts')
    <!-- Inclua a biblioteca Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Dados para o gráfico de Ativos por Categoria
        var ctxCategory = document.getElementById('assetsByCategoryChart').getContext('2d');
        var assetsByCategoryChart = new Chart(ctxCategory, {
            type: 'bar',
            data: {
                labels: {!! json_encode($categories) !!},
                datasets: [{
                    label: 'Quantidade',
                    data: {!! json_encode($assetsByCategory) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Dados para o gráfico de Ativos por Localização
        var ctxLocation = document.getElementById('assetsByLocationChart').getContext('2d');
        var assetsByLocationChart = new Chart(ctxLocation, {
            type: 'pie',
            data: {
                labels: {!! json_encode($locations) !!},
                datasets: [{
                    label: 'Quantidade',
                    data: {!! json_encode($assetsByLocation) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                    ],
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
@endsection
