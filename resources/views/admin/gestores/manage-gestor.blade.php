@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-8 px-4">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Gestores</h2>

    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-300 text-green-700 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('gestores.add-gestor') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            ➕ Novo Gestor
        </a>
    </div>

    @if($gestores->count())
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                    <tr>
                        <th class="px-4 py-2 text-left">Nome</th>
                        <th class="px-4 py-2 text-left">Departamento</th>
                        <th class="px-4 py-2 text-left">Cargo</th>
                        <th class="px-4 py-2 text-left">Telefone</th>
                        <th class="px-4 py-2 text-left">Estado</th>
                        <th class="px-4 py-2 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gestores as $gestor)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $gestor->nome }} {{ $gestor->sobrenome }}</td>
                            <td class="px-4 py-2">{{ $gestor->departamento->nome_dept ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $gestor->cargo->nome ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $gestor->telefone }}</td>
                            <td class="px-4 py-2">
                                @if($gestor->estado === 'activo')
                                    <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">Ativo</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded bg-gray-200 text-gray-700">Inativo</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-right space-x-2">
                                <a href="{{ route('gestores.gestor-details', $gestor->id) }}"
                                   class="text-blue-600 hover:underline">Ver</a>
                                <form action="{{ route('gestores.destroy', $gestor->id) }}" method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Deseja realmente eliminar este gestor?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-600 mt-4">Nenhum gestor registado.</p>
    @endif
</div>
@endsection
