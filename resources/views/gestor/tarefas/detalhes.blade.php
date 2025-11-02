@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Detalhes da Tarefa</h3>
    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <h5 class="card-title">{{ $tarefa->titulo_tarefa }}</h5>
            <p class="card-text">{{ $tarefa->descricao_taf ?? 'Sem descrição' }}</p>

            <ul class="list-group mb-3">
                <li class="list-group-item"><strong>Funcionário:</strong> {{ $tarefa->funcionario->nome ?? '—' }}</li>
                <li class="list-group-item"><strong>Departamento:</strong> {{ $tarefa->departamento->nome_dept ?? '—' }}</li>
                <li class="list-group-item"><strong>Gestor:</strong> {{ $tarefa->manager->nome ?? '—' }}</li>
                <li class="list-group-item"><strong>Estado:</strong> {{ ucfirst($tarefa->estado_tarefa) }}</li>
                <li class="list-group-item"><strong>Data limite:</strong> {{ $tarefa->data_limite ?? '—' }}</li>
            </ul>

            <a href="{{ route('tarefas.manage') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>
</div>
@endsection
