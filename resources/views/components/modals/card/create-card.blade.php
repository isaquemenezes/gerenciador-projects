<div class="modal fade" id="createCardModal" tabindex="-1" aria-labelledby="createCardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="createCardForm">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="createCardModalLabel">
                        <i class="fas fa-sticky-note me-2"></i>Criar Novo Card
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="card-titulo" class="form-label fw-bold">
                                    <i class="fas fa-heading me-1"></i>Título do Card <span style="color: red;">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control form-control-lg @error('titulo') is-invalid @enderror"
                                    id="card-titulo"
                                    name="titulo"

                                    maxlength="255"
                                    placeholder="Ex: Implementar nova funcionalidade"
                                >
                                @error('titulo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="card-category" class="form-label fw-bold">
                                    <i class="fas fa-tag me-1"></i>Categoria <span style="color: red;">*</span>
                                </label>
                                <select class="form-select" id="card-category" name="category_id" required >
                                    <option value="">Selecionar categoria</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="card-descricao" class="form-label fw-bold">
                            <i class="fas fa-align-left me-1"></i>Descrição
                        </label>
                        <textarea class="form-control" id="card-descricao" name="descricao" rows="4" placeholder="Descreva os detalhes do card..."></textarea>
                    </div>

                    <input type="hidden" id="card-board-id" name="board_id">

                    <div id="create-card-error" class="alert alert-danger d-none"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-plus me-1"></i>Criar Card
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
