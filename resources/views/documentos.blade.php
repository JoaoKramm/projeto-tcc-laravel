@extends('layout')

@section('content')
<div class="container">
    <h2>Documentos Necessários</h2>

    
    <p>
        Veja mais informações aqui:
        <a href="https://educacaocamaqua.com.br/" target="_blank">Clique para acessar</a>
    </p>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Documentos para Inscrição</h3>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <h4 class="mb-1">Certidão de Nascimento da Criança</h4>
                    <p class="mb-0">A certidão de nascimento é um documento obrigatório para a inscrição. Ela deve ser uma cópia legível e atualizada.</p>
                </li>
                <li class="list-group-item">
                    <h4 class="mb-1">Comprovante de Residência</h4>
                    <p class="mb-0">
                        O comprovante de residência deve estar no nome de um dos responsáveis legais pela criança. Exemplos aceitos:
                    </p>
                    <ul class="mb-0">
                        <li>Conta de luz, água ou telefone recente (últimos 3 meses)</li>
                        <li>Contrato de aluguel com firma reconhecida</li>
                        <li>Declaração de residência emitida por um órgão oficial</li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Documentos para Matrícula (após a data ser definida)</h3>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <h4 class="mb-1">Documentos dos Responsáveis Legais</h4>
                    <p class="mb-0">Cópia do RG e CPF dos responsáveis legais pela criança.</p>
                </li>
                <li class="list-group-item">
                    <h4 class="mb-1">Cartão de Vacinação</h4>
                    <p class="mb-0">Cópia do cartão de vacinação atualizado da criança.</p>
                </li>
            </ul>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Voltar para o Dashboard</a>
    </div>
</div>
@endsection
