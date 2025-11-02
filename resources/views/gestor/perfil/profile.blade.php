@extends('layouts.app')
@section('content')
<div class="container-fluid">

    {{-- Cabeçalho --}}
    <h3 class="mt-4">Detalhes do Gestor</h3>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('index') }}">Painel de Gestão</a></li>
        <li class="breadcrumb-item active">Perfil do Gestor</li>
    </ol>

    {{-- Corpo --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="row">

                {{-- =================== DADOS DO GESTOR =================== --}}
                <div class="col-md-8">
                    <table class="table table-bordered table-striped align-middle">
                        <tbody>
                            <tr>
                                <th width="35%">Nome Completo</th>
                                <td>{{ $gestor->nome }} {{ $gestor->sobrenome }}</td>
                            </tr>
                            <tr>
                                <th>Cargo</th>
                                <td>{{ $gestor->cargo->nome ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Departamento</th>
                                <td>{{ $gestor->departamento->nome ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Email Institucional</th>
                                <td>{{ $gestor->email }}</td>
                            </tr>
                            <tr>
                                <th>Telefone</th>
                                <td>{{ $gestor->telefone ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Data de Admissão</th>
                                <td>{{ $gestor->data_admissao ? date('d/m/Y', strtotime($gestor->data_admissao)) : '—' }}</td>
                            </tr>
                            <tr>
                                <th>Categoria</th>
                                <td>{{ ucfirst($gestor->categoria ?? 'Gestor') }}</td>
                            </tr>
                            <tr>
                                <th>Estado</th>
                                <td>
                                    <span class="badge {{ $gestor->estado == 'activo' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($gestor->estado) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Chefe Directo</th>
                                <td>{{ $gestor->chefe?->nome ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Registado em</th>
                                <td>{{ $gestor->created_at?->format('d/m/Y H:i') ?? '—' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- =================== FOTO DO GESTOR =================== --}}
                <div class="col-md-4 text-center">
                    <div class="border rounded-3 p-3 bg-light">
                        <img 
                            src="{{ $gestor->foto ? asset('storage/' . $gestor->foto) : asset('images/default-user.png') }}"
                            alt="Foto do Gestor"
                            class="rounded-circle shadow-sm mb-3"
                            width="180" height="180"
                        >
                        <h5 class="text-secondary">{{ $gestor->nome }}</h5>

                        <a href="{{ route('gestores.edit', $gestor->id) }}" 
                           class="btn btn-primary btn-sm w-100 mt-2">
                            <i class="fa fa-edit"></i> Editar Perfil
                        </a>

                        <a href="{{ route('index') }}" 
                           class="btn btn-outline-secondary btn-sm w-100 mt-2">
                            <i class="fa fa-arrow-left"></i> Voltar
                        </a>

                        @if(session('success'))
                            <div class="alert alert-success mt-3 p-2">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger mt-3 p-2">{{ session('error') }}</div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection