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
Route::put('/profile/{user}', [App\Http\Controllers\ProfileController::class, 'update'])->middleware('auth')->name('profile.update');

// Rotas de autenticação
Auth::routes();

// Rotas de autenticação personalizadas
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

// Rota para a página de redefinição de senha (customizada)
Route::get('/password/reset', function () {
    return view('auth.passwords.reset');
})->name('password.request');