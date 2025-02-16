@extends('layout')

@section('content')
<div class="main-blocks">
    <div class="block block-1">
        <h3>Vagas Disponíveis</h3>
        <p>Consulte as vagas disponíveis nas escolas e creches.</p>
        <a href="{{ route('vagas') }}" class="button">Ver Vagas</a>
    </div>
    <div class="block block-3">
        <h3>Acompanhar Inscrição</h3>
        <p>Verifique o status da sua inscrição.</p>
        <a href="{{ route('inscricao.acompanhar') }}" class="button">Acompanhar</a>
    </div>
    <div class="block block-4">
        <h3>Documentação</h3>
        <p>Veja a lista de documentos necessários para a matrícula.</p>
        <a href="{{ route('documentos') }}" class="button">Ver Documentos</a>
    </div>
    <div class="block block-5">
        <h3>Mapa das Escolas</h3>
        <p>Veja a localização das escolas no mapa da cidade.</p>
        <a href="#" class="button">Ver Mapa</a>
    </div>
</div>
@endsection