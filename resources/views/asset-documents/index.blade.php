@extends('layouts.app')
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Documentos de Ativos</h2>
            <a href="{{ route('asset-documents.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Novo Documento
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Ativo</th>
                                <th>Tipo</th>
                                <th>Data</th>
                                <th>Expiração</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documents as $document)
                                <tr>
                                    <td>{{ $document->document_code }}</td>
                                    <td>{{ $document->asset->name }}</td>
                                    <td>{{ $document->type }}</td>
                                    <td>{{ $document->document_date }}</td>
                                    <td>{{ $document->expiration_date }}</td>
                                    <td>
                                        <span class="badge bg-{{ $document->status_color }}">
                                            {{ $document->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('asset-documents.show', $document->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('asset-documents.edit', $document->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button onclick="deleteDocument({{ $document->id }})"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $documents->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
