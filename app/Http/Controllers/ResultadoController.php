<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao\Avaliacao;
use App\Models\Avaliacao\Resultado; // O teu modelo de "report"
use App\Models\Funcionario;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ResultadoController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | RELATÓRIOS / RESULTADOS DE TAREFAS
    |--------------------------------------------------------------------------
    | Este controlador adapta a lógica do ReportController (referência)
    | para o teu domínio de negócio, onde Resultado = Relatório.
    */

    /**
     * Exibir resultados (relatórios) de uma tarefa específica.
     * Lógica idêntica ao showTaskReport() do código de referência.
     */
    public function showTaskReport($tarefa_id)
    {
        $resultados = Resultado::where('tarefa_id', $tarefa_id)->get();

        if (session('userType') === 'gestor' || session('userType') === 'manager') {
            return view('gestor.resultados.view-task-report', compact('resultados'));
        }

        return view('admin.resultados.view-task-report', compact('resultados'));
    }

    /**
     * Mostrar formulário para o funcionário submeter relatório.
     */
    public function showTaskReportToEmployee($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        return view('funcionarios.resultados.task-report', compact('tarefa'));
    }

    /**
     * Upload do ficheiro do relatório (Resultado).
     */
    protected function uploadReportFile(Request $request, Tarefa $tarefa)
    {
        $funcionario = Auth::user()->funcionario ?? null;

        if (!$funcionario) {
            throw new \Exception('Funcionário autenticado não encontrado.');
        }

        $file = $request->file('report_file');
        $ext = $file->getClientOriginalExtension();
        $fileName = sprintf(
            '%s_%s_stage-%s.%s',
            $funcionario->id,
            $tarefa->id,
            $request->input('stage_no', 1),
            $ext
        );

        $path = $file->storeAs('resultado-files', $fileName, 'public');
        return $path;
    }

    /**
     * Submeter relatório (resultado) pelo funcionário.
     */
    public function submitTaskReportByEmployee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tarefa_id'   => 'required|exists:tarefas,id',
            'stage_no'    => 'required|integer|min:1',
            'report_file' => 'required|file|max:10240|mimes:pdf,doc,docx,zip,jpg,png'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $tarefa = Tarefa::findOrFail($request->tarefa_id);
            $funcionario = Auth::user()->funcionario;

            if (!$funcionario) {
                return back()->with('error', 'Funcionário não autenticado.');
            }

            $filePath = $this->uploadReportFile($request, $tarefa);

            $resultado = new Resultado();
            $resultado->departamento_id = $tarefa->departamento_id;
            $resultado->tarefa_id = $tarefa->id;
            $resultado->gestor_id = $tarefa->gestor_id ?? null;
            $resultado->funcionario_id = $funcionario->id;
            $resultado->stage_no = $request->input('stage_no');
            $resultado->report_file = $filePath;
            $resultado->comentario = $request->input('comentario', null);
            $resultado->save();

            return redirect()->route('funcionarios.tarefas.new')
                ->with('success', 'Relatório submetido com sucesso!');
        } catch (\Throwable $e) {
            Log::error("Erro ao submeter resultado: {$e->getMessage()}", [
                'user_id' => Auth::id(),
                'dados' => $request->all()
            ]);

            return back()->with('error', 'Erro ao submeter o relatório. Tente novamente.');
        }
    }

    /**
     * Visualizar ficheiro do relatório (resultado).
     */
    public function showReportFile($id)
    {
        $resultado = Resultado::findOrFail($id);

        if (session('userType') === 'gestor' || session('userType') === 'manager') {
            return view('gestor.resultados.view-report-file', compact('resultado'));
        }

        if (session('userType') === 'funcionario' || session('userType') === 'employee') {
            return view('funcionarios.resultados.view-report-file', compact('resultado'));
        }

        return view('admin.resultados.view-report-file', compact('resultado'));
    }
}
