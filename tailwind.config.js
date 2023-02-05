/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      colors: {
        'base': '#051C2A',
        'primary': '#785964',
      },
      fontFamily: {
        'raleway': 'Raleway',
        'scp': 'SourceCodePro',
      }
    },
  },
  plugins: [
    require('@tailwindcss/line-clamp'),
  ],
}
