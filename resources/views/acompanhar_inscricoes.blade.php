@extends('layout')

@section('content')
<div class="container">
    <h2>Acompanhar Inscrições</h2>

    @if ($inscricoes->isEmpty())
        <p>Você não possui inscrições ativas no momento.</p>
    @else
        <div class="inscricoes-list">
            @foreach ($inscricoes as $inscricao)
                <div class="card inscricao-card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Inscrição #{{ $inscricao->id }}</h5>
                        <p class="card-text">
                            <strong>Nome da Criança:</strong> {{ $inscricao->nome_crianca }}<br>
                            <strong>Data de Nascimento:</strong> {{ \Carbon\Carbon::parse($inscricao->data_nascimento_crianca)->format('d/m/Y') }}<br>
                            <strong>Modalidade:</strong> {{ $inscricao->quadroVaga ? $inscricao->quadroVaga->modalidade->nome : 'Aguardando' }}<br>
                            <strong>Status:</strong> {{ $inscricao->status }}<br>
                            <strong>1ª Opção de Escola:</strong> {{ $inscricao->primeiraOpcaoEscola->nome }}<br>
                            <strong>2ª Opção de Escola:</strong> {{ $inscricao->segundaOpcaoEscola ? $inscricao->segundaOpcaoEscola->nome : 'Não selecionada' }}<br>
                            @if ($inscricao->status == 'Fila de Espera')
                                <strong>Posição na Fila:</strong>
                                <span class="badge badge-secondary">A implementar</span>
                            @endif
                            <strong>Data da Inscrição:</strong> {{ $inscricao->created_at->format('d/m/Y H:i:s') }}<br>
                            <strong>Observações:</strong> {{ $inscricao->observacoes ?? 'Nenhuma observação' }}
                        </p>
                        {{-- Adicione botões para editar, cancelar, etc., se necessário --}}
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-3">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Voltar para o menu inicial</a>
    </div>
</div>
@endsection