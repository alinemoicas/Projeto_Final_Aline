<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Funcionario;
use App\Models\Cargo;
use App\Models\User;
use App\Models\Tarefa;
use App\Models\AssignTarefa;
use App\Models\Resultado;
use App\Notifications\WelcomeSetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class FuncionarioController extends Controller
{
    // ---------------- FUNCIONÁRIOS ---------------- //

    public function index()
    {
        $funcionarios = Funcionario::with(['cargo', 'departamento', 'chefe'])->get();
        return view('admin.funcionarios.index', compact('funcionarios'));
    }

    public function gestores()
    {
        $gestores = Funcionario::whereHas('cargo', function ($q) {
            $q->where('nome', 'like', '%gestor%')
              ->orWhere('nome', 'like', '%chefe%');
        })->with(['departamento', 'cargo'])->get();

        return view('funcionarios.gestores', compact('gestores'));
    }

    public function create()
    {
        $funcionarios = Funcionario::all(); 
        $cargos = Cargo::all();
        $departamentos = Departamento::all();

        return view('admin.funcionarios.create', compact('funcionarios', 'cargos', 'departamentos'));
    }

    protected function validateFuncionario(Request $request, $id = null)
    {
        return $request->validate([
            'nome'          => 'required|string|max:255',
            'sobrenome'     => 'required|string|max:255',
            'telefone'      => 'required|string|max:20|unique:funcionarios,telefone,' . $id,
            'email'         => 'required|email|unique:funcionarios,email,' . $id,
            'cargo_id'      => 'required|exists:cargos,id',
            'dept_id'       => 'required|exists:departamentos,id',
            'data_admissao' => 'nullable|date',
            'chefe_id'      => 'nullable|exists:funcionarios,id',
            'categoria'     => 'required|string|max:100',
            'estado'        => 'required|in:activo,inactivo',
            'foto'          => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);
    }

    protected function uploadFuncionarioImage($request)
    {
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $ext  = $foto->getClientOriginalExtension();
            $nome = $request->nome.'_'.$request->sobrenome.'_'.time().'.'.$ext;
            $path = 'funcionarios/'.$nome;
            return $path;
        }
        return null;
    }

    public function store(Request $request)
    {
        $validated = $this->validateFuncionario($request);

        try {
            if ($path = $this->uploadFuncionarioImage($request)) {
                $validated['foto'] = $path;
            }

            $funcionario = Funcionario::create($validated);

            $user = User::create([
                'name' => $validated['nome'].' '.$validated['sobrenome'],
                'email' => $validated['email'],
                'password' => bcrypt(str()->random(12)),
            ]);

            $token = Password::createToken($user);
            $user->notify(new WelcomeSetPassword($token));

            return redirect()->route('funcionarios.index')->with('success', 'Funcionário cadastrado com sucesso.');
        } catch (\Exception $e) {
            Log::error("Erro ao cadastrar funcionário: " . $e->getMessage());
            return redirect()->route('funcionarios.index')->with('error', 'Erro ao cadastrar o funcionário.');
        }
    }

    public function show(Funcionario $funcionario)
    {
        $funcionario->load(['departamento', 'cargo', 'chefe']);
        return view('admin.funcionarios.show', compact('funcionario'));
    }

    public function edit(Funcionario $funcionario)
    {
        $cargos = Cargo::all();
        $departamentos = Departamento::all();
        $funcionarios = Funcionario::where('id', '!=', $funcionario->id)->get();

        return view('admin.funcionarios.edit', compact('funcionario', 'cargos', 'departamentos', 'funcionarios'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $this->validateFuncionario($request, $id);

        try {
            $funcionario = Funcionario::findOrFail($id);

            if ($path = $this->uploadFuncionarioImage($request)) {
                if ($funcionario->foto && Storage::disk('public')->exists($funcionario->foto)) {
                    Storage::disk('public')->delete($funcionario->foto);
                }
                $validated['foto'] = $path;
            }

            $funcionario->update($validated);

            return redirect()->route('funcionarios.index')->with('success', 'Dados do Funcionário actualizados com sucesso.');
        } catch (\Exception $e) {
            Log::error("Erro ao actualizar funcionário ID {$id}: " . $e->getMessage());
            return redirect()->route('funcionarios.index')->with('error', 'Erro ao actualizar o funcionário.');
        }
    }

    public function destroy(string $id)
    {
        try {
            $funcionario = Funcionario::findOrFail($id);

            if ($funcionario->foto && Storage::disk('public')->exists($funcionario->foto)) {
                Storage::disk('public')->delete($funcionario->foto);
            }

            $funcionario->delete();

            return redirect()->route('funcionarios.index')->with('success', 'Funcionário removido com sucesso.');
        } catch (\Exception $e) {
            Log::error("Erro ao eliminar funcionário ID {$id}: " . $e->getMessage());
            return redirect()->route('funcionarios.index')->with('error', 'Erro ao eliminar o funcionário.');
        }
    }

    // ---------------- PERFIL DO FUNCIONÁRIO ---------------- //

    public function showEmployeeProfile()
    {
        $funcionario = Auth::user()->funcionario;
        return view('funcionarios.perfil.show', compact('funcionario'));
    }

    public function editEmployeeProfile()
    {
        $funcionario = Auth::user()->funcionario;
        return view('funcionarios.perfil.edit', compact('funcionario'));
    }

    public function updateEmployeeProfile(Request $request)
    {
        $funcionario = Auth::user()->funcionario;
        $validated = $this->validateFuncionario($request, $funcionario->id);

        if ($path = $this->uploadFuncionarioImage($request)) {
            if ($funcionario->foto && Storage::disk('public')->exists($funcionario->foto)) {
                Storage::disk('public')->delete($funcionario->foto);
            }
            $validated['foto'] = $path;
        }

        $funcionario->update($validated);

        return redirect()->route('funcionarios.perfil.show')->with('success','Perfil actualizado com sucesso');
    }

    // ---------------- FUNÇÕES ADICIONADAS PARA GESTOR ---------------- //

    /**
     * Exibe o formulário para o Gestor adicionar um funcionário (subordinado).
     */
    public function showAddEmployee()
    {
        $departamentos = Departamento::all();
        $cargos = Cargo::all();
        return view('gestor.funcionarios.create', compact('departamentos', 'cargos'));
    }

    /**
     * Guarda um novo funcionário adicionado por um Gestor.
     */
    public function saveEmployee(Request $request)
    {
        $validated = $this->validateFuncionario($request);

        try {
            $validated['chefe_id'] = Auth::user()->funcionario->id; // o gestor actual
            $validated['estado'] = 'activo';

            if ($path = $this->uploadFuncionarioImage($request)) {
                $validated['foto'] = $path;
            }

            Funcionario::create($validated);

            return redirect()->route('gestor.funcionarios.adicionar')->with('success', 'Funcionário adicionado com sucesso.');
        } catch (\Exception $e) {
            Log::error('Erro ao adicionar funcionário pelo gestor: '.$e->getMessage());
            return back()->with('error', 'Erro ao adicionar o funcionário.');
        }
    }

    /**
     * Mostra detalhes do funcionário sob gestão do gestor.
     */
    public function showEmployeeDetails($id)
    {
        $funcionario = Funcionario::with(['departamento', 'cargo', 'chefe'])->findOrFail($id);
        return view('gestor.funcionarios.details', compact('funcionario'));
    }

    // ---------------- TAREFAS ---------------- //

    public function showNewTaskToEmployee()
    {
        $funcionarioId = Auth::id();
        $tarefas = AssignTarefa::with('tarefa')
            ->where('funcionario_id', $funcionarioId)
            ->where('report_status', 0)
            ->get();

        return view('funcionarios.tarefas.new', compact('tarefas'));
    }

    public function showTaskDetailsToEmployee($id)
    {
        $tarefa = Tarefa::with(['departamento', 'funcionario'])->findOrFail($id);
        $assign = AssignTarefa::where('tarefa_id', $id)
            ->where('funcionario_id', Auth::id())
            ->first();

        return view('funcionarios.tarefas.details', compact('tarefa', 'assign'));
    }

    public function markTaskAsDoneByEmployee($id)
    {
        $assign = AssignTarefa::where('tarefa_id', $id)
            ->where('funcionario_id', Auth::id())
            ->firstOrFail();

        $assign->update(['report_status' => 1]);

        return redirect()->route('funcionarios.tarefas.new')->with('success', 'Tarefa concluída com sucesso!');
    }

    public function showCompleteTaskToEmployee()
    {
        $funcionarioId = Auth::id();

        $tarefas = AssignTarefa::with('tarefa')
            ->where('funcionario_id', $funcionarioId)
            ->where('report_status', 1)
            ->get();

        return view('funcionarios.tarefas.completed', compact('tarefas'));
    }

    public function showCompletedTaskDetailsByEmployee($id)
    {
        $tarefa = Tarefa::with(['departamento', 'funcionario'])->findOrFail($id);
        $assign = AssignTarefa::where('tarefa_id', $id)
            ->where('funcionario_id', Auth::id())
            ->where('report_status', 1)
            ->firstOrFail();

        return view('funcionarios.tarefas.completed-details', compact('tarefa', 'assign'));
    }
    
}