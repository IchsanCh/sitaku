import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/exavro.css",
                "resources/css/exavro-auth.css",
                "resources/css/exavro-panel.css",
                "resources/css/exavro-docs.css",
                "resources/js/public.js",
                "resources/js/auth.js",
                "resources/js/panel.js",
                "resources/js/exavro-docs.js",
                "resources/css/support.css",
                "resources/js/support.js",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
