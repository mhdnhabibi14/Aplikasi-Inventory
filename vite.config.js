import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/sass/app.scss", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                // Menyembunyikan deprecation warning dari dependensi node_modules (seperti Bootstrap)
                quietDeps: true,
                silenceDeprecations: [
                    "color-functions",
                    "import",
                    "global-builtin",
                ],
            },
        },
    },
});
