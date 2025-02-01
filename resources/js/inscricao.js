
function avancarEtapa(etapaAtual) {
    document.getElementById('etapa-' + etapaAtual).style.display = 'none';
    document.getElementById('etapa-' + (etapaAtual + 1)).style.display = 'block';
}

function voltarEtapa(etapaAtual) {
    document.getElementById('etapa-' + etapaAtual).style.display = 'none';
    document.getElementById('etapa-' + (etapaAtual - 1)).style.display = 'block';
}

document.addEventListener('DOMContentLoaded', function () {
    const dataNascimentoInput = document.getElementById('data_nascimento_crianca');
    const modalidadeInput = document.getElementById('modalidade');
    const fileInputs = document.querySelectorAll('.form-control-file');

    // Atualiza o nome do arquivo selecionado no label
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const fileName = this.files[0].name;
            const label = this.previousElementSibling;
            label.querySelector('span').textContent = fileName;
        });
    });

    dataNascimentoInput.addEventListener('change', function () {
        const dataNascimento = new Date(this.value);

        if (isNaN(dataNascimento)) {
            modalidadeInput.value = "Data inválida";
            return;
        }

        const anoMatricula = new Date().getFullYear();
        const dataLimite = new Date(anoMatricula, 2, 31); // 31 de março do ano atual

        const idade = calcularIdade(dataNascimento, dataLimite);
        const modalidade = definirModalidade(idade, dataNascimento, dataLimite);

        modalidadeInput.value = modalidade;
    });
});

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