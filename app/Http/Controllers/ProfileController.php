<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user(); // Obtém o usuário autenticado
        return view('profile', compact('user')); // Retorna a view 'profile.blade.php'
    }
}