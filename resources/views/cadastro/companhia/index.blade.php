<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Companhia</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            background-color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .card-body {
            background-color: white;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .form-label {
            font-weight: 600;
        }

        .alert-danger {
            font-size: 14px;
        }

        #qr-section {
            display: none; /* Oculto até que os campos sejam preenchidos */
            text-align: center;
            margin-top: 20px;
        }

        #qr-code {
            width: 200px;
            height: 200px;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h4 style="color: #000">Criar Companhia</h4>
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
                        
                        <form id="company-form" method="POST" action="{{ route('companies.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome da Companhia</label>
                                <input required type="text" name="nome" id="nome" class="form-control" value="{{ old('nome') }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Descrição</label>
                                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="cnpj" class="form-label">CNPJ</label>
                                <input required type="text" name="cnpj" id="cnpj" class="form-control" value="{{ old('cnpj') }}">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Telefone</label>
                                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Endereço</label>
                                <textarea name="address" id="address" class="form-control" rows="2">{{ old('address') }}"></textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" style="background-color: #007bff; color: #fff" class="btn">Salvar</button>
                            </div>
                        </form>

                        <!-- Área do QR Code PIX -->
                        <div id="qr-section">
                            <h5>Escaneie o QR Code para pagar</h5>
                            <img id="qr-code" src="{{ asset('img/qrcode-pix.png') }}" alt="QR Code PIX">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function checkFields() {
                let allFilled = true;
                $('#company-form input[required]').each(function() {
                    if ($(this).val().trim() === '') {
                        allFilled = false;
                    }
                });

                if (allFilled) {
                    $('#qr-section').fadeIn(); // Mostra o QR Code
                } else {
                    $('#qr-section').fadeOut(); // Esconde caso algo seja apagado
                }
            }

            $('#company-form input').on('input', checkFields);
        });
    </script>
</body>
</html>
