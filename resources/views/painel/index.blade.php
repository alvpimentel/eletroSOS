@extends('layout.app')

@section('title', 'Home')

@section('content')
    <div class="row">
        <h1>Bem-vindo</h1>
    </div>

    <div class="row mt-4">
        <!-- Card 1: OS para atendimento hoje -->
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $servicosPraHoje }}</h5>
                    <p class="card-text">OS para atendimento hoje</p>
                    <a href="#" class="btn btn-light btn-sm">Mais informações</a>
                </div>
            </div>
        </div>
        
        <!-- Card 2: OS Atrasadas -->
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $servicosAtrasados }}</h5>
                    <p class="card-text">OS Atrasadas</p>
                    <a href="#" class="btn btn-light btn-sm">Mais informações</a>
                </div>
            </div>
        </div>

        <!-- Card 3: OS em Aberto -->
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $servicosAbertos }}</h5>
                    <p class="card-text">OS em Aberto</p>
                    <a href="#" class="btn btn-light btn-sm">Mais informações</a>
                </div>
            </div>
        </div>

        <!-- Card 4: OS Fechadas -->
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $servicosFechados }}</h5>
                    <p class="card-text">OS Fechadas</p>
                    <a href="#" class="btn btn-light btn-sm">Mais informações</a>
                </div>
            </div>
        </div>
    </div>

<!-- Gráfico de Serviços por Dia -->
<div class="mt-4">
    <canvas id="servicosChart" width="20" height="5"></canvas> <!-- Tamanho reduzido -->
</div>

<script>
    const ctx = document.getElementById('servicosChart').getContext('2d');
    const servicosPorDia = @json($servicosPorDia); 
    const diasDoMes = Array.from({ length: servicosPorDia.length }, (_, i) => i + 1);

    const chart = new Chart(ctx, {
        type: 'bar', // Tipo de gráfico (pode ser 'bar' ou outro)
        data: {
            labels: diasDoMes, 
            datasets: [{
                label: 'Serviços por dia',
                data: servicosPorDia, 
                borderColor: '#007bff',
                backgroundColor: 'rgba(61, 58, 202, 0.2)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Dia do Mês' 
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Quantidade de Serviços'
                    },
                    ticks: {
                        stepSize: 1,
                        beginAtZero: true 
                    }
                }
            }
        }
    });
</script>
@endsection
