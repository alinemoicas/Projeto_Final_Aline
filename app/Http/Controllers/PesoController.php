<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao\Peso;
use Illuminate\Http\Request;

class PesoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'criterio_id' => 'required|exists:criterios,id',
            'valor'       => 'required|numeric|min:0|max:100',
        ]);

        Peso::create($request->all());
        return back()->with('success', 'Peso atribuído.');
    }
}

