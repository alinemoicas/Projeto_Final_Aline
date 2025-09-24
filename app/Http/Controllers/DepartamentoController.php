<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::with('chefe')->get(); // eager loading do chefe
        return view('departamentos.index', compact('departamentos'));
    }

    public function create()
    {
        $funcionarios = Funcionario::orderBy('nome')->get();
        return view('departamentos.create', compact('funcionarios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome_dept'      => 'required|string|max:255',
            'sigla'          => 'required|string|max:10',
            'descricao_dept' => 'nullable|string',
            'chefe_dpt_id'   => 'nullable|exists:funcionarios,id',
        ]);

        try {
            Departamento::create($validated);
            return redirect()
                ->route('departamentos.index')
                ->with('success', 'Departamento criado com sucesso.');
        } catch (\Exception $e) {
            Log::error('Erro ao criar departamento: ' . $e->getMessage());
            return redirect()
                ->route('departamentos.index')
                ->with('error', 'Erro ao criar o departamento.');
        }
    }

    public function edit(Departamento $departamento)
    {
        $funcionarios = Funcionario::orderBy('nome')->get();
        return view('departamentos.edit', compact('departamento', 'funcionarios'));
    }

    public function update(Request $request, Departamento $departamento)
    {
        $validated = $request->validate([
            'nome_dept'      => 'required|string|max:255',
            'sigla'          => 'required|string|max:10',
            'descricao_dept' => 'nullable|string',
            'chefe_dpt_id'   => 'nullable|exists:funcionarios,id',
        ]);

        try {
            $departamento->update($validated);
            return redirect()
                ->route('departamentos.index')
                ->with('success', 'Departamento actualizado com sucesso.');
        } catch (\Exception $e) {
            Log::error('Erro ao actualizar departamento ID ' . $departamento->id . ': ' . $e->getMessage());
            return redirect()
                ->route('departamentos.index')
                ->with('error', 'Erro ao actualizar o departamento.');
        }
    }

    public function show(Departamento $departamento)
{
    // Carregar também o chefe associado, se existir
    $departamento->load('chefe');

    return view('departamentos.show', compact('departamento'));
}


    public function destroy(Departamento $departamento)
    {
        try {
            $departamento->delete();
            return redirect()->route('departamentos.index')->with('success', 'Departamento eliminado com sucesso.');
        } catch (\Exception $e) {
            Log::error('Erro ao eliminar departamento ID ' . $departamento->id . ': ' . $e->getMessage());
            return redirect()->route('departamentos.index')->with('error', 'Erro ao eliminar o departamento.');
        }
    }
}
