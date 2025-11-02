@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-6 px-4">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Avaliações</h1>
    </div>

    @if($avaliacoes->count())
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-100 text-gray-700 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3">Funcionário</th>
                        <th class="px-6 py-3">Avaliador</th>
                        <th class="px-6 py-3">Data</th>
                        <th class="px-6 py-3">Resultado</th>
                        <th class="px-6 py-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($avaliacoes as $avaliacao)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3 font-medium">
                                {{ $avaliacao->funcionario->nome }}
                            </td>
                            <td class="px-6 py-3">
                                {{ $avaliacao->avaliador->nome ?? '—' }}
                            </td>
                            <td class="px-6 py-3">
                                {{ $avaliacao->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-3">
                                @if($avaliacao->resultado_final)
                                    <span class="px-2 py-1 rounded text-xs font-semibold 
                                        {{ $avaliacao->resultado_final >= 4 ? 'bg-green-100 text-green-700' : 
                                           ($avaliacao->resultado_final >= 3 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                        {{ $avaliacao->resultado_final }}/5
                                    </span>
                                @else
                                    <span class="text-gray-400 italic">Pendente</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-right space-x-2">
                                <a href="{{ route('avaliacoes.show', $avaliacao) }}" 
                                   class="inline-block bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1 rounded text-xs font-medium">
                                    Ver
                                </a>
                                <a href="{{ route('avaliacoes.edit', $avaliacao) }}" 
                                   class="inline-block bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-1 rounded text-xs font-medium">
                                    Editar
                                </a>
                                <form action="{{ route('avaliacoes.destroy', $avaliacao) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Confirma apagar esta avaliação?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-block bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1 rounded text-xs font-medium">
                                        Apagar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
            <p>Nenhuma avaliação registada.</p>
    @endif
    
    <div class="mt-6">
            <a href="{{ route('avaliacoes.create') }}"
               class="inline-block rounded bg-blue-600 px-4 py-2 text-white shadow hover:bg-blue-700">
                Criar Avaliação
            </a>
        </div>
</div>
@endsection
