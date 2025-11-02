@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-md rounded-lg p-6">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Detalhes da Tarefa
            </h2>
            <a href="{{ route('tarefas.index') }}" 
               class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm rounded-lg shadow">
                Voltar
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-gray-600"><span class="font-semibold">Título:</span> {{ $tarefa->titulo_taf }}</p>
                <p class="text-gray-600"><span class="font-semibold">Funcionário:</span> {{ $tarefa->funcionario->nome ?? '—' }}</p>
                <p class="text-gray-600"><span class="font-semibold">Data Início:</span> {{ $tarefa->data_inicio }}</p>
                <p class="text-gray-600"><span class="font-semibold">Data Fim:</span> {{ $tarefa->data_fim ?? '—' }}</p>
            </div>
            <div>
                <p class="text-gray-600"><span class="font-semibold">Importância:</span> 
                    <span class="rounded bg-gray-100 px-2 py-1 text-xs font-medium text-gray-800">
                        {{ $tarefa->importancia_taref }}
                    </span>
                </p>
                <p class="text-gray-600"><span class="font-semibold">Estado:</span> 
                    @if ($tarefa->estado_tarefa === 'pendente')
                        <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-800">
                            Pendente
                        </span>
                    @elseif ($tarefa->estado_tarefa === 'em andamento')
                        <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-800">
                            Em Andamento
                        </span>
                    @else
                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-800">
                            Concluída
                        </span>
                    @endif
                </p>
                <p class="text-gray-600"><span class="font-semibold">Criada em:</span> {{ $tarefa->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <!-- Descrição -->
        <div class="mt-6">
            <p class="text-gray-600 font-semibold">Descrição:</p>
            <p class="mt-2 text-gray-700 bg-gray-50 border border-gray-200 rounded-md p-3">
                {{ $tarefa->descricao_taf ?? '—' }}
            </p>
        </div>

        <!-- Ações -->
        <div class="mt-8 flex space-x-3">
            <a href="{{ route('tarefas.edit', $tarefa->id) }}" 
               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg shadow">
                Editar
            </a>

            <form action="{{ route('tarefas.destroy', $tarefa->id) }}" method="POST" 
                  onsubmit="return confirm('Tem certeza que deseja remover esta tarefa?')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-lg shadow">
                    Remover
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
