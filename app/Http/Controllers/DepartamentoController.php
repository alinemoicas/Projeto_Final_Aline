<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DepartamentoController extends Controller
{
    /**
     * Listar departamentos
     */
    public function index()
    {
        $departamentos = Departamento::with('chefe')->get();
        return view('admin.departamentos.index', compact('departamentos'));
    }

    /**
     * Formulário de criação
     */
    public function create()
    {
        $funcionarios = Funcionario::orderBy('nome')->get();
        return view('admin.departamentos.create', compact('funcionarios'));
    }

    /**
     * Guardar novo departamento
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome_dept'      => 'required|string|max:255|unique:departamentos,nome_dept',
            'sigla'          => 'required|string|max:10|unique:departamentos,sigla',
            'descricao_dept' => 'nullable|string',
            'chefe_dpt_id'   => 'nullable|exists:funcionarios,id',
        ]);

        try {
            Departamento::create($validated);
            return redirect()->route('departamentos.index')->with('success', 'Departamento criado com sucesso.');
        } catch (\Exception $e) {
            Log::error('Erro ao criar departamento: ' . $e->getMessage());
            return redirect()->route('departamentos.index')->with('error', 'Erro ao criar o departamento.');
        }
    }

    /**
     * Formulário de edição
     */
    public function edit(Departamento $departamento)
    {
        $funcionarios = Funcionario::orderBy('nome')->get();
        return view('admin.departamentos.edit', compact('departamento', 'funcionarios'));
    }

    /**
     * Actualizar departamento
     */
    public function update(Request $request, Departamento $departamento)
    {
        $validated = $request->validate([
            'nome_dept'      => 'required|string|max:255|unique:departamentos,nome_dept,' . $departamento->id,
            'sigla'          => 'required|string|max:10|unique:departamentos,sigla,' . $departamento->id,
            'descricao_dept' => 'nullable|string',
            'chefe_dpt_id'   => 'nullable|exists:funcionarios,id',
        ]);

        try {
            $departamento->update($validated);
            return redirect()->route('departamentos.index')->with('success', 'Departamento actualizado com sucesso.');
        } catch (\Exception $e) {
            Log::error("Erro ao actualizar departamento ID {$departamento->id}: " . $e->getMessage());
            return redirect()->route('departamentos.index')->with('error', 'Erro ao actualizar o departamento.');
        }
    }

    /**
     * Mostrar detalhes
     */
    public function show(Departamento $departamento)
    {
        $departamento->load('chefe');
        return view('admin.departamentos.show', compact('departamento'));
    }

    /**
     * Eliminar departamento
     */
    public function destroy(Departamento $departamento)
    {
        try {
            $departamento->delete();
            return redirect()->route('departamentos.index')->with('success', 'Departamento eliminado com sucesso.');
        } catch (\Exception $e) {
            Log::error("Erro ao eliminar departamento ID {$departamento->id}: " . $e->getMessage());
            return redirect()->route('departamentos.index')->with('error', 'Erro ao eliminar o departamento.');
        }
    }
}
