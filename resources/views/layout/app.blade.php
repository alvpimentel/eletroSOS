<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EletroSOS')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
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
            <a href="/estoque">
                <i class="bi bi-box-seam"></i><span>Estoque</span>
            </a>
            <a href="/relatorios">
                <i class="bi bi-bar-chart"></i><span>Relatórios</span>
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
                        {{ Route::currentRouteName() ?? 'EletroSOS' }}
                    </span>
                </div>
            </nav>
        </header>

        <main class="mt-4">
            @yield('content')
        </main>
    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const routeNameElement = document.getElementById('routeName');
        if (routeNameElement && routeNameElement.textContent) {
            const routeName = routeNameElement.textContent.trim();
            routeNameElement.textContent = capitalizeFirstLetter(routeName);
        }

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
        }
    });

    function goBack() {
        if (document.referrer) {
            history.back();
        } else {
            window.location.href = '/login'; 
        }
    }

    function aplicarMascaraTelefone(input) {
            let telefone = input.value;

            telefone = telefone.replace(/\D/g, '');

            telefone = telefone.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');

            input.value = telefone;
        }

        const telefoneInput = document.getElementById('telefone');
        telefoneInput.addEventListener('input', function () {
            aplicarMascaraTelefone(telefoneInput);
        });
</script>

</html>
