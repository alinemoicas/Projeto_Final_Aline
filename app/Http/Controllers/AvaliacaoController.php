<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao\Avaliacao;
use App\Models\Avaliacao\AvaliacaoCriterio;
use App\Models\Avaliacao\Criterio;
use App\Models\Funcionario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AvaliacaoController extends Controller
{
    // ------------------- ADMIN / RH ------------------- //

    public function index()
    {
        $avaliacoes = Avaliacao::with(['funcionario', 'avaliador'])->latest()->paginate(10);
        return view('admin.avaliacoes.index', compact('avaliacoes'));
    }

    public function create()
    {
        $funcionarios = Funcionario::all();
        $criterios = Criterio::all();

        return view('admin.avaliacoes.create', compact('funcionarios', 'criterios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'funcionario_id' => 'required|exists:funcionarios,id',
            'notas' => 'required|array'
        ]);

        DB::transaction(function () use ($request) {
            $avaliacao = Avaliacao::create([
                'funcionario_id' => $request->funcionario_id,
                'avaliador_id'   => Auth::id(),
                'descricao'      => $request->descricao ?? null,
                'data'           => now(),
            ]);

            $resultadoFinal = 0;
            $totalPesos = 0;

            foreach ($request->notas as $criterioId => $dados) {
                $criterio = Criterio::findOrFail($criterioId);
                $nota = $dados['nota'];
                $peso = $dados['peso'];

                AvaliacaoCriterio::create([
                    'avaliacao_id' => $avaliacao->id,
                    'criterio_id'  => $criterioId,
                    'peso_id'      => $peso,
                    'nota'         => $nota,
                    'observacao'   => $dados['observacao'] ?? null,
                ]);

                $resultadoFinal += $nota * $peso;
                $totalPesos += $peso;
            }

            $notaFinal = $totalPesos > 0 ? $resultadoFinal / $totalPesos : 0;

            $avaliacao->resultado()->create([
                'nota_final' => $notaFinal,
                'classificacao' => $this->classificar($notaFinal),
            ]);
        });

        return redirect()->route('avaliacoes.index')->with('success', 'Avaliação registada com sucesso.');
    }

    public function show(Avaliacao $avaliacao)
    {
        $avaliacao->load(['funcionario', 'avaliador', 'criterios']);
        return view('admin.avaliacoes.show', compact('avaliacao'));
    }

    public function edit(Avaliacao $avaliacao)
    {
        $avaliacao->load('criterios');
        return view('admin.avaliacoes.edit', compact('avaliacao'));
    }

    public function update(Request $request, Avaliacao $avaliacao)
    {
        $request->validate([
            'notas' => 'required|array'
        ]);

        DB::transaction(function () use ($request, $avaliacao) {
            $resultadoFinal = 0;
            $totalPesos = 0;

            foreach ($request->notas as $criterioId => $dados) {
                $nota = $dados['nota'];
                $peso = $dados['peso'];

                $avaliacaoCriterio = AvaliacaoCriterio::where('avaliacao_id', $avaliacao->id)
                    ->where('criterio_id', $criterioId)
                    ->first();

                if ($avaliacaoCriterio) {
                    $avaliacaoCriterio->update([
                        'nota' => $nota,
                        'peso_id' => $peso,
                        'observacao' => $dados['observacao'] ?? null,
                    ]);
                } else {
                    AvaliacaoCriterio::create([
                        'avaliacao_id' => $avaliacao->id,
                        'criterio_id'  => $criterioId,
                        'peso_id'      => $peso,
                        'nota'         => $nota,
                        'observacao'   => $dados['observacao'] ?? null,
                    ]);
                }

                $resultadoFinal += $nota * $peso;
                $totalPesos += $peso;
            }

            $notaFinal = $totalPesos > 0 ? $resultadoFinal / $totalPesos : 0;

            $avaliacao->resultado()->updateOrCreate(
                ['avaliacao_id' => $avaliacao->id],
                ['nota_final' => $notaFinal, 'classificacao' => $this->classificar($notaFinal)]
            );
        });

        return redirect()->route('avaliacoes.show', $avaliacao)->with('success', 'Avaliação actualizada com sucesso.');
    }

    public function destroy(Avaliacao $avaliacao)
    {
        $avaliacao->delete();
        return redirect()->route('avaliacoes.index')->with('success', 'Avaliação eliminada com sucesso.');
    }

    private function classificar($notaFinal)
    {
        if ($notaFinal >= 4.5) return 'Excelente';
        if ($notaFinal >= 3.5) return 'Bom';
        if ($notaFinal >= 2.5) return 'Regular';
        return 'Insuficiente';
    }

    // ------------------- GESTOR ------------------- //

    /**
     * Exibe o formulário para o Gestor avaliar um funcionário.
     * É chamado em /gestor/avaliacoes/avaliar/{id}
     */
    public function showGiveRatingToManager($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        $criterios = Criterio::all();

        return view('gestor.avaliacoes.avaliar', compact('funcionario', 'criterios'));
    }

    /**
     * Processa e grava a avaliação feita pelo Gestor.
     * É chamado em /gestor/avaliacoes/submeter
     */
    public function submitRatingByManager(Request $request)
    {
        $request->validate([
            'funcionario_id' => 'required|exists:funcionarios,id',
            'notas' => 'required|array'
        ]);

        DB::transaction(function () use ($request) {
            $avaliacao = Avaliacao::create([
                'funcionario_id' => $request->funcionario_id,
                'avaliador_id'   => Auth::id(),
                'descricao'      => $request->descricao ?? 'Avaliação efectuada pelo Gestor directo',
                'data'           => now(),
            ]);

            $resultadoFinal = 0;
            $totalPesos = 0;

            foreach ($request->notas as $criterioId => $dados) {
                $criterio = Criterio::findOrFail($criterioId);
                $nota = $dados['nota'];
                $peso = $dados['peso'] ?? 1;

                AvaliacaoCriterio::create([
                    'avaliacao_id' => $avaliacao->id,
                    'criterio_id'  => $criterioId,
                    'peso_id'      => $peso,
                    'nota'         => $nota,
                    'observacao'   => $dados['observacao'] ?? null,
                ]);

                $resultadoFinal += $nota * $peso;
                $totalPesos += $peso;
            }

            $notaFinal = $totalPesos > 0 ? $resultadoFinal / $totalPesos : 0;

            $avaliacao->resultado()->create([
                'nota_final' => $notaFinal,
                'classificacao' => $this->classificar($notaFinal),
            ]);
        });

        return redirect()->route('gestores.tarefas.concluidas')->with('success', 'Avaliação submetida com sucesso.');
    }
}