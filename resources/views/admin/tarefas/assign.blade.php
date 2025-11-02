@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Atribuir Tarefa: {{ $tarefa->titulo_tarefa }}</h3>

    <form action="{{ route('tarefas.assign.store') }}" method="POST" class="mt-3">
        @csrf
        <input type="hidden" name="tarefa_id" value="{{ $tarefa->id }}">

        <div class="mb-3">
            <label class="form-label">Funcionário</label>
            <select name="funcionario_id" class="form-select" required>
                <option value="">Selecione</option>
                @foreach($funcionarios as $funcionario)
                    <option value="{{ $funcionario->id }}">
                        {{ $funcionario->nome }} {{ $funcionario->sobrenome }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success"><i class="bi bi-check2-square"></i> Atribuir</button>
        <a href="{{ route('gestor.tarefas.new') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
