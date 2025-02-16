@extends('layout')

@section('content')
<div class="container">
    <h2>Painel Administrativo</h2>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Gerenciar Escolas</h5>
                    <p class="card-text">Adicionar, editar e excluir escolas.</p>
                    <a href="#" class="btn btn-primary">Ir</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Cadastrar Vagas</h5>
                    <p class="card-text">Gerenciar o quadro de vagas das escolas.</p>
                    <a href="#" class="btn btn-primary">Ir</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Controle de Usuários</h5>
                    <p class="card-text">Gerenciar usuários do sistema.</p>
                    <a href="#" class="btn btn-primary">Ir</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Prioridade por Inscrição</h5>
                    <p class="card-text">Definir critérios de prioridade.</p>
                    <a href="#" class="btn btn-primary">Ir</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Relatórios</h5>
                    <p class="card-text">Gerar relatórios de inscrições.</p>
                    <a href="#" class="btn btn-primary">Ir</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Configurações</h5>
                    <p class="card-text">Ajustar configurações do sistema.</p>
                    <a href="#" class="btn btn-primary">Ir</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection