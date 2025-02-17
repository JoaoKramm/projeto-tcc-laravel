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
    /**
     * Exibe o formulário de inscrição.
     */
    public function create($escola_id, $quadro_vaga_id)
    {
        // Busca a escola e a vaga selecionada (para o caso de pré-seleção)
        $escola = Escola::findOrFail($escola_id);
        $quadroVaga = QuadroVaga::findOrFail($quadro_vaga_id);

        // Obtém as escolas e modalidades para os selects do formulário
        $escolas = Escola::all();
        $modalidades = Modalidade::all();

        $user = Auth::user();

        // Retorna a view de inscrição
        return view('inscricao', compact('escola', 'quadroVaga', 'escolas', 'modalidades', 'user'));
    }

    /**
     * Método auxiliar para calcular a idade com base em uma data limite.
     */
    private function calcularIdade($dataNascimento, $dataLimite)
    {
        return $dataLimite->diff($dataNascimento)->y;
    }

    /**
     * Método auxiliar para definir a modalidade de acordo com a idade e data de nascimento.
     */
    private function definirModalidade($idade, $dataNasc)
    {
        $dataAtual = new \DateTime();
        $anoAtual = $dataAtual->format('Y');

        // Converte a data de nascimento para objeto DateTime
        $dataNasc = new \DateTime($dataNasc);

        $idadeCalculada = $dataAtual->diff($dataNasc)->y;
        $meses = ($idadeCalculada * 12) + $dataAtual->diff($dataNasc)->m;

        // Verifica se a idade excede ou se a criança nasceu após a data limite
        if ($idadeCalculada > 5 || $dataNasc > new \DateTime("$anoAtual-03-31")) {
            return 'Fora do período de matrícula';
        }

        // Aplica a lógica de acordo com a idade e os meses
        if ($meses >= 3 && $idadeCalculada < 2) {
            return 'Berçário';
        } elseif ($idadeCalculada >= 2 && $idadeCalculada < 3) {
            return 'Creche';
        } elseif ($idadeCalculada >= 3 && $idadeCalculada <= 4) {
            return 'Pré-escola';
        } else {
            return 'Idade insuficiente';
        }
    }

    /**
     * Verifica a disponibilidade de vagas em duas escolas, baseado em uma modalidade.
     * (Se não for mais necessário, pode remover este método.)
     */
    public function verificarVagas(Request $request)
    {
        Log::info('Dados recebidos:', $request->all());
        $escolaId1 = $request->input('escola_id_1');
        $escolaId2 = $request->input('escola_id_2');
        $modalidade = $request->input('modalidade');

        $vagaDisponivel = false;
        $mensagem = '';

        // 1ª opção
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

        // 2ª opção
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

        // Caso nenhuma das duas opções tenha vaga
        if (!$vagaDisponivel) {
            $mensagem = "Não há vagas disponíveis nas escolas selecionadas. Deseja entrar na fila de espera?";
        }

        return response()->json([
            'vaga_disponivel' => $vagaDisponivel,
            'mensagem' => $mensagem
        ]);
    }

    /**
     * Armazena a inscrição no banco de dados.
     */
    public function store(Request $request)
    {
        // Ajuste na validação, removendo 'modalidade' e incluindo 'quadro_vaga_id'
        $validatedData = $request->validate([
            'nome_responsavel' => 'required|string|max:255',
            'cpf_responsavel'  => 'required|string|size:11',
            'nome_crianca'     => 'required|string|max:255',
            'data_nascimento_crianca' => 'required|date',
            'cep_responsavel'  => 'required|string|size:8',
            'endereco_responsavel' => 'required|string|max:255',
            'numero_casa_responsavel' => 'required|string|max:10',
            'bairro_responsavel' => 'required|string|max:255',
            'escola_id_1' => 'required|exists:escolas,id',
            'escola_id_2' => 'nullable|exists:escolas,id',
            'quadro_vaga_id' => 'required|exists:quadro_vagas,id'
        ]);

        // Cria a inscrição, atribuindo 'quadro_vaga_id'
        $inscricao = Inscricao::create([
            'user_id' => Auth::id(),
            'escola_id_1' => $request->input('escola_id_1'),
            'escola_id_2' => $request->input('escola_id_2'),
            'quadro_vaga_id' => $request->input('quadro_vaga_id'),
            'status' => 'Deferido', // Ajuste conforme sua lógica
            'data_inscricao' => now(),
            'nome_crianca' => $request->input('nome_crianca'),
            'data_nascimento_crianca' => $request->input('data_nascimento_crianca'),
            'nome_responsavel' => $request->input('nome_responsavel'),
            'cpf_responsavel' => $request->input('cpf_responsavel'),
            'cep_responsavel' => $request->input('cep_responsavel'),
            'endereco_responsavel' => $request->input('endereco_responsavel'),
            'numero_casa_responsavel' => $request->input('numero_casa_responsavel'),
            'bairro_responsavel' => $request->input('bairro_responsavel'),
            'certidao_nascimento_path' => 'certidao.pdf', // Exemplo
            'comprovante_residencia_path' => 'comprovante.pdf',
        ]);

        // Redireciona para a página de sucesso
        return redirect()->route('inscricao.sucesso')
            ->with('success', 'Sua solicitação de inscrição foi realizada com sucesso!')
            ->with('nome_crianca', $inscricao->nome_crianca)
            ->with('escola', $inscricao->primeiraOpcaoEscola->nome);
    }

    /**
     * Exibe as inscrições do usuário logado.
     */
    public function acompanhar()
    {
        $user = Auth::user();

        // Carrega as inscrições, incluindo modal e escola
        $inscricoes = Inscricao::where('user_id', $user->id)
            ->with(['primeiraOpcaoEscola', 'segundaOpcaoEscola', 'quadroVaga.modalidade'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('acompanhar_inscricoes', compact('inscricoes'));
    }
}
