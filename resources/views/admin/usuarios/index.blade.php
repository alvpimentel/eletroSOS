@extends('layout.admin_app')

@section('title', 'Lista de Usuários')

@section('content')
    <h1>Lista de Usuários</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
        <a href="/admin/usuarios/create" class="btn btn-success">Criar Usuário</a>

        <div class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Pesquisar por nome" oninput="filterTable()" id="searchInput">
        </div>
    </div>

    @if ($usuarios->isEmpty())
        <p>Nenhum usuário encontrado.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Desativar</th> 
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id }}</td>
                        <td>{{ $usuario->name }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>
                            @if ($usuario->admin) 
                                Administrador
                            @else
                                <i class="bi bi-person-x" style="color: red; cursor: pointer; font-size: 1.2rem;" title="Desativar"></i>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
