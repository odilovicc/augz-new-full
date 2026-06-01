export default defineNuxtConfig({
  modules: ['@nuxt/ui'],

  devtools: { enabled: true },

  css: ['~/assets/css/main.css'],

  compatibilityDate: '2025-01-15',

  runtimeConfig: {
    public: {
      apiBase: 'https://mirasoft.pyramide.uz/api',
    },
  },

  vite: {
    server: {
      allowedHosts: ['08db-2a05-45c2-1074-4500-99d1-2871-8a5-82f5.ngrok-free.app']
    }
  }
})
