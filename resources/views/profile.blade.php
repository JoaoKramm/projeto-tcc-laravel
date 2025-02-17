@extends('layout')

@section('title', 'Perfil do Usuário - Sistema de Inscrições de Camaquã')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="profile-container">
        <div class="profile-header">
            <h2>Perfil do Usuário</h2>
        </div>

        <div class="profile-info">
            <form action="{{ route('profile.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" value="{{ $user->id }}">

                <div class="form-group">
                    <label for="cpf">CPF:</label>
                    <input type="text" id="cpf" name="cpf" value="{{ $user->cpf }}" readonly>
                </div>
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" value="{{ $user->nome }}" readonly>
                </div>
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" value="{{ $user->email }}" readonly>
                </div>
                <div class="form-group">
                    <label for="celular">Celular:</label>
                    <input type="text" id="celular" name="celular" value="{{ $user->celular }}" readonly>
                </div>
                <div class="form-group">
                    <label for="data_nascimento">Data de Nascimento:</label>
                    <input type="date" id="data_nascimento" name="data_nascimento" value="{{ $user->data_nascimento }}" readonly>
                </div>

                <div class="button-group">
                    <button type="button" class="button secondary">Editar</button>
                    <button type="submit" class="button" disabled>Salvar</button>
                    <a href="{{ Auth::user()->tipo === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="button">Voltar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const editButton = document.querySelector('.button.secondary:nth-child(1)');
    const saveButton = document.querySelector('.button:nth-child(2)');
    const formInputs = document.querySelectorAll('.form-group input');

    editButton.addEventListener('click', function() {
        formInputs.forEach(input => {
            input.removeAttribute('readonly');
        });
        saveButton.disabled = false;
        editButton.style.display = 'none';
    });
</script>
@endsection
