@extends('layouts.app')
@section('content')
    <div class="container-fluid px-4">
        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('asset-documents.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select name="asset_id" class="form-select" required>
                                        <option value="">Selecione o Ativo</option>
                                        @foreach ($assets as $asset)
                                            <option value="{{ $asset->id }}">{{ $asset->code }} - {{ $asset->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label>Ativo Relacionado</label>
                                </div>
                            </div>


                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="document_code"
                                            class="form-control @error('document_code') is-invalid @enderror"
                                            value="{{ old('document_code') }}" required>
                                        <label>Código do Documento</label>
                                        @error('document_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title') }}" required>
                                        <label>Título do Documento</label>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="type" class="form-select" required>
                                            <option value="">Selecione o tipo</option>
                                            <option value="manual">Manual</option>
                                            <option value="warranty">Garantia</option>
                                            <option value="invoice">Nota Fiscal</option>
                                            <option value="certificate">Certificado</option>
                                            <option value="other">Outro</option>
                                        </select>
                                        <label>Tipo de Documento</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" name="document_date" class="form-control" required>
                                        <label>Data do Documento</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" name="expiration_date" class="form-control">
                                        <label>Data de Expiração</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="file" name="document" class="form-control" required>
                                        <label>Arquivo</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea name="description" class="form-control" style="height: 100px"></textarea>
                                        <label>Descrição</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Salvar
                                    </button>
                                    <a href="{{ route('asset-documents.index') }}" class="btn btn-secondary">Cancelar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
