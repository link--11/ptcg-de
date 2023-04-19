import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/styles/main.sass',
                'resources/styles/tailwind.css',
                'resources/scripts/main.js',
                'resources/scripts/admin.js',
                'resources/scripts/registration.js'
            ],
            refresh: true,
        }),
    ],
});
