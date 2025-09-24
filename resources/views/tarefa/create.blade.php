@extends('layouts.app')

@section('content')
@php
    $label = 'block text-sm font-medium text-gray-700';
    $input = 'mt-1 block w-full rounded-md border border-gray-300 px-2.5 py-1 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500';
@endphp

<div class="max-w-4xl mx-auto mt-6 px-2">
    <h2 class="text-lg font-semibold mb-6 text-left">➕ Criar Nova Tarefa</h2>

    {{-- Erros de validação --}}
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

    <form method="POST" action="{{ route('tarefa.store') }}" novalidate>
        @csrf

        {{-- Card --}}
        <div class="border border-gray-300 rounded-md bg-white shadow-sm overflow-hidden">
            
            {{-- Linha 1: Funcionário / Título --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3 p-5">
                <div>
                    <label for="funcionario_id" class="{{ $label }}">Funcionário <span class="text-red-600">*</span></label>
                    <select id="funcionario_id" name="funcionario_id" class="{{ $input }}" required>
                        <option value="">-- Selecione --</option>
                        @foreach($funcionarios as $f)
                            <option value="{{ $f->id }}" {{ old('funcionario_id') == $f->id ? 'selected' : '' }}>
                                {{ $f->nome }} {{ $f->sobrenome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="titulo_taf" class="{{ $label }}">Título <span class="text-red-600">*</span></label>
                    <input id="titulo_taf" name="titulo_taf" type="text" class="{{ $input }}" 
                           value="{{ old('titulo_taf') }}" placeholder="Ex.: Relatório de Desempenho" required>
                </div>
            </div>

            {{-- Linha 2: Descrição --}}
            <div class="p-5">
                <label for="descricao_taf" class="{{ $label }}">Descrição</label>
                <textarea id="descricao_taf" name="descricao_taf" rows="3" class="{{ $input }}" 
                          placeholder="Detalhes da tarefa...">{{ old('descricao_taf') }}</textarea>
            </div>

            {{-- Linha 3: Datas --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3 p-5">
                <div>
                    <label for="data_inicio" class="{{ $label }}">Data Início <span class="text-red-600">*</span></label>
                    <input id="data_inicio" name="data_inicio" type="date" class="{{ $input }}" 
                           value="{{ old('data_inicio') }}" required>
                </div>
                <div>
                    <label for="data_fim" class="{{ $label }}">Data Fim</label>
                    <input id="data_fim" name="data_fim" type="date" class="{{ $input }}" 
                           value="{{ old('data_fim') }}">
                </div>
            </div>

            {{-- Linha 4: Importância / Estado --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3 p-5">
                <div>
                    <label for="importancia_taref" class="{{ $label }}">Importância (1-5) <span class="text-red-600">*</span></label>
                    <input id="importancia_taref" name="importancia_taref" type="number" min="1" max="5" class="{{ $input }}" 
                           value="{{ old('importancia_taref') }}" required>
                </div>
                <div>
                    <label for="estado_tarefa" class="{{ $label }}">Estado <span class="text-red-600">*</span></label>
                    <select id="estado_tarefa" name="estado_tarefa" class="{{ $input }}" required>
                        <option value="pendente" {{ old('estado_tarefa') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="em andamento" {{ old('estado_tarefa') == 'em andamento' ? 'selected' : '' }}>Em andamento</option>
                        <option value="concluída" {{ old('estado_tarefa') == 'concluída' ? 'selected' : '' }}>Concluída</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Botões --}}
        <div class="mt-6 flex justify-end gap-2">
            <a href="{{ route('tarefa.index') }}"
               class="inline-block text-sm px-4 py-1.5 border border-gray-300 rounded-md bg-white hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-1 bg-green-600 text-white text-sm px-4 py-1.5 rounded-md shadow-sm hover:bg-green-700">
                💾 Salvar
            </button>
        </div>
    </form>
</div>
@endsection
