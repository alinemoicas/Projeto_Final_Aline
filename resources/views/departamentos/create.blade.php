@extends('layouts.app')

@section('content')
@php
    $label = 'block text-sm font-medium text-gray-700';
    $input = 'mt-1 block w-full rounded-md border border-gray-300 px-2.5 py-1 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500';
@endphp

<div class="max-w-3xl mx-auto mt-3 px-1">
    <h2 class="text-lg font-semibold mb-6 text-lefth">Adicionar novo departamento</h2>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded">
            <strong>Existem erros no formulário:</strong>
            <ul class="mt-2 list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('departamentos.store') }}" method="POST" novalidate>
        @csrf

        <div class="border border-gray-300 rounded-md bg-white shadow-sm overflow-hidden">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3 p-5">
                <div>
                    <label for="nome_dept" class="{{ $label }}">Nome Departamento <span class="text-red-600">*</span></label>
                    <input id="nome_dept" name="nome_dept" type="text" class="{{ $input }} @error('nome_dept') border-red-500 @enderror"
                           value="{{ old('nome_dept') }}" placeholder="Ex.: Recursos Humanos" required>
                    @error('nome_dept') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="sigla" class="{{ $label }}">Sigla <span class="text-red-600">*</span></label>
                    <input id="sigla" name="sigla" type="text" class="{{ $input }} @error('sigla') border-red-500 @enderror"
                           value="{{ old('sigla') }}" placeholder="Ex.: RH" maxlength="10" required>
                    @error('sigla') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3 p-5">
                <div>
                    <label for="chefe_dpt_id" class="{{ $label }}">Chefe de Departamento <span class="text-red-600">*</span></label>
                    <select id="chefe_dpt_id" name="chefe_dpt_id" class="{{ $input }} @error('chefe_dpt_id') border-red-500 @enderror" required>
                        <option value="">-- Selecione o Chefe --</option>
                        @foreach($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}" {{ old('chefe_dpt_id') == $funcionario->id ? 'selected' : '' }}>
                                {{ $funcionario->nome }} {{ $funcionario->sobrenome }}
                            </option>
                        @endforeach
                    </select>
                    @error('chefe_dpt_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="hidden md:block"></div>
            </div>

            <div class="p-5">
                <label for="descricao_dept" class="{{ $label }}">Descrição Departamento <span class="text-red-600">*</span></label>
                <textarea id="descricao_dept" name="descricao_dept" rows="3"
                          class="{{ $input }} @error('descricao_dept') border-red-500 @enderror"
                          placeholder="Breve descrição das funções do departamento" required>{{ old('descricao_dept') }}</textarea>
                @error('descricao_dept') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-2">
            <a href="{{ route('departamentos.index') }}"
               class="inline-block text-sm px-4 py-1.5 border border-gray-300 rounded-md bg-white hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-1 bg-green-600 text-white text-sm px-4 py-1.5 rounded-md shadow-sm hover:bg-green-700">
                Adicionar
            </button>
        </div>
    </form>
</div>
@endsection
