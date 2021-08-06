module.exports = (mix) => {
  // Configure PostCSS plugins
  mix.options({
    postCss: [require('autoprefixer'), require('tailwindcss')],
  })
}
