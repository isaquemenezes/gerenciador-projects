@extends('layouts.app')

@section('title', 'Perfil do Usuário')

@push('styles')

@endpush

@section('content')
    <div class="container profile-container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="card profile-card">

                    <div class="profile-header">
                        <div class="profile-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <h1 class="profile-name">{{ $usuario->name }}</h1>
                        <p class="profile-role">
                            @if(Auth::user()->is_admin)
                                Administrador do Sistema
                            @else
                                Usuário {{ ucfirst($usuario->tipo) }}
                            @endif
                        </p>
                    </div>

                    @if(session('success'))
                        <div id="flash-message" class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                        </div>
                    @endif


                    <div class="profile-body">

                        <!-- Informações do Usuário -->
                       <div class="row align-items-center">

                            <div class="col-md-6">
                                <div class="info-item email d-flex align-items-center gap-2">

                                    <div>
                                        <div class="info-label">E-mail</div>
                                        <div class="info-value">{{ $usuario->email }}</div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="info-item role d-flex align-items-center gap-2">

                                    <div>
                                        <div class="info-label">Papel do Usuário</div>
                                        <div class="info-value">
                                            @php
                                                $roleColors = [
                                                    'admin' => 'bg-danger',
                                                    'manager' => 'bg-warning text-dark',
                                                    'user' => 'bg-primary',
                                                    'guest' => 'bg-secondary'
                                                ];
                                                $color = $roleColors[$usuario->tipo] ?? 'bg-secondary';
                                            @endphp
                                            <span class="badge custom-badge {{ $color }}">{{ ucfirst($usuario->tipo) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="info-item admin">
                            <div class="info-label">
                                <i class="bi bi-shield-fill-check text-success"></i>
                                Nível de Acesso
                            </div>
                            <div class="info-value">
                                @if(Auth::user()->is_admin)
                                    <span class="badge custom-badge bg-danger">
                                        <i class="bi bi-shield-fill-check me-1"></i>
                                        Administrador
                                    </span>
                                @else
                                    <span class="badge custom-badge bg-secondary">
                                        <i class="bi bi-person-fill me-1"></i>
                                        Usuário Comum
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="info-item status">
                            <div class="info-label">
                                <i class="bi bi-circle-fill text-warning"></i>
                                Status da Conta
                            </div>
                            <div class="info-value">
                                @if ($usuario->status)
                                    <span class="badge custom-badge bg-success">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Ativo
                                    </span>
                                @else
                                    <span class="badge custom-badge bg-secondary">
                                        <i class="bi bi-x-circle-fill me-1"></i>
                                        Inativo
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="info-item date">
                            <div class="info-label">
                                <i class="bi bi-calendar-fill text-primary"></i>
                                Membro Desde
                            </div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($usuario->created_at)->locale('pt_BR')->translatedFormat('d \d\e F \d\e Y \à\s H:i') }}
                            </div>
                        </div>

                        <!-- Botões de Ação -->
                        <div class="action-buttons">
                            <button type="button" class="btn btn-edit-profile" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                <i class="bi bi-pencil-fill me-2"></i>
                                Editar Perfil
                            </button>

                            <a href="#" class="btn btn-custom btn-password">
                                <i class="bi bi-key-fill me-2"></i>
                                Atualizar Senha
                            </a>

                            <a href="{{ route('logout') }}" class="btn btn-custom btn-logout"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Desativar da Conta
                            </a>
                        </div>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal de Edição de Perfil -->
    @include('components.modals.user.editar-perfil-user')

    <!-- Toast Container -->
    <div class="toast-container"></div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const card = document.querySelector('.profile-card');
        if (card) {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';

            setTimeout(() => {
                card.style.transition = 'all 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        }

        // Efeito hover nos info-items
        document.querySelectorAll('.info-item').forEach(item => {
            item.addEventListener('mouseenter', function () {
                this.style.background = 'rgba(248, 249, 250, 1)';
            });

            item.addEventListener('mouseleave', function () {
                this.style.background = 'rgba(248, 249, 250, 0.8)';
            });
        });


        const editForm = document.getElementById('editProfileForm');
        if (editForm) {
            editForm.addEventListener('submit', function () {
                const btnText = editForm.querySelector('.btn-text');
                const spinner = editForm.querySelector('.loading-spinner');

                btnText.textContent = 'Salvando...';
                if (spinner) spinner.classList.remove('d-none');
            });
        }

    });
</script>
@endpush
