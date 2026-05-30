import tailwindcss from '@tailwindcss/vite'

export default defineNuxtConfig({
  compatibilityDate: '2025-07-15',
  devtools: { enabled: true },
  modules: ['@nuxt/icon', '@nuxt/fonts', '@nuxtjs/i18n', '@nuxtjs/sitemap'],

  i18n: {
    locales: [
      { code: 'ru', language: 'ru-RU', name: 'Русский' },
      { code: 'uz', language: 'uz-UZ', name: "O'zbekcha" },
      { code: 'en', language: 'en-US', name: 'English' },
    ],
    defaultLocale: 'ru',
    strategy: 'prefix_except_default',
  },

  site: {
    url: process.env.NUXT_PUBLIC_SITE_URL ?? 'https://augz.uz',
    name: 'АУГЗ — Ассоциация участников государственных закупок',
    description: 'Новости, аналитика и события в сфере государственных закупок Узбекистана',
    defaultLocale: 'ru',
  },

  sitemap: {
    sources: ['/api/__sitemap__/urls'],
    exclude: ['/report'],
    urls: [
      { loc: '/privacy', priority: 0.5, changefreq: 'yearly' },
      { loc: '/appeals-rules', priority: 0.5, changefreq: 'yearly' },
    ],
  },

  runtimeConfig: {
    public: {
      yandexMapsApiKey: process.env.NUXT_PUBLIC_YANDEX_MAPS_API_KEY ?? '',
      apiBase: process.env.NUXT_PUBLIC_API_BASE ?? 'http://localhost:8000/api',
      siteUrl: process.env.NUXT_PUBLIC_SITE_URL ?? 'https://augz.uz',
    },
  },


  app: {
    head: {
      link: [
        { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
        { rel: 'icon', type: 'image/png', sizes: '16x16', href: '/favicon-16x16.png' },
        { rel: 'icon', type: 'image/png', sizes: '32x32', href: '/favicon-32x32.png' },
        { rel: 'apple-touch-icon', sizes: '180x180', href: '/apple-touch-icon.png' },
        { rel: 'manifest', href: '/site.webmanifest' },
      ],
    },
  },

  css: ['./app/assets/css/main.css'],
  vite: {
    plugins: [
      tailwindcss(),
    ],
    server: {
      allowedHosts: ['6dea-94-158-58-172.ngrok-free.app', 'e724-2a05-45c2-5037-9200-94e-6baf-23f-f6b9.ngrok-free.app']
    }
  },
})