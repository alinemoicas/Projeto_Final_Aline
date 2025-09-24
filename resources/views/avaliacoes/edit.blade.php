@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Avaliação</h1>

    <form action="{{ route('avaliacoes.update', $avaliacao) }}" method="POST">
        @csrf
        @method('PUT')

        <h4>Critérios</h4>
        @foreach($avaliacao->avaliacaoCriterios as $ac)
            <div class="mb-2">
                <label>{{ $ac->criterio->nome }} (Peso: {{ $ac->criterio->peso }})</label>
                <input type="number" name="notas[{{ $ac->criterio->id }}]" class="form-control" value="{{ $ac->nota }}">
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
