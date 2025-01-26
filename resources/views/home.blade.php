<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Inscrições - Camaquã</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo-space">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" width="80"> 
                </div>
                <h1>Sistema de Inscrições de Camaquã</h1>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="login-container">
                <h2>Login</h2>
                <form action="{{ route('login') }}" method="POST"> 
                    @csrf 
                    <div class="form-group">
                        <label for="cpf">CPF:</label>
                        <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
                    </div>
                    <button type="submit" class="button">Entrar</button>
                    <div class="links">
                        <a href="{{ route('register') }}">Cadastre-se</a>
                        <a href="{{ route('password.request') }}">Esqueceu a senha?</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="info-blocks">
            <div class="container">
                <div class="info-block">
                    <h3>Notícias</h3>
                    <p>Fique por dentro das últimas notícias sobre o processo de inscrição.</p>
                </div>
                <div class="info-block">
                    <h3>Documentação</h3>
                    <p>Veja a lista de documentos necessários para a inscrição.</p>
                </div>
                <div class="info-block">
                    <h3>Contato</h3>
                    <p>Entre em contato conosco em caso de dúvidas.</p>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Prefeitura Municipal de Camaquã - RS. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>

    @if ($errors->any())
    <script>
        alert("{{ $errors->first() }}"); 
    </script>
    @endif
</body>
</html>