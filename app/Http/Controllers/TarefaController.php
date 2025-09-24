<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Tarefa;
use Illuminate\Http\Request;

class TarefaController extends Controller
{
    /**
     * Exibe a lista de tarefas.
     */
    public function index()
    {
        $tarefas = Tarefa::with('funcionario')->get();
        return view('tarefa.index', compact('tarefas'));
    }

    /**
     * Mostra o formulário para criar uma nova tarefa.
     */
    public function create()
    {
        $funcionarios = Funcionario::all();
        return view('tarefa.create', compact('funcionarios'));


    }

    /**
     * Armazena uma nova tarefa no banco de dados.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'funcionario_id' => 'required|exists:funcionarios,id',
            'titulo_taf' => 'required|string|max:255',
            'descricao_taf' => 'nullable|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'importancia_taref' => 'required|integer|min:1|max:5',
            'estado_tarefa' => 'required|in:pendente,em andamento,concluída',
        ]);

        Tarefa::create($validated);
        return redirect()->route('tarefa.index')->with('success', 'Tarefa criada com sucesso');

    }

    /**
     * Exibe os detalhes de uma tarefa específica.
     */
    public function show(string $id)
    {
        $tarefa = Tarefa::with('funcionario')->findOrFail($id);
        return view('tarefa.show', compact('tarefa'));
    }

    /**
     * Mostra o formulário de edição para uma tarefa específica.
     */
    public function edit(string $id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $funcionarios = Funcionario::all();
        return view('tarefa.edit', compact('tarefa', 'funcionarios'));
    }

    /**
     * Actualiza uma tarefa existente no banco de dados.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'funcionario_id' => 'required|exists:funcionarios,id',
            'titulo_taf' => 'required|string|max:255',
            'descricao_taf' => 'nullable|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'importancia_taref' => 'required|integer|min:1|max:5',
            'estado_tarefa' => 'required|in:pendente,em andamento,concluída',
        ]);

        $tarefa = Tarefa::findOrFail($id);
        $tarefa->update($validated);

        return redirect()->route('tarefa.index')->with('success', 'Tarefa actualizada com sucesso');
    }

    /**
     * Remove uma tarefa do banco de dados.
     */
    public function destroy(string $id)
    {
        Tarefa::findOrFail($id)->delete();
        return redirect()->route('tarefa.index')->with('success', 'Tarefa eliminada com sucesso');
    }
}