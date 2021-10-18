const colors = require('tailwindcss/colors')

module.exports = {
  purge: [],
  darkMode: false, // or 'media' or 'class'
  theme: {
    colors: {
      gray: colors.trueGray,
      blue: colors.blue,
      orange: colors.amber,
      white: colors.white,
      green: colors.emerald,
      red: colors.red,
      yellow: colors.yellow,
      bluegray: colors.blueGray,
    },
    extend: {
      
    },
  },
  variants: {
    extend: {

    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/line-clamp'),
  ],
}
