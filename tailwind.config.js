module.exports = {
  purge: [
      './storage/framework/view/*.php',
      './resources/**/*.blade.php',
      './resources/**/*.js',
      './resources/**/*.jsx',
      './resources/**/*.css',
      './resources/**/*.scss'
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
