export default defineNuxtConfig({
  modules: ['@nuxt/ui'],

  devtools: { enabled: true },

  css: ['~/assets/css/main.css'],

  compatibilityDate: '2025-01-15',

  runtimeConfig: {
    public: {
      apiBase: 'https://e422-2a05-45c2-5037-9200-94e-6baf-23f-f6b9.ngrok-free.app/api',
    },
  },
})
