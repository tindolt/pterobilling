const mix = require('laravel-mix')
const path = require('path')
const ESLintPlugin = require('eslint-webpack-plugin')
const webpackConfig = require('./webpack')

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
/**
 * Environments parsing
 */
// Part to build (default will build all the parts => admin, client, store)
const part = process.env.MIX_PART || null

/*
 * Configure Options
 */
mix.options({
  hmrOptions: {
    host: '0.0.0.0',
    port: 8080,
  },
  postCss: [require('autoprefixer'), require('tailwindcss')],
})

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

// Admin files
if (part === 'admin' || part === null) webpackConfig.admin(mix)
// Store files
if (part === 'store' || part === null) webpackConfig.store(mix)
// Client files
if (part === 'client' || part === null) webpackConfig.client(mix)

mix.react()

if (mix.inProduction()) {
  mix.version()
} else {
  mix.sourceMaps()
}
