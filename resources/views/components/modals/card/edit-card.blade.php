
<div class="modal fade" id="editCardModal" tabindex="-1" aria-labelledby="editCardModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="edit-card-form">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editCardModalLabel">Editar Card</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>

        <div class="modal-body">

          <input type="hidden" id="edit-card-id">

          <div class="mb-3">
            <label for="edit-card-title" class="form-label">Título</label>
            <input type="text" class="form-control" id="edit-card-title" required>
          </div>

          <div class="mb-3">
            <label for="edit-card-description" class="form-label">Descrição</label>
            <textarea class="form-control" id="edit-card-description"></textarea>
          </div>


        </div>
        <div class="modal-footer">
             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </div>
      </div>
    </form>
  </div>
</div>

