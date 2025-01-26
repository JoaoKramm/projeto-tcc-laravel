<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - Sistema de Inscrições de Camaquã</title>
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
            <div class="forgot-password-container">
                <h2>Redefinir Senha</h2>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.request') }}">
                    @csrf

                    <div class="options">
                        <div class="option-block" onclick="selectOption('email')">
                            <input type="radio" name="option" id="option-email" value="email" checked>
                            <label for="option-email">
                                <h3>Redefinir com E-mail</h3>
                                <p>Enviaremos um link de redefinição para o seu e-mail cadastrado.</p>
                            </label>
                        </div>

                        <div class="option-block" onclick="selectOption('cpf')">
                            <input type="radio" name="option" id="option-cpf" value="cpf">
                            <label for="option-cpf">
                                <h3>Redefinir com CPF e Celular</h3>
                                <p>Verificaremos o seu CPF e número de celular cadastrados.</p>
                            </label>
                        </div>
                    </div>

                    <div class="form-group email-option">
                        <label for="email">E-mail:</label>
                        <input type="email" name="email" id="email" required>
                        @error('email')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group cpf-option" style="display: none;">
                        <label for="cpf">CPF:</label>
                        <input type="text" name="cpf" id="cpf">
                        @error('cpf')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group cpf-option" style="display: none;">
                        <label for="phone">Celular:</label>
                        <input type="text" name="phone" id="phone">
                        @error('phone')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="button-group">
                        <button type="submit" class="button">Enviar Link de Redefinição</button>
                        <a href="{{ route('home') }}" class="button secondary">Voltar</a>
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

    <script>
        function selectOption(option) {
            const emailOption = document.querySelector('.email-option');
            const cpfOption = document.querySelectorAll('.cpf-option');

            if (option === 'email') {
                emailOption.style.display = 'block';
                cpfOption.forEach(el => el.style.display = 'none');
                document.getElementById('email').required = true;
                document.getElementById('cpf').required = false;
                document.getElementById('phone').required = false;
            } else {
                emailOption.style.display = 'none';
                cpfOption.forEach(el => el.style.display = 'block');
                document.getElementById('email').required = false;
                document.getElementById('cpf').required = true;
                document.getElementById('phone').required = true;
            }
        }
    </script>
</body>
</html>