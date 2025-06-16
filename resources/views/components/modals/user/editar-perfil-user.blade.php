<div class="modal fade edit-profile-modal" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form id="editProfileForm" method="POST" action="{{ route('perfil.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">
                        <i class="bi bi-person-gear me-2"></i>
                        Editar Perfil
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                     <!-- Avatar Upload -->
                    <div class="avatar-upload">
                        <div class="avatar-preview" onclick="document.getElementById('avatar-input').click()">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <input type="file" id="avatar-input" name="avatar" accept="image/*" style="display: none;">
                        <p class="text-muted mb-0">Clique na imagem para alterar</p>
                        <small class="text-muted">Formatos aceitos: JPG, PNG, GIF (máx. 2MB)</small>
                    </div>

                    <hr class="my-4">

                    <!-- Informações Pessoais -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating-group">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="edit_name" name="name"
                                           value="{{ $usuario->name }}" placeholder="Nome completo" required>
                                    <label for="edit_name">
                                        <i class="bi bi-person me-1"></i>Nome Completo
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating-group">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="edit_email" name="email"
                                           value="{{ $usuario->email }}" placeholder="E-mail" required>
                                    <label for="edit_email">
                                        <i class="bi bi-envelope me-1"></i>E-mail
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Informações Profissionais -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating-group">

                                <div class="form-floating">
                                    <select class="form-select" id="edit_tipo" name="tipo" required>
                                        <option value="" disabled {{ empty($usuario->tipo) ? 'selected' : '' }}>
                                            Selecione o tipo
                                        </option>

                                        <option value="desenvolvedor" {{ $usuario->tipo == 'desenvolvedor' ? 'selected' : '' }}>
                                            Desenvolvedor
                                        </option>

                                        <option value="analista" {{ $usuario->tipo == 'analista' ? 'selected' : '' }}>
                                            Analista
                                        </option>

                                        <option value="analista_teste" {{ $usuario->tipo == 'analista_teste' ? 'selected' : '' }}>
                                            Analista de Teste
                                        </option>

                                        <option value="gerente" {{ $usuario->tipo == 'gerente' ? 'selected' : '' }}>
                                            Gerente
                                        </option>

                                    </select>
                                    <label for="edit_tipo">
                                        <i class="bi bi-person-badge me-1"></i>Tipo de Usuário
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <span class="loading-spinner spinner-border spinner-border-sm me-2 d-none" role="status"></span>
                        <span class="btn-text">
                            <i class="bi bi-check-lg me-2"></i>Salvar Alterações
                        </span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
