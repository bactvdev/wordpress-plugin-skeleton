import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path'

export default defineConfig({
  server: {
    host: '0.0.0.0',
    port: 3000,
    origin: 'http://localhost:3000',
    cors: true,
    headers: {
      'Access-Control-Allow-Origin': '*', // Allow all origins
    },
  },
  build: {
    manifest: true,
    outDir: 'dist',
    rollupOptions: {
      input: {
        admin: resolve(__dirname, './assets/src/admin/main.js'),
        public: resolve(__dirname, './assets/src/public/main.js'),
      },
    }
  },
  plugins: [vue()]
})
