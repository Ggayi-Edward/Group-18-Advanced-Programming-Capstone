import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/program-details.css', // <- add your CSS here
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
