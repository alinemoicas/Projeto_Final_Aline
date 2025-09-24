<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MetricFlow') }}</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    {{-- CSS personalizado --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
    <div id="app" class="d-flex flex-grow-1">

        {{-- Sidebar --}}
        <nav id="sidebar" class="bg-dark text-light p-3">
            <div class="d-flex align-items-center mb-4">
                <i class="bi bi-graph-up-arrow fs-4 me-2 text-primary"></i>
                <span class="fw-bold fs-5">MetricFlow</span>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" 
                       class="nav-link text-light {{ request()->routeIs('dashboard') ? 'active bg-primary' : '' }}">
                        <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('funcionarios.index') }}" 
                       class="nav-link text-light {{ request()->routeIs('funcionarios.*') ? 'active bg-primary' : '' }}">
                        <i class="bi bi-person-badge-fill"></i> <span>Funcionários</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('departamentos.index') }}" 
                       class="nav-link text-light {{ request()->routeIs('departamentos.*') ? 'active bg-primary' : '' }}">
                        <i class="bi bi-diagram-3-fill"></i> <span>Departamentos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cargos.index') }}" 
                       class="nav-link text-light {{ request()->routeIs('cargos.*') ? 'active bg-primary' : '' }}">
                        <i class="bi bi-briefcase-fill"></i> <span>Cargos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('avaliacoes.index') }}" 
                       class="nav-link text-light {{ request()->routeIs('avaliacoes.*') ? 'active bg-primary' : '' }}">
                        <i class="bi bi-clipboard2-check-fill"></i> <span>Avaliações</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tarefas.index') }}" 
                       class="nav-link text-light {{ request()->routeIs('tarefas.*') ? 'active bg-primary' : '' }}">
                        <i class="bi bi-check2-square"></i> <span>Tarefas</span>
                    </a>
                </li>
            </ul>
        </nav>

        {{-- Conteúdo Principal --}}
        <div class="flex-grow-1 d-flex flex-column">
            {{-- Navbar Superior --}}
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3">
                <div class="container-fluid">
                    <button class="btn btn-outline-secondary btn-sm me-2" id="toggleSidebar" aria-label="Alternar Menu">
                        <i class="bi bi-list"></i>
                    </button>
                   <span class="navbar-brand fw-bold">Bem-vindo, {{ Auth::user()->name ?? 'Convidado' }}</span>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Entrar</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="{{ route('profile') }}">Perfil</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                           Terminar Sessão
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </nav>

            {{-- Conteúdo dinâmico --}}
            <main class="container-fluid py-4 flex-grow-1">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-dark text-light text-center py-2 mt-auto shadow-sm">
        <small>© {{ date('Y') }} MetricFlow – Sistema de Gestão de RH e Produtividade</small>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('sidebar-collapsed');
        });
    </script>
</body>
</html>
