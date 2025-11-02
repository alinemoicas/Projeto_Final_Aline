<?php

namespace App\Http\Controllers;

use App\Models\Gestor;
use App\Models\Departamento;
use App\Models\Cargo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Notifications\WelcomeSetPassword;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class GestorController extends Controller
{
    // ============================================================
    // ---------------------- BLOCO ADMIN / RH ---------------------
    // ============================================================

    /**
     * Exibe o formulário para criar um novo gestor.
     * Carrega todos os departamentos e cargos disponíveis.
     */

    public function showAddGestor()
    {
    $departamentos = Departamento::all();
    $cargos = Cargo::all();
    $gestores = Gestor::all(); // para escolher chefe directo
    return view('admin.gestores.add-gestor', compact('departamentos', 'cargos', 'gestores'));
    }


    /**
     * Lista todos os gestores com os respectivos departamentos e cargos.
     */
    public function showManageGestor()
    {
        $gestores = Gestor::with(['departamento', 'cargo'])->get();
        return view('admin.gestores.manage-gestor', compact('gestores'));
    }
    



    /**
     * Faz o upload e processamento da imagem do gestor.
     * Usa Intervention Image v3 com o driver GD.
     */
    protected function uploadGestorImage($request)
    {
        if ($request->hasFile('foto')) {
            $gestorImage = $request->file('foto');
            $imageName = time() . '_' . $gestorImage->getClientOriginalName();

            $manager = new ImageManager(new Driver());
            $image = $manager->read($gestorImage);

            $path = 'uploads/gestores/' . $imageName;
            $fullPath = storage_path('app/public/' . $path);

            // Garante a criação da pasta
            if (!file_exists(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0755, true);
            }

            $image->save($fullPath);

            return 'storage/' . $path; // Caminho acessível publicamente
        }

        return null;
    }

    /**
     * Validação dos dados do gestor (Admin/RH).
     * 
     */

  protected function validateGestorInfo(Request $request, $id = null)
    {
        // Observação: o email pertence à tabela users, por isso use 'unique:users,email'
        return $request->validate([
            'departamento_id' => ['required','exists:departamentos,id'],
            'cargo_id' => ['required','exists:cargos,id'],
            'chefe_directo' => ['nullable','exists:gestores,id'],
            'nome' => ['required','string','max:255'],
            'sobrenome' => ['required','string','max:255'],
            'telefone' => ['required','string','max:20','unique:gestores,telefone,' . $id],
            'email' => ['required','email','max:255','unique:users,email,' . $id],
            'genero' => ['required','in:Masculino,Feminino,Outro'],
            'categoria' => ['nullable','string','max:100'],
            'data_admissao' => ['nullable','date'],
            'endereco' => ['nullable','string','max:255'],
            'estado' => ['required','in:activo,inactivo'],
        ], [
            'departamento_id.required' => 'O campo Departamento é obrigatório.',
            'departamento_id.exists' => 'O Departamento seleccionado é inválido.',
            'cargo_id.required' => 'O campo Cargo é obrigatório.',
            'nome.required' => 'O nome do Gestor é obrigatório.',
            'sobrenome.required' => 'O sobrenome é obrigatório.',
            'telefone.required' => 'O telefone é obrigatório.',
            'telefone.unique' => 'Já existe um Gestor com este número de telefone.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Por favor, introduza um e-mail válido.',
            'email.unique' => 'Este e-mail já se encontra registado.',
            'genero.required' => 'Seleccione o género do Gestor.',
            'estado.required' => 'O estado do Gestor é obrigatório.',
        ]);
    }
  

    /**
     * Criar gestor + user associado + envio token.
     */
    public function saveGestor(Request $request)
    {
        Log::info('Entrou em saveGestor', $request->only(['nome','sobrenome','email','telefone']));

        $validated = $this->validateGestorInfo($request);

        DB::beginTransaction();
        try {
            // Upload foto (opcional) — adicionar ao array validated se existir
            if ($request->hasFile('foto')) {
                $validated['foto'] = $this->uploadGestorImage($request);
            }

          
            $user = User::create([
            'name'     => "{$validated['nome']} {$validated['sobrenome']}",
            'email'    => $validated['email'],
            'password' => Hash::make(str()->random(10)),
            'role'     => 'gestor',
             ]);

            // Associar user_id ao gestor e criar gestor
            $validated['user_id'] = $user->id;

            // Criar gestor (puxa apenas os campos em fillable)
            $gestor = Gestor::create($validated);

            // Enviar link para definição de senha (ou welcome)
            $token = Password::createToken($user);
            $user->notify(new WelcomeSetPassword($token));

            DB::commit();

            return redirect()->route('admin.gestores.manage-gestor')
                ->with('success', 'Gestor criado com sucesso.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao criar gestor: ' . $e->getMessage());
            return back()->with('error', 'Erro ao criar gestor.')->withInput();
        }
    }

    /**
     * Cria um novo Gestor + User associado.
     * Usa transacção para evitar inconsistências e envia link de senha.
     */
/**public function saveGestor(Request $request)
{
    Log::info('✅ Entrou no método saveGestor', $request->all());

    $validated = $this->validateGestorInfo($request);

    DB::beginTransaction();

    try {
        // Upload da imagem (opcional)
        if ($request->hasFile('foto')) {
            $validated['foto'] = $this->uploadGestorImage($request);
        }

        // Criação do utilizador associado
        $user = User::create([
            'name'     => "{$validated['nome']} {$validated['sobrenome']}",
            'email'    => $validated['email'],
            'password' => Hash::make(str()->random(10)),
            'role'     => 'gestor',
        ]);

        // Associação user_id → gestor
        $validated['user_id'] = $user->id;

        // Criação do gestor
        $gestor = Gestor::create($validated);

        // Envio do link para definição da senha
        $token = Password::createToken($user);
        $user->notify(new WelcomeSetPassword($token));

        DB::commit();

        return redirect()
            ->route('admin.gestores.manage-gestor')
            ->with('success', '✅ Gestor criado e conta de utilizador gerada com sucesso.');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('❌ Erro ao criar gestor: ' . $e->getMessage());

        return back()
            ->with('error', 'Ocorreu um erro ao criar o gestor. Verifique os dados e tente novamente.')
            ->withInput();
        }
    }
 
    /**
 * Mostra os detalhes de um gestor específico.
 * View esperada: resources/views/admin/gestor/gestor-details.blade.php
 */
/**public function showGestorDetails($id)
{
 

    try {
        $departamentos = Departamento::all();
        $cargos = Cargo::all();
        $gestores = Gestor::all();
        $gestor = Gestor::with(['departamento', 'cargo', 'gestor'])->findOrFail($id);
        return view('admin.gestores.gestor-details', compact('departamentos', 'cargos', 'gestores'));
    } catch (\Exception $e) {
        Log::error("Erro ao carregar detalhes do gestor (ID {$id}): " . $e->getMessage());
        return redirect()->route('gestores.manage-gestor')
            ->with('error', 'Não foi possível carregar os detalhes do gestor.');
    }
}
*/
public function showGestorDetails($id)
{
    try {
        // Carrega o gestor com os relacionamentos necessários
        $gestor = Gestor::with(['departamento', 'cargo', 'chefe'])->findOrFail($id);

        // Retorna a view com os dados do gestor
        return view('admin.gestores.gestor-details', compact('gestor'));

    } catch (\Exception $e) {
        Log::error("Erro ao carregar detalhes do gestor (ID {$id}): " . $e->getMessage());

        return redirect()->route('gestores.manage-gestor')
            ->with('error', 'Não foi possível carregar os detalhes do gestor.');
    }
}

/**
 * Elimina um gestor e remove a foto associada (se existir).
 * View relacionada: resources/views/admin/gestor/manage-gestor.blade.php
 */
public function deleteGestor($id)
{
    try {
        $gestor = Gestor::findOrFail($id);

        if (!empty($gestor->foto)) {
            $fotoPath = public_path($gestor->foto);
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }

        if ($gestor->user_id && $user = User::find($gestor->user_id)) {
            $user->delete();
        }

        $gestor->delete();

        return redirect()->route('gestores.manage-gestor')
            ->with('success', 'Gestor removido com sucesso.');
    } catch (\Exception $e) {
        Log::error("Erro ao eliminar gestor (ID {$id}): " . $e->getMessage());
        return back()->with('error', 'Erro ao eliminar gestor.');
    }
}

    // ============================================================
    // ---------------------- BLOCO GESTOR -------------------------
    // ============================================================

    /**
     * Exibe o perfil do gestor autenticado.
     */
    public function showGestorProfile()
    {
        $gestor = Auth::user()->gestor;
        return view('gestor.perfil.profile', compact('gestor'));
    }

    /**
     * Exibe o formulário de edição do perfil do gestor.
     */
    public function editGestorProfile()
    {
        $gestor = Auth::user()->gestor;
        $departamentos = Departamento::all();

        return view('gestor.perfil.edit-profile', compact('gestor', 'departamentos'));
    }

    /**
     * Valida os dados de actualização do perfil do gestor.
     */
    protected function validateUpdatedGestorInfo(Request $request)
    {
        return $request->validate([
            'telefone'       => 'required|string|min:9|max:20',
            'conta_bancaria' => 'nullable|string|max:50',
            'endereco'       => 'nullable|string|max:255',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    }

    /**
     * Actualiza o perfil do gestor autenticado.
     */
    public function updateGestorProfile(Request $request)
    {
        $gestor = Auth::user()->gestor;
        $validated = $this->validateUpdatedGestorInfo($request);

        try {
            if ($path = $this->uploadGestorImage($request)) {
                if ($gestor->foto && file_exists(public_path($gestor->foto))) {
                    unlink(public_path($gestor->foto));
                }
                $validated['foto'] = $path;
            }

            $gestor->update($validated);

            return redirect()->route('gestor.perfil.profile')
                ->with('success', 'Perfil actualizado com sucesso.');
        } catch (\Exception $e) {
            Log::error('Erro ao actualizar perfil do gestor: ' . $e->getMessage());
            return back()->with('error', 'Erro ao actualizar perfil.')->withInput();
        }
    }
}