module.exports = {
  mode: 'jit',
  purge: {
    enabled: true,
    content: [
      './storage/framework/view/*.php',
      './resources/**/*.blade.php',
      './resources/**/*.ts',
      './resources/**/*.tsx',
      './resources/**/*.css',
      './resources/**/*.scss',
    ],
  },
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
