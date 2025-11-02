@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Gestão de Tarefas</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Título</th>
                        <th>Funcionário</th>
                        <th>Departamento</th>
                        <th>Gestor</th>
                        <th>Estado</th>
                        <th class="text-end">Acções</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tarefas as $tarefa)
                        <tr>
                            <td>{{ $tarefa->id }}</td>
                            <td>{{ $tarefa->titulo_tarefa }}</td>
                            <td>{{ $tarefa->funcionario->nome ?? '—' }}</td>
                            <td>{{ $tarefa->departamento->nome_dept ?? '—' }}</td>
                            <td>{{ $tarefa->manager->nome ?? '—' }}</td>
                            <td>
                                <span class="badge bg-{{ $tarefa->estado_tarefa == 'concluída' ? 'success' : 'warning' }}">
                                    {{ ucfirst($tarefa->estado_tarefa) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('tarefas.details', $tarefa->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('tarefas.edit', $tarefa->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('tarefas.destroy', $tarefa->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Confirma eliminar esta tarefa?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if($tarefas->isEmpty())
                        <tr><td colspan="7" class="text-center text-muted">Nenhuma tarefa registada.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
