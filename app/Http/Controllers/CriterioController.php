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

    public function store(Request $request)
    {
        $request->validate(['nome' => 'required|string|max:255']);
        Criterio::create($request->all());
        return back()->with('success', 'Critério criado.');
    }
}
