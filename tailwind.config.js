/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './vendor/filament/**/*.blade.php',
  ],
  theme: {
    extend: {
        colors: {
            danger: colors.rose,
            primary: colors.blue,
            success: colors.green,
            warning: colors.yellow,
        },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}

