<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'XKanban Pro')</title>


    {{-- Bootstrap e Font Awesome via CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    {{-- jQuery UI (CSS) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/ui-lightness/jquery-ui.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Estilos Vite --}}
    @vite([
        'resources/css/app.css',
        'resources/css/style-navbar.css',
        'resources/css/drag-drop.css',
        'resources/css/perfil.css',
        'resources/css/footer.css',
        'resources/css/editar-perfil-user.css',

    ])

    {{-- páginas específicas --}}
    @stack('styles')
</head>
