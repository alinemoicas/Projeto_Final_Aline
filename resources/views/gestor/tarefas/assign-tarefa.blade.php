@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white rounded-2xl shadow-md overflow-hidden" x-data="{ sending:false }">
    {{-- Cabeçalho --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex items-center justify-between">
        <h2 class="text-white text-xl font-semibold flex items-center gap-2">
            <i class="bi bi-person-check-fill text-lg"></i>
            Atribuir Tarefa
        </h2>
        <a href="{{ route('gestores.tarefas.new') }}"
           class="text-white bg-white/20 hover:bg-white/30 px-3 py-1 rounded-lg text-sm transition-all">
            <i class="bi bi-arrow-left-circle"></i> Voltar
        </a>
    </div>

    {{-- Corpo --}}
    <div class="p-6">
        {{-- Alerts de sessão --}}
        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 border border-green-200 p-4 text-green-800">
                {{ session('success') }}
            </div>
        @endif
        @if(session('warning'))
            <div class="mb-4 rounded-lg bg-yellow-100 border border-yellow-200 p-4 text-yellow-800">
                {{ session('warning') }}
            </div>
        @endif

        {{-- Mensagens de erro globais --}}
        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-100 border border-red-200 p-4 text-red-700">
                <strong>⚠️ Foram encontrados erros:</strong>
                <ul class="mt-1 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Cabeçalho da tarefa --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800">
                {{ $tarefa->titulo_tarefa }}
            </h3>
            <p class="text-sm text-gray-600 mt-1">
                {{-- suporta ambos os nomes de coluna --}}
                {{ $tarefa->descricao_tarefa ?? $tarefa->descricao_taf ?? 'Sem descrição disponível.' }}
            </p>
            <div class="mt-2 text-xs text-gray-500">
                <span class="inline-flex items-center gap-1">
                    <i class="bi bi-diagram-3"></i>
                    Departamento: {{ $tarefa->departamento->nome_dept ?? '—' }}
                </span>
                <span class="inline-flex items-center gap-1 ml-4">
                    <i class="bi bi-flag"></i>
                    Estado: {{ ucfirst($tarefa->estado_tarefa ?? 'pendente') }}
                </span>
            </div>
        </div>

        {{-- Formulário --}}
        <form action="{{ route('gestores.tarefas.atribuir.salvar') }}" method="POST" class="space-y-6" x-on:submit="sending=true">
            @csrf
            <input type="hidden" name="tarefa_id" value="{{ $tarefa->id }}">

            {{-- Selecionar Funcionário --}}
            <div>
                <label for="funcionario_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Funcionário Responsável <span class="text-red-500">*</span>
                </label>

                <select id="funcionario_id" name="funcionario_id" required
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition">
                    <option value="">-- Selecione um funcionário --</option>
                    @forelse($funcionarios as $funcionario)
                        <option value="{{ $funcionario->id }}" @selected(old('funcionario_id') == $funcionario->id)>
                            {{ $funcionario->nome }} {{ $funcionario->sobrenome }}
                        </option>
                    @empty
                        <option value="" disabled>Não há funcionários disponíveis para este departamento</option>
                    @endforelse
                </select>

                @error('funcionario_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botões --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('gestores.tarefas.new') }}"
                   class="inline-flex items-center gap-1 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 text-sm font-medium transition">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>

                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-green-600 hover:bg-green-700 text-white px-5 py-2 text-sm font-medium shadow transition disabled:opacity-60"
                        :disabled="sending || {{ $funcionarios->count() ? 'false' : 'true' }}">
                    <i class="bi bi-check2-square"></i>
                    <span x-show="!sending">Atribuir Tarefa</span>
                    <span x-show="sending">A atribuir…</span>
                </button>
            </div>
        </form>

        {{-- Dica se lista estiver vazia --}}
        @if($funcionarios->isEmpty())
            <div class="mt-4 rounded-lg bg-yellow-50 border border-yellow-200 p-4 text-yellow-800 text-sm">
                Não há funcionários disponíveis neste departamento. Verifique se existem funcionários ativos com
                <code>dept_id = {{ $tarefa->departamento_id }}</code>.
            </div>
        @endif
    </div>
</div>
@endsection
