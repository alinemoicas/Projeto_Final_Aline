<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao\Criterio;
use Illuminate\Http\Request;

class CriterioController extends Controller
{
    public function index()
    {
        $criterios = Criterio::all();
        return view('criterios.index', compact('criterios'));
    }

    public function create()
    {
        return view('criterios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        Criterio::create($validated);

        return redirect()->route('criterios.index')
                         ->with('success', 'Critério criado com sucesso.');
    }

    public function edit(Criterio $criterio)
    {
        return view('criterios.edit', compact('criterio'));
    }

    public function update(Request $request, Criterio $criterio)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        $criterio->update($validated);

        return redirect()->route('criterios.index')
                         ->with('success', 'Critério actualizado com sucesso.');
    }

    public function destroy(Criterio $criterio)
    {
        try {
            $criterio->delete();
            return redirect()->route('criterios.index')
                             ->with('success', 'Critério eliminado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('criterios.index')
                             ->with('error', 'Erro ao eliminar critério.');
        }
    }
}