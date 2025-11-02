@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">
    <div class="bg-white shadow-md rounded-lg p-6 relative">
    
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 text-left">
                Perfil do Funcionário
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-gray-600"><span class="font-semibold">Nome:</span> {{ auth()->user()->funcionario->nome ?? '' }} {{ auth()->user()->funcionario->sobrenome ?? '' }}</p><br>
                <p class="text-gray-600"><span class="font-semibold">Email:</span> {{ auth()->user()->email }}</p><br>
                <p class="text-gray-600"><span class="font-semibold">Telefone:</span> {{ auth()->user()->funcionario->telefone ?? '—' }}</p><br>
                <p class="text-gray-600"><span class="font-semibold">Categoria:</span> {{ auth()->user()->funcionario->categoria ?? '—' }}</p><br>
                <p class="text-gray-600"><span class="font-semibold">Data de Admissão:</span> {{ auth()->user()->funcionario->data_admissao ?? '—' }}</p>
            </div>
            <div>
                <p class="text-gray-600"><span class="font-semibold">Cargo:</span> {{ auth()->user()->funcionario->cargo->nome ?? '—' }}</p><br>
                <p class="text-gray-600"><span class="font-semibold">Departamento:</span> {{ auth()->user()->funcionario->departamento->nome_dept ?? '—' }}</p><br>
                <p class="text-gray-600"><span class="font-semibold">Chefe:</span> {{ auth()->user()->funcionario->chefe->nome ?? '—' }}</p><br>
                <p class="text-gray-600"><span class="font-semibold">Estado:</span> 
                    <span class="px-2 py-1 text-xs rounded {{ auth()->user()->funcionario->estado === 'activo' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst(auth()->user()->funcionario->estado ?? '—') }}
                    </span>
                </p>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg shadow">
                    Sair
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
