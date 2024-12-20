@extends('layout.admin_app')

@section('title', 'Lista de Usuários')

@section('content')
    <h1>Lista de Usuários Não Administradores</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($usuarios->isEmpty())
        <p>Nenhum usuário encontrado.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id }}</td>
                        <td>{{ $usuario->name }}</td>
                        <td>{{ $usuario->email }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
