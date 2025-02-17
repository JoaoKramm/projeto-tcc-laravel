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

// Rota do painel admin, que você já tem
Route::get('/admin/dashboard', function () {
    if (auth()->check() && auth()->user()->tipo === 'admin') {
        return view('dashadmin');
    }
    return redirect('/dashboard')->with('error', 'Você não tem acesso de administrador.');
})->name('admin.dashboard');




// ROTAS PARA CRUD DE VAGAS
// 1) Listar
Route::get('/admin/vagas', function() {
    // Checa se é admin
    if (auth()->check() && auth()->user()->tipo === 'admin') {
        return app()->call('\App\Http\Controllers\VagaController@index');
    }
    return redirect('/home')->with('error', 'Você não tem acesso de administrador.');
})->name('vagas.index');

// 2) Form de criar
Route::get('/admin/vagas/create', function() {
    if (auth()->check() && auth()->user()->tipo === 'admin') {
        return app()->call('\App\Http\Controllers\VagaController@create');
    }
    return redirect('/home')->with('error', 'Acesso negado.');
})->name('vagas.create');

// 3) Salvar (store)
Route::post('/admin/vagas', function() {
    if (auth()->check() && auth()->user()->tipo === 'admin') {
        return app()->call('\App\Http\Controllers\VagaController@store');
    }
    return redirect('/home')->with('error', 'Acesso negado.');
})->name('vagas.store');

// 4) Form de editar
Route::get('/admin/vagas/{id}/edit', function($id) {
    if (auth()->check() && auth()->user()->tipo === 'admin') {
        return app()->call('\App\Http\Controllers\VagaController@edit', ['id' => $id]);
    }
    return redirect('/home')->with('error', 'Acesso negado.');
})->name('vagas.edit');

// 5) Atualizar (update)
Route::put('/admin/vagas/{id}', function($id) {
    if (auth()->check() && auth()->user()->tipo === 'admin') {
        return app()->call('\App\Http\Controllers\VagaController@update', ['id' => $id]);
    }
    return redirect('/home')->with('error', 'Acesso negado.');
})->name('vagas.update');

// 6) Excluir (destroy)
Route::delete('/admin/vagas/{id}', function($id) {
    if (auth()->check() && auth()->user()->tipo === 'admin') {
        return app()->call('\App\Http\Controllers\VagaController@destroy', ['id' => $id]);
    }
    return redirect('/dashboard')->with('error', 'Acesso negado.');
})->name('vagas.destroy');


/*
|--------------------------------------------------------------------------
| Rotas para Redefinição de Senha
|--------------------------------------------------------------------------
*/
Route::get('/password/reset', function () {
    return view('auth.passwords.reset');
})->name('password.request');
