<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Escola;
use App\Models\QuadroVaga;
use App\Models\Modalidade;
use App\Models\Inscricao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class InscricaoController extends Controller
{
    public function create($escola_id, $quadro_vaga_id)
    {
        // Busca a escola e a vaga selecionada (para o caso de pré-seleção)
        $escola = Escola::findOrFail($escola_id);
        $quadroVaga = QuadroVaga::findOrFail($quadro_vaga_id);

        // Obtém as escolas e modalidades para os selects do formulário
        $escolas = Escola::all();
        $modalidades = Modalidade::all();

        $user = Auth::user();

        // Retorna a view de inscrição, passando as variáveis necessárias
        return view('inscricao', compact('escola', 'quadroVaga', 'escolas', 'modalidades', 'user'));
    }

    private function calcularIdade($dataNascimento, $dataLimite)
    {
        $idade = $dataLimite->diff($dataNascimento)->y;
        return $idade;
    }

    private function definirModalidade($idade, $dataNasc)
    {
        $dataAtual = new \DateTime();
        $anoAtual = $dataAtual->format('Y');

        // Converte a data de nascimento para um objeto DateTime
        $dataNasc = new \DateTime($dataNasc);

        // Calcula a idade correta com base no ano
        $idadeCalculada = $dataAtual->diff($dataNasc)->y;

        // Calcula a quantidade de meses desde o nascimento
        $meses = ($dataAtual->diff($dataNasc)->y * 12) + $dataAtual->diff($dataNasc)->m;

        // Valida se a idade está fora do intervalo permitido
        if ($idadeCalculada > 5 || $dataNasc > new \DateTime("$anoAtual-03-31")) {
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

    public function verificarVagas(Request $request)
    {
        \Log::info('Dados recebidos:', $request->all());
        $escolaId1 = $request->input('escola_id_1');
        $escolaId2 = $request->input('escola_id_2');
        $modalidade = $request->input('modalidade');

        $vagaDisponivel = false;
        $mensagem = '';

        // Verifica a primeira opção de escola
        $escola1 = Escola::find($escolaId1);
        if ($escola1) {
            $modalidadeObj = Modalidade::where('nome', $modalidade)->first();
            if ($modalidadeObj) {
                $quadroVaga = QuadroVaga::where('escola_id', $escola1->id)
                    ->where('modalidade_id', $modalidadeObj->id)
                    ->where('vagas', '>', \DB::raw('vagas_ocupadas'))
                    ->first();
                if ($quadroVaga) {
                    $vagaDisponivel = true;
                    $mensagem = "Vaga disponível na primeira opção de escola!";
                }
            } else {
                $mensagem = "Modalidade não encontrada para a primeira opção de escola.";
            }
        } else {
            $mensagem = "Primeira opção de escola não encontrada.";
        }

        // Verifica a segunda opção de escola, caso a primeira não tenha vagas e uma segunda opção tenha sido escolhida
        if (!$vagaDisponivel && $escolaId2) {
            $escola2 = Escola::find($escolaId2);
            if ($escola2) {
                $modalidadeObj = Modalidade::where('nome', $modalidade)->first();
                if ($modalidadeObj) {
                    $quadroVaga = QuadroVaga::where('escola_id', $escola2->id)
                        ->where('modalidade_id', $modalidadeObj->id)
                        ->where('vagas', '>', \DB::raw('vagas_ocupadas'))
                        ->first();
                    if ($quadroVaga) {
                        $vagaDisponivel = true;
                        $mensagem = "Vaga disponível na segunda opção de escola!";
                    }
                } else {
                    $mensagem = "Modalidade não encontrada para a segunda opção de escola.";
                }
            } else {
                $mensagem = "Segunda opção de escola não encontrada.";
            }
        }

        // Se não houver vaga em nenhuma das opções, prepara para adicionar à fila de espera
        if (!$vagaDisponivel) {
            $mensagem = "Não há vagas disponíveis nas escolas selecionadas. Deseja entrar na fila de espera?";
        }

        return response()->json([
            'vaga_disponivel' => $vagaDisponivel,
            'mensagem' => $mensagem
        ]);
    }

    public function store(Request $request)
    {
        // Validação dos dados
        $validatedData = $request->validate([
            'nome_responsavel' => 'required|string|max:255',
            'cpf_responsavel' => 'required|string|size:11',
            'nome_crianca' => 'required|string|max:255',
            'data_nascimento_crianca' => 'required|date',
            'modalidade' => 'required|string',
            'cep_responsavel' => 'required|string|size:8',
            'endereco_responsavel' => 'required|string|max:255',
            'numero_casa_responsavel' => 'required|string|max:10',
            'bairro_responsavel' => 'required|string|max:255',
            'escola_id_1' => 'required|exists:escolas,id',
            'escola_id_2' => 'nullable|exists:escolas,id',
            // Não precisa mais validar os arquivos
        ]);
    
        // Criar a inscrição no banco de dados
        $inscricao = Inscricao::create([
            'user_id' => Auth::id(),
            'escola_id_1' => $request->input('escola_id_1'),
            'escola_id_2' => $request->input('escola_id_2'),
            'status' => 'Fila de Espera', // Aqui você vai definir como 'Inscrito' se houver vaga disponível
            'data_inscricao' => now(),
            'nome_crianca' => $request->input('nome_crianca'),
            'data_nascimento_crianca' => $request->input('data_nascimento_crianca'),
            'nome_responsavel' => $request->input('nome_responsavel'),
            'cpf_responsavel' => $request->input('cpf_responsavel'),
            'cep_responsavel' => $request->input('cep_responsavel'),
            'endereco_responsavel' => $request->input('endereco_responsavel'),
            'numero_casa_responsavel' => $request->input('numero_casa_responsavel'),
            'bairro_responsavel' => $request->input('bairro_responsavel'),
            'certidao_nascimento_path' => 'certidao.pdf', // Valor fixo para o caminho do arquivo
            'comprovante_residencia_path' => 'comprovante.pdf', // Valor fixo para o caminho do arquivo
        ]);
    
        // Redireciona para a página de sucesso com uma mensagem
        return redirect()->route('inscricao.sucesso')
            ->with('success', 'Sua solicitação de inscrição foi realizada com sucesso!')
            ->with('nome_crianca', $inscricao->nome_crianca)
            ->with('escola', $inscricao->primeiraOpcaoEscola->nome);
    }
}