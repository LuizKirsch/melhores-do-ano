import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        cors: {
            origin: true,
            credentials: true,
        },
        hmr: {
            // Permite que o HMR funcione através do ngrok
            host: '0.0.0.0',
            port: 5173,
            // Desabilita o cliente para evitar conflitos com múltiplos usuários
            clientPort: false,
        },
        watch: {
            ignored: ['**/storage/framework/views/**'],
            usePolling: true,
            interval: 100,
        },
    },
});
