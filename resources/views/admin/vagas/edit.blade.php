@extends('layout')

@section('title', 'Editar Vaga')

@section('content')
<div class="container">
    <h2>Editar Quadro de Vaga número: #{{ $vaga->id }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('vagas.update', $vaga->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- ESCOLAS --}}
        <div class="form-group">
            <label>Escola:</label>
            <select name="escola_id" class="form-control" required>
                <option value="">Selecione a escola</option>
                @foreach($escolas as $esc)
                    <option value="{{ $esc->id }}" 
                        {{ $esc->id == $vaga->escola_id ? 'selected' : '' }}>
                        {{ $esc->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- MODALIDADES --}}
        <div class="form-group">
            <label>Modalidade:</label>
            <select name="modalidade_id" class="form-control" required>
                <option value="">Selecione a modalidade</option>
                @foreach($modalidades as $mod)
                    <option value="{{ $mod->id }}"
                        {{ $mod->id == $vaga->modalidade_id ? 'selected' : '' }}>
                        {{ $mod->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Turno:</label>
            <input type="text" name="turno" class="form-control" 
                   value="{{ $vaga->turno }}" required>
        </div>

        <div class="form-group">
            <label>Quantidade de Vagas:</label>
            <input type="number" name="vagas" class="form-control" min="1"
                   value="{{ $vaga->vagas }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="{{ route('vagas.index') }}" class="btn btn-secondary">Voltar</a>
    </form>
</div>
@endsection
