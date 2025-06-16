
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="bg-gradient-primary text-white py-5 mb-4">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">
                <i class="fas fa-clipboard-list me-3"></i>
                Gerenciador de Projetos
            </h1>
            <p class="lead">Organize suas tarefas de forma eficiente</p>

            @can('create', App\Models\Board::class)

                <button class="btn btn-warning btn-lg" data-bs-toggle="modal" data-bs-target="#createBoardModal">
                    <i class="fas fa-plus me-2"></i>Criar Novo Board
                </button>
            @endcan

        </div>
    </div>

    <div class="container">

        <!-- Loading -->
        <div id="loading" class="text-center py-5">
            <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Carregando...</span>
            </div>
            <h5 class="text-muted">Carregando boards...</h5>
        </div>

        <!-- Container dos Boards -->
        <div id="boards-container"></div>

    </div>

    <!-- Modais -->
    @include('components.modals.board.create-board')
    @include('components.modals.card.create-card')
    @include('components.modals.card.edit-card')
    @include('components.modals.card.confirmacao-exclusao-card')


@endsection

@push('scripts')

    <script>
        $(document).ready(function () {

            // Esconde estados anteriores
            $('.card-empty, .alert').remove();

            // Variáveis para mapeamento de categorias
            let categoryMap = {};

            // Carregar categorias para o select
            function loadCategories() {
                $.ajax({
                    url: '/api/categories',
                    type: 'GET',
                    success: function(categories) {
                        const select = $('#card-category');
                        select.empty().append('<option value="">Selecionar categoria</option>');

                        // Criar mapeamento de categorias
                        categoryMap = {};
                        categories.forEach(category => {
                            select.append(`<option value="${category.id}">${category.nome}</option>`);
                            const categoryName = category.nome.toLowerCase();

                            // Mapear categorias para colunas
                            if (categoryName.includes('fazer')) {
                                categoryMap[category.id] = 'todo';
                            } else if (categoryName.includes('progresso')) {
                                categoryMap[category.id] = 'in-progress';
                            } else if (categoryName.includes('concluído') || categoryName.includes('concluido')) {
                                categoryMap[category.id] = 'done';
                            }
                        });
                    },
                    error: function() {
                        console.warn('Não foi possível carregar as categorias');
                    }
                });
            }

            // Carregar categorias ao inicializar
            loadCategories();

            // Função para inicializar drag and drop
            function initializeDragAndDrop() {

                // Tornar os cards moveis
                $('.draggable-card').draggable({
                    helper: 'clone',
                    revert: 'invalid',
                    zIndex: 1000,
                    start: function(event, ui) {
                        $(this).addClass('card-being-dragged');
                        ui.helper.addClass('ui-sortable-helper');
                    },
                    stop: function(event, ui) {
                        $(this).removeClass('card-being-dragged');
                    }
                });

                // Tornar as colunas droppable
                $('.drop-zone').droppable({
                    accept: '.draggable-card',
                    hoverClass: 'ui-droppable-hover',

                    drop: function(event, ui) {
                        const cardElement = ui.draggable;
                        const cardId = cardElement.data('card-id');
                        const targetColumn = $(this).attr('id');
                        const boardId = targetColumn.split('-')[1];

                        // Determinar nova categoria baseada na coluna
                        let newCategoryId = null;

                        if (targetColumn.includes('todo')) {
                            newCategoryId = getCategoryIdByType('todo');
                        } else if (targetColumn.includes('in-progress')) {
                            newCategoryId = getCategoryIdByType('in-progress');
                        } else if (targetColumn.includes('done')) {
                            newCategoryId = getCategoryIdByType('done');
                        }


                        updateCardCategory(
                            cardId,
                            newCategoryId,
                            cardElement, $(this)
                        );
                    }
                });
            }

            // Função para obter ID da categoria
            function getCategoryIdByType(type)
            {
                for (let categoryId in categoryMap) {
                    if (categoryMap[categoryId] === type) {
                        return categoryId;
                    }
                }
                return null;
            }

            // Função para atualizar categoria do card
            function updateCardCategory(cardId, newCategoryId, cardElement, targetColumn) {
                $.ajax({
                    url: `/api/cards/${cardId}`,
                    type: 'PUT',
                    contentType: 'application/json',

                    data: JSON.stringify({
                        category_id: newCategoryId
                    }),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    success: function(response)
                    {
                        // Mover o card visualmente
                        cardElement.appendTo(targetColumn);
                        cardElement.removeClass('card-being-dragged');

                        // Atualizar estados vazios
                        updateEmptyStates();

                        showNotification('Card movido com sucesso!', 'success');
                    },
                    error: function(xhr) {
                        console.error('Erro ao atualizar card:', xhr);
                        showNotification('Erro ao mover card. Tente novamente.', 'error');

                        // Reverter posição do card em caso de erro
                        cardElement.animate({
                            left: 0,
                            top: 0
                        }, 300);
                    }
                });
            }

            // Função para atualizar estados vazios
            function updateEmptyStates() {
                $('.drop-zone').each(function() {
                    const $zone = $(this);
                    const $emptyState = $zone.find('.empty-state');
                    const hasCards = $zone.find('.draggable-card').length > 0;

                    if (hasCards) {
                        $emptyState.addClass('d-none');
                    } else {
                        $emptyState.removeClass('d-none');
                    }
                });
            }

            // Função para mostrar notificações
            function showNotification(message, type) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const icon = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-triangle';

                const notification = $(`
                    <div class="alert ${alertClass} alert-dismissible fade show position-fixed"
                         style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                        <i class="${icon} me-2"></i>
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `);

                $('body').append(notification);

                // Auto-remover após 3 segundos
                setTimeout(() => {
                    notification.alert('close');
                }, 3000);
            }

            // Função para buscar e renderizar todos os boards
            function fetchAndRenderAllBoards() {
                $('#loading').removeClass('d-none');
                $('#boards-container').empty();

                $.ajax({
                    url: '/api/boards',
                    type: 'GET',
                    dataType: 'json',
                    success: function (boards) {
                        $('#loading').addClass('d-none');
                        if (boards.length > 0) {
                            renderBoards(boards);
                            // Inicializar drag and drop após renderizar
                            setTimeout(() => {
                                initializeDragAndDrop();
                            }, 100);
                        } else {
                            renderEmptyState();
                        }
                    },
                    error: function (xhr) {
                        $('#loading').addClass('d-none');
                        renderErrorState();
                    }
                });
            }

            fetchAndRenderAllBoards();

            function renderEmptyState() {
                $('#boards-container').html(`
                    <div class="card border-0 shadow-lg card-empty">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-clipboard-list text-muted mb-4" style="font-size: 4rem;"></i>
                            <h3 class="card-title text-muted">Nenhum board encontrado</h3>
                            <p class="card-text text-muted">Comece criando seu primeiro projeto!</p>
                            <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#createBoardModal">
                                <i class="fas fa-plus me-2"></i>Criar Board
                            </button>
                        </div>
                    </div>
                `);
            }

            function renderErrorState() {
                $('#boards-container').html(`
                    <div class="alert alert-danger d-flex align-items-center border-0 shadow" role="alert">
                        <i class="fas fa-exclamation-triangle fs-4 me-3"></i>
                        <div>
                            <h5 class="alert-heading mb-1">Erro ao carregar dados!</h5>
                            <p class="mb-0">Não foi possível carregar os boards. Tente novamente mais tarde.</p>
                        </div>
                    </div>
                `);
            }

            function renderBoards(boards) {
                // Limpe o contêiner antes de renderizar todas os boards
                $('#boards-container').empty();

                boards.forEach(board => {
                    const totalCards = board.cards.length;

                    const boardHtml = `
                        <div class="card border-0 shadow-lg mb-5">
                            <div class="card-header bg-white border-bottom-0 py-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="card-title mb-0 fw-bold text-dark d-flex align-items-center">
                                        <i class="fas fa-project-diagram text-primary me-3"></i>
                                        ${board.nome}
                                    </h2>
                                    <button class="btn btn-info create-card-btn" data-board-id="${board.id}" data-board-name="${board.nome}" data-bs-toggle="modal" data-bs-target="#createCardModal">
                                        <i class="fas fa-plus me-2"></i>Criar Novo Card
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4" id="board-${board.id}">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card border-0 bg-gradient-primary text-white mb-3 shadow">
                                            <div class="card-body text-center py-3">
                                                <h5 class="card-title mb-0 fw-bold">
                                                    <i class="fas fa-clock me-2"></i>
                                                    A Fazer
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="border border-2 border-primary border-opacity-25 rounded-3 p-3 bg-light drop-zone"
                                            id="todo-${board.id}" style="min-height: 300px;">
                                            <div class="text-center text-muted py-4 d-none empty-state">
                                                <i class="fas fa-plus-circle fs-1 mb-3 opacity-50"></i>
                                                <p class="mb-0">Nenhuma tarefa pendente</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="card border-0 bg-gradient-warning text-white mb-3 shadow">
                                            <div class="card-body text-center py-3">
                                                <h5 class="card-title mb-0 fw-bold">
                                                    <i class="fas fa-spinner me-2"></i>
                                                    Em Progresso
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="border border-2 border-warning border-opacity-25 rounded-3 p-3 bg-light drop-zone"
                                            id="in-progress-${board.id}" style="min-height: 300px;">
                                            <div class="text-center text-muted py-4 d-none empty-state">
                                                <i class="fas fa-play-circle fs-1 mb-3 opacity-50"></i>
                                                <p class="mb-0">Nenhuma tarefa em andamento</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-12">
                                        <div class="card border-0 bg-gradient-success text-white mb-3 shadow">
                                            <div class="card-body text-center py-3">
                                                <h5 class="card-title mb-0 fw-bold">
                                                    <i class="fas fa-check-circle me-2"></i>
                                                    Concluído
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="border border-2 border-success border-opacity-25 rounded-3 p-3 bg-light drop-zone"
                                            id="done-${board.id}" style="min-height: 300px;">
                                            <div class="text-center text-muted py-4 d-none empty-state">
                                                <i class="fas fa-trophy fs-1 mb-3 opacity-50"></i>
                                                <p class="mb-0">Nenhuma tarefa concluída</p>
                                            </div>
                                        </div>
                                    </div>

                                    <span class="badge bg-primary fs-6 px-3 py-2">
                                        <i class="fas fa-tasks me-1"></i>
                                        ${totalCards} ${totalCards === 1 ? 'card' : 'cards'}
                                    </span>
                                </div>
                            </div>
                        </div>
                    `;

                    $('#boards-container').append(boardHtml);

                    // Contadores
                    let todoCount = 0, progressCount = 0, doneCount = 0;

                    board.cards.forEach(card => {
                        const categoryName = card.category?.nome?.toLowerCase() || '';
                        const categoryId = card.category?.id;

                        const cardHtml = `
                            <div class="card border-0 shadow-sm mb-3 card-hover draggable-card" data-card-id="${card.id}">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-grip-vertical text-muted me-2 mt-1 drag-handle"></i>
                                        <i class="fas fa-sticky-note text-primary me-3 mt-1"></i>
                                        <div class="flex-grow-1">
                                            <h6 class="card-title fw-semibold mb-2 text-dark">${card.titulo}</h6>
                                            <p class="card-text text-muted small mb-0">${card.descricao || 'Sem descrição'}</p>
                                        </div>
                                    </div>



                                    <div class="mt-3 pt-2 border-top border-light">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            Criado em ${new Date(card.created_at).toLocaleDateString('pt-BR')}
                                        </small>
                                    </div>

                                    <div class="d-flex gap-2 mt-2">
                                        <button class="btn btn-sm btn-outline-primary edit-card-btn"
                                            data-id="${card.id}"
                                            data-title="${card.titulo}"
                                            data-description="${card.descricao || ''}"
                                            data-category="${categoryId}">
                                            <i class="bi bi-pencil"></i>Editar
                                        </button>

                                        <button class="btn btn-sm btn-outline-danger btn-delete-card" id="btn-delete-card" title="Excluir">
                                            <i class="bi bi-trash"></i> Excluir
                                        </button>
                                    </div>




                                </div>
                            </div>
                        `;

                        if (categoryName.includes('fazer')) {
                            $(`#todo-${board.id}`).append(cardHtml);
                            todoCount++;
                        } else if (categoryName.includes('progresso')) {
                            $(`#in-progress-${board.id}`).append(cardHtml);
                            progressCount++;
                        } else if (categoryName.includes('concluído') || categoryName.includes('concluido')) {
                            $(`#done-${board.id}`).append(cardHtml);
                            doneCount++;
                        }
                    });

                    if (todoCount === 0) $(`#todo-${board.id} .empty-state`).removeClass('d-none');
                    if (progressCount === 0) $(`#in-progress-${board.id} .empty-state`).removeClass('d-none');
                    if (doneCount === 0) $(`#done-${board.id} .empty-state`).removeClass('d-none');
                });
            }

            // Evento para abrir modal de criar
            $(document).on('click', '.create-card-btn', function() {
                const boardId = $(this).data('board-id');
                const boardName = $(this).data('board-name');

                $('#card-board-id').val(boardId);
                $('#createCardModalLabel').html(`
                    <i class="fas fa-sticky-note me-2"></i>Criar Novo Card - ${boardName}
                `);

                // Limpar campos
                $('#card-titulo').val('');
                $('#card-descricao').val('');
                $('#card-category').val('');
                $('#create-card-error').addClass('d-none').text('');
            });

            // Formulário de criação de board
            $('#createBoardForm').submit(function (e) {
                e.preventDefault();

                const nome = $('#board-name').val();
                const errorBox = $('#create-board-error');
                const user_id = {{ auth()->id() }};

                $.ajax({
                    url: '/api/boards',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ nome, user_id }),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    success: function (newBoard) {
                        $('#createBoardModal').modal('hide');
                        $('#board-name').val('');
                        errorBox.addClass('d-none').text('');

                        // Após criar um novo board com sucesso, busque e renderize novamente todos os boards
                        fetchAndRenderAllBoards();
                    },
                    error: function (xhr) {
                        const mensagem = xhr.responseJSON?.message || 'Erro ao criar board.';
                        errorBox.removeClass('d-none').text(mensagem);
                    }
                });
            });

            // Formulário de criação de card
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

            // Evento para abrir modal de edição
            $(document).on('click', '.edit-card-btn', function () {
                const id = $(this).data('id');
                const title = $(this).data('title');
                const description = $(this).data('description');
                const categoryId = $(this).data('category');

                $('#edit-card-id').val(id);
                $('#edit-card-title').val(title);
                $('#edit-card-description').val(description);
                // $('#edit-card-category').val(categoryId);



                // const categorySelect = $('#edit-card-category');
                // categorySelect.empty().append('<option value="">Selecionar categoria</option>');
                // Object.keys(categoryMap).forEach(id => {
                //     categorySelect.append(`<option value="${id}" ${id == categoryId ? 'selected' : ''}>${categoryMap[id]}</option>`);
                // });

                const modal = new bootstrap.Modal(document.getElementById('editCardModal'));
                modal.show();
            });

              // Formulário de edicao de card
            $('#edit-card-form').on('submit', function (e) {
                e.preventDefault();

                const id = $('#edit-card-id').val();
                const data = {
                    titulo: $('#edit-card-title').val(),
                    descricao: $('#edit-card-description').val(),
                    // category_id: $('#edit-card-category').val()
                };

                    const cardElement = $(`.draggable-card[data-card-id="${id}"]`);

                $.ajax({
                    url: `/api/cards/${id}`,
                    method: 'PUT',
                     headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    success: function (response) {
                        $('#editCardModal').modal('hide');


                        cardElement.find('.card-title').text(response.titulo);
                        cardElement.find('.card-text').text(response.descricao || 'Sem descrição');

                        showNotification('Card atualizado com sucesso!', 'success');
                    },
                    error: function (xhr) {
                        alert('Erro ao salvar alterações.');
                    }
                });
            });

            // Evento de clique para excluir card
            let cardToDelete = null;
            $(document).ready(function () {

                $(document).on('click', '.btn-delete-card', function (e) {
                    e.preventDefault();
                    cardToDelete = $(this).closest('.draggable-card');
                    $('#confirmDeleteModal').modal('show');
                });

                // Confirmação do modal
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
                            updateEmptyStates();
                            showNotification('Card excluído com sucesso!', 'success');
                        },
                        error: function (xhr) {
                            console.error('Erro ao excluir card:', xhr);
                            showNotification('Erro ao excluir card. Tente novamente.', 'error');
                        },
                        complete: function () {
                            $('#confirmDeleteModal').modal('hide');
                            cardToDelete = null;
                        }
                    });
                });

            });
        }); // END ready(function () {

    </script>
@endpush
