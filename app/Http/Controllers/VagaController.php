<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Escola;
use App\Models\Modalidade;
use App\Models\QuadroVaga;

class VagaController extends Controller
{
    /**
     * Lista todas as vagas para o painel administrativo.
     */
    public function index(Request $request)
    {
        $escolaId = $request->input('escola_id'); // vamos filtrar por escola depois
        // Carrega a relação 'modalidade'
        $query = QuadroVaga::with(['escola', 'modalidade']);
    
        // Se tiver ID de escola, filtra
        if ($escolaId) {
            $query->where('escola_id', $escolaId);
        }
    
        $vagas = $query->orderBy('id','desc')->get();
    
        // Precisamos também de todas as escolas para montar o select
        $escolas = Escola::orderBy('nome')->get();
    
        return view('admin.vagas.index', compact('vagas','escolas','escolaId'));
    }

    /**
     * Exibe o formulário de criação de vaga.
     */
    public function create()
    {
        // Carrega as escolas e as modalidades para selects.
        $escolas = Escola::orderBy('nome')->get();
        $modalidades = Modalidade::orderBy('nome')->get();

        // Exemplo de view: 'admin.vagas.create'
        return view('admin.vagas.create', compact('escolas', 'modalidades'));
    }

    /**
     * Salva uma nova vaga no banco de dados.
     */
    public function store(Request $request)
    {
        // Valida os campos
        $request->validate([
            'escola_id'      => 'required|exists:escolas,id',
            'modalidade_id'  => 'required|exists:modalidades,id',
            'turno'          => 'required|string|max:20',
            'vagas'          => 'required|integer|min:1',
        ]);

        // Cria a vaga
        QuadroVaga::create([
            'escola_id'      => $request->input('escola_id'),
            'modalidade_id'  => $request->input('modalidade_id'),
            'turno'          => $request->input('turno'),
            'vagas'          => $request->input('vagas'),
            'vagas_ocupadas' => 0,  // Você pode ajustar a lógica.
        ]);

        return redirect()->route('vagas.index')
                         ->with('success', 'Vaga criada com sucesso!');
    }

    /**
     * Exibe o formulário de edição de uma vaga existente.
     */
    public function edit($id)
    {
        $vaga = QuadroVaga::findOrFail($id);
        $escolas = Escola::orderBy('nome')->get();
        $modalidades = Modalidade::orderBy('nome')->get();
    
        return view('admin.vagas.edit', compact('vaga', 'escolas', 'modalidades'));
    }
    

    /**
     * Atualiza uma vaga no banco de dados.
     */
    public function update(Request $request, $id)
    {
        $vaga = QuadroVaga::findOrFail($id);

        // Valida os campos
        $request->validate([
            'escola_id'     => 'required|exists:escolas,id',
            'modalidade_id' => 'required|exists:modalidades,id',
            'turno'         => 'required|string|max:20',
            'vagas'         => 'required|integer|min:1',
        ]);

        $vaga->update([
            'escola_id'     => $request->input('escola_id'),
            'modalidade_id' => $request->input('modalidade_id'),
            'turno'         => $request->input('turno'),
            'vagas'         => $request->input('vagas'),
        ]);

        return redirect()->route('vagas.index')
                         ->with('success', 'Vaga atualizada com sucesso!');
    }

    /**
     * Remove uma vaga do banco de dados.
     */
    public function destroy($id)
    {
        $vaga = QuadroVaga::findOrFail($id);
        $vaga->delete();

        return redirect()->route('vagas.index')
                         ->with('success', 'Vaga excluída com sucesso!');
    }
}
