@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 mt-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Lista de Tarefas</h2>

    <!-- Mensagem de sucesso -->
    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-700 shadow">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabela de tarefas -->
    @if($tarefas->count())
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 bg-white rounded-lg shadow-md">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Título</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Funcionário</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Estado</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Importância</th>
                        <th class="px-4 py-2 text-lefth text-sm font-semibold text-gray-700">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tarefas as $tarefa)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2 text-gray-800">{{ $tarefa->titulo_taf }}</td>
                            <td class="px-4 py-2 text-gray-800">{{ $tarefa->funcionario->nome ?? '-' }}</td>
                            <td class="px-4 py-2">
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
                            </td>
                            <td class="px-4 py-2">
                                <span class="rounded bg-gray-100 px-3 py-1 text-xs font-medium text-gray-800">
                                    {{ $tarefa->importancia_taref }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('tarefa.show', $tarefa->id) }}"
                                       class="rounded bg-blue-600 px-2 py-1 text-white hover:bg-blue-700 text-sm">
                                        Ver
                                    </a>
                                    <a href="{{ route('tarefa.edit', $tarefa->id) }}"
                                       class="rounded bg-yellow-500 px-3 py-1 text-white hover:bg-yellow-600 text-sm">
                                        Editar
                                    </a>
                                    <form action="{{ route('tarefa.destroy', $tarefa->id) }}" method="POST"
                                          onsubmit="return confirm('Confirmar eliminação?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="rounded bg-red-600 px-3 py-1 text-white hover:bg-red-700 text-sm">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Botão nova tarefa -->
        <div class="mt-6">
            <a href="{{ route('tarefa.create') }}"
               class="inline-block rounded bg-blue-600 px-4 py-2 text-white shadow hover:bg-blue-700">
                Criar tarefa nova
            </a>
        </div>
    @else
        <p class="mt-6 text-gray-600">Nenhuma tarefa cadastrada.</p>
    @endif
</div>

@endsection
