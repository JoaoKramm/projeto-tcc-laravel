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
                            <strong>Data de Nascimento:</strong> 
                                {{ \Carbon\Carbon::parse($inscricao->data_nascimento_crianca)->format('d/m/Y') }}<br>
                            
                            <strong>Modalidade:</strong>
                            @if($inscricao->quadroVaga)
                                {{ $inscricao->quadroVaga->modalidade->nome }}
                            @else
                                Aguardando
                            @endif
                            <br>

                            <strong>Status:</strong> {{ $inscricao->status }}<br>

                            @if ($inscricao->status === 'Deferido')
                                {{-- Se o status for Deferido, exibir a 1ª opção em verde com (Inscrito),
                                     e a 2ª em laranja com (Não relacionado) --}}
                                <strong>1ª Opção de Escola:</strong>
                                <span style="color: green; font-weight: bold;">
                                    {{ $inscricao->primeiraOpcaoEscola->nome }} (Inscrito)
                                </span>
                                <br>

                                <strong>2ª Opção de Escola:</strong>
                                <span style="color: black; font-weight: bold;">
                                    @if($inscricao->segundaOpcaoEscola)
                                        {{ $inscricao->segundaOpcaoEscola->nome }} (Não relacionado)
                                    @else
                                        Não selecionada
                                    @endif
                                </span>
                                <br>
                            @else
                                {{-- Caso contrário, exibir normalmente --}}
                                <strong>1ª Opção de Escola:</strong> 
                                {{ $inscricao->primeiraOpcaoEscola->nome }}<br>

                                <strong>2ª Opção de Escola:</strong> 
                                {{ $inscricao->segundaOpcaoEscola ? $inscricao->segundaOpcaoEscola->nome : 'Não selecionada' }}
                                <br>
                            @endif

                            @if ($inscricao->status == 'Fila de Espera')
                                <strong>Posição na Fila:</strong>
                                <span class="badge badge-secondary">A implementar</span><br>
                            @endif

                            <strong>Data da Inscrição:</strong> 
                                {{ $inscricao->created_at->format('d/m/Y H:i:s') }}
                            <br>
                            {{-- Observações removidas, conforme solicitado --}}
                        </p>
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
