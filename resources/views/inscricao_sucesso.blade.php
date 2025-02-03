@extends('layout')

@section('content')
@if (session('success'))
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Sucesso!</h4>
        <p>{{ session('success') }}</p>
        @if (session('nome_crianca') && session('escola'))
            <p>A inscrição de {{ session('nome_crianca') }} para a escola {{ session('escola') }} foi registrada.</p>
        @endif
        <hr>
        <p class="mb-0">Você receberá em seu WhatsApp e E-mail uma confirmação.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Voltar para o Início</a>
    </div>
@endif
@endsection