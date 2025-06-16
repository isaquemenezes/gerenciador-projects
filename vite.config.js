import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/style-navbar.css',
                'resources/css/drag-drop.css',
                'resources/css/perfil.css',
                'resources/css/footer.css',
                'resources/css/editar-perfil-user.css',

                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
