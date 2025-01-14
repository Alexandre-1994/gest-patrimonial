<!-- resources/views/partials/nav.blade.php -->
<nav class="main-navbar">
    <div class="navbar-container">
        <!-- Logo -->
        <div class="navbar-brand-section">
            <a class="navbar-brand" href="/">
                <i class="fas fa-cube"></i>
                <span>N’Kaya</span>
            </a>
        </div>

        <!-- Menu Central -->
        <div class="navbar-center">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">
                        <i class="fas fa-home"></i> Início
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="gestaoDropdown" data-toggle="dropdown">
                        <i class="fas fa-boxes"></i> Gestão
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ url('/assets') }}">
                            <i class="fas fa-box"></i> Cadastro de Ativos
                        </a>
                        <a class="dropdown-item" href="{{ url('/physical_inventories') }}">
                            <i class="fas fa-clipboard-list"></i> Inventário
                        </a>
                        <a class="dropdown-item" href="{{ route('asset_movements.index') }}">
                            <i class="fas fa-exchange-alt"></i> Movimentações
                        </a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="adminDropdown" data-toggle="dropdown">
                        <i class="fas fa-cog"></i> Administração
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ url('/users') }}">
                            <i class="fas fa-users"></i> Usuários
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-chart-bar"></i> Relatórios
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-tools"></i> Configurações
                        </a>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Perfil -->
        <div class="navbar-profile">
            <div class="nav-item dropdown">
                <a class="nav-link" href="#" id="userDropdown" data-toggle="dropdown">
                    <span class="profile-info">
                        <span class="profile-name">{{ Auth::user()->name ?? 'Usuário' }}</span>
                        <span class="profile-role">{{ Auth::user()->role ?? 'Função' }}</span>
                    </span>
                    <img src="https://placehold.co/40" class="profile-avatar" alt="Avatar">
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-user"></i> Perfil
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-cog"></i> Configurações
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Sair
                    </a>
                    {{-- <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form> --}}
                </div>
            </div>
        </div>
    </div>
</nav>
