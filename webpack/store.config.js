module.exports = (mix) => {
  mix.ts('resources/js/store/app.ts', 'public/js/store.js')

  // Default theme
  mix.sass('./resources/css/themes/default/store.scss', 'public/css/themes/default/')
  // Flat-dark theme
  mix.sass('./resources/css/themes/flat-dark/store.scss', 'public/css/themes/flat-dark/')
  // Flat-light theme
  mix.sass('./resources/css/themes/flat-light/store.scss', 'public/css/themes/flat-light/')
}
