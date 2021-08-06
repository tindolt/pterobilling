module.exports = (mix) => {
  mix.ts('resources/js/client/app.ts', 'public/js/client.js')

  // Default theme
  mix.sass('./resources/css/themes/default/client.scss', 'public/css/themes/default/')
  // Flat-dark theme
  mix.sass('./resources/css/themes/flat-dark/client.scss', 'public/css/themes/flat-dark/')
  // Flat-light theme
  mix.sass('./resources/css/themes/flat-light/client.scss', 'public/css/themes/flat-light/')
}
