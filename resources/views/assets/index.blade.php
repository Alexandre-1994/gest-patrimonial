@extends('layouts.app')

@section('title', 'Gestão de Ativos')

@section('content')
    <div class="container-fluid px-4">
        <!-- Cabeçalho da Página -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">Gestão de Patrimônio</div>
                    <h2 class="page-title">Ativos</h2>
                </div>
                <div class="col-auto ms-auto">
                    <div class="btn-list">
                        {{-- <a href="{{ route('assets.export') }}" class="btn btn-outline-secondary d-none d-sm-inline-block">
                            <i class="fas fa-file-export me-2"></i>Exportar
                        </a> --}}
                        <a href="{{ route('assets.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <i class="fas fa-plus me-2"></i>Novo Ativo
                        </a>
                        <a href="{{ route('assets.create') }}" class="btn btn-primary d-sm-none btn-icon">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <!-- Filtros -->
        <div class="card mb-3">
            <div class="card-body">
                <form action="{{ route('assets.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3 col-sm-6">
                        <label class="form-label">Buscar</label>
                        <div class="input-icon">
                            <span class="input-icon-addon">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                                placeholder="Código ou nome...">
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <label class="form-label">Categoria</label>
                        <select class="form-select" name="category">
                            <option value="">Todas</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="">Todos</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Ativo</option>
                            <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Em
                                Manutenção</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inativo
                            </option>
                            <option value="disposed" {{ request('status') == 'disposed' ? 'selected' : '' }}>Descartado
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <label class="form-label">Localização</label>
                        <input type="text" name="location" class="form-select" value="{{ request('location') }}"
                            placeholder="Digite a localização">
                    </div>
                    <div class="col-md-auto">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i>Filtrar
                        </button>
                    </div>
                    <div class="col-md-auto">
                        <a href="{{ route('assets.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-undo me-2"></i>Limpar
                        </a>
                    </div>
                </form>
            </div>
        </div>


        <!-- Lista de Ativos -->
        <div class="card">

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Localização</th>
                                <th>Status</th>
                                <th>Valor Atual</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($assets as $asset)
                                <tr>
                                    <td>{{ $asset->code }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="font-weight-medium">{{ $asset->name }}</div>
                                                <div class="text-muted">
                                                    MZN {{ number_format($asset->current_value, 2, ',', '.') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-blue-lt">
                                            {{ $asset->category->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>{{ $asset->location }}</td>
                                    <td>
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
                                    </td>
                                    <td>
                                        MZN {{ number_format($asset->current_value, 2, ',', '.') }}
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('assets.show', $asset) }}"
                                                class="btn btn-outline-secondary btn-icon" title="Visualizar">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('assets.edit', $asset) }}"
                                                class="btn btn-outline-secondary btn-icon" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('assets.destroy', $asset) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-icon"
                                                    onclick="return confirm('Tem certeza que deseja excluir este ativo?')"
                                                    title="Excluir">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">Nenhum ativo encontrado</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Paginação -->
            @if ($assets->hasPages())
                <div class="card-footer d-flex align-items-center">
                    <p class="m-0 text-muted">
                        Mostrando <span>{{ $assets->firstItem() }}</span> até
                        <span>{{ $assets->lastItem() }}</span> de
                        <span>{{ $assets->total() }}</span> registros
                    </p>
                    <div class="pagination m-0 ms-auto">
                        {{ $assets->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
            <!-- Modal de Confirmação de Exclusão -->
            <div class="modal fade" id="deleteModal" tabindex="-1">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body text-center py-4">
                            <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                            <h3 class="mt-3">Confirmar exclusão?</h3>
                            <p class="text-muted">Esta ação não pode ser desfeita.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger" id="confirmDelete">
                                <i class="fas fa-trash me-2"></i>Excluir
                            </button>
                        </div>
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

                .page-pretitle {
                    font-size: 0.825rem !important;
                    text-transform: uppercase !important;
                    line-height: 1.6 !important;
                    color: #656d77 !important;
                    font-weight: 600 !important;
                    letter-spacing: 0.04em !important;
                    margin: 0 !important;
                }

                .page-title {
                    margin: 0 !important;
                    font-size: 1.5rem !important;
                    font-weight: 600 !important;
                    line-height: 1.5 !important;
                    color: #1f2937 !important;
                }

                .card {
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
                    border: 1px solid rgba(0, 0, 0, 0.05) !important;
                    border-radius: 4px !important;
                    margin-bottom: 1.5rem !important;
                }

                .input-icon {
                    position: relative !important;
                }

                .input-icon .input-icon-addon {
                    position: absolute !important;
                    top: 0 !important;
                    left: 0 !important;
                    height: 100% !important;
                    width: 2.5rem !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                    color: #656d77 !important;
                    pointer-events: none !important;
                }

                .input-icon .form-control {
                    padding-left: 2.5rem !important;
                }

                .avatar {
                    width: 2.5rem !important;
                    height: 2.5rem !important;
                    line-height: 2.5rem !important;
                    border-radius: 50% !important;
                    display: inline-flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                    font-size: 1rem !important;
                    font-weight: 600 !important;
                    background: #e9ecef !important;
                    color: #1f2937 !important;
                }

                .avatar.avatar-sm {
                    width: 2rem !important;
                    height: 2rem !important;
                    line-height: 2rem !important;
                    font-size: 0.875rem !important;
                }

                .table-vcenter td {
                    vertical-align: middle !important;
                }

                .badge {
                    padding: 0.5em 1em !important;
                    font-size: 0.75rem !important;
                    font-weight: 600 !important;
                }

                .badge.bg-blue-lt {
                    background-color: rgba(32, 107, 196, 0.1) !important;
                    color: #206bc4 !important;
                }

                .btn-group {
                    gap: 0.25rem !important;
                }

                .btn-icon {
                    width: 2rem !important;
                    height: 2rem !important;
                    padding: 0 !important;
                    display: inline-flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                }

                .modal .fas {
                    font-size: 2rem !important;
                }
            </style>
        @endsection

        @section('scripts')
            <script>
                function confirmDelete(assetId) {
                    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
                    const confirmButton = document.getElementById('confirmDelete');

                    confirmButton.onclick = function() {
                        document.getElementById(`delete-form-${assetId}`).submit();
                    }

                    modal.show();
                }

                // Inicializar tooltips
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                })
            </script>
        @endsection
