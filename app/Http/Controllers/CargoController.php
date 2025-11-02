<?php

namespace App\Http\Controllers;
use App\Models\Cargo;

use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function index()
    {
        $cargos = Cargo::all();
        return view('admin.cargos.index', compact('cargos'));
    }

    public function create()
    {
        return view('admin.cargos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100|unique:cargos,nome',
            'descricao' => 'nullable|string'
        ]);

        Cargo::create($request->all());
        return redirect()->route('admin.cargos.index')->with('success', 'Cargo adicionado com sucesso.');
    }

    public function show($id)
    {
        $cargo = Cargo::findOrFail($id);
        return view('admin.cargos.show', compact('cargo'));
    }

    public function edit($id)
    {
        $cargo = Cargo::findOrFail($id);
        return view('admin.cargos.edit', compact('cargo'));
    }

    public function update(Request $request, $id)
    {
        $cargo = Cargo::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:100|unique:cargos,nome,' . $cargo->id,
            'descricao' => 'nullable|string'
        ]);

        $cargo->update($request->all());
        return redirect()->route('cargos.index')->with('success', 'Cargo actualizado com sucesso.');
    }

    public function destroy($id)
    {
        Cargo::destroy($id);
        return redirect()->route('cargos.index')->with('success', 'Cargo removido com sucesso.');
    }
}