@extends('layout')

@section('content')
<div class="container">
    <h2>Formulário de Inscrição</h2>

    <form id="inscricao-form" method="POST" action="{{ route('inscricao.store') }}">
        @csrf

        <!-- 1) Armazena escola e quadro em inputs hidden -->
        <input type="hidden" name="escola_id_1" value="{{ $escola->id }}">
        <input type="hidden" name="quadro_vaga_id" value="{{ $quadroVaga->id }}">

        <div id="etapa-1" class="etapa">
            <h3>Dados Pessoais</h3>

            <div class="form-group">
                <label for="nome_responsavel">Nome do Responsável:</label>
                <input type="text" name="nome_responsavel" id="nome_responsavel" class="form-control"
                       value="{{ $user->nome }}" readonly>
            </div>
            <div class="form-group">
                <label for="cpf_responsavel">CPF do Responsável:</label>
                <input type="text" name="cpf_responsavel" id="cpf_responsavel" class="form-control"
                       value="{{ $user->cpf }}" readonly>
            </div>
            <div class="form-group">
                <label for="nome_crianca">Nome da Criança:</label>
                <input type="text" name="nome_crianca" id="nome_crianca" class="form-control" required>
                <div class="invalid-feedback">Por favor, preencha o nome da criança.</div>
            </div>
            <div class="form-group">
                <label for="data_nascimento_crianca">Data de Nascimento da Criança:</label>
                <input type="date" name="data_nascimento_crianca" id="data_nascimento_crianca" class="form-control" required>
                <div class="invalid-feedback">Por favor, preencha a data de nascimento da criança.</div>
            </div>
            <div class="form-group">
                <!-- Esse campo "modalidade" só para exibição do JS, não vamos salvá-lo no store -->
                <label for="modalidade">Modalidade (calculada):</label>
                <input type="text" name="modalidade" id="modalidade" class="form-control" readonly>
            </div>
            <div class="form-group button-group">
                <button type="button" class="btn btn-primary" onclick="avancarEtapa(1)">Avançar</button>
            </div>
        </div>

        <div id="etapa-2" class="etapa" style="display: none;">
            <h3>Endereço</h3>
            <div class="form-group">
                <label for="cep_responsavel">CEP:</label>
                <input type="text" name="cep_responsavel" id="cep_responsavel" class="form-control" required>
                <div class="invalid-feedback">Por favor, preencha o CEP.</div>
            </div>
            <div class="form-group">
                <label for="endereco_responsavel">Endereço:</label>
                <input type="text" name="endereco_responsavel" id="endereco_responsavel" class="form-control" required>
                <div class="invalid-feedback">Por favor, preencha o endereço.</div>
            </div>
            <div class="form-group">
                <label for="numero_casa_responsavel">Número:</label>
                <input type="text" name="numero_casa_responsavel" id="numero_casa_responsavel" class="form-control" required>
                <div class="invalid-feedback">Por favor, preencha o número.</div>
            </div>
            <div class="form-group">
                <label for="bairro_responsavel">Bairro:</label>
                <input type="text" name="bairro_responsavel" id="bairro_responsavel" class="form-control" required>
                <div class="invalid-feedback">Por favor, preencha o bairro.</div>
            </div>
            <div class="form-group button-group">
                <button type="button" class="btn btn-secondary" onclick="voltarEtapa(2)">Voltar</button>
                <button type="button" class="btn btn-primary" id="avancar-etapa-2" onclick="avancarEtapa(2)">Avançar</button>
            </div>
        </div>

        <div id="etapa-3" class="etapa" style="display: none;">
            <h3>Documentos</h3>
            <div class="form-group">
                <label for="certidao_nascimento" class="file-upload-label">
                    <span id="certidao_nascimento_file">Escolher Arquivo da Certidão de Nascimento</span>
                </label>
                <input type="file" name="certidao_nascimento" id="certidao_nascimento" class="form-control-file" required>
                <div class="invalid-feedback">Por favor, anexe a certidão de nascimento.</div>
            </div>
            <div class="form-group">
                <label for="comprovante_residencia" class="file-upload-label">
                    <span id="comprovante_residencia_file">Escolher Arquivo do Comprovante de Residência</span>
                </label>
                <input type="file" name="comprovante_residencia" id="comprovante_residencia" class="form-control-file" required>
                <div class="invalid-feedback">Por favor, anexe o comprovante de residência.</div>
            </div>
            <div class="form-group button-group">
                <button type="button" class="btn btn-secondary" onclick="voltarEtapa(3)">Voltar</button>
                <button type="button" class="btn btn-primary" onclick="avancarEtapa(3)">Avançar</button>
            </div>
        </div>

        <div id="etapa-4" class="etapa" style="display: none;">
            <h3>Definir Instituição</h3>

            <div class="form-group">
                <label for="escola_id_1">1ª Opção de Escola:</label>
                <select name="escola_id_1" id="escola_id_1" class="form-control" required>
                    <option value="">Selecione a escola</option>
                    @foreach ($escolas as $esc)
                        <option value="{{ $esc->id }}" {{ $esc->id == $escola->id ? 'selected' : '' }}>
                            {{ $esc->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="escola_id_2">2ª Opção de Escola (opcional):</label>
                <select name="escola_id_2" id="escola_id_2" class="form-control">
                    <option value="">Selecione uma escola (opcional)</option>
                    @foreach ($escolas as $esc)
                        <option value="{{ $esc->id }}">{{ $esc->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div id="aviso-primeira-opcao" style="display: none; font-weight: bold; color: green; margin-top: 10px;"></div>

            <div class="form-group button-group" style="margin-top: 15px;">
                <button type="button" class="btn btn-secondary" onclick="voltarEtapa(4)">Voltar</button>
                <button type="button" class="btn btn-success" id="avancar-etapa-4">Avançar</button>
            </div>
        </div>

        <div id="etapa-5" class="etapa" style="display: none;">
            <h3>Confirmação</h3>
            <p>Confirme os dados da inscrição:</p>
            <div id="confirmacao-dados"></div>
            <div class="form-group button-group">
                <button type="button" class="btn btn-secondary" onclick="voltarEtapa(5)">Voltar</button>
                <button type="submit" class="btn btn-success" id="enviar-inscricao">Enviar Solicitação</button>
            </div>
        </div>
    </form>

    <div class="button-group">
        <a href="{{ route('vagas') }}" class="btn btn-secondary">Voltar para Vagas</a>
    </div>
</div>

<script src="{{ asset('js/inscricao.js') }}"></script>
@endsection
