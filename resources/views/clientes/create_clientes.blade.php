@extends('layout.app')

@section('title', 'Home')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('clientes.create') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="telefone">Telefone</label>
            <input maxlength="11" minlength="11" type="text" name="telefone" id="telefone" class="form-control">
        </div>

        <div class="d-flex flex-row gap-3 mt-3">
            <button onclick="goBack();" class="btn btn-primary">Voltar</button>
            <button type="submit" class="btn btn-success">Criar Cliente</button>
        </div>
        
    </form>

@endsection
