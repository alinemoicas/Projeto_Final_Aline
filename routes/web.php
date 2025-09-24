<?php

use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\AvaliacaoCriterioController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\CriterioController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TarefaController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\PesoController;
use App\Http\Controllers\ResultadoController;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Models\Role;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//Rotas do Modelo funcionario
Route::resource('funcionarios', FuncionarioController::class);


//Rotas do Modelo Cargo
Route::resource('cargo', CargoController::class);

//Rotas do Modelo Departamento
Route::resource('departamentos', DepartamentoController::class);

//Rotas da tarefa
Route::resource('tarefa', TarefaController::class);


 /*
    |--------------------------------------------------------------------------
    | Recursos de Avaliações e Componentes
    |--------------------------------------------------------------------------
    */

Route::prefix('avaliacoes')->name('avaliacoes.')->group(function () {
        Route::resource('/', AvaliacaoController::class)->parameters([
            '' => 'avaliacao'
        ]);
    });

    Route::prefix('criterios')->name('criterios.')->group(function () {
        Route::resource('/', CriterioController::class)->parameters([
            '' => 'criterio'
        ]);
    });

    Route::prefix('pesos')->name('pesos.')->group(function () {
        Route::resource('/', PesoController::class)->parameters([
            '' => 'peso'
        ]);
    });

    Route::prefix('avaliacao-criterios')->name('avaliacao_criterios.')->group(function () {
        Route::resource('/', AvaliacaoCriterioController::class)->parameters([
            '' => 'avaliacao_criterio'
        ]);
    });

    Route::prefix('resultados')->name('resultados.')->group(function () {
        Route::resource('/', ResultadoController::class)->parameters([
            '' => 'resultado'
        ]);
    });

require __DIR__.'/auth.php';
