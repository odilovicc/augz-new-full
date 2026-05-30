<template>
  <header class="sticky top-0 z-50 bg-white border-b border-gray-100">
    <div class="container mx-auto px-4">
      <div class="py-4 flex justify-between items-center">
        <Logo />

        <!-- Desktop nav -->
        <ul class="hidden lg:flex items-center gap-x-5">
          <li v-for="link in links" :key="link.href">
            <NuxtLink :to="localePath(link.href)" class="px-1 py-0.5 hover:text-(--theme-color) transition">
              {{ link.label }}
            </NuxtLink>
          </li>
        </ul>

        <!-- Desktop actions -->
        <div class="hidden lg:flex items-center gap-x-6">
          <LocaleSwitcher />
          <NuxtLink :to="localePath('/report')">
            <UiButton>{{ t('nav.report') || 'Подать жалобу' }}</UiButton>
          </NuxtLink>
        </div>

        <!-- Mobile burger -->
        <button @click="open = !open" class="lg:hidden p-2 -mr-2 rounded-md hover:bg-gray-50 transition">
          <svg v-if="!open" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Mobile dropdown -->
      <div v-if="open" class="lg:hidden pb-5 border-t border-gray-100 pt-4 flex flex-col gap-y-5">
        <ul class="flex flex-col gap-y-1">
          <li v-for="link in links" :key="link.href">
            <NuxtLink :to="localePath(link.href)" @click="open = false"
               class="block px-2 py-2 rounded-md hover:bg-gray-50 hover:text-(--theme-color) transition">
              {{ link.label }}
            </NuxtLink>
          </li>
        </ul>
        <div class="flex items-center gap-x-4 pt-3 border-t border-gray-100">
          <LocaleSwitcher />
          <NuxtLink :to="localePath('/report')">
            <UiButton>{{ t('nav.report') || 'Подать жалобу' }}</UiButton>
          </NuxtLink>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup lang="ts">
const { t } = useI18n()
const localePath = useLocalePath()
const open = ref(false)

const links = computed(() => [
  { href: '/about',      label: t('nav.about') },
  { href: '/news',       label: t('nav.news') },
  { href: '/services',   label: t('nav.services') },
  { href: '/markets',   label: t('nav.markets') },
  { href: '/membership', label: t('nav.membership') },
  { href: '/contacts',   label: t('nav.contacts') },
])
</script>
