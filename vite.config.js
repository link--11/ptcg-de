import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/styles/main.sass',
                'resources/scripts/main.js'
            ],
            refresh: true,
        }),
    ],
});
