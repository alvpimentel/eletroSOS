@extends('layout.app')

@section('title', 'Editar Serviço')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-1 mb-3 gap-2 d-flex flex-column">
        <strong>Cliente: {{ $servico->cliente->nome }}</strong>
        
        @if (!$servico->editado_por)
            <small>Criado por {{ $servico->user->name }} em {{ formatarDataHora($servico->created_at) }}</small>
        @else
            <small>Editado por {{ $servico->editor->name }} em {{ formatarDataHora($servico->updated_at) }}</small>
        @endif
    </div>


    <form action="{{ route('servicos.update', $servico->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nome" class="mb-2">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control" value="{{ $servico->nome }}" disabled required>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="dt_chamado" class="mb-2">Data</label>
                    <input type="date" name="dt_chamado" id="dt_chamado" class="form-control"
                        value="{{ $servico->dt_chamado ? \Carbon\Carbon::parse($servico->dt_chamado)->format('Y-m-d') : '' }}" 
                        disabled required>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="valor" class="mb-2">Valor</label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="text" name="valor" id="valor" class="form-control" value="{{ number_format($servico->valor, 2, ',', '.') }}" disabled required oninput="formatarMoeda(this)">
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="prioridade" class="mb-2">Prioridade</label>
                    <input type="text" name="prioridade" id="prioridade" class="form-control fw-bold
                    {{ $servico->finalizado == 1 ? 'text-success' : 'text-danger' }}" 
                        value="{{ $servico->prioridade->nome }}" disabled required>
                </div>
            </div>

            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <label for="descricao" class="mb-2">Descrição</label>
                    <textarea rows="5" name="descricao" id="descricao" class="form-control" rows="3" disabled>{{ $servico->descricao }}</textarea>
                </div>
            </div>

            <div class="col-md-2 mt-3">
                <div class="form-group">
                    <label for="finalizado" class="mb-2">Finalizado</label>
                    <select name="finalizado" id="finalizado" class="form-control fw-bold" onchange="atualizarCor(this)" disabled>
                        <option value="1" class="text-success" {{ $servico->finalizado == 1 ? 'selected' : '' }}>Sim</option>
                        <option value="0" class="text-danger" {{ $servico->finalizado == 0 ? 'selected' : '' }}>Não</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 mt-3">
                <div class="form-group">
                    <label for="statusPagamento" class="mb-2">Pago</label>
                    <select name="statusPagamento" id="statusPagamento" class="form-control fw-bold" onchange="atualizarCor(this)" disabled>
                        <option value="1" class="text-success" {{ $servico->statusPagamento == 1 ? 'selected' : '' }}>Sim</option>
                        <option value="0" class="text-danger" {{ $servico->statusPagamento == 0 ? 'selected' : '' }}>Não</option>
                    </select>
                </div>
            </div>


            <div class="d-flex flex-row gap-3 mt-3">
            <button type="button" onclick="goBack()" class="btn btn-secondary">Voltar</button>
            <button type="button" onclick="enableEditing()" class="btn btn-warning">Editar</button>
            <button type="submit" class="btn btn-success" style="display: none;" id="saveButton">Salvar Alterações</button>
        </div>
    </form>

    <hr class="mt-3"/>

    <h3 class="mt-2">Contratos do Serviço</h3>

    <div>
        <a href="{{ route('contratos.gerar', ['id' => $servico->id]) }}" class="btn btn-success mb-3 mt-1">Gerar Contrato</a>
    </div>

    @if($contratos->isEmpty())
        <p class="mt-2">Este serviço ainda não possui contrato gerado.</p>
    @else
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Data do Chamado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($servicos as $servico)
                    <tr>
                        <td>{{ $contratos->nr_versao }}</td>
                        <td>{{ $contratos->user_id }}</td>
                        <td>{{ $contratos->dt_criado ? $servico->dt_chamado : 'Sem data.' }}</td>
                        <td>
                            <a href="{{ route('servicos.edit', $servico ?? ''->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

@endsection

@section('scripts')
<script>
    function enableEditing() {
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => input.removeAttribute('disabled'));
        document.getElementById('saveButton').style.display = 'inline-block'; 
    }

    function atualizarCor(select) {
    if (select.value == "1") {
        select.classList.remove("text-danger");
        select.classList.add("text-success");
    } else {
        select.classList.remove("text-success");
        select.classList.add("text-danger");
    }
    }

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll("select").forEach(select => atualizarCor(select));
    });

</script>
@endsection
