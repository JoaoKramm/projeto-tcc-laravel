<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VagasController;
use App\Http\Controllers\InscricaoController;

/*
|--------------------------------------------------------------------------
| Rotas Principais
|--------------------------------------------------------------------------
*/

// Página inicial
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rotas de autenticação (login, registro etc.)
Auth::routes();

/*
|--------------------------------------------------------------------------
| Rotas Protegidas por 'auth'
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Dashboard padrão para usuários
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Perfil de usuário
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
    Route::put('/profile/{user}', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // Vagas
    Route::get('/vagas', [VagasController::class, 'index'])->name('vagas');
    Route::post('/verificar-vagas', [InscricaoController::class, 'verificarVagas'])->name('verificar.vagas');

    // Inscrições
    Route::get('/inscricao/{escola_id}/{quadro_vaga_id}', [InscricaoController::class, 'create'])->name('inscricao.create');
    Route::post('/inscricao', [InscricaoController::class, 'store'])->name('inscricao.store');

    // Exibição de sucesso
    Route::get('/inscricao/sucesso', function () {
        return view('inscricao_sucesso');
    })->name('inscricao.sucesso');
});

// Rota que exibe a lista de inscrições do usuário logado
Route::get('/acompanhar-inscricoes', [InscricaoController::class, 'acompanhar'])
    ->name('inscricao.acompanhar');

    
    Route::middleware(['auth'])->group(function () {
        // ... (outras rotas)
    
        // Rota para exibir a documentação
        Route::get('/documentos', function () {
            return view('documentos'); // Nome do seu arquivo Blade
        })->name('documentos');
    });
    


/*
|--------------------------------------------------------------------------
| Rota Exclusiva para o Administrador
|--------------------------------------------------------------------------
*/
Route::get('/admin/dashboard', function () {
    // Verifica se o usuário está logado e é admin
    if (auth()->check() && auth()->user()->tipo === 'admin') {
        return view('dashadmin'); // Exibe a view do administrador
    }
    // Caso contrário, redireciona para o dashboard normal com mensagem de erro
    return redirect('/dashboard')->with('error', 'Você não tem acesso de administrador.');
})->name('admin.dashboard');

/*
|--------------------------------------------------------------------------
| Rotas para Redefinição de Senha
|--------------------------------------------------------------------------
*/
Route::get('/password/reset', function () {
    return view('auth.passwords.reset');
})->name('password.request');
