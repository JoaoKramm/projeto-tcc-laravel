<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\ValidationException;

class LoginController extends BaseController
{
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard'; // Redireciona para o dashboard

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function middleware($middleware, $options = [])
    {
        return parent::middleware($middleware, $options);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
            //'senha' => [trans('auth.password')], // Pode remover também, não é mais necessário
            'password' => [trans('auth.password')], // Adiciona novamente, caso precise da mensagem de erro na senha
        ]);
    }

    public function username()
    {
        return 'cpf';
    }

// ... outras partes do LoginController

public function logout(Request $request)
{
    $this->guard()->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/');
}

}