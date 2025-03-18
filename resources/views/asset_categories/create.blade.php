@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Nova Categoria de Ativo</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Início</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('asset-categories.index') }}">Categorias</a></li>
                            <li class="breadcrumb-item active">Nova Categoria</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('asset-categories.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('code') is-invalid @enderror"
                                    id="code" name="code" value="{{ old('code') }}" required>
                                <label for="code">Código da Categoria</label>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required>
                                <label for="name">Nome</label>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-floating">
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    style="height: 100px">{{ old('description') }}</textarea>
                                <label for="description">Descrição</label>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id"
                                    name="parent_id">
                                    <option value="">Selecione uma categoria pai</option>
                                    @foreach ($categories ?? [] as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="parent_id">Categoria Pai</label>
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="number" step="0.01"
                                    class="form-control @error('depreciation_rate') is-invalid @enderror"
                                    id="depreciation_rate" name="depreciation_rate" value="{{ old('depreciation_rate') }}"
                                    required>
                                <label for="depreciation_rate">Taxa de Depreciação (%)</label>
                                @error('depreciation_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="number"
                                    class="form-control @error('estimated_life_months') is-invalid @enderror"
                                    id="estimated_life_months" name="estimated_life_months"
                                    value="{{ old('estimated_life_months') }}" required>
                                <label for="estimated_life_months">Vida Útil (meses)</label>
                                @error('estimated_life_months')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="active" name="active" value="1"
                                    {{ old('active', 1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">Ativo</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Salvar
                        </button>
                        <a href="{{ route('asset-categories.index') }}" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
