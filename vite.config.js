import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/public.js",
                "resources/js/auth.js",
                "resources/css/support.css",
                "resources/js/support.js",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
