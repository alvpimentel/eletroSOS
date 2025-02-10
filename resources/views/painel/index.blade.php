@extends('layout.app')

@section('title', 'Home')

@section('content')
    <div class="row">
        <h1>Bem-vindo</h1>
    </div>

    <div class="row mt-4">
        <!-- Card 1: OS em Aberto -->
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $servicosAbertos }}</h5>
                    <p class="card-text">OS em Aberto</p>
                    <a href="#" class="btn btn-light btn-sm">Mais informações</a>
                </div>
            </div>
        </div>

        <!-- Card 2: OS para atendimento hoje -->
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $servicosPraHoje }}</h5>
                    <p class="card-text">OS para atendimento hoje</p>
                    <a href="#" class="btn btn-light btn-sm">Mais informações</a>
                </div>
            </div>
        </div>

        <!-- Card 3: OS Fechadas -->
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
@endsection
