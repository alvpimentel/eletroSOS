@extends('layout.app')

@section('title', 'Gerencia')

@section('content')
    <h3>Informações da Empresa</h3>

    <div class="d-flex justify-content-center">
        @if ($companyInfo->tx_logo)
        <div class="d-flex flex-column align-items-center">
            <img src="data:image/png;base64,{{ $companyInfo->tx_logo }}" alt="Logo da Empresa" class="img-fluid rounded-circle" style="max-width: 150px; max-height: 150px; object-fit: cover;">
            <button class="btn btn-secondary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="bi bi-pencil-square"></i> Editar Logo
            </button>
        </div>
        @else
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">Adicionar Logo</button>
        @endif
    </div>

    <div class="mt-3 mb-5 gap-2">
        <p>Nome: {{ $companyInfo->nome }}</p>
        <p>Email: {{ $companyInfo->email }}</p>
    </div>

    <div class="col-md-4 col-sm-6 mt-2 mb-3">
        <input type="text" name="search" class="form-control me-2" placeholder="Pesquisar por nome" oninput="filterTable()" id="searchInput">
    </div>

    @if ($usersCompany->isEmpty())
        <p>Nenhum Usuário localizado.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Data Criação</th>
                    <th>Status</th>
                    <th>Acesso</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usersCompany as $users)
                    <tr>
                        <td>{{ $users->id }}</td>
                        <td>{{ $users->name }}</td>
                        <td>{{ formatarData($users->created_at) }}</td>
                        <td>{{ $users->status ? 'Ativo' : 'Inativo' }}</td>
                        <td>{{ $users->acesso->nome }}</td>
                        <td>
                            <a href="{{ route('gerente.logUsuario', $users->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-clock-history"></i>
                            </a>
                            <a href="{{ route('gerente.logUsuario', $users->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-key"></i>
                            </a>
                            <a href="{{ route('gerente.logUsuario', $users->id) }}" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- MODAL -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload de Logo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('gerente.uploadLogo') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input type="file" name="logo" accept="image/*" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">Salvar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function filterTable() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('table tbody tr');
            
            rows.forEach(row => {
                const nameCell = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                if (nameCell.includes(searchInput)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
@endsection
