<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Início') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="{{route('profile.edit')}}">{{ __('Perfil') }}</a></li>
                        @can('view_financial_dashboard')
                        <li><a class="dropdown-item" href="{{route('dashboardCharts.dashboardCharts')}}">Dashboard</a></li>
                        @endcan
                        @can('view_person_management')
                        <li><a class="dropdown-item" href="{{route('services.peopleService')}}">Cadastro de Pessoas</a></li>
                        @endcan
                        @can('view_contract')
                        <li><a class="dropdown-item" href="{{route('contract.index')}}">Contratos</a></li>
                        @endcan
                        @can('view_generate_monthly_fee')
                        <li><a class="dropdown-item" href="{{route('services.monthly')}}">Geração de Mensalidades</a></li>
                        @endcan
                        @can('view_tution')
                        <li><a class="dropdown-item" href="{{route('monthly.tuition')}}">Mensalidades</a></li>
                        @endcan
                        @can('view_user_management')
                        <li><a class="dropdown-item" href="{{route('user.index')}}">Gestão de Usuários</a></li>
                        @endcan
                        @can('view_security_management')
                            <li><a class="dropdown-item" href="{{route('services.securityService')}}">Gestão de Segurança</a></li>
                        @endcan
                        @can('view_structure_management')
                        <li><a class="dropdown-item" href="{{route('services.structureService')}}">Estrutura</a></li>
                        @endcan
                        @can('view_domain_management')
                        <li><a class="dropdown-item" href="{{route('services.domainService')}}">Domínios</a></li>
                        @endcan
                        @can('view_reports')
                        <li><a class="dropdown-item" href="{{route('reports.index')}}">Relatórios</a></li>
                        @endcan
                        <li>
                            <form action="{{route('logout')}}" method="POST">
                                @csrf
                                <button class="dropdown-item">
                                    {{ __('Sair') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Início') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>
                @can('view_financial_dashboard')
                    <x-responsive-nav-link :href="route('dashboardCharts.dashboardCharts')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                @endcan
                @can('view_person_management')
                    <x-responsive-nav-link :href="route('services.peopleService')">
                        {{ __('Cadastro de Pessoas') }}
                    </x-responsive-nav-link>
                @endcan
                @can('view_contract')
                    <x-responsive-nav-link :href="route('contract.index')">
                        {{ __('Contratos') }}
                    </x-responsive-nav-link>
                @endcan
                @can('view_generate_monthly_fee')
                    <x-responsive-nav-link :href="route('services.monthly')">
                        {{ __('Geração de Mensalidades') }}
                    </x-responsive-nav-link>
                @endcan
                @can('view_tution')
                    <x-responsive-nav-link :href="route('monthly.tuition')">
                        {{ __('Mensalidades') }}
                    </x-responsive-nav-link>
                @endcan
                @can('view_user_management')
                    <x-responsive-nav-link :href="route('user.index')">
                        {{ __('Gestão de Usuários') }}
                    </x-responsive-nav-link>
                @endcan
                @can('view_security_management')
                    <x-responsive-nav-link :href="route('services.securityService')">
                        {{ __('Gestão de Segurança') }}
                    </x-responsive-nav-link>
                @endcan
                @can('view_structure_management')
                    <x-responsive-nav-link :href="route('services.structureService')">
                        {{ __('Estrutura') }}
                    </x-responsive-nav-link>
                @endcan
                @can('view_domain_management')
                    <x-responsive-nav-link :href="route('services.domainService')">
                        {{ __('Domínios') }}
                    </x-responsive-nav-link>
                @endcan
                @can('view_reports')
                    <x-responsive-nav-link :href="route('reports.index')">
                        {{ __('Relatórios') }}
                    </x-responsive-nav-link>
                @endcan
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Sair') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
