/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/**/*.{js,jsx,ts,tsx,css}',
    './*.php',
    './templates/**/*.php',
  ],
  theme: {
    extend: {
      fontFamily: {
        'site-title': ['var(--font-site-title)', 'Instrument Serif', 'serif'],
        'heading': ['var(--font-heading)', 'Baskerville', 'serif'],
        'body': ['var(--font-body)', 'Instrument Sans', 'sans-serif'],
      },
      colors: {
        'primary': 'var(--color-primary, #D9F275)',
        'button-text': 'var(--color-button-text, #0F2F14)',
        'body': 'var(--color-body, #3D3A3A)',
        'heading': 'var(--color-heading, #0B1134)',
        'background': 'var(--color-background, #FFFFFF)',
      },
      fontSize: {
        'site-title': ['32px', { lineHeight: '1.2', fontWeight: '400' }],
        'heading-1': ['56px', { lineHeight: '1.1', fontWeight: '400' }],
        'heading-2': ['42px', { lineHeight: '1.2', fontWeight: '400' }],
      },
      spacing: {
        'section-desktop': '96px',
        'section-mobile': '64px',
        'container': '1200px',
      },
      borderRadius: {
        'card': '1rem',
      },
      transitionDuration: {
        'button': '200ms',
      },
    },
  },
  plugins: [],
}; 