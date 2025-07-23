import { defineConfig } from 'vite';

export default defineConfig({
  build: {
    outDir: 'public',
    rollupOptions: {
      input: {
        app: 'resources/css/app.css',
        main: 'resources/js/app.js',
      },
    },
  },
  css: {
    postcss: {
      plugins: [
        require('tailwindcss'),
        require('autoprefixer'),
      ],
    },
  },
}); 