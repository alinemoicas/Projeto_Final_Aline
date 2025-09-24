@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalhes da Avaliação</h1>

    <p><strong>Funcionário:</strong> {{ $avaliacao->funcionario->nome }}</p>
    <p><strong>Avaliador:</strong> {{ $avaliacao->avaliador->nome }}</p>
    <p><strong>Data:</strong> {{ $avaliacao->created_at->format('d/m/Y') }}</p>

    <h4>Critérios e Notas</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Critério</th>
                <th>Peso</th>
                <th>Nota</th>
                <th>Resultado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($avaliacao->avaliacaoCriterios as $ac)
            <tr>
                <td>{{ $ac->criterio->nome }}</td>
                <td>{{ $ac->criterio->peso }}</td>
                <td>{{ $ac->nota }}</td>
                <td>{{ $ac->resultado }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Resultado Final: {{ $avaliacao->resultado_final ?? 'Em cálculo' }}</h4>
</div>
@endsection
