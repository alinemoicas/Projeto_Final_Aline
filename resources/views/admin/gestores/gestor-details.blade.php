@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-8 px-4">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Detalhes do Gestor</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <p><strong>Nome:</strong> {{ $gestor->nome }} {{ $gestor->sobrenome }}</p>
            <p><strong>Email:</strong> {{ $gestor->email }}</p>
            <p><strong>Telefone:</strong> {{ $gestor->telefone }}</p>
            <p><strong>Departamento:</strong> {{ $gestor->departamento->nome_dept ?? '-' }}</p>
            <p><strong>Cargo:</strong> {{ $gestor->cargo->nome ?? '-' }}</p>
            <p><strong>Estado:</strong> {{ ucfirst($gestor->estado) }}</p>
        </div>

        @if($gestor->foto)
            <div class="mt-4">
                <img src="{{ asset($gestor->foto) }}" alt="Foto do Gestor"
                     class="w-32 h-32 object-cover rounded-full shadow">
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('gestores.index') }}" class="bg-gray-200 px-4 py-2 rounded">Voltar</a>
        </div>
    </div>
</div>
@endsection
