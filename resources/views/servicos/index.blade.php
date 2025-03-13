@extends('layout.app')

@section('title', 'Lista de Serviços')

@section('content')
    <div class="d-flex flex-row gap-3 align-items-center">
        <h1>Serviços</h1>
            <a href="{{ route('servicos.create') }}" class="btn btn-outline-success btn-sm d-flex align-items-center">
                <i class="bi bi-plus"></i>
            </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulário de Filtro -->
    <form method="GET" action="{{ route('servicos.index') }}" class="mb-4 mt-4">
        <div class="row g-3">
            <div class="col-md-3">
                <label for="cliente_id" class="form-label">Cliente</label>
                <select name="cliente_id" id="cliente_id" class="form-select">
                    <option value="">Todos</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ request('cliente_id') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="tecnico_id" class="form-label">Técnico</label>
                <select name="tecnico_id" id="tecnico_id" class="form-select">
                    <option value="">Todos</option>
                    @foreach ($tecnicos as $tecnico)
                        <option value="{{ $tecnico->id }}" {{ request('tecnico_id') == $tecnico->id ? 'selected' : '' }}>
                            {{ $tecnico->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-2">
                <label for="dataInicial" class="form-label">Data Inicial</label>
                <input type="date" name="dataInicial" id="dataInicial" class="form-control" value="{{ request('dataInicial') }}">
            </div>

            <div class="col-md-2">
                <label for="dataFinal" class="form-label">Data Final</label>
                <input type="date" name="dataFinal" id="dataFinal" class="form-control" value="{{ request('dataFinal') }}">
            </div>

            <div class="col-md-2">
                <label for="finalizado" class="form-label">Finalizado</label>
                <select name="finalizado" id="finalizado" class="form-select">
                    <option value="">Todos</option>
                    <option value="1" {{ request('finalizado') == '1' ? 'selected' : '' }}>Sim</option>
                    <option value="0" {{ request('finalizado') == '0' ? 'selected' : '' }}>Não</option>
                </select>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('servicos.index') }}" class="btn btn-secondary">Limpar</a>
        </div>
    </form>

    @if ($servicos->isEmpty())
        <p>Nenhum serviço encontrado.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Cliente</th>
                    <th>Técnico</th>
                    <th>Valor</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($servicos as $servico)
                    <tr>
                        <td>{{ $servico->id }}</td>
                        <td>{{ $servico->nome }}</td>
                        <td>{{ $servico->cliente->nome }}</td>
                        <td>{{ $servico->tecnico?->name ?? 'Sem técnico vinculado' }}</td>
                        <td>{{ formatarMoeda($servico->valor) }}</td>
                        <td>{{ $servico->dt_chamado ? formatarData($servico->dt_chamado) : 'Sem data' }}</td>
                        <td>
                            <a href="{{ route('servicos.edit', $servico->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="d-flex justify-content-center">
        {{ $servicos->links('vendor.pagination.bootstrap-4') }}
    </div>
@endsection

@section('scripts')
<script>
    
</script>
@endsection