<!DOCTYPE html>
<html lang="pt-BR">
    @include('components.head')

    <body class="bg-light">

        @include('components.navbar')

        <main class="container">
            @yield('content')
        </main>

        @include('components.footer', ['ano' => date('Y')])

        {{-- Scripts externos --}}
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>

        {{-- Scripts da aplicação --}}
        @vite('resources/js/app.js')

        {{-- scripts em páginas específicas --}}
        @stack('scripts')
    </body>
</html>

