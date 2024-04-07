// tailwind.config.js

module.exports = {
  content: [
    './templates/**/*.html.twig',
    './assets/**/*.scss',
     './assets/**/*.css',
    './node_modules/tw-elements/dist/js/**/*.js',
    './src/**/*.{html,js}'
    
  ],
  theme: {
    extend: {
      fontSize: {
        sm: ['14px', '20px'],
        base: ['16px', '24px'],
        lg: ['20px', '28px'],
        xl: ['24px', '32px'],
      }
    }
  },
  plugins: [
    require('@tailwindcss/forms'),
    // require("daisyui"),
    // require('tw-elements/dist/plugin'),
    //  require('flowbite/plugin'),
    //   require('tw-elements')
  ],
};
