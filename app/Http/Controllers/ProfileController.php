<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Importe a classe User aqui

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function update(Request $request, User $user)
{
    // Validação dos dados
    $request->validate([
        'nome' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id], // Garante que o e-mail seja único, exceto para o próprio usuário
        'celular' => ['required', 'string', 'min:10', 'max:15', function ($attribute, $value, $fail) {
            // Validação de telefone
            $value = preg_replace('/[^0-9]/', '', $value);

            if (strlen($value) < 10 || strlen($value) > 15) {
                $fail('O telefone informado é inválido.');
            }
        }],
    ]);

    // Atualiza os dados do usuário
    $user->update([
        'nome' => $request->nome,
        'email' => $request->email,
        'celular' => preg_replace('/[^0-9]/', '', $request->celular), // Remove caracteres não numéricos do telefone
    ]);

    // Redireciona de volta para a página de perfil
    return redirect()->route('profile')->with('success', 'Perfil atualizado com sucesso!');
}
}