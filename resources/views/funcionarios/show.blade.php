@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Card -->
    <div class="bg-white shadow-md rounded-lg p-6">
        
        <!-- Cabeçalho -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Dados do Funcionário
            </h2>
            <a href="{{ route('funcionarios.index') }}" 
               class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm rounded-lg shadow">
                Voltar
            </a>
        </div>

        <!-- Informações -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-gray-600"><span class="font-semibold">Nome:</span> {{ $funcionarios->nome }} {{ $funcionarios->sobrenome }}</p><br>
                <p class="text-gray-600"><span class="font-semibold">Email:</span> {{ $funcionarios->email }}</p><br>
                <p class="text-gray-600"><span class="font-semibold">Telefone:</span> {{ $funcionarios->telefone }}</p><br>
                <p class="text-gray-600"><span class="font-semibold">Categoria:</span> {{ $funcionarios->categoria }}</p><br>
            </div>
            <div>
                <p class="text-gray-600"><span class="font-semibold">Cargo:</span> {{ $funcionarios->cargo->nome ?? '—' }}</p><br>
                <p class="text-gray-600"><span class="font-semibold">Departamento:</span> {{ $funcionarios->departamento->nome ?? '—' }}</p><br>
                <p class="text-gray-600"><span class="font-semibold">Chefe:</span> {{ $funcionarios->chefe->nome ?? '—' }}</p><br>
                <p class="text-gray-600"><span class="font-semibold">Estado:</span> 
                    <span class="px-2 py-1 text-xs rounded {{ $funcionarios->estado === 'activo' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst($funcionarios->estado) }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Datas -->
        <div class="mt-6">
            <p class="text-gray-600"><span class="font-semibold">Data de Admissão:</span> {{ $funcionarios->data_admissao ?? '—' }}</p>
        </div>

        <!-- Ações -->
        <div class="mt-8 flex space-x-3">
            <a href="{{ route('funcionarios.edit', $funcionarios->id) }}" 
               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg shadow">
                Editar
            </a>

            <form action="{{ route('funcionarios.destroy', $funcionarios->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover este funcionário?')">
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
