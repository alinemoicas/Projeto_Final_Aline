@extends('layouts.app')

@section('content')
@php
    $label = 'block text-sm font-medium text-gray-700';
    $input = 'mt-1 block w-full rounded-md border border-gray-300 px-2.5 py-1 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500';
@endphp

<div class="max-w-3xl mx-auto mt-3 px-1">
    <h2 class="text-lg font-semibold mb-6 text-left">Editar Cargo</h2>

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

    <form method="POST" action="{{ route('cargo.update', $cargo->id) }}" novalidate>
        @csrf
        @method('PUT')

        <div class="border border-gray-300 rounded-md bg-white shadow-sm overflow-hidden">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3 p-5">
                <div>
                    <label for="nome" class="{{ $label }}">Nome do Cargo <span class="text-red-600">*</span></label>
                    <input id="nome" name="nome" type="text"
                           class="{{ $input }} @error('nome') border-red-500 @enderror"
                           value="{{ old('nome', $cargo->nome) }}" placeholder="Ex.: Analista de RH" required>
                    @error('nome') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="p-5">
                <label for="descricao" class="{{ $label }}">Descrição do Cargo <span class="text-red-600">*</span></label>
                <textarea id="descricao" name="descricao" rows="3"
                          class="{{ $input }} @error('descricao') border-red-500 @enderror"
                          placeholder="Breve descrição das funções do cargo" required>{{ old('descricao', $cargo->descricao) }}</textarea>
                @error('descricao') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-2">
            <a href="{{ route('cargo.index') }}"
               class="inline-block text-sm px-4 py-1.5 border border-gray-300 rounded-md bg-white hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-1 bg-blue-600 text-white text-sm px-4 py-1.5 rounded-md shadow-sm hover:bg-green-700">
                Actualizar
            </button>
        </div>
    </form>
</div>
@endsection
