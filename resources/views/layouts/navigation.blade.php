<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="d-flex justify-between h-16">
            <div class="flex">
                <div class="d-flex align-items-center">
                    <nav class="navbar bg-body-tertiary">
                        <div class="container-fluid">
                            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                                aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                                aria-labelledby="offcanvasNavbarLabel">
                                <div class="offcanvas-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                        <li class="nav-item">
                                            <a class="nav-link" aria-current="page"
                                                href="{{ route('serviceOrders.index') }}">Ordem de Serviço</a>
                                        </li>
                                        @can('view_financial_dashboard')
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Dashboards
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('dashboardCharts.dashboardCharts') }}">Mensalidades
                                                            por data de vencimento</a></li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('dashboardCharts.financialLowersDashboard') }}">Valores
                                                            de recebimento por data de baixa</a></li>
                                                </ul>
                                            </li>
                                        @endcan
                                        @can('view_person_management')
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Cadastro de Pessoas
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('physicalPerson.index') }}">Pessoa Física</a>
                                                    </li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('legalPerson.index') }}">Pessoa Jurídica</a></li>
                                                </ul>
                                            </li>
                                        @endcan
                                        @can('view_generate_monthly_fee')
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Geração de Mensalidades
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ route('monthly.store') }}">Gerar
                                                            Mensalidades em lote</a></li>
                                                    @can('generate_retroactive_monthly_payment')
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('monthly.createGenerateRetroactiveMonthlyPayment') }}">Gerar
                                                                Mensalidade Retroativa</a></li>
                                                    @endcan
                                                </ul>
                                            </li>
                                        @endcan
                                        @can('view_tution')
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('monthly.tuition') }}">Mensalidades</a>
                                            </li>
                                        @endcan
                                        @can('view_user_management')
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('user.index') }}">Gestão de Usuários</a>
                                            </li>
                                        @endcan
                                        @can('view_security_management')
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Gestão de Segurança
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ route('role.index') }}">Perfis</a>
                                                    </li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('permission.index') }}">Permissões</a></li>
                                                </ul>
                                            </li>
                                        @endcan
                                        @can('view_structure_management')
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Estrutura
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('pavement.index') }}">Pavimentos</a></li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('store.index') }}">Lojas</a>
                                                    </li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('equipment.index') }}">Equipamentos</a></li>
                                                </ul>
                                            </li>
                                        @endcan
                                        @can('view_domain_management')
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Domínios
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('storeStatus.index') }}">Status da loja</a>
                                                    </li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('storeType.index') }}">Tipo
                                                            de loja</a></li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('typeContract.index') }}">Tipo de contrato</a>
                                                    </li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('typePayment.index') }}">Tipo
                                                            de pagamento</a></li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('typeCharge.index') }}">Tipo
                                                            de cobrança</a></li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('typeCancellation.index') }}">Tipo de
                                                            cancelamento</a></li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('contractCancellationType.index') }}">Tipo de
                                                            de
                                                            cancelamento do contrato</a></li>
                                                </ul>
                                            </li>
                                        @endcan
                                        @can('view_reports')
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Relatórios
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('reports.contractStoresIndex') }}">Contratos</a>
                                                    </li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('reports.storesIndex') }}">Lojas</a></li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('reports.lowersTuitionIndex') }}">Relatório de
                                                            baixas</a></li>
                                                </ul>
                                            </li>
                                        @endcan
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button class="dropdown-item">
                                                    {{ __('Sair') }}
                                                </button>
                                            </form>
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
            </div>
            <div class="d-flex align-items-center">
                <div class="mr-3">
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px"
                            fill="#5f6368">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                    </a>
                </div>
                <div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24"
                                width="24px" fill="#5f6368">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
