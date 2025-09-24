@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Avaliações</h1>
    <a href="{{ route('avaliacoes.create') }}" class="btn btn-primary mb-3">Nova Avaliação</a>

    @if($avaliacoes->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Funcionário</th>
                    <th>Avaliador</th>
                    <th>Data</th>
                    <th>Resultado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($avaliacoes as $avaliacao)
                <tr>
                    <td>{{ $avaliacao->funcionario->nome }}</td>
                    <td>{{ $avaliacao->avaliador->nome }}</td>
                    <td>{{ $avaliacao->created_at->format('d/m/Y') }}</td>
                    <td>{{ $avaliacao->resultado_final ?? 'Pendente' }}</td>
                    <td>
                        <a href="{{ route('avaliacoes.show', $avaliacao) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('avaliacoes.edit', $avaliacao) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('avaliacoes.destroy', $avaliacao) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirma apagar esta avaliação?')">Apagar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Nenhuma avaliação registada.</p>
    @endif
</div>
@endsection
