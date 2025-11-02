@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 mt-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Lista de Departamentos</h2>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if($departamentos->count())
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 bg-white rounded-lg shadow-md">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">#</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Nome</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Sigla</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Chefe</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Criado em</th>
                        <th class="px-4 py-2 text-lefth text-sm font-semibold text-gray-700">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departamentos as $departamento)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2 text-gray-800">{{ $departamento->id }}</td>
                            <td class="px-4 py-2 text-gray-800">{{ $departamento->nome_dept }}</td>
                            <td class="px-4 py-2 text-gray-800">{{ $departamento->sigla }}</td>
                            <td class="px-4 py-2 text-gray-800">
                                @if($departamento->chefe)
                                    {{ $departamento->chefe->nome }} {{ $departamento->chefe->sobrenome }}
                                @else
                                    <span class="text-gray-500">Não definido</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-gray-800">
                                {{ optional($departamento->created_at)->format('d/m/Y') ?? '-' }}
                            </td>
                            <td class="px-4 py-2 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('departamentos.show', $departamento) }}"
                                       class="rounded bg-blue-600 px-2 py-1 text-white hover:bg-blue-700 text-sm">
                                        Ver
                                    </a>
                                    <a href="{{ route('departamentos.edit', $departamento) }}"
                                       class="rounded bg-yellow-500 px-3 py-1 text-white hover:bg-yellow-600 text-sm">
                                        Editar
                                    </a>
                                    <form action="{{ route('departamentos.destroy', $departamento) }}"
                                          method="POST" class="inline-block"
                                          onsubmit="return confirm('Tem certeza que deseja eliminar este departamento?');">
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
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                Nenhum departamento registado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($departamentos, 'links'))
            <div class="mt-4 flex justify-between items-center">
                <div class="text-gray-600">Total: {{ $departamentos->total() }}</div>
                <div>
                    {{ $departamentos->withQueryString()->links() }}
                </div>
            </div>
        @endif
    @else
        <p class="mt-6 text-gray-600">Nenhum departamento registado.</p>
    @endif
    <div class="mt-6">
            <a href="{{ route('departamentos.create') }}"
               class="inline-block rounded bg-blue-600 px-4 py-2 text-white shadow hover:bg-blue-700">
                Criar novo departamento
            </a>
        </div>
</div>
@endsection
