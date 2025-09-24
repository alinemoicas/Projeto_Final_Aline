<nav nav ="{ open: false }" class="bg-white shadow-md"> 
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <!-- Logo -->
            <div class="flex">
                <div class="container mx-auto flex items-center justify-between px-4 py-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                        <img src="{{ asset('/img/logo.png') }}" alt="MetricFlowIMG" class="h-10 w-auto rounded">
                        <span class="font-bold text-lg text-gray-800">MetricFlow</span>
                    </a>
                </div>
            </div>

            <!-- Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center">
                            <svg class="h-4 w-4 text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9.935 9.935 0 0112 15c2.21 0 4.216.72 5.879 1.928M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('funcionarios.index')" class="flex items-center">
                            <svg class="h-4 w-4 text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V4H2v16h5m10 0V4M7 20V4" />
                            </svg>
                            {{ __('Funcionários') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('departamentos.index')" class="flex items-center">
                            <svg class="h-4 w-4 text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                            </svg>
                            {{ __('Departamentos') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('cargo.index')" class="flex items-center">
                            <svg class="h-4 w-4 text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 1.657-1.343 3-3 3S6 12.657 6 11s1.343-3 3-3 3 1.343 3 3zM6 19v-2a4 4 0 014-4h0a4 4 0 014 4v2H6z" />
                            </svg>
                            {{ __('Cargos') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('tarefa.index')" class="flex items-center">
                            <svg class="h-4 w-4 text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 8H7a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2z" />
                            </svg>
                            {{ __('Tarefas') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('avaliacoes.index')" class="flex items-center">
                            <svg class="h-4 w-4 text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2h6v2m-7-8h8m-4 4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                            </svg>
                            {{ __('Avaliações') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" class="flex items-center"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                <svg class="h-4 w-4 text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                                </svg>
                                {{ __('Sair') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
