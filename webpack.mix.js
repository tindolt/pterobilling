const mix = require('laravel-mix')
const path = require('path')
const ESLintPlugin = require('eslint-webpack-plugin')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// Configure PostCSS plugins
mix.options({
  postCss: [require('autoprefixer'), require('tailwindcss')],
})

/**
 * DEFAULT THEME
 */
mix.sass('./resources/css/themes/default/app.scss', 'public/css/themes/default/base.css')

/**
 * FLAT-DARK THEME
 */
mix.sass('./resources/css/themes/flat-dark/app.scss', 'public/css/themes/flat-dark/base.css')

/**
 * FLAT-LIGHT THEME
 */
mix.sass('./resources/css/themes/flat-light/app.scss', 'public/css/themes/flat-light/base.css')

/**
 * Frontend configuration
 */
// Aliases
mix.alias({
  '@': path.join(__dirname, 'resources/js'),
})
// ESLint / Prettier
mix.webpackConfig({
  plugins: [
    new ESLintPlugin({
      context: path.resolve(__dirname, 'resources/js'),
      extensions: ['ts', 'tsx'],
      fix: true,
      threads: true,
    }),
  ],
})
mix.ts('resources/js/app.ts', 'public/js').react()

if (mix.inProduction()) {
  mix.version()
} else {
  mix.sourceMaps()
}
