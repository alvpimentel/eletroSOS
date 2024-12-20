@extends('layout.app')

@section('title', 'Editar Cliente')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nome" class="mb-2">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control" value="{{ $cliente->nome }}" disabled required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="email" class="mb-2">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $cliente->email }}" disabled required>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="telefone" class="mb-2">Telefone</label>
                    <input maxlength="11" minlength="11" type="text" name="telefone" id="telefone" class="form-control" value="{{ $cliente->telefone }}" disabled>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="endereco" class="mb-2">Endereço</label>
                    <input type="text" name="endereco" id="endereco" class="form-control" value="{{ $cliente->endereco }}" disabled>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="obs" class="mb-2">Observações</label>
                    <textarea name="obs" id="obs" class="form-control" rows="3" disabled>{{ $cliente->obs }}</textarea>
                </div>
            </div>
        </div>

        <div class="d-flex flex-row gap-3 mt-3">
            <button type="button" onclick="enableEditing()" class="btn btn-primary">Editar</button>
            <button type="submit" class="btn btn-success" style="display: none;" id="saveButton">Salvar Alterações</button>
        </div>
    </form>
@endsection

@section('scripts')
<script>
    function enableEditing() {
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => input.removeAttribute('disabled'));
        document.getElementById('saveButton').style.display = 'inline-block'; // Exibe o botão de salvar
    }
</script>
@endsection
