@extends('layout.admin_app')

@section('title', 'Criar Usuário')

@section('content')
    <h1>Criar Novo Usuário</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.usuarios.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="name">Nome</label>
            <input type="text" name="name" id="name" class="form-control" required>
            @error('name')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
            @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="password">Senha</label>
            <input type="password" name="password" id="password" class="form-control" required>
            @error('password')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="password_confirmation">Confirmar Senha</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_admin" id="is_admin" value="1" class="form-check-input">
            <label for="is_admin" class="form-check-label">Usuário é Administrador</label>
        </div>

        <div class="d-flex flex-row gap-3 mt-3">
            <button type="button" onclick="goBack()" class="btn btn-secondary">Voltar</button>
            <button type="submit" class="btn btn-success">Criar Usuário</button>
        </div>
    </form>
@endsection
