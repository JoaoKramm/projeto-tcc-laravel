<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Escola;
use App\Models\QuadroVaga;
use App\Models\Modalidade;
use Illuminate\Support\Facades\Auth;

class InscricaoController extends Controller
{
    public function create($escola_id, $quadro_vaga_id)
{
    // Busca a escola e a vaga selecionada (para o caso de pré-seleção)
    $escola = Escola::findOrFail($escola_id);
    $quadroVaga = QuadroVaga::findOrFail($quadro_vaga_id);

    // Obtém as escolas e modalidades para os selects do formulário
    $escolas = Escola::all();
    $modalidades = Modalidade::all(); //Adiciona essa linha para enviar as modalidades para a view

    $user = Auth::user();

    // Retorna a view de inscrição, passando as variáveis necessárias
    return view('inscricao', compact('escola', 'quadroVaga', 'escolas', 'modalidades', 'user'));
}

private function calcularIdade($dataNascimento, $dataLimite) {
    $idade = $dataLimite->diff($dataNascimento)->y;
    return $idade;
}

private function definirModalidade($idade, $dataNasc) {
    $dataAtual = new DateTime();
    $anoAtual = $dataAtual->format('Y');

    // Converte a data de nascimento para um objeto DateTime
    $dataNasc = new DateTime($dataNasc);

    // Calcula a idade correta com base no ano
    $idadeCalculada = $dataAtual->diff($dataNasc)->y;

    // Calcula a quantidade de meses desde o nascimento
    $meses = ($dataAtual->diff($dataNasc)->y * 12) + $dataAtual->diff($dataNasc)->m;

    // Valida se a idade está fora do intervalo permitido
    if ($idadeCalculada > 5 || $dataNasc > new DateTime("$anoAtual-03-31")) {
        return 'Fora do período de matrícula';
    }

    // Define a modalidade com base na idade e meses
    if ($meses >= 3 && $idadeCalculada < 2) {
        return 'Berçário';
    } elseif ($idadeCalculada >= 2 && $idadeCalculada < 3) {
        return 'Creche';
    } elseif ($idadeCalculada >= 3 && $idadeCalculada <= 4) { // Limite superior ajustado
        return 'Pré-escola';
    } else {
        return 'Idade insuficiente';
    }
}



    public function store(Request $request)
{
    // Aqui você vai validar e salvar os dados da inscrição
    // ...

    // Exemplo de retorno de sucesso
    return response()->json(['message' => 'Inscrição recebida com sucesso!'], 200);
}
}