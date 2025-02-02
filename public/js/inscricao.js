// Funções fora do $(document).ready para ficarem no escopo global
function avancarEtapa(etapaAtual) {
    $('#etapa-' + etapaAtual).hide();
    $('#etapa-' + (etapaAtual + 1)).show();
}

function voltarEtapa(etapaAtual) {
    $('#etapa-' + etapaAtual).hide();
    $('#etapa-' + (etapaAtual - 1)).show();
}

function calcularIdade(dataNascimento, dataLimite) {
    let idade = dataLimite.getFullYear() - dataNascimento.getFullYear();
    const meses = dataLimite.getMonth() - dataNascimento.getMonth();
    const dias = dataLimite.getDate() - dataNascimento.getDate();

    if (meses < 0 || (meses === 0 && dias < 0)) {
        idade--;
    }

    return idade;
}

function definirModalidade(idade, dataNasc, dataLimite) {
    const meses = (dataLimite.getFullYear() - dataNasc.getFullYear()) * 12 + (dataLimite.getMonth() - dataNasc.getMonth());

    if (idade > 5) {
        return "Fora do período de matrícula";
    }

    if (dataNasc > dataLimite) {
        return "Fora do período de matrícula";
    }

    if (meses >= 3 && idade < 2) {
        return "Berçário";
    } else if (idade >= 2 && idade < 3) {
        return "Creche";
    } else if (idade >= 3 && idade <= 4) {
        return "Pré-escola";
    } else {
        return "Idade insuficiente";
    }
}

function enviarInscricao() {
    // Aqui você pode adicionar a lógica para enviar os dados do formulário via AJAX
    alert('Inscrição enviada com sucesso!');
}

// Função para limpar os campos de endereço
function limparEndereco() {
    $('#endereco_responsavel').val('');
    $('#bairro_responsavel').val('');
}

// Função para preencher os campos de endereço
function preencherEndereco(data) {
    $('#endereco_responsavel').val(data.logradouro);
    $('#bairro_responsavel').val(data.bairro);
    // $('#cidade_responsavel').val(data.localidade); // Se você tiver um campo para cidade
    // $('#uf_responsavel').val(data.uf); // Se você tiver um campo para UF
    $('#numero_casa_responsavel').focus(); // Move o foco para o campo de número
}

$(document).ready(function() {
    const dataNascimentoInput = $('#data_nascimento_crianca');
    const modalidadeInput = $('#modalidade');
    const fileInputs = $('.form-control-file');

    // Atualiza o nome do arquivo selecionado no label
    fileInputs.on('change', function() {
        const fileName = $(this).prop('files')[0].name;
        const label = $(this).prev('label');
        label.find('span').text(fileName);
    });

    dataNascimentoInput.on('change', function() {
        const dataNascimento = new Date($(this).val());

        if (isNaN(dataNascimento)) {
            modalidadeInput.val("Data inválida");
            return;
        }

        const anoMatricula = new Date().getFullYear();
        const dataLimite = new Date(anoMatricula, 2, 31); // 31 de março do ano atual

        const idade = calcularIdade(dataNascimento, dataLimite);
        const modalidade = definirModalidade(idade, dataNascimento, dataLimite);

        modalidadeInput.val(modalidade);
    });

    // Listener para o botão "Avançar" da etapa 2
    $('#avancar-etapa-2').on('click', function() {
        avancarEtapa(2);
    });

    // Listener para os botões "Voltar"
    $('.btn-secondary').on('click', function(event) {
        // Verifica se o botão clicado está dentro de uma etapa
        if ($(this).closest('.etapa').length > 0) {
            // Obtém o número da etapa atual a partir do ID do botão
            var etapaAtual = parseInt($(this).closest('.etapa').attr('id').split('-')[1]);

            // Verifica se o botão clicado é o botão "Voltar para Vagas"
            if ($(this).attr('href') === "{{ route('vagas') }}") {
                return; // Não faz nada, deixa o comportamento padrão do link funcionar
            }

            event.preventDefault();
            voltarEtapa(etapaAtual);
        }
    });

    // Evento de blur (quando o campo perde o foco) do campo CEP
    $('#cep_responsavel').on('blur', function() {
        const cep = $(this).val().replace(/\D/g, ''); // Remove caracteres não numéricos

        if (cep.length === 8) {
            // Desabilita o botão "Avançar" e "Voltar" da etapa 2
            $('#avancar-etapa-2').prop('disabled', true);
            $('.btn-secondary').prop('disabled', true);


            // Mostra um indicador de carregamento (opcional)
            // $('#loading').show();

            $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function(data) {
                if (!data.erro) {
                    preencherEndereco(data);
                } else {
                    limparEndereco();
                    alert('CEP não encontrado.');
                }
            })
            .fail(function() {
                limparEndereco();
                alert('Erro ao buscar o CEP. Por favor, verifique sua conexão.');
            })
            .always(function() {
                // Reabilita o botão "Avançar" e "Voltar" da etapa 2
                $('#avancar-etapa-2').prop('disabled', false);
                $('.btn-secondary').prop('disabled', false);

                // $('#loading').hide(); // Esconde o indicador de carregamento (opcional)
            });
        } else {
            limparEndereco();
            alert('Formato de CEP inválido.');
        }
    });
});