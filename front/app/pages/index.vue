<template>
  <Hero />
  <SectionAbout />
  <SectionNews />
  <SectionStats />
  <SectionPartners />
</template>

<script setup lang="ts">
import type { HomePageContent } from '~/composables/usePageContent'

const config = useRuntimeConfig()
const pageContent = usePageContent()

const { data } = await useFetch<{ slug: string; content: HomePageContent }>(
  `${config.public.apiBase}/page/home`,
  { key: 'home-page', server: true },
)

if (data.value?.content) {
  pageContent.value = data.value.content
}

useSeoMeta({
  title: 'АУГЗ — Ассоциация участников государственных закупок Узбекистана',
  description: 'Официальный сайт АУГЗ: защита интересов участников тендеров, новости, аналитика и инструменты для государственных закупок Узбекистана.',
  ogTitle: 'АУГЗ — Ассоциация участников государственных закупок',
  ogDescription: 'Официальный сайт АУГЗ: защита интересов участников тендеров, новости, аналитика и инструменты для государственных закупок Узбекистана.',
  ogImage: '/og-default.jpg',
  ogUrl: 'https://augz.uz',
  ogType: 'website',
  twitterCard: 'summary_large_image',
  twitterTitle: 'АУГЗ — Ассоциация участников государственных закупок',
  twitterDescription: 'Официальный сайт АУГЗ: защита интересов участников тендеров, новости, аналитика.',
  twitterImage: '/og-default.jpg',
})
</script>
