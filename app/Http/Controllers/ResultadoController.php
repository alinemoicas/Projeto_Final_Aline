<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao\Avaliacao;
use Illuminate\Http\Request;

class ResultadoController extends Controller
{
    public function show($avaliacao_id)
    {
        $avaliacao = Avaliacao::with(['criterios'])->findOrFail($avaliacao_id);

        $resultado = 0;
        foreach ($avaliacao->criterios as $criterio) {
            $resultado += $criterio->pivot->nota * ($criterio->peso->valor / 100);
        }

        return view('resultados.show', compact('avaliacao', 'resultado'));
    }
}
