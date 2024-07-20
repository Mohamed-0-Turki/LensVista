/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./**/*.{html,js,php}",
    "./App/Views**/*.{html,js,php}",
    "./App/Views/Includes**/*.{html,js,php}"
  ],
  theme: {
    extend: {
      keyframes: {
        fadeInUp: {
          '0%': { opacity: 0, transform: 'translateY(100%)' },
          '100%': { opacity: 1, transform: 'translateY(0)' },
        },
        fadeInRight: {
          '0%': { opacity: 0, transform: 'translateX(100%)' },
          '100%': { opacity: 1, transform: 'translateX(0)' },
        },
        fadeInLeft: {
          '0%': { opacity: 0, transform: 'translateX(-100%)' },
          '100%': { opacity: 1, transform: 'translateX(0)' },
        },
        fadeOn: {
          '0%': { opacity: 0, display: 'none' },
          '100%': { opacity: 1, display: 'block' },
        },
      },
      animation: {
        fadeInUp: 'fadeInUp 0.5s ease-out',
        fadeInRight: 'fadeInRight 0.5s ease-out',
        fadeInLeft: 'fadeInLeft 0.5s ease-out',
        fadeOn: 'fadeOn 0.5s ease-out',
      },
      colors: {
        'blue': '#0000EE',
        'purple': '#551a8b',
        'light-gray': '#EEEEEE',
        'slate-gray': '#686D76',
        'white': '#ffffff',
        'silver-mist': '#c3c6d1',
        'black': '#000000',
        'midnight-sapphire': '#183153',
        'red': '#ff0000',
        'solid-red': '#bb2828',
        'sunburst-gold': '#ffd43b',
        'goldenrod-blaze': '#fab005',
        'sky-breeze-blue': '#74c0fc',
        'cerulean-depths': '#146ebe',
        'lavender-bliss': '#b197fc',
        'royal-amethyst': '#6741d9',
        'turquoise-splash': '#0ca678',
        'emerald-envy': '#06533c',
      }
    },
  },
  plugins: [],
}

