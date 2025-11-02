<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveTarefaRequest;
use App\Http\Requests\UpdateTarefaRequest;
use App\Models\Tarefa;
use App\Models\Departamento;
use App\Models\Funcionario;
use App\Models\AssignTarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TarefaController extends Controller
{
    /**
     * Mostrar a lista de todas as tarefas (Admin/RH).
     * Rota: GET /tarefas  → nome: tarefas.index
     */
    public function index()
    {
        $tarefas = Tarefa::with(['departamento', 'funcionario', 'manager'])->get();
        return view('admin.tarefas.index', compact('tarefas'));
    }

    /**
     * Formulário para criar nova tarefa.
     * Rota: GET /tarefas/criar  → nome: tarefas.create
     */
    public function create()
    {
        $departamentos = Departamento::all();
        $funcionarios = collect(); 
        return view('admin.tarefas.create', compact('departamentos', 'funcionarios'));
    }

    /**
     * Guardar nova tarefa.
     * Rota: POST /tarefas  → nome: tarefas.store
     */
    public function store(SaveTarefaRequest $request)
    {
        $tarefa = new Tarefa();
        $tarefa->fill($request->validated());
        $tarefa->estado_tarefa = 'pendente';
        $tarefa->save();

        return redirect()->route('admin.tarefas.index')->with('success', 'Tarefa criada com sucesso!');
    }

    /**
     * Mostrar detalhes de uma tarefa.
     * Rota: GET /tarefas/{id}  → nome: tarefas.show
     */
    public function show($id)
    {
        $tarefa = Tarefa::with(['departamento', 'manager', 'funcionario'])->findOrFail($id);
        return view('admin.tarefas.show', compact('tarefa'));
    }

    /**
     * Formulário para editar tarefa.
     * Rota: GET /tarefas/{id}/editar  → nome: tarefas.edit
     */
    public function edit($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $departamentos = Departamento::all();
        $gestores = Funcionario::where('dept_id', $tarefa->departamento_id)->get();
        return view('admin.tarefas.edit', compact('tarefa', 'departamentos', 'gestores'));
    }

    /**
     * Actualizar tarefa existente.
     * Rota: PUT /tarefas/{id}  → nome: tarefas.update
     */
    public function update(UpdateTarefaRequest $request, $id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->update($request->validated());

        return redirect()->route('admin.tarefas.index')->with('success', 'Tarefa actualizada com sucesso!');
    }

    /**
     * Eliminar uma tarefa.
     * Rota: DELETE /tarefas/{id}  → nome: tarefas.destroy
     */
    public function destroy($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->delete();

        return redirect()->route('admin.tarefas.index')->with('success', 'Tarefa removida com sucesso!');
    }

    /**
     * Retornar os gestores de um departamento (AJAX).
     */
    public function getManagersByDepartment($departamentoId)
{
    try {
        $gestores = \App\Models\Gestor::where('departamento_id', $departamentoId)
            ->select('id', 'nome', 'sobrenome')
            ->get();

        return response()->json($gestores);
    } catch (\Exception $e) {
        \Log::error('Erro ao carregar gestores: ' . $e->getMessage());
        return response()->json([], 500);
    }
}


    /* ======================================================
     *                  ÁREA DO GESTOR
     * ====================================================== */

    /**
     * Mostrar novas tarefas atribuídas ao gestor.
     * Rota: GET /tarefas/gestor/novas → nome: gestor.tarefas.new
     */
    public function showNewTask()
    {
        $gestorId = Auth::id();
        $tarefas = Tarefa::where('gestor_id', $gestorId)
            ->where('estado_tarefa', 'pendente')
            ->get();

        return view('gestor.tarefas.new', compact('tarefas'));
    }

    /**
     * Detalhes da tarefa para o gestor.
     * Rota: GET /tarefas/gestor/detalhes/{id} → nome: gestor.tarefas.details
     */
    public function showTaskDetailsToManager($id)
    {
        $tarefa = Tarefa::with(['departamento', 'funcionario'])->findOrFail($id);
        return view('gestor.tarefas.details', compact('tarefa'));
    }

    /**
     * Página para o gestor atribuir tarefa a funcionário.
     * Rota: GET /tarefas/gestor/atribuir/{id} → nome: gestor.tarefas.assign
     */
    public function showTaskAssignByManager($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $funcionarios = Funcionario::where('dept_id', $tarefa->departamento_id)
            ->where('estado', 'activo')
            ->get();

        return view('gestor.tarefas.assign-tarefa', compact('tarefa', 'funcionarios'));
    }

    /**
     * Atribuir tarefa a funcionário.
     * Rota: POST /tarefas/gestor/atribuir → nome: gestor.tarefas.assign.store
     */
    public function AssignNewTaskToEmployee(Request $request)
{
    $request->validate([
        'tarefa_id' => 'required|exists:tarefas,id',
        'funcionario_id' => 'required|exists:funcionarios,id',
    ]);

    $tarefa = Tarefa::findOrFail($request->tarefa_id);

    // Verifica se a tarefa já foi atribuída
    if (AssignTarefa::where('tarefa_id', $tarefa->id)->where('funcionario_id', $request->funcionario_id)->exists()) {
        return redirect()
            ->back()
            ->with('warning', 'Esta tarefa já foi atribuída a este funcionário.');
    }

    // Cria nova atribuição
    AssignTarefa::create([
        'departamento_id'    => $tarefa->departamento_id,
        'gestor_id'          => $tarefa->gestor_id,
        'funcionario_id'     => $request->funcionario_id,
        'tarefa_id'          => $tarefa->id,
        'peso'               => null,
        'resultado'          => null,
        'gestor_peso_status' => 0,
    ]);

    // Actualiza o estado da tarefa
    $tarefa->estado_tarefa = 'em andamento';
    $tarefa->save();

    return redirect()
        ->route('gestor.tarefas.new')
        ->with('success', 'Tarefa atribuída com sucesso!');
}

    /**
     * Mostrar tarefas pendentes para o gestor.
     * Rota: GET /tarefas/gestor/pendentes → nome: gestor.tarefas.pending
     */
    public function showPendingTaskToManager()
    {
        $gestorId = Auth::id();

        $tarefas = DB::table('assign_tarefas')
            ->where('gestor_id', $gestorId)
            ->where('gestor_peso_status', 0)
            ->join('tarefas', 'tarefas.id', '=', 'assign_tarefas.tarefa_id')
            ->join('funcionarios', 'funcionarios.id', '=', 'assign_tarefas.funcionario_id')
            ->select('tarefas.*', 'funcionarios.nome', 'funcionarios.sobrenome')
            ->get();

        return view('gestor.tarefas.pending', compact('tarefas'));
    }

    /**
     * Detalhes de tarefa pendente do gestor.
     * Rota: GET /tarefas/gestor/pendentes/{id} → nome: gestor.tarefas.pending.details
     */
    public function showPendingTaskDetailsToManager($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $assign = AssignTarefa::with('funcionario')->where('tarefa_id', $id)->first();

        return view('gestor.tarefas.pending-details', compact('tarefa', 'assign'));
    }

    /**
     * Tarefas concluídas do gestor.
     * Rota: GET /tarefas/gestor/concluidas → nome: gestor.tarefas.completed
     */
    public function showCompletedTaskToManager()
    {
        $gestorId = Auth::id();

        $tarefas = DB::table('assign_tarefas')
            ->where('gestor_id', $gestorId)
            ->where('gestor_peso_status', 1)
            ->join('tarefas', 'tarefas.id', '=', 'assign_tarefas.tarefa_id')
            ->join('funcionarios', 'funcionarios.id', '=', 'assign_tarefas.funcionario_id')
            ->select('tarefas.*', 'funcionarios.nome', 'funcionarios.sobrenome')
            ->get();

        return view('gestor.tarefas.completed', compact('tarefas'));
    }
}
