@extends('layout')

@section('title', 'Cadastro de Usuário - Sistema de Inscrições de Camaquã')

@section('content')
<div class="container">
    <div class="register-container">
        <h2>Cadastro de Usuário</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" name="cpf" id="cpf" value="{{ old('cpf') }}" required placeholder="Digite seu CPF (somente números)">
                @error('cpf')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Nome Completo:</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Digite seu nome completo">
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="Digite seu e-mail">
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" name="password" id="password" required placeholder="Digite uma senha">
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirme a Senha:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Confirme a senha">
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
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required placeholder="Digite seu telefone (somente números)">
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

@if ($errors->any())
    <script>
        alert("{{ $errors->first() }}");
    </script>
@endif
@endsection
