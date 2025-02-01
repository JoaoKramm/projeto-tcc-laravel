<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Escola;
use App\Models\Modalidade; // Importe a classe Modalidade aqui
use App\Models\QuadroVaga;

class VagasController extends Controller
{
    public function index()
    {
        $escolas = Escola::with('quadroVagas.modalidade')->get();

        return view('vagas', compact('escolas'));
    }
}