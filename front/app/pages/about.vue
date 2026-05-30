<template>
  <div>
    <AboutHero />
  </div>
</template>

<script setup lang="ts">
import type { AboutPageContent } from '~/composables/usePageContent'

const config = useRuntimeConfig()
const aboutContent = useAboutPageContent()

const { data } = await useFetch<{ slug: string; content: AboutPageContent }>(
  `${config.public.apiBase}/page/about`,
  { key: 'about-page', server: true },
)

if (data.value?.content) {
  aboutContent.value = data.value.content
}

useSeoMeta({
  title: 'О нас — АУГЗ',
  description: 'АУГЗ — некоммерческая ассоциация, объединяющая участников государственных закупок Узбекистана. Наша миссия: честные тендеры, поддержка бизнеса, развитие отрасли.',
  ogTitle: 'О нас — АУГЗ',
  ogDescription: 'АУГЗ — некоммерческая ассоциация, объединяющая участников государственных закупок Узбекистана.',
  ogImage: '/og-default.jpg',
  ogUrl: 'https://augz.uz/about',
  ogType: 'website',
  twitterCard: 'summary_large_image',
  twitterTitle: 'О нас — АУГЗ',
  twitterDescription: 'АУГЗ — некоммерческая ассоциация, объединяющая участников государственных закупок Узбекистана.',
})
</script>
