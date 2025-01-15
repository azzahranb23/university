import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    server: {
        host: "127.0.0.1",
        hmr: {
            host: "127.0.0.1",
        },
    },
    // server: {
    //     host: "0.0.0.0",
    //     port: 5173,
    //     hmr: {
    //         host: "06d4-111-94-23-73.ngrok-free.app", // URL Ngrok Anda
    //         protocol: "wss", // WebSocket Secure untuk HTTPS
    //     },
    // },
});
