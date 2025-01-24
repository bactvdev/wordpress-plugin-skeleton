import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path'
import AutoImport from 'unplugin-auto-import/vite'
import Components from 'unplugin-vue-components/vite'
import { ElementPlusResolver } from 'unplugin-vue-components/resolvers'

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
  plugins: [
    vue(),
    AutoImport({
      resolvers: [ElementPlusResolver()],
    }),
    Components({
      resolvers: [ElementPlusResolver()],
    })]
})
