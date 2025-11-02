<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao\AvaliacaoCriterio;
use Illuminate\Http\Request;

class AvaliacaoCriterioController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'avaliacao_id' => 'required|exists:avaliacoes,id',
            'criterio_id'  => 'required|exists:criterios,id',
            /*'peso_id'      => 'required|exists:pesos,id',
            'resultado_id' => 'required|exists:pesos,id',*/
            'nota'         => 'required|numeric|min:0|max:20',
        ]);

        AvaliacaoCriterio::create($request->all());
        return back()->with('success', 'Nota registada.');
    }
}

