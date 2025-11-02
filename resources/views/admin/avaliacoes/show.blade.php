@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-md rounded-lg p-6">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Detalhes da Avaliação
            </h2>
            <a href="{{ route('avaliacoes.index') }}" 
               class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm rounded-lg shadow">
                Voltar
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-gray-600"><span class="font-semibold">Funcionário:</span> {{ $avaliacao->funcionario->nome }}</p>
                <p class="text-gray-600"><span class="font-semibold">Avaliador:</span> {{ $avaliacao->avaliador->nome ?? '—' }}</p>
            </div>
            <div>
                <p class="text-gray-600"><span class="font-semibold">Data:</span> {{ $avaliacao->created_at->format('d/m/Y') }}</p>
                <p class="text-gray-600"><span class="font-semibold">Resultado Final:</span> 
                    @if($avaliacao->resultado_final)
                        <span class="px-2 py-1 text-xs rounded 
                            {{ $avaliacao->resultado_final >= 4 ? 'bg-green-100 text-green-700' : 
                               ($avaliacao->resultado_final >= 3 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                            {{ $avaliacao->resultado_final }}/5
                        </span>
                    @else
                        <span class="text-gray-400 italic">Em cálculo</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Critérios e Notas</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 bg-white rounded-lg shadow-sm text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Critério</th>
                            <th class="px-4 py-2 text-left">Peso</th>
                            <th class="px-4 py-2 text-center">Nota</th>
                            <th class="px-4 py-2 text-center">Resultado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($avaliacao->avaliacaoCriterios as $ac)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $ac->criterio->nome }}</td>
                                <td class="px-4 py-2">{{ $ac->criterio->peso }}</td>
                                <td class="px-4 py-2 text-center">{{ $ac->nota }}</td>
                                <td class="px-4 py-2 text-center">{{ $ac->resultado ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 flex space-x-3">
            <a href="{{ route('avaliacoes.edit', $avaliacao->id) }}" 
               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg shadow">
                Editar
            </a>

            <form action="{{ route('avaliacoes.destroy', $avaliacao->id) }}" method="POST" 
                  onsubmit="return confirm('Tem certeza que deseja remover esta avaliação?')">
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
