<template>
  <Navbar/>
  <NuxtLayout>
    <NuxtPage />
  </NuxtLayout>
</template>

<script setup lang="ts">
useHead({
  script: [
    {
      type: 'application/ld+json',
      innerHTML: JSON.stringify({
        '@context': 'https://schema.org',
        '@type': 'Organization',
        name: 'АУГЗ — Ассоциация участников государственных закупок',
        alternateName: 'AUGZ',
        url: 'https://augz.uz',
        logo: 'https://augz.uz/img/logo.png',
        contactPoint: {
          '@type': 'ContactPoint',
          telephone: '+998-55-503-12-21',
          email: 'info@augz.uz',
          contactType: 'customer service',
          availableLanguage: ['Russian', 'Uzbek'],
          hoursAvailable: {
            '@type': 'OpeningHoursSpecification',
            dayOfWeek: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
            opens: '09:00',
            closes: '18:00',
          },
        },
        address: {
          '@type': 'PostalAddress',
          streetAddress: 'ул. Нукуса, 89',
          addressLocality: 'Ташкент',
          addressRegion: 'Мирабадский район',
          postalCode: '100000',
          addressCountry: 'UZ',
        },
        sameAs: ['https://t.me/augz_uz'],
      }),
    },
  ],
})
</script>
