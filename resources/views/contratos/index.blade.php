<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato de Prestação de Serviços</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            line-height: 1.6;
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
    </style>
</head>
<body>
    <h1>CONTRATO DE PRESTAÇÃO DE SERVIÇOS</h1>
    
    <div class="contract-section">
        <label for="cliente">CONTRATANTE:</label>
        <p id="cliente">{{ $servico->cliente->nome }}</p>
        <label for="cnpj_cliente">CNPJ/CPF:</label>
        <p id="cnpj_cliente">{{ $servico->cliente->cnpj }}</p>
        <label for="endereco_cliente">Endereço:</label>
        <p id="endereco_cliente">{{ $servico->cliente->endereco }}</p>
    </div>

    <div class="contract-section">
        <label for="empresa">CONTRATADA:</label>
        <p id="empresa">{{ $servico->company->nome }}</p>
        <label for="cnpj_empresa">CNPJ:</label>
        <p id="cnpj_empresa">{{ $servico->company->cnpj }}</p>
        <label for="endereco_empresa">Endereço:</label>
        
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
        <p id="disposicoes">1. A CONTRATADA se compromete a executar o serviço com qualidade e dentro do prazo estabelecido.</p>
        <p id="disposicoes">2. A CONTRATANTE deve fornecer as condições necessárias para a realização do serviço.</p>
        <p id="disposicoes">3. O descumprimento de qualquer cláusula poderá resultar na rescisão do contrato.</p>
    </div>

    <div class="contract-section">
        <label for="local_data">Local e Data:</label>
        
    </div>

    <div class="signature">
        <p><strong>CONTRATANTE:</strong> {{ $servico->cliente->nome }}</p>
        <p>Assinatura: __________________________</p>
        
        <p>Assinatura: __________________________</p>
    </div>
</body>
</html>
