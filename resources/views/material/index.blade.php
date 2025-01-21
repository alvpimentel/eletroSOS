@extends('layout.app')

@section('title', 'Lista de Materiais')

@section('content')
    <h1>Materiais Cadastrados</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center">
        <button class="btn btn-success" onclick="toggleAddMaterialModal(true)">
            Adicionar Material
        </button>
        <form method="GET" action="{{ route('materiais.index') }}" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Pesquisar por nome" oninput="filterTable()" id="searchInput">
        </form>
    </div>

    @if ($materiais->isEmpty())
        <p class="mt-3">Nenhum material encontrado.</p>
    @else
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    <th>Última Atualização</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($materiais as $material)
                    <tr>
                        <td>{{ $material->id }}</td>
                        <td>{{ $material->nome }}</td>
                        <td>{{ $material->qtd }}</td>
                        <td>R${{ $material->valor }}</td>
                        <td>{{ $material->updated_at->format('d/m/Y') }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="openEditMaterialModal({{ $material->id }}, '{{ $material->nome }}', {{ $material->qtd }})">
                                <i class="bi bi-pencil"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Modal para adicionar material -->
    <div id="addMaterialModal" class="custom-modal">
        <div class="custom-modal-content">
            <div class="modal-header mb-3">
                <h5 class="modal-title">Adicionar Material</h5>
            </div>
            <form action="{{ route('materiais.create') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="nome" class="mb-1">Nome do Material</label>
                        <input type="text" name="nome" id="nome" class="form-control" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="qtd" class="mb-1">Quantidade</label>
                        <input type="number" name="qtd" id="qtd" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="valor" class="mb-1">Quantidade</label>
                        <input type="number" step="any" name="valor" id="valor" class="form-control" required>
                    </div>                    
                </div>
                <div class="modal-footer gap-3">
                    <button type="button" class="btn btn-secondary" onclick="toggleAddMaterialModal(false)">Fechar</button>
                    <button type="submit" class="btn btn-success">Salvar Material</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para editar material -->
    <div id="editMaterialModal" class="custom-modal">
        <div class="custom-modal-content">
            <div class="modal-header mb-3">
                <h5 class="modal-title">Editar Quantidade do Material</h5>
            </div>
            <form id="editMaterialForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="id" id="editMaterialId">
                    <div class="form-group mb-3">
                        <label for="editMaterialName" class="mb-1">Nome do Material</label>
                        <input type="text" id="editMaterialName" class="form-control" disabled>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="editMaterialQtd" class="mb-1">Quantidade</label>
                        <input type="number" name="qtd" id="editMaterialQtd" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="editMaterialValor" class="mb-1">Valor</label>
                        <input type="number" step="any" name="editMaterialValor" id="editMaterialValor" class="form-control" required>
                    </div>  
                </div>
                <div class="modal-footer gap-3">
                    <button type="button" class="btn btn-secondary" onclick="toggleEditMaterialModal(false)">Fechar</button>
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function toggleAddMaterialModal(show) {
        const modal = document.getElementById('addMaterialModal');
        modal.style.display = show ? 'block' : 'none';
    }

    function toggleEditMaterialModal(show) {
        const modal = document.getElementById('editMaterialModal');
        modal.style.display = show ? 'block' : 'none';
    }

    function openEditMaterialModal(id, nome, qtd) {
        document.getElementById('editMaterialId').value = id;
        document.getElementById('editMaterialName').value = nome;
        document.getElementById('editMaterialQtd').value = qtd;

        const form = document.getElementById('editMaterialForm');
        form.action = `/materiais/${id}`;

        toggleEditMaterialModal(true);
    }

</script>
@endsection
