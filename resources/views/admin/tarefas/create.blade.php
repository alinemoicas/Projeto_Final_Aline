@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Criar Nova Tarefa</h2>

    {{-- Erros de validação --}}
    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-100 border border-red-300 p-4 text-red-700">
            <strong>Foram encontrados erros:</strong>
            <ul class="list-disc pl-5 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tarefas.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf

        {{-- Título --}}
        <div class="mb-4">
            <label for="titulo" class="block text-gray-700 font-medium mb-1">Título da Tarefa</label>
            <input type="text" name="titulo" id="titulo"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                   value="{{ old('titulo') }}" placeholder="Ex: Avaliar desempenho mensal" required>
        </div>

        {{-- Descrição --}}
        <div class="mb-4">
            <label for="descricao" class="block text-gray-700 font-medium mb-1">Descrição</label>
            <textarea name="descricao" id="descricao" rows="4"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                      placeholder="Descreva os objetivos e detalhes da tarefa..." required>{{ old('descricao') }}</textarea>
        </div>

        {{-- Departamento --}}
        <div class="mb-4">
            <label for="departamento_id" class="block text-gray-700 font-medium mb-1">Departamento</label>
            <select name="departamento_id" id="departamento_id"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                    required>
                <option value="">-- Selecione o Departamento --</option>
                @foreach($departamentos as $departamento)
                    <option value="{{ $departamento->id }}" {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
                        {{ $departamento->nome_dept }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Gestor responsável (via AJAX) --}}
        <div class="mb-4">
            <label for="gestor_id" class="block text-gray-700 font-medium mb-1">Gestor Responsável</label>
            <select name="gestor_id" id="gestor_id"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                    required>
                <option value="">-- Selecione um departamento primeiro --</option>
            </select>
        </div>

        {{-- Dias para completar (REQUERIDO pelo Request) --}}
        <div class="mb-4">
            <label for="dias_para_completar" class="block text-gray-700 font-medium mb-1">Dias para Completar</label>
            <input type="number" min="1" name="dias_para_completar" id="dias_para_completar"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                   value="{{ old('dias_para_completar') }}" placeholder="Ex: 7" required>
        </div>

        {{-- Número de nível (REQUERIDO pelo Request) --}}
        <div class="mb-6">
            <label for="numero_de_nivel" class="block text-gray-700 font-medium mb-1">Número de Nível</label>
            <input type="number" min="1" name="numero_de_nivel" id="numero_de_nivel"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                   value="{{ old('numero_de_nivel') }}" placeholder="Ex: 1" required>
        </div>

        {{-- Data limite --}}
        <div class="mb-6">
            <label for="data_limite" class="block text-gray-700 font-medium mb-1">Data Limite</label>
            <input type="date" name="data_limite" id="data_limite"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                   value="{{ old('data_limite') }}" required>
        </div>

        {{-- Botões --}}
        <div class="flex justify-end space-x-3">
            <a href="{{ route('tarefas.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                Cancelar
            </a>
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Guardar Tarefa
            </button>
        </div>
    </form>
</div>

{{-- AJAX para carregar gestores e repovoar após validação --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const departamentoSelect = document.getElementById('departamento_id');
    const gestorSelect = document.getElementById('gestor_id');
    const oldDepartamento = "{{ old('departamento_id') }}";
    const oldGestor = "{{ old('gestor_id') }}";

    function carregarGestores(departamentoId, selectedId = null) {
        gestorSelect.innerHTML = '<option>Carregando...</option>';

        fetch("{{ route('tarefas.managers', ['departamentoId' => '__ID__']) }}".replace('__ID__', departamentoId))
            .then(response => response.json())
            .then(data => {
                gestorSelect.innerHTML = '<option value="">-- Selecione o Gestor --</option>';

                if (!Array.isArray(data) || data.length === 0) {
                    gestorSelect.innerHTML = '<option value="">Nenhum gestor encontrado</option>';
                    return;
                }

                data.forEach(gestor => {
                    const option = document.createElement('option');
                    option.value = gestor.id;
                    option.textContent = `${gestor.nome} ${gestor.sobrenome}`;
                    if (selectedId && String(selectedId) === String(gestor.id)) {
                        option.selected = true;
                    }
                    gestorSelect.appendChild(option);
                });
            })
            .catch(() => {
                gestorSelect.innerHTML = '<option value="">Erro ao carregar gestores</option>';
            });
    }

    // Ao mudar o Departamento
    departamentoSelect.addEventListener('change', function() {
        const id = this.value;
        if (id) {
            carregarGestores(id);
        } else {
            gestorSelect.innerHTML = '<option value="">-- Selecione um departamento primeiro --</option>';
        }
    });

    // Se veio de validação com valores antigos, repovoar
    if (oldDepartamento) {
        carregarGestores(oldDepartamento, oldGestor);
    }
});
</script>
@endsection
