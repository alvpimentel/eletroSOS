<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato de Prestação de Serviços</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding-bottom: 20px;
            padding-top: 20px;
        }
        .contract-container {
            background: white;
            width: 80%;
            max-width: 800px;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-bottom: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 40px;
        }
        .contract-section {
            margin-bottom: 20px;
        }
        .contract-section label {
            font-weight: bold;
        }
        .contract-section p {
            margin: 5px 0;
        }
        .signature {
            margin-top: 40px;
            text-align: center;
        }
        .button-container {
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="contract-container">
        <h1>CONTRATO DE PRESTAÇÃO DE SERVIÇOS</h1>
        
        <div class="contract-section">
            <label for="cliente">CONTRATANTE:</label>
            <p id="cliente">{{ $servico->cliente->nome }}</p>
            <label for="cnpj_cliente">CNPJ/CPF:</label>
            <p id="cnpj_cliente">{{ $servico->cliente->cnpj ? $servico->cliente->cnpj : $servico->cliente->cpf }}</p>
            <label for="endereco_cliente">Endereço:</label>
            <p id="endereco_cliente">{{ $servico->cliente->endereco }}</p>
        </div>

        <div class="contract-section">
            <label for="empresa">CONTRATADA:</label>
            <p id="empresa">{{ $servico->company->nome }}</p>
            <label for="cnpj_empresa">CNPJ:</label>
            <p id="cnpj_empresa">{{ $servico->company->cnpj }}</p>
            <label for="endereco_empresa">Endereço:</label>
            <p id="endereco_empresa">{{ $servico->company->endereco }}</p>
        </div>

        <div class="contract-section">
            <label for="objeto_contrato">OBJETO DO CONTRATO:</label>
            <p id="objeto_contrato">{{ $servico->nome }}</p>
            <label for="descricao_servico">Descrição:</label>
            <p id="descricao_servico">{{ $servico->descricao }}</p>
        </div>

        <div class="contract-section">
            <label for="data_execucao">DATA DE EXECUÇÃO:</label>
            <p id="data_execucao">{{ \Carbon\Carbon::parse($servico->dt_chamado)->format('d/m/Y') }}</p>
        </div>

        <div class="contract-section">
            <label for="valor_pagamento">VALOR E FORMA DE PAGAMENTO:</label>
            <p id="valor_pagamento">R$ {{ number_format($servico->valor, 2, ',', '.') }}</p>
        </div>

        <div class="contract-section">
            <label for="disposicoes">DISPOSIÇÕES GERAIS:</label>
            <p>1. A CONTRATADA se compromete a executar o serviço com qualidade e dentro do prazo estabelecido.</p>
            <p>2. A CONTRATANTE deve fornecer as condições necessárias para a realização do serviço.</p>
            <p>3. O descumprimento de qualquer cláusula poderá resultar na rescisão do contrato.</p>
        </div>

<!--         <div class="contract-section">
            <label for="local_data">Local e Data:</label>
            <p id="local_data">________________, _____ de ______________ de _______</p>
        </div> -->

        <div class="signature">
            <p><strong>CONTRATANTE:</strong> {{ $servico->cliente->nome }}</p>
            <p>Assinatura: __________________________</p>
            <p><strong>CONTRATADA:</strong> {{ $servico->company->nome }}</p>
            <p>Assinatura: __________________________</p>
        </div>
    </div>

    <div class="button-container d-flex flex-row gap-2">
        <a href="{{ previousUrl() }}" class="btn btn-danger">Cancelar</a>
        <button type="button" class="btn btn-primary" onclick="gerarContrato()">Gerar Contrato</button>
    </div>
</body>
</html>
<script>
function gerarContrato() {
    // Pega o conteúdo HTML da div .contract-container
    let contratoHtml = document.querySelector('.contract-container').innerHTML;
    
    let dados = {
        company_id: "{{ $servico->company->id }}",
        user_id: "{{ auth()->user()->id }}",
        cliente_id: "{{ $servico->cliente->id }}",
        servico_id: "{{ $servico->id }}",
        tx_contrato: contratoHtml, 
        nr_versao: "1", 
    };

    console.log(dados);

    fetch("{{ route('contratos.store') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
        },
        body: JSON.stringify(dados),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = "{{ route('servicos.edit', ':id') }}".replace(':id', dados.servico_id);
        } else {
            alert("Ocorreu um erro ao gerar o contrato.");
        }
    })
    .catch(error => {
        console.error("Erro:", error);
        alert("Erro ao tentar gerar o contrato.");
    });
}
</script>
