<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends BaseController
{
    use AuthenticatesUsers;

    /**
     * Construtor aplicando middlewares para logout e proteção de convidados.
     */
    public function __construct()
    {
        // Permite acesso apenas a convidados, exceto ao fazer logout
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Define que o campo de login será o CPF.
     */
    public function username()
    {
        return 'cpf';
    }

    /**
     * Sobrescreve o método de login para autenticar pelo CPF
     * e redirecionar manualmente com base em 'tipo'.
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Tenta autenticar com os dados fornecidos
        if (Auth::attempt($request->only('cpf', 'password'))) {
            // Se a autenticação foi bem-sucedida:
            $user = Auth::user();
            if ($user->tipo === 'admin') {
                return redirect('/admin/dashboard');
            }
            // Se não for admin, vai para /dashboard
            return redirect('/dashboard');
        }

        // Retorna mensagem de erro caso falhe na autenticação
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Personaliza mensagem de falha de login.
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'cpf' => [trans('auth.failed')],
            'password' => [trans('auth.password')],
        ]);
    }

    /**
     * Realiza logout, invalida sessão e token.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
