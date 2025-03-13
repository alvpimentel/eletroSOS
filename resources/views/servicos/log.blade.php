@extends('layout.app')

@section('title', 'Logs Cadastrados')

@section('content')
    <h1>Histórico do Serviço</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($servicosLog->isEmpty())
        <p>Nenhum log encontrado.</p>
    @else
    <div class="list-group mt-4">
        @foreach ($servicosLog as $log)
            <div class="list-group-item logContainer">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">{{ $log->tx_alteracoes }}</h5>
                        <small class="text-muted">
                            <i class="bi bi-clock"></i> {{ formatarDataHora($log->created_at) }}
                        </small>
                    </div>
                    <div class="d-flex flex-row gap-2">
                        <div class="d-flex flex-column">
                            <small class="text-muted">
                                <i class="bi bi-person"></i> {{ $log->user->name ?? 'Usuário não informado' }}
                            </small>
                            <small class="text-muted">
                                <i class="bi bi-globe"></i> {{ $log->tx_ip ?? 'IP não informado' }}
                            </small>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#logDetailsModal" data-json="{{ $log->json_detalhes }}">
                            <i class="bi bi-eye"></i> Detalhes
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @endif

    <!-- Modal -->
    <div class="modal fade" id="logDetailsModal" tabindex="-1" aria-labelledby="logDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Aumentei o tamanho do modal para melhor visualização -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logDetailsModalLabel">Detalhes do Log</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <pre id="logDetailsText" class="bg-light p-3 rounded"></pre> <!-- Adicionei estilos para o <pre> -->
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
                
                // Formata o JSON para exibição
                try {
                    const jsonObj = JSON.parse(jsonDetalhes);
                    modalBody.textContent = JSON.stringify(jsonObj, null, 2);
                } catch (error) {
                    modalBody.textContent = "Erro ao carregar os detalhes.";
                }
            });
        });
    </script>
@endsection