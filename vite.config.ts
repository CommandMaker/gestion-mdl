import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/app.scss', 'resources/ts/app.ts'],
            refresh: true,
        }),
        vue()
    ],
    resolve: {
        alias: {
            '@': path.join(__dirname, 'resources', 'ts')
        }
    }
});
