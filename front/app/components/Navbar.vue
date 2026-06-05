<template>
  <header class="sticky top-0 z-50 bg-white border-b border-gray-100">
    <div class="container mx-auto px-4">

      <!-- Row 1: Logo + actions -->
      <div class="py-3 flex justify-between items-center border-b border-gray-50">
        <Logo />

        <!-- Desktop actions -->
        <div class="hidden lg:flex items-center gap-x-5">
          <LocaleSwitcher />
          <NuxtLink :to="localePath('/report')">
            <UiButton>{{ t('nav.report') || 'Подать жалобу' }}</UiButton>
          </NuxtLink>
        </div>

        <!-- Mobile burger -->
        <button type="button" @click="open = !open" class="lg:hidden cursor-pointer p-2 -mr-2 rounded-md hover:bg-gray-50 transition">
          <svg v-if="!open" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Row 2: Nav links (desktop only) -->
      <nav class="hidden lg:flex items-center gap-x-1 py-1.5 overflow-x-auto scrollbar-none">
        <NuxtLink
          v-for="link in links"
          :key="link.href"
          :to="localePath(link.href)"
          class="px-3 py-1.5 rounded-md text-sm whitespace-nowrap hover:text-(--theme-color) hover:bg-orange-50 transition-colors"
          :class="$route.path === localePath(link.href) || $route.path.startsWith(localePath(link.href) + '/') ? 'text-(--theme-color) font-semibold' : 'text-gray-600'"
        >
          {{ lt(link.label) }}
        </NuxtLink>
      </nav>

      <!-- Mobile dropdown -->
      <div v-show="open" class="lg:hidden pb-5 border-t border-gray-100 pt-4 flex flex-col gap-y-5">
        <ul class="flex flex-col gap-y-1">
          <li v-for="link in links" :key="link.href">
            <NuxtLink
              :to="localePath(link.href)"
              @click="open = false"
              class="block px-2 py-2 rounded-md hover:bg-gray-50 hover:text-(--theme-color) transition"
            >
              {{ lt(link.label) }}
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
const config = useRuntimeConfig()
const lt = useLocaleText()
const route = useRoute()

const open = ref(false)

const { data: links } = await useAsyncData(
  'navbar-links',
  () => $fetch<{ data: any[] }>(`${config.public.apiBase}/navbar`)
    .then(res => res.data),
  { default: () => [] }
)
</script>
