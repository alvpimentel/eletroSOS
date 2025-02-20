@extends('layout.app')

@section('title', 'Cadastrar Serviço')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('servicos.create') }}" method="POST">
        @csrf
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nome" class="mb-2">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control" required>
                </div>
                @error('nome')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="valor" class="mb-2">Valor</label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="text" name="valor" id="valor" class="form-control" required oninput="formatarMoeda(this)">
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="cliente_id" class="mb-2">Cliente</label>
                    <select name="cliente_id" id="cliente_id" class="form-control" required>
                        <option value="">Selecione o Cliente</option>
                        @foreach ($clientes ?? '' as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                        @endforeach
                    </select>
                </div>
                @error('cliente_id')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="descricao" class="mb-2">Descrição</label>
                    <textarea rows="5" name="descricao" id="descricao" class="form-control" required></textarea>
                </div>
                @error('descricao')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="dt_chamado" class="mb-2">Data</label>
                    <input type="date" name="dt_chamado" id="dt_chamado" class="form-control" required>
                </div>
                @error('dt_chamado') 
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="prioridade_id" class="mb-2">Prioridade</label>
                    <select name="prioridade_id" id="prioridade_id" class="form-control">
                        <option value="">Selecione a Prioridade</option>
                        @foreach ($prioridades as $prioridade)
                            <option value="{{ $prioridade->id }}">{{ $prioridade->nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="d-flex flex-row gap-3 mt-4">
            <button onclick="goBack();" class="btn btn-secondary">Voltar</button>
            <button type="submit" class="btn btn-success">Cadastrar Serviço</button>
        </div>
    </form>
@endsection

@section('scripts')
<script>
    function goBack() {
        window.history.back();
    }
</script>
@endsection
