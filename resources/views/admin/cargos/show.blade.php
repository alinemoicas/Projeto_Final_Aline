@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-md rounded-lg p-6">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Detalhe do Cargo
            </h2>
            <a href="{{ route('cargos.index') }}" 
               class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm rounded-lg shadow">
                Voltar
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-gray-600"><span class="font-semibold">Nome:</span> {{ $cargo->nome }}</p>
            </div>
        </div>

        <div class="mt-6">
            <p class="text-gray-600"><span class="font-semibold">Descrição:</span></p>
            <p class="mt-2 text-gray-700 bg-gray-50 border border-gray-200 rounded-md p-3">
                {{ $cargo->descricao ?? '—' }}
            </p>
        </div>

        <div class="mt-8 flex space-x-3">
            <a href="{{ route('cargos.edit', $cargo->id) }}" 
               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg shadow">
                Editar
            </a>

            <form action="{{ route('cargos.destroy', $cargo->id) }}" method="POST" 
                  onsubmit="return confirm('Tem certeza que deseja remover este cargo?')">
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
