@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-6 px-4">
    <h2 class="text-lg font-semibold mb-4">Editar dados do funcionário</h2>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 text-sm">
            <strong>Existem erros no formulário:</strong>
            <ul class="mt-2 list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('funcionarios.update', $funcionario->id) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-3">

            <div>
                <label for="nome" class="block text-xs font-medium text-gray-600">
                    Nome <span class="text-red-600">*</span>
                </label>
                <input id="nome" name="nome" type="text"
                       value="{{ old('nome', $funcionario->nome) }}"
                       class="mt-1 block w-full border border-gray-300 px-3 py-2 text-sm bg-white focus:outline-none rounded-sm"
                       required>
                @error('nome') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="sobrenome" class="block text-xs font-medium text-gray-600">
                    Sobrenome <span class="text-red-600">*</span>
                </label>
                <input id="sobrenome" name="sobrenome" type="text"
                       value="{{ old('sobrenome', $funcionario->sobrenome) }}"
                       class="mt-1 block w-full border border-gray-300 px-3 py-2 text-sm bg-white focus:outline-none rounded-sm"
                       required>
                @error('sobrenome') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-medium text-gray-600">
                    E-mail <span class="text-red-600">*</span>
                </label>
                <input id="email" name="email" type="email"
                       value="{{ old('email', $funcionario->email) }}"
                       class="mt-1 block w-full border border-gray-300 px-3 py-2 text-sm bg-white focus:outline-none rounded-sm"
                       required>
                @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="telefone" class="block text-xs font-medium text-gray-600">
                    Telefone <span class="text-red-600">*</span>
                </label>
                <input id="telefone" name="telefone" type="text"
                       value="{{ old('telefone', $funcionario->telefone) }}"
                       class="mt-1 block w-full border border-gray-300 px-3 py-2 text-sm bg-white focus:outline-none rounded-sm"
                       required>
                @error('telefone') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="cargo_id" class="block text-xs font-medium text-gray-600">
                    Cargo <span class="text-red-600">*</span>
                </label>
                <select id="cargo_id" name="cargo_id"
                        class="mt-1 block w-full border border-gray-300 px-3 py-2 text-sm bg-white focus:outline-none rounded-sm"
                        required>
                    <option value="">-- Seleccione --</option>
                    @foreach ($cargos as $cargo)
                        <option value="{{ $cargo->id }}"
                            {{ old('cargo_id', $funcionario->cargo_id) == $cargo->id ? 'selected' : '' }}>
                            {{ $cargo->nome }}
                        </option>
                    @endforeach
                </select>
                @error('cargo_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="categoria" class="block text-xs font-medium text-gray-600">Categoria</label>
                <input id="categoria" name="categoria" type="text"
                       value="{{ old('categoria', $funcionario->categoria) }}"
                       class="mt-1 block w-full border border-gray-300 px-3 py-2 text-sm bg-white focus:outline-none rounded-sm">
                @error('categoria') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="dept_id" class="block text-xs font-medium text-gray-600">
                    Departamento <span class="text-red-600">*</span>
                </label>
                <select id="dept_id" name="dept_id"
                        class="mt-1 block w-full border border-gray-300 px-3 py-2 text-sm bg-white focus:outline-none rounded-sm"
                        required>
                    <option value="">-- Seleccione --</option>
                    @foreach ($departamentos as $departamento)
                        <option value="{{ $departamento->id }}"
                            {{ old('dept_id', $funcionario->dept_id) == $departamento->id ? 'selected' : '' }}>
                            {{ $departamento->nome_dept }}
                        </option>
                    @endforeach
                </select>
                @error('dept_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="data_admissao" class="block text-xs font-medium text-gray-600">Data de Admissão</label>
                <input id="data_admissao" name="data_admissao" type="date"
                       value="{{ old('data_admissao', $funcionario->data_admissao) }}"
                       class="mt-1 block w-full border border-gray-300 px-3 py-2 text-sm bg-white focus:outline-none rounded-sm">
                @error('data_admissao') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="chefe_id" class="block text-xs font-medium text-gray-600">Chefe Imediato</label>
                <select id="chefe_id" name="chefe_id"
                        class="mt-1 block w-full border border-gray-300 px-3 py-2 text-sm bg-white focus:outline-none rounded-sm">
                    <option value="">-- Nenhum --</option>
                    @foreach ($funcionarios as $chefe)
                        <option value="{{ $chefe->id }}"
                            {{ old('chefe_id', $funcionario->chefe_id) == $chefe->id ? 'selected' : '' }}>
                            {{ $chefe->nome }} {{ $chefe->sobrenome }}
                        </option>
                    @endforeach
                </select>
                @error('chefe_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="estado" class="block text-xs font-medium text-gray-600">
                    Estado <span class="text-red-600">*</span>
                </label>
                <select id="estado" name="estado"
                        class="mt-1 block w-full border border-gray-300 px-3 py-2 text-sm bg-white focus:outline-none rounded-sm"
                        required>
                    <option value="activo" {{ old('estado', $funcionario->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ old('estado', $funcionario->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
                @error('estado') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-4 flex justify-end gap-2">
            <a href="{{ route('funcionarios.index') }}"
               class="inline-block text-sm px-4 py-2 border border-gray-300 rounded-sm bg-white hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit"
                    class="inline-block bg-blue-600 text-white text-sm px-4 py-2 rounded-sm hover:bg-blue-700">
                Atualizar
            </button>
        </div>
    </form>
</div>
@endsection
