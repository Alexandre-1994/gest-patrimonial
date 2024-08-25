<!-- resources/views/assets/index.blade.php -->
@extends('layouts.app')

@section('title', 'Listagem de Ativos')

@section('content')
    <h1>Bem-vindo ao Sistema de Gestão de Ativos</h1>
    <p>Este é o seu painel principal. Aqui você pode acessar e gerenciar todos os seus ativos.</p>
    <a href="{{ route('ativos.create') }}" class="btn btn-primary">Create New Asset</a>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Serial Number</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ativos as $asset)
                <tr>
                    <td>{{ $asset->name }}</td>
                    <td>{{ $asset->serial_number }}</td>
                    <td>{{ $asset->category }}</td>
                    <td>
                        <a href="{{ route('ativos.show', $asset) }}" class="btn btn-info">View</a>
                        <a href="{{ route('ativos.edit', $asset) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('ativos.destroy', $asset) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this asset?');">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
