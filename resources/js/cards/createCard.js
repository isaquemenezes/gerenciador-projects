export default function initCreateCard() {
    $('#createCardForm').submit(function (e) {
        e.preventDefault();

        const titulo = $('#card-titulo').val();
        const descricao = $('#card-descricao').val();
        const boardId = $('#card-board-id').val();
        const categoryId = $('#card-category').val() || null;
        const errorBox = $('#create-card-error');

        $.ajax({
            url: '/api/cards',
            type: 'POST',
            contentType: 'application/json',

            data: JSON.stringify({
                titulo: titulo,
                descricao: descricao,
                board_id: boardId,
                category_id: categoryId
            }),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function (newCard)
            {
                $('#createCardModal').modal('hide');
                $('#card-titulo').val('');
                $('#card-descricao').val('');
                $('#card-category').val('');
                errorBox.addClass('d-none').text('');

                // Recarregar todos os boards para mostrar o novo card
                fetchAndRenderAllBoards();
            },
            error: function (xhr) {
                console.error('Erro:', xhr);
                let mensagem = 'Erro ao criar card.';

                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        mensagem = xhr.responseJSON.message;
                    } else if (xhr.responseJSON.errors) {
                        const errors = Object.values(xhr.responseJSON.errors).flat();
                        mensagem = errors.join('<br>');
                    }
                }

                errorBox.removeClass('d-none').html(mensagem);
            }
        });
    });
}
