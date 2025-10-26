import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";

// Vite configuration for the standalone frontend repo
export default defineConfig({
    plugins: [vue()],
    server: {
        port: 5173,
        proxy: {
            // 👇 Send all unknown requests to your Laravel backend
            "/": "http://127.0.0.1:8000",
        },
    },
    resolve: {
        alias: {
            "@": "/src", // optional: allows imports like @/Components/Button.vue
        },
    },
    
});
