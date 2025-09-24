@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nova Avaliação</h1>

    <form action="{{ route('avaliacoes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="funcionario_id" class="form-label">Funcionário</label>
            <select name="funcionario_id" id="funcionario_id" class="form-select">
                @foreach($funcionarios as $funcionario)
                    <option value="{{ $funcionario->id }}">{{ $funcionario->nome }}</option>
                @endforeach
            </select>
        </div>

        <h4>Critérios</h4>
        @foreach($criterios as $criterio)
            <div class="mb-2">
                <label>{{ $criterio->nome }} (Peso: {{ $criterio->peso }})</label>
                <input type="number" name="notas[{{ $criterio->id }}]" class="form-control" placeholder="Nota de 0 a 10">
            </div>
        @endforeach

        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
</div>
@endsection

