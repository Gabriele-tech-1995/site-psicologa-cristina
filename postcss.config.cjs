/* PurgeCSS in production: elenchi solo classi realmente usate (purge-safelist.txt).
   Evita regex tipo /^p-/ che tengono centinaia di utility Bootstrap mai usate → meno CSS “barrato” in DevTools. */
const fs = require('fs');
const path = require('path');
const purgecss = require('@fullhuman/postcss-purgecss');

const production = process.env.NODE_ENV === 'production';

const safelistFile = path.join(__dirname, 'resources/css/purge-safelist.txt');
const safelistFromFile = fs.existsSync(safelistFile)
    ? fs
          .readFileSync(safelistFile, 'utf8')
          .split('\n')
          .map((l) => l.trim())
          .filter((l) => l.length > 0 && !l.startsWith('#'))
    : [];

/** Stati / prefissi Bootstrap che non compaiono letteralmente nel Blade ma servono a runtime. */
const safelistPatterns = [
    /^accordion/,
    /^offcanvas/,
    /^collapse/,
    /^collapsing$/,
    /^collapsed$/,
    /^show$/,
    /^fade$/,
    /^modal/,
    /^data-bs-/,
    /^page-(item|link)$/,
    /^pagination/,
    /^alert-dismissible/,
];

module.exports = {
    plugins: production
        ? [
              purgecss({
                  content: [
                      './resources/**/*.blade.php',
                      './resources/**/*.php',
                      './resources/**/*.js',
                      './resources/**/*.scss',
                  ],
                  safelist: {
                      standard: [...safelistFromFile, ...safelistPatterns],
                      deep: [/^toast/, /^tooltip/],
                  },
              }),
          ]
        : [],
};
