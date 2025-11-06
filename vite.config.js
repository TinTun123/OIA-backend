import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    // build: {
    //     rollupOptions: {
    //         output: {
    //             entryFileNames: "assets/[name].js",
    //             chunkFileNames: "assets/[name].js",
    //             assetFileNames: "assets/[name][extname]",
    //         },
    //     },
    // },
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                // "resources/js/filament/rich-content-plugins/image-resize.js",
            ],
            refresh: true,
        }),
    ],
});
