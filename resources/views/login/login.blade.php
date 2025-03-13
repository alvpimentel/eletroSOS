<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #0056b3;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            border: 2px solid #007bff;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); 
        }

        .card-header {
            background-color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            text-align: center;
            padding: 20px;
        }

        .card-body {
            background-color: white;
            padding: 30px;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px;
            font-size: 16px;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .form-label {
            font-weight: 600;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ccc;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .alert-danger {
            font-size: 14px;
        }

        .logo {
            width: 120px; 
            height: auto;
            transition: width 0.3s ease;
        }

        .text-links a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }

        .text-links a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <img src="{{ asset('logoAzul.png') }}" alt="Logo Eletro OSS" class="logo">
                    <h4 style="color: #000">Login</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="exemplo@email.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Digite sua senha" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </div>

                        <div class="text-center mt-3 text-links">
                            <!--/cadastro/companhia-->
                            <a href="#">Não tem uma conta? Se cadastre aqui.</a> <br>
                            <a href="#">Esqueci minha senha.</a>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
