<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request; // Importe a classe Request

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/dashboard'; // Redireciona para o dashboard após o registro

    public function __construct()
    {
        //$this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'cpf' => ['required', 'string', 'size:11', 'unique:users', function ($attribute, $value, $fail) {
                // Validação de CPF
                $value = preg_replace('/[^0-9]/', '', $value);

                if (!preg_match('/^(\d)\1+$/', $value) && $this->validaCPF($value)) {
                   return true;
                } else {
                    $fail('O CPF informado é inválido.');
                }
            }],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'birth_date' => ['required', 'date'],
            'phone' => ['required', 'string', 'min:10', 'max:15', function ($attribute, $value, $fail) {
                // Validação de telefone
                $value = preg_replace('/[^0-9]/', '', $value);

                if (strlen($value) >= 10 && strlen($value) <= 15) {
                    return true;
                } else {
                     $fail('O telefone informado é inválido.');
                }
            }],
        ]);
    }

    protected function create(array $data)
    {
        // Remover caracteres especiais do CPF
        $cpf = preg_replace('/[^0-9]/', '', $data['cpf']);

        // Remover caracteres especiais do telefone
        $phone = preg_replace('/[^0-9]/', '', $data['phone']);

        return User::create([
            'cpf' => $cpf, // Salva o CPF sem caracteres especiais
            'nome' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'data_nascimento' => $data['birth_date'],
            'celular' => $phone, // Salva o telefone sem caracteres especiais
        ]);
    }

        /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        return redirect($this->redirectTo);
    }

    // Função para validar CPF
    private function validaCPF($cpf) {

        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
            
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;

    }
}