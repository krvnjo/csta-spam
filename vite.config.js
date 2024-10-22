import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/css/docs.min.css',
        'resources/css/docs-dark.min.css',
        'resources/css/theme.min.css',
        'resources/css/theme-dark.min.css',
        'resources/js/app.js',
        'resources/js/hs.theme-appearance.js',
        'resources/js/hs.theme-appearance-charts.js',
        'resources/js/hs-style-switcher.js',
        'resources/js/hs-window-config.js',
      ],
      refresh: true,
    }),
  ],
});
