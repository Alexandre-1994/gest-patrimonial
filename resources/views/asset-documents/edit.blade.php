@extends('layouts.app')
@section('content')
    <div class="container-fluid px-4">
        <div class="card">
            <div class="card-header">
                <h3>Editar Documento</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('asset-documents.update', $document->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" name="title" class="form-control" value="{{ $document->title }}"
                                    required>
                                <label>Título do Documento</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select name="status" class="form-select" required>
                                    <option value="active" {{ $document->status == 'active' ? 'selected' : '' }}>Ativo
                                    </option>
                                    <option value="expired" {{ $document->status == 'expired' ? 'selected' : '' }}>Expirado
                                    </option>
                                    <option value="pending" {{ $document->status == 'pending' ? 'selected' : '' }}>Pendente
                                    </option>
                                </select>
                                <label>Status</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" name="document_date" class="form-control"
                                    value="{{ $document->document_date }}" required>
                                <label>Data do Documento</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" name="expiration_date" class="form-control"
                                    value="{{ $document->expiration_date }}">
                                <label>Data de Expiração</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-floating">
                                <textarea name="description" class="form-control" style="height: 100px">{{ $document->description }}</textarea>
                                <label>Descrição</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" name="requires_renewal" class="form-check-input"
                                    {{ $document->requires_renewal ? 'checked' : '' }}>
                                <label>Requer Renovação</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" name="is_confidential" class="form-check-input"
                                    {{ $document->is_confidential ? 'checked' : '' }}>
                                <label>Documento Confidencial</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Atualizar
                            </button>
                            <a href="{{ route('asset-documents.show', $document->id) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
