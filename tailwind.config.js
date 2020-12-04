const plugin = require('tailwindcss/plugin')

module.exports = {
  purge: [
    './resources/views/**/*.php',
    './resources/assets/js/**/*.js',
    './resources/assets/js/**/*.vue',
    './resources/assets/sass/**/*.scss',
    './node_modules/@bytefury/spacewind/**/*.js',
    './node_modules/@bytefury/spacewind/**/*.vue',
    './node_modules/flatpickr/**/*.js',
    './node_modules/toastr/**/*.js',
    './public/js/pace/**/*.js',
  ],
  theme: {
    extend: {
      fontFamily: {
        base: ['Poppins', 'sans-serif'],
      },
      colors: {
        primary: {
          50: '#FEF2F2',
          100: '#FEE2E2',
          200: '#FECACA',
          300: '#FCA5A5',
          400: '#F87171',
          500: '#EF4444',
          600: '#DC2626',
          700: '#B91C1C',
          800: '#991B1B',
          900: '#7F1D1D',
        },
        black: '#040405',
      },
      spacing: {
        7: '1.75rem',
        9: '2.25rem',
        72: '18rem',
        80: '20rem',
        88: '22rem',
        96: '24rem',
      },
      screens: {
        xxl: '1440px',
      },
    },
  },
  variants: {
    textColor: ['responsive', 'hover', 'focus', 'active', 'visited'],
    borderColor: ['responsive', 'hover', 'focus', 'active', 'focus-within'],
    borderRadius: ['responsive', 'hover', 'first', 'last'],
    boxShadow: ['responsive', 'hover', 'focus', 'active', 'group-hover'],
    borderStyle: ['responsive', 'hover', 'first', 'last'],
    borderWidth: ['responsive', 'last', 'hover', 'focus'],
  },
  plugins: [
    require('@bytefury/spacewind/plugin'),

    plugin(({ config, addBase }) => {
      let craterDefaultTypography = {
        fontFamily: config('theme.fontFamily.base'),
      }
      addBase({
        '.h1': {
          ...craterDefaultTypography,
        },
        '.h2': {
          ...craterDefaultTypography,
        },
        '.h3': {
          ...craterDefaultTypography,
        },
        '.h4': {
          ...craterDefaultTypography,
        },
        '.h5': {
          ...craterDefaultTypography,
        },
        '.h6': {
          ...craterDefaultTypography,
        },
        '.page-title': {
          ...craterDefaultTypography,
        },
        '.section-title': {
          ...craterDefaultTypography,
        },
      })
    }),
  ],
}
