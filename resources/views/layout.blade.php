<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Inscrições de Camaquã')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<header>
    <div class="container">
        <div class="header-content">
            <div class="logo-space">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" width="80">
            </div>
            <div> <h1>Sistema de Inscrições de Camaquã</h1></div>
            <div class="header-buttons">
                <a href="{{ route('profile') }}" class="profile-button">Perfil</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="profile-button">Sair</button>
                </form>
            </div>
        </div>
    </div>
</header>

<main>
    <div class="container">
        @yield('content')
    </div>
</main>

<footer>
    <div class="container">
        <p>&copy; {{ date('Y') }} Prefeitura Municipal de Camaquã - RS. Todos os direitos reservados.</p>
    </div>
</footer>
</body>
</html>