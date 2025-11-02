@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 mt-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Lista dos Cargos</h2>

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($cargos->count())
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 bg-white rounded-lg shadow-md">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Nome</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Descrição</th>
                        <th class="px-4 py-2 text-right text-sm font-semibold text-gray-700">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cargos as $cargo)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2 text-gray-800">{{ $cargo->nome }}</td>
                            <td class="px-4 py-2 text-gray-800">{{ $cargo->descricao }}</td>
                            <td class="px-4 py-2 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('cargos.show', $cargo->id) }}"
                                       class="rounded bg-blue-600 px-2 py-1 text-white hover:bg-blue-700 text-sm">
                                        Ver
                                    </a>
                                    <a href="{{ route('cargos.edit', $cargo->id) }}"
                                       class="rounded bg-yellow-500 px-3 py-1 text-white hover:bg-yellow-600 text-sm">
                                        Editar
                                    </a>
                                    <form action="{{ route('cargos.destroy', $cargo->id) }}" method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Tem certeza que deseja eliminar este cargo?');">
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
        <p class="mt-6 text-gray-600">Nenhum cargo cadastrado.</p>
    @endif

    <div class="mt-6">
        <a href="{{ route('cargos.create') }}"
           class="inline-block rounded bg-blue-600 px-4 py-2 text-white shadow hover:bg-blue-700">
            Criar novo cargo
        </a>
    </div>
</div>

@endsection
