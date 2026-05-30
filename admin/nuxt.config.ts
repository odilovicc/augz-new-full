export default defineNuxtConfig({
  modules: ['@nuxt/ui'],

  devtools: { enabled: true },

  css: ['~/assets/css/main.css'],

  compatibilityDate: '2025-01-15',

  runtimeConfig: {
    public: {
      apiBase: 'http://localhost:8000/api',
    },
  },
})
