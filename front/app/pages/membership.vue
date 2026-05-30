<template>
    <Membership/>
</template>
<script setup lang="ts">
import Membership from '~/components/membership/index.vue'

useSeoMeta({
  title: 'Членство в АУГЗ — вступить в ассоциацию',
  description: 'Станьте членом АУГЗ и получите доступ к юридической поддержке, аналитике, обучению и защите ваших интересов в государственных закупках Узбекистана.',
  ogTitle: 'Членство в АУГЗ',
  ogDescription: 'Станьте членом АУГЗ и получите доступ к юридической поддержке, аналитике, обучению и защите интересов в государственных закупках.',
  ogImage: '/og-default.jpg',
  ogUrl: 'https://augz.uz/membership',
  ogType: 'website',
  twitterCard: 'summary_large_image',
  twitterTitle: 'Членство в АУГЗ',
  twitterDescription: 'Вступите в АУГЗ — ассоциацию участников государственных закупок Узбекистана.',
})
</script>