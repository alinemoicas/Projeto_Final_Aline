<?php

namespace App\Http\Controllers;
use App\Models\Departamento;
use App\Models\Funcionario;
use App\Models\Cargo;
use Illuminate\Http\Request;

//controladores são intermediarios do codigo com a base de dados
class FuncionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Para visualizar a pagina dos funcionarios
        //$funcionarios = Funcionario::with('departamento')->get();
        //return view('index'); //compact('funcionarios'));
        $funcionarios = Funcionario::with(['cargo', 'departamento', 'chefe'])->get();
        return view('funcionarios.index', compact('funcionarios'));
    

    }
    /**
     * Show the form for creating a new resource.
     */

    public function create()       
    {   
    $funcionarios = Funcionario::all(); // Para select de chefes
    $cargos = Cargo::all();
    $departamentos = Departamento::all();
    return view('funcionarios.create', compact('funcionarios', 'cargos', 'departamentos'));
    }

  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'nome'            => 'required|string|max:255',
        'sobrenome'       => 'required|string|max:255',
        'telefone'        => 'required|string|max:20',
        'email'           => 'required|email|unique:funcionarios,email',
        'cargo_id'        => 'required|exists:cargos,id',
        'dept_id'         => 'required|exists:departamentos,id',
        'data_admissao'   => 'nullable|date',
        'chefe_id'        => 'nullable|exists:funcionarios,id',
        'categoria'       => 'required|string|max:100',
        'estado'          => 'required|in:activo,inactivo',
    ]);

    Funcionario::create($validated);

   return redirect()->route('funcionarios.index')->with('success', 'Funcionário cadastrado com sucesso.');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $funcionarios = Funcionario::with('departamento')->findOrFail($id);
        return view('funcionarios.show', compact('funcionarios'));
    
    }

    /**
     * Show the form for editing the specified resource.
     */
 public function edit(Funcionario $funcionario)
{
    $cargos = Cargo::all();
    $departamentos = Departamento::all();
    $funcionarios = Funcionario::where('id', '!=', $funcionario->id)->get(); // <- lista de chefes possíveis

    return view('funcionarios.edit', compact('funcionario', 'cargos', 'departamentos', 'funcionarios'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $validated = $request->validate([
        'nome'            => 'required|string|max:255',
        'sobrenome'       => 'required|string|max:255',
        'telefone'        => 'required|string|max:20',
        'email'           => 'required|email|unique:funcionarios,email,' . $id,
        'cargo_id'        => 'required|exists:cargos,id',
        'dept_id'         => 'required|exists:departamentos,id',
        'data_admissao' => 'required|date',
        'categoria'       => 'required|string|max:100',
        'estado'          => 'required|in:activo,inactivo',
    ]);

    $funcionario = Funcionario::findOrFail($id);
    $funcionario->update($validated);

    return redirect()->route('funcionarios.index')->with('success', 'Dados do Funcionário atualizados com sucesso.');
}    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Funcionario::findOrFail($id)->delete();
        return redirect()->route('funcionarios.index')->with('success', 'Funcionário removido com sucesso.');

    }
}
