<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal - Sistema de Inscrições de Camaquã</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<header>
    <div class="container">
        <div class="header-content">
            <div class="logo-space">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" width="80">
            </div>
            <div> <h1>Sistema de Inscrições de Camaquã</h1></div>
            <a href="{{ route('profile') }}" class="profile-button">Perfil</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-button">Sair</button>
            </form>
        </div>
    </div>
</header>

    <main>
        <div class="container">
            <div class="main-blocks">
                <div class="block block-1">
                    <h3>Vagas Disponíveis</h3>
                    <p>Consulte as vagas disponíveis nas escolas e creches.</p>
                    <a href="#" class="button">Ver Vagas</a>
                </div>
                <div class="block block-2">
                    <h3>Realizar Inscrição</h3>
                    <p>Faça a inscrição do seu filho em uma vaga.</p>
                    <a href="#" class="button">Inscrever</a>
                </div>
                <div class="block block-3">
                    <h3>Acompanhar Inscrição</h3>
                    <p>Verifique o status da sua inscrição.</p>
                    <a href="#" class="button">Acompanhar</a>
                </div>
                <div class="block block-4">
                    <h3>Documentação</h3>
                    <p>Veja a lista de documentos necessários para a matrícula.</p>
                    <a href="#" class="button">Ver Documentos</a>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Prefeitura Municipal de Camaquã - RS. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>