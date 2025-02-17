@extends('layout')

@section('title', 'Cadastrar Vaga')

@section('content')
<div class="container">
    <h2>Nova Vaga</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('vagas.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Escola:</label>
            <select name="escola_id" class="form-control" required>
                <option value="">Selecione a escola</option>
                @foreach($escolas as $esc)
                    <option value="{{ $esc->id }}">{{ $esc->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Modalidade:</label>
            <select name="modalidade_id" class="form-control" required>
                <option value="">Selecione a modalidade</option>
                @foreach($modalidades as $mod)
                    <option value="{{ $mod->id }}">{{ $mod->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Turno:</label>
            <select name="turno" class="form-control" required>
                <option value="">Selecione o turno</option>
                <option value="Integral">Integral</option>
                <option value="Manhã">Manhã</option>
                <option value="Tarde">Tarde</option>
            </select>
        </div>

        <div class="form-group">
            <label>Quantidade de Vagas:</label>
            <input type="number" name="vagas" class="form-control" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{ route('vagas.index') }}" class="btn btn-secondary">Voltar</a>
    </form>
</div>
@endsection
