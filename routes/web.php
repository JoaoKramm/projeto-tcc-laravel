<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rota para a página inicial (home)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rota para o dashboard (após o login)
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

// Rota para sair
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Rota para perfil
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->middleware('auth')->name('profile');

// Rotas de autenticação
Auth::routes();

// Rota para a página de redefinição de senha (customizada)
Route::get('/password/reset', function () {
    return view('auth.passwords.reset');
})->name('password.request');