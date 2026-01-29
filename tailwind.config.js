/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./views/**/*.php",
    "./admin/**/*.php",
    "./app/**/*.php",
    "./index.php"
  ],
  theme: {
    extend: {
      colors: {
        // Operon Premium Technical Palette
        petrol: {
          deep: '#0A3A3A',   // Main Backgrounds
          mid: '#164A4A',    // Cards / Secondary
          DEFAULT: '#0A3A3A',
        },
        olive: {
          light: '#9AB89C',  // Accents
          subtle: '#E8F3E9', // Light Backgrounds
          DEFAULT: '#9AB89C',
        },
        neutral: {
          dark: '#1A1A1A',   // Primary Text
          mid: '#6B6B6B',    // Secondary Text
          light: '#E5E5E5',  // Borders
        },
        softwhite: {
          DEFAULT: '#F9F9F7', // Base Background (Off-white)
          pure: '#FFFFFF',
        },
        metallic: '#A8B5A8', // Tech accents
      },
      fontFamily: {
        serif: ['Montserrat', 'sans-serif'], // Used for Headings/Títulos
        sans: ['Inter', 'system-ui', 'sans-serif'], // Used for Body/Texto
        mono: ['JetBrains Mono', 'SF Mono', 'monospace'],
        poppins: ['Poppins', 'sans-serif'], // Auxiliary
      },
      fontSize: {
        'display': ['4.5rem', { lineHeight: '1', letterSpacing: '-0.02em' }],
        'heading': ['3rem', { lineHeight: '1.1', letterSpacing: '-0.01em' }],
        'tech-sm': ['0.875rem', { lineHeight: '1.5', letterSpacing: '0.05em' }], // For mono text
      },
      borderRadius: {
        'sm': '8px',
        'DEFAULT': '12px',
        'md': '14px',
        'lg': '16px',
        'xl': '20px',
        '2xl': '24px',
        'pill': '999px',
      },
      boxShadow: {
        'soft': '0 2px 8px rgba(10, 58, 58, 0.08)',
        'card': '0 1px 2px rgba(0, 0, 0, 0.04), 0 4px 8px rgba(0, 0, 0, 0.06), 0 12px 32px rgba(0, 0, 0, 0.08)', // iOS Multi-layer
        'lift': '0 4px 12px rgba(0, 0, 0, 0.08), 0 16px 48px rgba(0, 0, 0, 0.12)', // iOS Hover Lift
        'glow': '0 0 20px rgba(154, 184, 156, 0.4)',
      },
      backgroundImage: {
        'grid-pattern': "linear-gradient(to right, rgba(0, 0, 0, 0.05) 1px, transparent 1px), linear-gradient(to bottom, rgba(0, 0, 0, 0.05) 1px, transparent 1px)",
        'grid-pattern-dark': "linear-gradient(to right, rgba(255, 255, 255, 0.05) 1px, transparent 1px), linear-gradient(to bottom, rgba(255, 255, 255, 0.05) 1px, transparent 1px)",
      },
      animation: {
        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
      },
      keyframes: {
        fadeInUp: {
          '0%': { opacity: '0', transform: 'translateY(20px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
      },
    },
  },
  plugins: [],
}
