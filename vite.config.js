import { defineConfig } from "vite";
import laravel, { refreshPaths } from "laravel-vite-plugin";

export default defineConfig({
    server: {
        hmr: {
            host: "localhost",
        },
    },
    plugins: [
        laravel({
            input: ["resources/js/app.js"],
            refresh: [...refreshPaths, "app/Http/Livewire/**"],
        }),
    ],
});
