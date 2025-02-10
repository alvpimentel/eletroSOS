<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EletroSOS')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Menu Lateral */
        .sidebar {
            height: 100vh;
            background-color: #007bff;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 80px; 
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px 0;
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

    </style>
</head>
<body>
    <!-- Menu Lateral -->
    <div class="sidebar">
        <!-- Itens do Menu -->
        <div>
            <h4 class="text-center mb-4">ES</h4> <!-- Sigla para o título -->
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
                            | {{ $usuario->name }}
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
        let valor = input.value.replace(/\D/g, ""); // Remove tudo que não for número
        valor = (parseFloat(valor) / 100).toFixed(2); // Divida por 100 se o valor for sem casas decimais
        input.value = valor.replace(".", ","); // Substitui o ponto por vírgula para exibição
    }

</script>
</html>
