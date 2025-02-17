@extends('layout')

@section('title', 'Login - Sistema de Inscrições de Camaquã')

@section('content')
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

<script src="{{ asset('js/app.js') }}"></script>

@if ($errors->any())
    <script>
        alert("{{ $errors->first() }}"); 
    </script>
@endif
@endsection
