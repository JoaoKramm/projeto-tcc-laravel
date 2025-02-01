@extends('layout')

@section('content')
<h2>Vagas Disponíveis</h2>

<table class="table">
    <thead>
        <tr>
            <th>Escola</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($escolas as $escola)
        <tr>
            <td>
                <div class="escola-header" data-escola-id="{{ $escola->id }}">
                    {{ $escola->nome }}
                    <button class="btn btn-sm btn-secondary toggle-vagas">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="vagas-info" id="vagas-escola-{{ $escola->id }}" style="display: none;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Modalidade</th>
                                <th>Turno</th>
                                <th>Vagas Disponíveis</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($escola->quadroVagas as $quadroVaga)
                            <tr>
                                <td>{{ $quadroVaga->modalidade->nome }}</td>
                                <td>{{ $quadroVaga->turno }}</td>
                                <td>{{ $quadroVaga->vagas - $quadroVaga->vagas_ocupadas }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </td>
            <td>
            <a href="{{ route('inscricao.create', ['escola_id' => $escola->id, 'quadro_vaga_id' => $quadroVaga->id]) }}" class="btn btn-success btn-sm">Inscreva-se</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="text-center"> 
    <a href="{{ route('dashboard') }}" class="btn btn-primary">Voltar</a>
</div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const escolaHeaders = document.querySelectorAll('.escola-header');

        escolaHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const escolaId = this.getAttribute('data-escola-id');
                const vagasInfo = document.getElementById('vagas-escola-' + escolaId);
                const button = this.querySelector('.toggle-vagas');

                if (vagasInfo.style.display === 'none') {
                    vagasInfo.style.display = 'block';
                    button.querySelector('i').classList.remove('fa-chevron-down');
                    button.querySelector('i').classList.add('fa-chevron-up');
                } else {
                    vagasInfo.style.display = 'none';
                    button.querySelector('i').classList.remove('fa-chevron-up');
                    button.querySelector('i').classList.add('fa-chevron-down');
                }
            });
        });
    });
</script>