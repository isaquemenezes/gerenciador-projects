
<nav class="navbar navbar-expand-lg custom-navbar mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto">
                    @auth
                    <li class="nav-item">
                        <span class="nav-link text-white">
                            <i class="fas fa-user nav-icon"></i>Olá, {{ Auth::user()->name }}
                        </span>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('usuario.perfil') }}">
                            <i class="fas fa-user-cog nav-icon"></i>Perfil
                        </a>
                    </li>

                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-link nav-link btn-logout" type="submit">
                                <i class="fas fa-sign-out-alt nav-icon"></i>Sair
                            </button>
                        </form>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
