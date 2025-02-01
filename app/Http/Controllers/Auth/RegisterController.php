<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/dashboard';

    protected function validator(array $data)
    {
        $data['cpf'] = preg_replace('/[^0-9]/', '', $data['cpf']); // Limpa CPF antes de validar
        $data['phone'] = preg_replace('/[^0-9]/', '', $data['phone']); // Limpa telefone antes de validar

        return Validator::make($data, [
            'cpf' => [
                'required', 
                'string', 
                'size:11', 
                'unique:users',
                function ($attribute, $value, $fail) {
                    if (!$this->validaCPF($value)) {
                        $fail('O CPF informado é inválido.');
                    }
                }
            ],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'birth_date' => ['required', 'date'],
            'phone' => [
                'required', 
                'string', 
                'min:10', 
                'max:15', 
                function ($attribute, $value, $fail) {
                    if (strlen($value) < 10 || strlen($value) > 15) {
                        $fail('O telefone informado é inválido.');
                    }
                }
            ],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'cpf' => preg_replace('/[^0-9]/', '', $data['cpf']),
            'nome' => $data['name'], 
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'data_nascimento' => $data['birth_date'],
            'celular' => preg_replace('/[^0-9]/', '', $data['phone']),
            'tipo' => 'responsavel',
        ]);
    }

    protected function registered(Request $request, $user)
    {
        return redirect($this->redirectTo);
    }

    private function validaCPF($cpf) {
        // Remove caracteres não numéricos
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Verifica se o CPF tem 11 dígitos e não é uma sequência repetida
        if (strlen($cpf) != 11 || preg_match('/^(\d)\1+$/', $cpf)) {
            return false;
        }

        // Cálculo dos dígitos verificadores
        for ($i = 9; $i < 11; $i++) {
            $soma = 0;
            for ($j = 0; $j < $i; $j++) {
                $soma += $cpf[$j] * (($i + 1) - $j);
            }

            $resto = $soma % 11;
            $dv = ($resto < 2) ? 0 : 11 - $resto;

            if ($cpf[$i] != $dv) {
                return false;
            }
        }
        return true;
    }
}
