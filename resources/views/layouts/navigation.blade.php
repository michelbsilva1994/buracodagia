<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="d-flex justify-between h-16">
            <div class="flex">
                <div class="d-flex align-items-center">
                    <nav class="navbar bg-body-tertiary">
                        <div class="container-fluid">
                          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                          </button>
                          <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                            <div class="offcanvas-header">
                              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                              <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="#">Ordem de Serviço</a>
                                </li>
                                <li class="nav-item dropdown"></li>
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                      Dashboards
                                    </a>
                                    <ul class="dropdown-menu">
                                      <li><a class="dropdown-item" href="#">Mensalidades por data de vencimento</a></li>
                                      <li><a class="dropdown-item" href="#">Valores de recebimento por data de baixa</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                      Cadastro de Pessoas
                                    </a>
                                    <ul class="dropdown-menu">
                                      <li><a class="dropdown-item" href="#">Pessoa Física</a></li>
                                      <li><a class="dropdown-item" href="#">Pessoa Jurídica</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown"></li>
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                      Geração de Mensalidades
                                    </a>
                                    <ul class="dropdown-menu">
                                      <li><a class="dropdown-item" href="#">Gerar Mensalidades em lote</a></li>
                                      <li><a class="dropdown-item" href="#">Gerar Mensalidade Retroativa</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" href="#">Mensalidades</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Gestão de Usuários</a>
                                </li>
                                <li class="nav-item dropdown"></li>
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                      Gestão de Segurança
                                    </a>
                                    <ul class="dropdown-menu">
                                      <li><a class="dropdown-item" href="#">Perfis</a></li>
                                      <li><a class="dropdown-item" href="#">Permissões</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown"></li>
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                      Estrutura
                                    </a>
                                    <ul class="dropdown-menu">
                                      <li><a class="dropdown-item" href="#">Pavimentos</a></li>
                                      <li><a class="dropdown-item" href="#">Lojas</a></li>
                                      <li><a class="dropdown-item" href="#">Equipamentos</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown"></li>
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                      Domínios
                                    </a>
                                    <ul class="dropdown-menu">
                                      <li><a class="dropdown-item" href="#">Status da loja</a></li>
                                      <li><a class="dropdown-item" href="#">Tipo de loja</a></li>
                                      <li><a class="dropdown-item" href="#">Tipo de contrato</a></li>
                                      <li><a class="dropdown-item" href="#">Tipo de pagamento</a></li>
                                      <li><a class="dropdown-item" href="#">Tipo de cobrança</a></li>
                                      <li><a class="dropdown-item" href="#">Tipo de cancelamento</a></li>
                                      <li><a class="dropdown-item" href="#">Tipo de de cancelamento do contrato</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Relatórios
                                  </a>
                                  <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Contratos</a></li>
                                    <li><a class="dropdown-item" href="#">Lojas</a></li>
                                    <li><a class="dropdown-item" href="#">Relatório de baixas</a></li>
                                  </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Sair</a>
                                  </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </nav>
                </div>
                <!-- Logo -->
                <div class="d-flex align-items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                {{-- <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Início') }}
                    </x-nav-link>
                </div> --}}
            </div>
            <div class="d-flex align-items-center">
                <div class="mr-3">
                    <a class="dropdown-item" href="{{route('profile.edit')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </a>
                </div>
                <div>
                    <form action="{{route('logout')}}" method="POST">
                        @csrf
                        <button class="dropdown-item">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368"><path d="M0 0h24v24H0z" fill="none"/><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
                        </button>
                    </form>
                </div>
            </div>
            <!-- Settings Dropdown -->
            {{-- <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="{{route('profile.edit')}}">{{ __('Perfil') }}</a></li>
                        <li><a class="dropdown-item" href="{{route('serviceOrders.index')}}">Ordem de Serviço</a></li>
                        @can('view_financial_dashboard')
                        <li><a class="dropdown-item" href="{{route('dashboardCharts.dashboardChartsIndex')}}">Dashboard</a></li>
                        @endcan
                        @can('view_person_management')
                        <li><a class="dropdown-item" href="{{route('services.peopleService')}}">Cadastro de Pessoas</a></li>
                        @endcan
                        @can('view_contract')
                        <li><a class="dropdown-item" href="{{route('contract.index')}}">Contratos</a></li>
                        @endcan
                        @can('view_generate_monthly_fee')
                        <li><a class="dropdown-item" href="{{route('services.generationTuitions')}}">Geração de Mensalidades</a></li>
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
            </div> --}}
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
                <x-responsive-nav-link :href="route('serviceOrders.index')">
                    {{ __('Ordem de Serviço') }}
                </x-responsive-nav-link>
                @can('view_financial_dashboard')
                    <x-responsive-nav-link :href="route('dashboardCharts.dashboardChartsIndex')">
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
                    <x-responsive-nav-link :href="route('services.generationTuitions')">
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
