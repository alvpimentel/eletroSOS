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
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nome" class="mb-2">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="email" class="mb-2">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="telefone" class="mb-2">Telefone</label>
                    <input maxlength="11" minlength="11" type="text" name="telefone" id="telefone" class="form-control">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="endereco" class="mb-2">Endereço</label>
                    <input type="text" name="endereco" id="endereco" class="form-control">
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tipo_pessoa">Tipo de Pessoa</label>
                    <select class="form-control" name="tipo_pessoa" id="tipo_pessoa" onchange="toggleCpfCnpj()" required>
                        <option value="">Selecione</option>
                        <option value="0">Pessoa Física</option>
                        <option value="1">Pessoa Jurídica</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group" id="cpf_group" style="display: none;">
                    <label for="cpf" class="mb-2">CPF</label>
                    <input maxlength="11" minlength="11" type="text" name="cpf" id="cpf" class="form-control">
                </div>

                <div class="form-group" id="cnpj_group" style="display: none;">
                    <label for="cnpj" class="mb-2">CNPJ</label>
                    <input maxlength="14" minlength="14" type="text" name="cnpj" id="cnpj" class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="obs" class="mb-2">Observações</label>
                    <textarea name="obs" id="obs" class="form-control" rows="3"></textarea>
                </div>
            </div>
        </div>

        <div class="d-flex flex-row gap-3 mt-3">
            <button onclick="goBack();" class="btn btn-primary">Voltar</button>
            <button type="submit" class="btn btn-success">Cadastrar Cliente</button>
        </div>
    </form>
@endsection

@section('scripts')
<script>
    function toggleCpfCnpj() {
        const tipoPessoa = document.getElementById('tipo_pessoa').value;
        const cpfGroup = document.getElementById('cpf_group');
        const cnpjGroup = document.getElementById('cnpj_group');

        if (tipoPessoa === "0") {
            cpfGroup.style.display = 'block';
            cnpjGroup.style.display = 'none';
        } else if (tipoPessoa === "1") {
            cpfGroup.style.display = 'none';
            cnpjGroup.style.display = 'block';
        } else {
            cpfGroup.style.display = 'none';
            cnpjGroup.style.display = 'none';
        }
    }
</script>
@endsection
