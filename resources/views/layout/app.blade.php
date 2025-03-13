<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EletroSOS')</title>
    
    <!-- CSS do Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- Ícones do Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    
    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* Menu Lateral */
        .sidebar {
            height: 100vh;
            background-color: #007bff;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 90px; 
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 15px 0;
            overflow: hidden;
            transition: width 0.3s ease; 
        }
        .sidebar:hover {
            width: 250px; 
        }
        .sidebar a, .logout-btn {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            white-space: nowrap; 
        }
        .sidebar a i, .logout-btn i {
            font-size: 1.5rem;
            margin-right: 10px;
        }
        .sidebar a span, .logout-btn span {
            opacity: 0;
            transition: opacity 0.3s ease; 
        }
        .sidebar:hover a span, .sidebar:hover .logout-btn span {
            opacity: 1; 
        }
        .logout-btn {
            background: none;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: left;
        }
        .logout-btn:hover, .sidebar a:hover {
            background-color: #0056b3;
        }
        .content {
            margin-left: 80px; 
            padding: 20px;
            transition: margin-left 0.3s ease; 
        }
        .sidebar:hover ~ .content {
            margin-left: 250px; 
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90px;
            transition: height 0.3s ease; 
        }

        .logo {
            width: 90px; 
            height: auto;
            transition: width 0.3s ease;
        }

        .sidebar:hover .logo-container {
            height: 150px; /* Aumenta mais */
        }

        .sidebar:hover .logo {
            width: 140px; /* Fica ainda maior */
        }

        /* Modal */
        .custom-modal {
            display: none; 
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); 
            z-index: 1050;
            justify-content: center;
            align-items: center;
        }

        .custom-modal-content {
            background: white;
            width: 50%;
            margin: auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
            margin-top: 50px;
        }

        .modal-header .btn-close {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 1.5rem;
            line-height: 1;
            cursor: pointer;
        }

        table tbody tr {
            transition: transform 0.3s ease;
        }

        table tbody tr:hover {
            transform: scale(1.025); 
            cursor: pointer;
        }

        .list-group-item {
            border: 1px solid #ddd;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .list-group-item h5 {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .list-group-item small {
            font-size: 0.9rem;
            color: #666;
        }

        .logContainer {
            transition: transform 0.3s ease-in-out; 
        }

        .logContainer:hover {
            transform: scale(1.02);
        }

    </style>
</head>
<body>
    <!-- Menu Lateral -->
    <div class="sidebar">
        <!-- Itens do Menu -->
        <div>
            <div class="logo-container">
                <img src="{{ asset('logoBranca.png') }}" alt="Logo Eletro OSS" class="logo">
            </div>
            <a href="/painel">
                <i class="bi bi-speedometer2"></i><span>Painel</span>
            </a>
            <a href="/clientes">
                <i class="bi bi-people"></i><span>Clientes</span>
            </a>
            <a href="/servicos">
                <i class="bi bi-tools"></i><span>Serviços</span>
            </a>
            <a href="/materiais">
                <i class="bi bi-box-seam"></i><span>Estoque</span>
            </a>
            <a href="/relatorios">
                <i class="bi bi-bar-chart"></i><span>Relatórios</span>
            </a>
            <a href="/perfil">
                <i class="bi bi-person"></i><span>Perfil</span>
            </a>
            @can('acesso-gerente')
                <a href="{{ route('gerente.index') }}">
                    <i class="bi bi-house-lock"></i><span>Gerência</span>
                </a>
            @endcan
        </div>

        <!-- Botão de Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-left"></i><span>Sair</span>
            </button>
        </form>
    </div>

    <!-- Conteúdo Principal -->
    <div class="content">
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <span id="routeName" class="navbar-brand mb-0 h1">
                        <span id="clock"></span>
                        @if(isset($usuario))
                            | {{ $usuario->company->nome }} | {{ $usuario->name }}
                        @endif
                    </span>
                </div>
            </nav>
        </header>

        <main class="mt-4">
            @yield('content')
        </main>
    </div>
</body>
@yield('scripts')
<!-- JavaScript do Bootstrap (certifique-se de carregar o bootstrap.bundle.min.js para o funcionamento do Modal) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Se você estiver usando jQuery, é melhor carregar após o Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        function updateClock() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');

            const clockElement = document.getElementById("clock");
            if (clockElement) {
                clockElement.textContent = `${hours}:${minutes}:${seconds}`;
            }
        }

        setInterval(updateClock, 1000);
        updateClock();

        function goBack() {
            if (document.referrer) {
                history.back();
            } else {
                window.location.href = '/login'; 
            }
        }

        function aplicarMascaraTelefone(input) {
            let telefone = input.value.replace(/\D/g, '');
            telefone = telefone.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
            input.value = telefone;
        }

        const telefoneInput = document.getElementById('telefone');
        if (telefoneInput) {
            telefoneInput.addEventListener('input', function () {
                aplicarMascaraTelefone(telefoneInput);
            });
        }

        function filterTable() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const table = document.querySelector('table tbody');
            const rows = table.querySelectorAll('tr');

            rows.forEach(row => {
                const materialName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                row.style.display = materialName.includes(searchInput) ? '' : 'none';
            });
        }
    });

    function formatarMoeda(input) {
        let valor = input.value.replace(/\D/g, ""); 
        valor = (parseFloat(valor) / 100).toFixed(2); 
        input.value = valor.replace(".", ","); 
    }

    document.addEventListener("DOMContentLoaded", function() {
            // Função para resetar os inputs dos modais ao fechá-los
            function clearModalInputs() {
                const modals = document.querySelectorAll('.modal'); // Seleciona todos os modais
                
                modals.forEach(modal => {
                    modal.addEventListener('hidden.bs.modal', function () {
                        const inputs = modal.querySelectorAll('input');
                        inputs.forEach(input => {
                            input.value = '';
                        });

                        const errorDiv = modal.querySelector('.alert-danger');
                        if (errorDiv) {
                            errorDiv.remove();
                        }
                    });
                });
            }

            clearModalInputs();
        });

        // Expandir logo
        document.addEventListener("DOMContentLoaded", function() {
        const sidebar = document.querySelector(".sidebar");
        const logo = document.querySelector(".logo");

            sidebar.addEventListener("mouseenter", function() {
                logo.style.width = "110px";

                setTimeout(() => {
                    if (sidebar.matches(":hover")) { 
                        logo.style.width = "150px";
                    }
                }, 10);
            });

            sidebar.addEventListener("mouseleave", function() {
                logo.style.width = "90px";
            });
        });
</script>
</html>
