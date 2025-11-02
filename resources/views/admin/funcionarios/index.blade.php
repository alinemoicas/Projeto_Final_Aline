@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 mt-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Lista de Funcionários</h2>

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($funcionarios->count())
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 bg-white rounded-lg shadow-md">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Nome</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Cargo</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Departamento</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Chefe</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Estado</th>
                        <th class="px-4 py-2 text-lefth text-sm font-semibold text-gray-700">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($funcionarios as $funcionario)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2 text-gray-800">
                                {{ $funcionario->nome }} {{ $funcionario->sobrenome }}
                            </td>
                            <td class="px-4 py-2 text-gray-800">{{ $funcionario->email }}</td>
                            <td class="px-4 py-2 text-gray-800">{{ $funcionario->cargo->nome ?? $funcionario->cargo }}</td>
                            <td class="px-4 py-2 text-gray-800">{{ $funcionario->departamento->nome_dept ?? '-' }}</td>
                            <td class="px-4 py-2 text-gray-800">{{ $funcionario->chefe->nome ?? '-' }}</td>
                            <td class="px-4 py-2">
                                @if ($funcionario->estado === 'activo')
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-800">
                                        Ativo
                                    </span>
                                @else
                                    <span class="rounded-full bg-gray-200 px-3 py-1 text-xs font-medium text-gray-700">
                                        Inativo
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('funcionarios.show', $funcionario->id) }}"
                                       class="rounded bg-blue-600 px-2 py-1 text-white hover:bg-blue-700 text-sm">
                                        Ver
                                    </a>
                                    <a href="{{ route('funcionarios.edit', $funcionario->id) }}"
                                       class="rounded bg-yellow-500 px-3 py-1 text-white hover:bg-yellow-600 text-sm">
                                        Editar
                                    </a>
                                    <form action="{{ route('funcionarios.destroy', $funcionario->id) }}"
                                          method="POST" class="inline-block"
                                          onsubmit="return confirm('Tem certeza que deseja eliminar este funcionário?');">
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
    @else
        <p class="mt-6 text-gray-600">Nenhum funcionário cadastrado.</p>
    @endif
    
        <div class="mt-6">
            <a href="{{ route('funcionarios.create') }}"
               class="inline-block rounded bg-blue-600 px-4 py-2 text-white shadow hover:bg-blue-700">
                Registar novo funcionário
            </a>
        </div>
</div>

@endsection
