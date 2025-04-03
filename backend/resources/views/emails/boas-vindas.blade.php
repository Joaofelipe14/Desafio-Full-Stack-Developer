<!DOCTYPE html>
<html>
<head>
    <title>Bem-vindo!</title>
</head>
<body>
    <h1>Olá, {{ $cliente->name }}! 👋</h1>
    <p>Seja bem-vindo ao <strong>{{ config('app.name') }}</strong>!</p>
    
    <p>Detalhes do seu cadastro:</p>
    <ul>
        <li><strong>CPF:</strong> {{ $cliente->cpf }}</li>
        <li><strong>Data de Nascimento:</strong></li>
    </ul>

    <p>Estamos felizes em tê-lo como nosso cliente! 🚀</p>
</body>
</html>