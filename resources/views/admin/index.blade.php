@extends('layout.admin_app')

@section('title', 'Home')

@section('content')
    <div class="row">
        <h1>Bem-vindo (ADM)</h1>
    </div>

    <div class="row mt-4">
        <!-- Card 1: OS em Aberto -->
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $usuariosSemAdmin ?? '' }}</h5>
                    <p class="card-text">Usuários ativos</p>
                    <a href="#" class="btn btn-light btn-sm">Mais informações</a>
                </div>
            </div>
        </div>

        <!-- Card 2: OS para atendimento hoje -->
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <p class="card-text"></p>
                    <a href="#" class="btn btn-light btn-sm">Mais informações</a>
                </div>
            </div>
        </div>

        <!-- Card 3: OS Fechadas -->
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">53</h5>
                    <p class="card-text"></p>
                    <a href="#" class="btn btn-light btn-sm">Mais informações</a>
                </div>
            </div>
        </div>
    </div>
@endsection
