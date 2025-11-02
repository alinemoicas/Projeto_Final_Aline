<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    AvaliacaoController,
    AvaliacaoCriterioController,
    CargoController,
    CriterioController,
    FuncionarioController,
    ProfileController,
    TarefaController,
    DepartamentoController,
    GestorController,
    PesoController,
    ResultadoController
};

/*
|--------------------------------------------------------------------------
| ROTA PRINCIPAL (PÚBLICA)
|--------------------------------------------------------------------------
| Página inicial e acesso ao painel principal.
*/
Route::get('/', fn() => view('welcome'));

// Middleware de autenticação e verificação comentados
Route::get('/dashboard', fn() => view('dashboard'))
    //->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| ROTAS PROTEGIDAS POR AUTENTICAÇÃO
|--------------------------------------------------------------------------
| Todas as rotas abaixo exigem que o utilizador esteja autenticado.
| (Neste caso, middleware desativado)
*/
//Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PERFIL DO UTILIZADOR (PADRÃO LARAVEL)
    |--------------------------------------------------------------------------
    */
    Route::prefix('profile/funcionario')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | MÓDULO ADMIN / RH – RECURSOS PRINCIPAIS
    |--------------------------------------------------------------------------
    | Recursos base do sistema (CRUDs administrativos)
    */
    Route::resources([
        'funcionarios'        => FuncionarioController::class,
        'cargos'              => CargoController::class,
        'departamentos'       => DepartamentoController::class,
        'tarefas'             => TarefaController::class,
        'avaliacoes'          => AvaliacaoController::class,
        'criterios'           => CriterioController::class,
        'pesos'               => PesoController::class,
        'avaliacao-criterios' => AvaliacaoCriterioController::class,
        'resultados'          => ResultadoController::class,
    ]);

    /*
    |--------------------------------------------------------------------------
    | MÓDULO DE GESTORES
    |--------------------------------------------------------------------------
    | Inclui: gestão de gestores, perfil de gestor,
    | gestão de tarefas, avaliações e funcionários subordinados.
    */
    Route::/*middleware(['auth', 'role:admin,gestor'])*/
        prefix('gestores')
        ->name('gestores.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | ADMIN / RH – GESTÃO DE GESTORES
            |--------------------------------------------------------------------------
            */
            Route::get('/', [GestorController::class, 'showManageGestor'])->name('manage-gestor');
            Route::get('/create', [GestorController::class, 'showAddGestor'])->name('add-gestor');
            Route::post('/store', [GestorController::class, 'saveGestor'])->name('store');
            Route::get('gestor/{id}', [GestorController::class, 'showGestorDetails'])->name('gestor-details');
            Route::delete('/{id}/eliminar', [GestorController::class, 'deleteGestor'])->name('destroy');

            /*
            |--------------------------------------------------------------------------
            | PERFIL DO GESTOR AUTENTICADO
            |--------------------------------------------------------------------------
            */
            Route::prefix('perfil')->name('perfil.')->group(function () {
                Route::get('/', [GestorController::class, 'showGestorProfile'])->name('show');
                Route::get('/editar', [GestorController::class, 'editGestorProfile'])->name('edit');
                Route::patch('/actualizar', [GestorController::class, 'updateGestorProfile'])->name('update');
            });

            /*
            |--------------------------------------------------------------------------
            | GESTÃO DE TAREFAS PELO GESTOR
            |--------------------------------------------------------------------------
            */
            Route::prefix('tarefas')->name('tarefas.')->group(function () {
                Route::get('/nova', [TarefaController::class, 'showNewTask'])->name('new');
                Route::get('/atribuir/{id}', [TarefaController::class, 'showTaskAssignByManager'])->name('atribuir');
                Route::post('/atribuir/salvar', [TarefaController::class, 'AssignNewTaskToEmployee'])->name('atribuir.salvar');
                Route::get('/detalhes/{id}', [TarefaController::class, 'showTaskDetailsToManager'])->name('detalhes');
                Route::get('/pendentes', [TarefaController::class, 'showPendingTaskToManager'])->name('pendentes');
                Route::get('/pendentes/{id}', [TarefaController::class, 'showPendingTaskDetailsToManager'])->name('pendentes.detalhes');
                Route::get('/submetidas', [TarefaController::class, 'showSubmittedTaskToManager'])->name('submetidas');
                Route::get('/concluidas', [TarefaController::class, 'showCompletedTaskToManager'])->name('concluidas');
            });

            /*
            |--------------------------------------------------------------------------
            | AVALIAÇÕES / RATINGS DO GESTOR
            |--------------------------------------------------------------------------
            */
            Route::prefix('avaliacoes')->name('avaliacoes.')->group(function () {
                Route::get('/avaliar/{id}', [AvaliacaoController::class, 'showGiveRatingToManager'])->name('avaliar');
                Route::post('/submeter', [AvaliacaoController::class, 'submitRatingByManager'])->name('submeter');
            });

            /*
            |--------------------------------------------------------------------------
            | FUNCIONÁRIOS SOB GESTÃO DIRECTA DO GESTOR
            |--------------------------------------------------------------------------
            */
            Route::prefix('funcionarios')->name('funcionarios.')->group(function () {
                Route::get('/adicionar', [FuncionarioController::class, 'showAddEmployee'])->name('adicionar');
                Route::post('/salvar', [FuncionarioController::class, 'saveEmployee'])->name('salvar');
            });
        });

    /*
    |--------------------------------------------------------------------------
    | PERFIL DO FUNCIONÁRIO
    |--------------------------------------------------------------------------
    */
    Route::prefix('funcionarios/perfil')->name('funcionarios.perfil.')->group(function () {
        Route::get('/', [FuncionarioController::class, 'showEmployeeProfile'])->name('show');
        Route::get('/editar', [FuncionarioController::class, 'editEmployeeProfile'])->name('edit');
        Route::patch('/actualizar', [FuncionarioController::class, 'updateEmployeeProfile'])->name('update');
    });

    /*
    |--------------------------------------------------------------------------
    | TAREFAS GERAIS (ADMIN / GESTOR)
    |--------------------------------------------------------------------------
    */
    Route::prefix('tarefas')
        //->middleware(['auth', 'role:admin,gestor'])
        ->name('tarefas.')
        ->group(function () {
            Route::get('/', [TarefaController::class, 'index'])->name('index');
            Route::get('/create', [TarefaController::class, 'create'])->name('create');
            Route::post('/', [TarefaController::class, 'store'])->name('store');
            Route::get('/{id}', [TarefaController::class, 'show'])->name('show');
            Route::get('/{id}/editar', [TarefaController::class, 'edit'])->name('edit');
            Route::put('/{id}', [TarefaController::class, 'update'])->name('update');
            Route::delete('/{id}', [TarefaController::class, 'destroy'])->name('destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | RELATÓRIOS E RESULTADOS DE TAREFAS
    |--------------------------------------------------------------------------
    */
    Route::prefix('resultados')->name('resultados.')->group(function () {
        Route::get('/tarefa/{id}', [ResultadoController::class, 'showTaskReport'])->name('tarefa');
        Route::get('/tarefa/{id}/reportar', [ResultadoController::class, 'showTaskReportToEmployee'])->name('reportar');
        Route::post('/tarefa/reportar', [ResultadoController::class, 'submitTaskReportByEmployee'])->name('submeter');
        Route::get('/ficheiro/{id}', [ResultadoController::class, 'showReportFile'])->name('ficheiro');
    });

    Route::get('/tarefas/managers/{departamentoId}', [TarefaController::class, 'getManagersByDepartment'])
    ->name('tarefas.managers');
    //}); // Fim do grupo de middleware 'auth'

/*
|--------------------------------------------------------------------------
| AUTENTICAÇÃO (DEFAULT LARAVEL BREEZE / JETSTREAM)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
