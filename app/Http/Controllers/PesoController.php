<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao\Peso;
use Illuminate\Http\Request;

class PesoController extends Controller
{
    public function index()
    {
        $pesos = Peso::all();
        return view('pesos.index', compact('pesos'));
    }

    public function create()
    {
        return view('pesos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'valor' => 'required|numeric|min:0',
            'descricao' => 'nullable|string|max:255',
        ]);

        Peso::create($validated);

        return redirect()->route('pesos.index')
                         ->with('success', 'Peso criado com sucesso.');
    }

    public function edit(Peso $peso)
    {
        return view('pesos.edit', compact('peso'));
    }

    public function update(Request $request, Peso $peso)
    {
        $validated = $request->validate([
            'valor' => 'required|numeric|min:0',
            'descricao' => 'nullable|string|max:255',
        ]);

        $peso->update($validated);

        return redirect()->route('pesos.index')
                         ->with('success', 'Peso actualizado com sucesso.');
    }

    public function destroy(Peso $peso)
    {
        try {
            $peso->delete();
            return redirect()->route('pesos.index')
                             ->with('success', 'Peso eliminado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('pesos.index')
                             ->with('error', 'Erro ao eliminar peso.');
        }
    }
}
