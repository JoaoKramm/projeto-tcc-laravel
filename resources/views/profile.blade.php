@extends('layouts.dashboard')

@section('content')
<div class="profile-container">
    <div class="container">
        <div class="profile-header">
            <div class="profile-image">
                @if($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Foto de Perfil">
                @else
                    <img src="{{ asset('images/user-placeholder.png') }}" alt="Foto de Perfil">
                @endif
            </div>
            <h2>Perfil do Usuário</h2>
        </div>

        <div class="profile-info">
            <form action="#" method="POST">
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
                    <button type="submit" class="button">Salvar</button>
                    
                </div>
            </form>
        </div>
    </div>
</div>
@endsection