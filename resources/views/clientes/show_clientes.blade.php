@extends('layout.app')

@section('title', 'Lista de Clientes')

@section('content')
    <h1>Clientes Cadastrados</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div>
        <a href="{{ route('clientes.create.form') }}" class="btn btn-success mb-3 mt-3">Cadastrar Cliente</a>
    </div>

    @if ($clientes->isEmpty())
        <p>Nenhum cliente cadastrado ainda.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->id }}</td>
                        <td>{{ $cliente->nome }}</td>
                        <td>{{ $cliente->email }}</td>
                        <td>{{ $cliente->telefone }}</td>
                        <td>
                            <a href="#" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="#" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

@endsection
