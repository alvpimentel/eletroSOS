<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento via Pix</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
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
        .qr-code {
            width: 100%;
            max-width: 250px;
            margin: 20px auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-center p-4">
                    <h4 class="mb-3">Escaneie o QR Code para pagar</h4>
                    <img src="data:image/png;base64,{{ $qr_code }}" alt="QR Code Pix" class="qr-code">
                    <p class="mt-3">Após o pagamento, clique no botão abaixo:</p>
                    <form action="{{ route('company.confirm') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Confirmar Pagamento</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
