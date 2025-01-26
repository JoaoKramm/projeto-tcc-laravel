<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Sistema de Inscrições de Camaquã</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header>
        <div class="container">
            <h1>Sistema de Inscrições de Camaquã</h1>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="register-container">
                <h2>Cadastro de Usuário</h2>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <label for="cpf">CPF:</label>
                        <input type="text" name="cpf" id="cpf" value="{{ old('cpf') }}" required>
                        @error('cpf')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Nome Completo:</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" name="password" id="password" required>
                        @error('password')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirme a Senha:</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required>
                    </div>

                    <div class="form-group">
                        <label for="birth_date">Data de Nascimento:</label>
                        <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" required>
                        @error('birth_date')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Telefone:</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required>
                        @error('phone')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group button-group">
                        <button type="submit" class="button">Cadastrar</button>
                        <button type="reset" class="button secondary">Limpar</button>
                         <a href="{{ route('home') }}" class="button secondary back-button">Voltar</a>
                    </div>
                </form>
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