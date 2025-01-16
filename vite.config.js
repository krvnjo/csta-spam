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
        'resources/js/theme.min.js',
        'resources/js/modules/auth/auth-user.js',
        'resources/js/modules/borrow-reservation/ongoing.js',
        'resources/js/modules/borrow-reservation/request.js',
        'resources/js/modules/file-maintenance/brand-crud.js',
        'resources/js/modules/file-maintenance/category-crud.js',
        'resources/js/modules/file-maintenance/department-crud.js',
        'resources/js/modules/file-maintenance/designation-crud.js',
        'resources/js/modules/file-maintenance/requester-crud.js',
        'resources/js/modules/item-transactions/new-transaction.js',
        'resources/js/modules/other/account.js',
        'resources/js/modules/other/audit-history.js',
        'resources/js/modules/other/system-settings.js',
        'resources/js/modules/properties-assets/property-child-crud.js',
        'resources/js/modules/properties-assets/property-stock-crud.js',
        'resources/js/modules/repair-maintenance/history.js',
        'resources/js/modules/repair-maintenance/ongoing.js',
        'resources/js/modules/repair-maintenance/request.js',
        'resources/js/modules/user-management/role.js',
        'resources/js/modules/user-management/user.js',
      ],
      refresh: true,
    }),
  ],
});
