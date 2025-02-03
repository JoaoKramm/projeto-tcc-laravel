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

function enviarInscricao() {
    // Coleta os dados do formulário
    var formData = new FormData(document.getElementById('inscricao-form'));

    $.ajax({
        url: "{{ route('inscricao.store') }}", // Substitua pela rota correta
        type: "POST",
        data: formData,
        processData: false,  // Impede que o jQuery processe os dados (necessário para FormData)
        contentType: false,  // Impede que o jQuery defina o Content-Type (necessário para FormData)
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Obtém o token CSRF do meta tag (se aplicável)
        },
        success: function(response) {
            // Ação em caso de sucesso
            alert("Inscrição enviada com sucesso!");
            console.log(response);
            // Exemplo: redirecionar para outra página
            // window.location.href = "/outra-pagina";
        },
        error: function(error) {
            // Ação em caso de erro
            let errorMessage = "Erro ao enviar inscrição. Verifique os dados e tente novamente.";
            
            // Se houver erros de validação no retorno
            if (error.responseJSON && error.responseJSON.errors) {
                errorMessage = "";
                for (let field in error.responseJSON.errors) {
                    errorMessage += error.responseJSON.errors[field][0] + "\n";
                }
            }
            
            alert(errorMessage);
            console.error(error);
        }
    });
}

function verificarVagas(escolaId1, escolaId2, modalidade) {
    console.log("CSRF Token:", "{{ csrf_token() }}");
    $.ajax({
        url: "/verificar-vagas", // A rota correta, sem usar Blade
        method: "POST",
        data: {
            escola_id_1: escolaId1,
            escola_id_2: escolaId2,
            modalidade: modalidade,
            _token: "{{ csrf_token() }}" // Continua sendo necessário
        },
        success: function(response) {
            exibirMensagemVagas(response.mensagem);
            if (response.vaga_disponivel) {
                avancarEtapa(4);
            }
        },
        error: function(error) {
            console.error(error);
            exibirMensagemVagas("Erro ao verificar as vagas. Tente novamente.");
        },
        complete: function() {
            $('#avancar-etapa-4').prop('disabled', false);
        }
    });
}


function exibirMensagemVagas(mensagem) {
    $('#vagas-mensagem').html(mensagem);
}

function exibirConfirmacao() {
    const dados = {
        'Nome do Responsável': $('#nome_responsavel').val(),
        'CPF do Responsável': $('#cpf_responsavel').val(),
        'Nome da Criança': $('#nome_crianca').val(),
        'Data de Nascimento da Criança': $('#data_nascimento_crianca').val(),
        'Modalidade': $('#modalidade').val(),
        'CEP': $('#cep_responsavel').val(),
        'Endereço': $('#endereco_responsavel').val(),
        'Número': $('#numero_casa_responsavel').val(),
        'Bairro': $('#bairro_responsavel').val(),
        '1ª Opção de Escola': $('#escola_id_1 option:selected').text(),
        '2ª Opção de Escola': $('#escola_id_2 option:selected').text() || 'Não selecionada',
        'Certidão de Nascimento': $('#certidao_nascimento')[0].files[0] ? $('#certidao_nascimento')[0].files[0].name : 'Nenhum arquivo selecionado',
        'Comprovante de Residência': $('#comprovante_residencia')[0].files[0] ? $('#comprovante_residencia')[0].files[0].name : 'Nenhum arquivo selecionado'
    };

    let html = '<ul class="list-group">';
    for (const chave in dados) {
        html += `<li class="list-group-item"><strong>${chave}:</strong> ${dados[chave]}</li>`;
    }
    html += '</ul>';

    $('#confirmacao-dados').html(html);
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

    // Listener para o botão "Avançar" da etapa 4
    $('#avancar-etapa-4').on('click', function() {
        const escolaId1 = $('#escola_id_1').val();
        const escolaId2 = $('#escola_id_2').val();
        const modalidade = $('#modalidade').val();

        // Verifica se a primeira opção de escola foi selecionada
        if (!escolaId1) {
            alert('Por favor, selecione a primeira opção de escola.');
            return;
        }

        // Verifica se a modalidade foi calculada
        if (!modalidade) {
            alert('Por favor, informe a data de nascimento da criança.');
            return;
        }

        verificarVagas(escolaId1, escolaId2, modalidade);
        exibirConfirmacao();
    });
});