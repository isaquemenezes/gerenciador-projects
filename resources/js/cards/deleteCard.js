import showNotification from '../utils/showNotification';

let cardToDelete = null;

export default function initDeleteCard() {
    $(document).on('click', '.btn-delete-card', function (e) {
        e.preventDefault();
        cardToDelete = $(this).closest('.draggable-card');
        $('#confirmDeleteModal').modal('show');
    });

    $('#confirmDeleteBtn').on('click', function () {
        if (!cardToDelete) return;

        const cardId = cardToDelete.data('card-id');

        $.ajax({
            url: `/api/cards/${cardId}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function () {
                cardToDelete.remove();
                if (typeof updateEmptyStates === 'function') updateEmptyStates();
                if (typeof showNotification === 'function') {
                    showNotification('Card excluído com sucesso!', 'success');
                }
            },
            error: function (xhr) {
                console.error('Erro ao excluir card:', xhr);
                if (typeof showNotification === 'function') {
                    showNotification('Erro ao excluir card. Tente novamente.', 'error');
                }
            },
            complete: function () {
                $('#confirmDeleteModal').modal('hide');
                cardToDelete = null;
            }
        });
    });
}
