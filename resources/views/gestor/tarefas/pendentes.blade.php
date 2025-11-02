@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tarefas Pendentes</h3>

    <div class="card mt-3 shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Tarefa</th>
                        <th>Funcionário</th>
                        <th>Data Limite</th>
                        <th class="text-end">Acções</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tarefas as $tarefa)
                        <tr>
                            <td>{{ $tarefa->id }}</td>
                            <td>{{ $tarefa->titulo_tarefa }}</td>
                            <td>{{ $tarefa->nome }} {{ $tarefa->sobrenome }}</td>
                            <td>{{ $tarefa->data_limite ?? '—' }}</td>
                            <td class="text-end">
                                <a href="{{ route('gestor.tarefas.pending.details', $tarefa->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    @if($tarefas->isEmpty())
                        <tr><td colspan="5" class="text-center text-muted">Sem tarefas pendentes.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
