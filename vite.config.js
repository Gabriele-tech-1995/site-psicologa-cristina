import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.scss', 'resources/css/admin.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        target: 'es2022',
        cssTarget: 'chrome110',
        cssMinify: 'lightningcss',
        modulePreload: {
            polyfill: false,
        },
        esbuild: {
            legalComments: 'none',
        },
    },
    css: {
        preprocessorOptions: {
            scss: {
                quietDeps: true,
                silenceDeprecations: ['import', 'global-builtin', 'color-functions'],
            },
        },
    },
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
