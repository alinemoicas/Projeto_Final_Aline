<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Avaliacao\Avaliacao as AvaliacaoAvaliacao;
use App\Models\Avaliacao\AvaliacaoCriterio as AvaliacaoAvaliacaoCriterio;
use App\Models\Avaliacao\Criterio as ModelsAvaliacaoCriterio;
use App\Models\Funcionario;
use App\Models\Criterio;
use App\Models\AvaliacaoCriterio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AvaliacaoController extends Controller
{
    /**
     * Listar todas as avaliações
     */
    public function index()
    {
        $avaliacoes = AvaliacaoAvaliacao::with(['funcionario', 'avaliador'])->latest()->paginate(10);
        return view('avaliacoes.index', compact('avaliacoes'));
    }

    /**
     * Formulário para nova avaliação
     */
    public function create()
    {
        $funcionarios = Funcionario::all();
        $criterios = ModelsAvaliacaoCriterio::all();

        return view('avaliacoes.create', compact('funcionarios', 'criterios'));
    }

    /**
     * Guardar avaliação
     */
    public function store(Request $request)
    {
        $request->validate([
            'funcionario_id' => 'required|exists:funcionarios,id',
            'notas' => 'required|array'
        ]);

        DB::transaction(function () use ($request) {
            $avaliacao = AvaliacaoAvaliacao::create([
                'funcionario_id' => $request->funcionario_id,
                /** 'avaliador_id' => auth()->isAdmin(), // assumindo utilizador autenticado */
                'resultado_final' => null,
            ]);

            $resultadoFinal = 0;

            foreach ($request->notas as $criterioId => $nota) {
                $criterio = ModelsAvaliacaoCriterio::findOrFail($criterioId);

                $resultado = $nota * $criterio->peso;

                AvaliacaoAvaliacaoCriterio::create([
                    'avaliacao_id' => $avaliacao->id,
                    'criterio_id' => $criterioId,
                    'nota' => $nota,
                    'resultado' => $resultado
                ]);

                $resultadoFinal += $resultado;
            }

            $avaliacao->update(['resultado_final' => $resultadoFinal]);
        });

        return redirect()->route('avaliacoes.index')->with('success', 'Avaliação registada com sucesso.');
    }

    /**
     * Ver detalhes
     */
    public function show(AvaliacaoAvaliacao $avaliacao)
    {
        $avaliacao->load(['funcionario', 'avaliador', 'avaliacaoCriterios.criterio']);
        return view('avaliacoes.show', compact('avaliacao'));
    }

    /**
     * Formulário de edição
     */
    public function edit(AvaliacaoAvaliacao $avaliacao)
    {
        $avaliacao->load(['avaliacaoCriterios.criterio']);
        return view('avaliacoes.edit', compact('avaliacao'));
    }

    /**
     * Actualizar avaliação
     */
    public function update(Request $request, AvaliacaoAvaliacao $avaliacao)
    {
        $request->validate([
            'notas' => 'required|array'
        ]);

        DB::transaction(function () use ($request, $avaliacao) {
            $resultadoFinal = 0;

            foreach ($request->notas as $criterioId => $nota) {
                $criterio = ModelsAvaliacaoCriterio::findOrFail($criterioId);
                $resultado = $nota * $criterio->peso;

                $avaliacaoCriterio = AvaliacaoAvaliacaoCriterio::where('avaliacao_id', $avaliacao->id)
                    ->where('criterio_id', $criterioId)
                    ->first();

                if ($avaliacaoCriterio) {
                    $avaliacaoCriterio->update([
                        'nota' => $nota,
                        'resultado' => $resultado
                    ]);
                } else {
                    AvaliacaoAvaliacaoCriterio::create([
                        'avaliacao_id' => $avaliacao->id,
                        'criterio_id' => $criterioId,
                        'nota' => $nota,
                        'resultado' => $resultado
                    ]);
                }

                $resultadoFinal += $resultado;
            }

            $avaliacao->update(['resultado_final' => $resultadoFinal]);
        });

        return redirect()->route('avaliacoes.show', $avaliacao)->with('success', 'Avaliação actualizada com sucesso.');
    }

    /**
     * Eliminar avaliação
     */
    public function destroy(AvaliacaoAvaliacao $avaliacao)
    {
        $avaliacao->delete();
        return redirect()->route('avaliacoes.index')->with('success', 'Avaliação eliminada com sucesso.');
    }
}
