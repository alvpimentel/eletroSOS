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
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nome" class="mb-2">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control" required>
                </div>
                @error('nome')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="descricao" class="mb-2">Descrição</label>
                    <input type="text" name="descricao" id="descricao" class="form-control" required>
                </div>
                @error('descricao')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="valor" class="mb-2">Valor</label>
                    <input type="text" name="valor" id="valor" class="form-control" required>
                </div>
                @error('valor')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
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

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="material_id" class="mb-2">Material</label>
                    <select name="material_id" id="material_id" class="form-control" required>
                        <option value="">Selecione o Material</option>
                        @foreach ($materiais as $material)
                            <option value="{{ $material->id }}">{{ $material->nome }}</option>
                        @endforeach
                    </select>
                </div>
                @error('material_id')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="data_entrega" class="mb-2">Data de Entrega</label>
                    <input type="date" name="data_entrega" id="data_entrega" class="form-control" required>
                </div>
                @error('data_entrega')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex flex-row gap-3 mt-3">
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
