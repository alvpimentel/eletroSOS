@extends('layout.app')

@section('title', 'Gerencia')

@section('content')
    @if (!$logUsuario->isEmpty())
        <h3 class="mb-3 mt-3">LOG do usuário {{ $logUsuario->first()->user->name }}</h3> 
    @endif
    
    @if ($logUsuario->isEmpty())
        <p>Nenhum Log localizado.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Data LOG</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logUsuario as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->tx_acao }}</td>
                        <td>{{ formatarDataHora($log->created_at) }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#logDetailsModal" data-json="{{ json_encode($log->json_detalhes) }}">
                                <i class="bi bi-eye"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="d-flex flex-row gap-3 mt-3">
        <button type="button" onclick="goBack()" class="btn btn-secondary">Voltar</button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="logDetailsModal" tabindex="-1" aria-labelledby="logDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logDetailsModalLabel">Detalhes do Log</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <pre id="logDetailsText"></pre> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const logButtons = document.querySelectorAll('button[data-bs-toggle="modal"]');
        
        logButtons.forEach(button => {
            button.addEventListener('click', function () {
                const jsonDetalhes = this.getAttribute('data-json');
                const modalBody = document.getElementById('logDetailsText');
                modalBody.textContent = JSON.stringify(JSON.parse(jsonDetalhes), null, 2);
            });
        });
    </script>
@endsection
