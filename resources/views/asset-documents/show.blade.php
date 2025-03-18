@extends('layouts.app')
@section('content')
    <div class="container-fluid px-4">
        <div class="card">
            <div class="card-header">
                <h3>Detalhes do Documento</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Código:</strong> {{ $document->document_code }}</p>
                        <p><strong>Tipo:</strong> {{ $document->type }}</p>
                        <p><strong>Data:</strong> {{ $document->document_date }}</p>
                        <p><strong>Expiração:</strong> {{ $document->expiration_date }}</p>
                        <p><strong>Status:</strong> {{ $document->status }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Arquivo:</strong> {{ $document->file_name }}</p>
                        <p><strong>Tamanho:</strong> {{ number_format($document->file_size / 1024, 2) }} KB</p>
                        <p><strong>Tipo de Arquivo:</strong> {{ $document->file_type }}</p>
                        <p><strong>Enviado por:</strong> {{ $document->uploadedBy->name }}</p>
                        <p><strong>Data de Upload:</strong> {{ $document->created_at }}</p>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('asset-documents.download', $document->id) }}" class="btn btn-primary">
                        <i class="fas fa-download"></i> Download
                    </a>
                    <a href="{{ route('asset-documents.edit', $document->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
