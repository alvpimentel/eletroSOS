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

    <div class="mt-3 mb-5 gap-1">
        <p>Nome: {{ $companyInfo->nome }}</p>
        <small>CNPJ: {{ $companyInfo->cnpj }}</small>
        <!-- <p>Email: {{ $companyInfo->email }}</p> -->
    </div>

    <div class="d-flex flex-row gap-3 align-items-center">
        <div class="col-md-4 col-sm-6 mt-2 mb-3">
            <input type="text" name="search" class="form-control me-2" placeholder="Pesquisar por nome" oninput="filterTable()" id="searchInput">
        </div>

        <button class="btn btn-outline-success btn-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createUserModal">
            <i class="bi bi-plus"></i> Adicionar Usuário
        </button>
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
                            <a href="#" class="btn btn-warning btn-sm changePasswordBtn" 
                                data-id="{{ $users->id }}" 
                                data-name="{{ $users->name }}" 
                                data-bs-toggle="modal" 
                                data-bs-target="#changePasswordModal">
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

    <!-- MODAL PARA ALTERAR SENHA -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Alterar Senha de <span id="userName"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="userId" name="user_id">
                        <div class="mb-3">
                            <label for="password" class="form-label">Nova Senha</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <button type="submit" class="btn btn-success">Salvar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL UPLOAD LOGO -->
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

    <!-- MODAL PARA CRIAR USUÁRIO -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Criar Novo Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('gerente.criarUsuario') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Digite o nome" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="exemplo@email.com" required>
                        </div>

                        <div class="mb-3">
                            <label for="acesso_id" class="form-label">Tipo de Acesso</label>
                            <select name="acesso_id" id="acesso_id" class="form-control" required>
                                <option value="" disabled selected>Selecione o tipo de acesso</option>
                                <option value="1">Gerente</option>
                                <option value="2">Operador</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Digite a senha" required>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirme a senha" required>
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

        document.addEventListener("DOMContentLoaded", function() {
            const changePasswordButtons = document.querySelectorAll('.changePasswordBtn');
            
            changePasswordButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');
                    const userName = this.getAttribute('data-name');

                    console.log("User ID:", userId); 
                    console.log("User Name:", userName); 

                    document.getElementById('userId').value = userId;
                    document.getElementById('userName').textContent = userName;
                    
                    const form = document.getElementById('changePasswordForm');
                    form.action = `{{ route('gerente.senha.atualizar', ':id') }}`.replace(':id', userId);
                });
            });
        });

    </script>
@endsection
