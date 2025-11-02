@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-8 px-4">
    <h2 class="text-xl font-semibold mb-6">Adicionar Novo Gestor</h2>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded">
            <strong>Foram encontrados erros no formulário:</strong>
            <ul class="mt-2 list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('gestores.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white shadow rounded-lg p-6 grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block text-sm font-medium text-gray-700">Nome</label>
                <input type="text" name="nome" value="{{ old('nome') }}" required
                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Sobrenome</label>
                <input type="text" name="sobrenome" value="{{ old('sobrenome') }}" required
                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Telefone</label>
                <input type="text" name="telefone" value="{{ old('telefone') }}" required
                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Departamento</label>
                <select name="departamento_id" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Selecione</option>
                    @foreach($departamentos as $d)
                        <option value="{{ $d->id }}" {{ old('departamento_id') == $d->id ? 'selected' : '' }}>
                            {{ $d->nome_dept ?? $d->nome ?? $d->department_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Cargo</label>
                <select name="cargo_id" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Selecione</option>
                    @foreach($cargos as $c)
                        <option value="{{ $c->id }}" {{ old('cargo_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- chefe_directo --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Chefe Directo (opcional)</label>
                <select name="chefe_directo" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">-- Nenhum --</option>
                    @foreach($gestores ?? [] as $g) {{-- certifique-se que controller fornece $gestores --}}
                        <option value="{{ $g->id }}" {{ old('chefe_directo') == $g->id ? 'selected' : '' }}>
                            {{ $g->nome }} {{ $g->sobrenome }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- categoria --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Categoria</label>
                <input type="text" name="categoria" value="{{ old('categoria') }}"
                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Género</label>
                <select name="genero" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Selecione</option>
                    <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="Feminino" {{ old('genero') == 'Feminino' ? 'selected' : '' }}>Feminino</option>
                    <option value="Outro" {{ old('genero') == 'Outro' ? 'selected' : '' }}>Outro</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Data de Admissão</label>
                <input type="date" name="data_admissao" value="{{ old('data_admissao') }}"
                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Estado</label>
                <select name="estado" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Selecione</option>
                    <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700">Endereço</label>
                <input type="text" name="endereco" value="{{ old('endereco') }}"
                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700">Foto (opcional)</label>
                <input type="file" name="foto" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('gestores.manage-gestor') }}" class="bg-gray-200 px-4 py-2 rounded">Cancelar</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Salvar</button>
        </div>
    </form>
</div>
@endsection 