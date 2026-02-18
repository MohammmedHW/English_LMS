import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // Use the full URL in production so CSS loads correctly
    base: process.env.APP_URL ? process.env.APP_URL + '/build/' : '/build/',
});
