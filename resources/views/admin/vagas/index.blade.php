@extends('layout')

@section('title', 'Gerenciar Vagas')

@section('content')
<div class="container">
    <h2>Gerenciar Vagas</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Formulário para escolher a escola --}}
    <form action="{{ route('vagas.index') }}" method="GET" class="mb-3">
        <div class="form-inline">
            <label for="escola_id" class="mr-2">Selecione a Escola:</label>
            <select name="escola_id" id="escola_id" class="form-control mr-2">
                <option value="">Todas</option>
                @foreach($escolas as $esc)
                    <option value="{{ $esc->id }}" 
                        {{ (isset($escolaId) && $escolaId == $esc->id) ? 'selected' : '' }}>
                        {{ $esc->nome }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
    </form>

    <a href="{{ route('vagas.create') }}" class="btn btn-success mb-3">Nova Vaga</a>

    @if($vagas->isEmpty())
        <p>Nenhuma vaga encontrada para esta escola.</p>
    @else
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Escola</th>
                <th>Modalidade</th>
                <th>Turno</th>
                <th>Vagas</th>
                <th>Ocupadas</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        @foreach($vagas as $vaga)
            <tr>
                <td>{{ $vaga->id }}</td>
                <td>{{ $vaga->escola ? $vaga->escola->nome : 'N/D' }}</td>
                <td>
                  {{-- Se usar modalName array no controller ou se tiver $vaga->modalidade->nome --}}
                  @if($vaga->modalidade)
                    {{ $vaga->modalidade->nome }}
                  @else
                    N/D
                  @endif
                </td>
                <td>{{ $vaga->turno }}</td>
                <td>{{ $vaga->vagas }}</td>
                <td>{{ $vaga->vagas_ocupadas }}</td>
                <td>
                    <a href="{{ route('vagas.edit', $vaga->id) }}" class="btn btn-sm btn-info">Editar</a>
                    <form action="{{ route('vagas.destroy', $vaga->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Tem certeza que deseja excluir?')">
                            Excluir
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
