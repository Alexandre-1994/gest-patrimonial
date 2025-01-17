@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <!-- Cabeçalho -->
        <div class="row" style="margin-top: 3.5rem !important;">
            <div class="col-lg-12">
                <h2 class="mt-4">Dashboard</h2>
                <p>Visão geral das estatísticas dos ativos.</p>
            </div>
        </div>

        <!-- Filtros -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form id="filterForm" class="row g-3">
                            <div class="col-md-3">
                                <label>Data Inicial</label>
                                <input type="date" class="form-control" name="date_start">
                            </div>
                            <div class="col-md-3">
                                <label>Data Final</label>
                                <input type="date" class="form-control" name="date_end">
                            </div>
                            <div class="col-md-3">
                                <label>Categoria</label>
                                <select class="form-control" name="category">
                                    <option value="">Todas</option>
                                    @foreach ($allCategories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cards de Estatísticas Principais -->
        <div class="row">
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
                        <a href="{{ route('assets.by-category') }}" class="text-white">Ver Detalhes</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card bg-info text-white h-100">
                    <div class="card-body">
                        <h5 class="card-title">Valor Total dos Ativos</h5>
                        <p class="card-text display-4">MZN {{ number_format($totalValue, 2, ',', '.') }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('assets.value') }}" class="text-white">Ver Detalhes</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card bg-warning text-white h-100">
                    <div class="card-body">
                        <h5 class="card-title">Em Manutenção</h5>
                        <p class="card-text display-4">{{ $maintenanceCount }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('assets.maintenance') }}" class="text-white">Ver Manutenções</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Segunda Linha de Cards -->
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card bg-danger text-white h-100">
                    <div class="card-body">
                        <h5 class="card-title">Ativos Depreciados</h5>
                        <p class="card-text display-4">{{ $depreciatedAssets }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('assets.depreciated') }}" class="text-white">Ver Lista</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card bg-secondary text-white h-100">
                    <div class="card-body">
                        <h5 class="card-title">Garantias a Vencer</h5>
                        <p class="card-text display-4">{{ $expiringWarranties }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('assets.warranty') }}" class="text-white">Ver Lista</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row">
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

        <!-- Tabela de Alertas -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Ativos que Precisam de Atenção
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nome</th>
                                        <th>Categoria</th>
                                        <th>Status</th>
                                        <th>Alerta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alertAssets as $asset)
                                        <tr>
                                            <td>{{ $asset->code }}</td>
                                            <td>{{ $asset->name }}</td>
                                            <td>{{ $asset->category->name }}</td>
                                            <td>
                                                <span class="badge bg-{{ $asset->status_color }}">
                                                    {{ $asset->status }}
                                                </span>
                                            </td>
                                            <td>{{ $asset->alert_message }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Inclua a biblioteca Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Dados para o gráfico de Ativos por Categoria
        // Função para gerar cores aleatórias
        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        // Dados para o gráfico de Ativos por Categoria
        const ctxCategory = document.getElementById('assetsByCategoryChart').getContext('2d');
        new Chart(ctxCategory, {
            type: 'bar',
            data: {
                labels: @json($categories),
                datasets: [{
                    label: 'Quantidade de Ativos',
                    data: @json($assetsByCategory),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Distribuição de Ativos por Categoria'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Dados para o gráfico de Ativos por Localização
        // const ctxLocation = document.getElementById('assetsByLocationChart').getContext('2d');
        // new Chart(ctxLocation, {
        //     type: 'pie',
        //     data: {
        //         labels: @json($locations),
        //         datasets: [{
        //             data: @json($assetsByLocation),
        //             backgroundColor: Array(@json($locations).length).fill().map(() => {
        //                 const color = getRandomColor();
        //                 return `rgba(${parseInt(color.slice(1,3),16)}, ${parseInt(color.slice(3,5),16)}, ${parseInt(color.slice(5,7),16)}, 0.5)`;
        //             }),
        //             borderColor: 'rgba(255, 255, 255, 0.8)',
        //             borderWidth: 1
        //         }]
        //     },
        //     options: {
        //         responsive: true,
        //         plugins: {
        //             legend: {
        //                 position: 'right',
        //             },
        //             title: {
        //                 display: true,
        //                 text: 'Distribuição de Ativos por Localização'
        //             }
        //         }
        //     }
        // });
        // var ctxCategory = document.getElementById('assetsByCategoryChart').getContext('2d');
        // var assetsByCategoryChart = new Chart(ctxCategory, {
        //     type: 'bar',
        //     data: {
        //         labels: {!! json_encode($categories) !!},
        //         datasets: [{
        //             label: 'Quantidade',
        //             data: {!! json_encode($assetsByCategory) !!},
        //             backgroundColor: 'rgba(54, 162, 235, 0.5)',
        //             borderColor: 'rgba(54, 162, 235, 1)',
        //             borderWidth: 1
        //         }]
        //     },
        //     options: {
        //         responsive: true,
        //         scales: {
        //             y: {
        //                 beginAtZero: true
        //             }
        //         }
        //     }
        // });

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
        $('#filterForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('dashboard.filter') }}',
                method: 'GET',
                data: $(this).serialize(),
                success: function(response) {
                    // Atualizar os gráficos com os novos dados
                    assetsByCategoryChart.data.datasets[0].data = response.assetsByCategory;
                    assetsByCategoryChart.update();

                    assetsByLocationChart.data.datasets[0].data = response.assetsByLocation;
                    assetsByLocationChart.update();


                    updateCards(response);
                }
            });
        });

        function updateCards(data) {
            $('#totalAssets').text(data.totalAssets);
            $('#totalValue').text(formatCurrency(data.totalValue));
            $('#maintenanceCount').text(data.maintenanceCount);
            // ... atualizar outros cards
        }
    </script>
@endsection
