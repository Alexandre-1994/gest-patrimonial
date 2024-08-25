<!-- resources/views/partials/nav.blade.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top"
    style="position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
">
    <a class="navbar-brand" href="#">Sistema de Gestão de Ativos</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/">Início <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/assets') }}">Cadastro de Ativos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/physical_inventories') }}">Gestão de Inventário</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('asset_movements.index') }}">Movimentações</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/users') }}">Gestão de Usuários</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Relatórios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Configurações</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="https://via.placeholder.com/40" class="rounded-circle" alt="Avatar"> Usuário
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#">Perfil</a>
                    <a class="dropdown-item" href="#">Sair</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
