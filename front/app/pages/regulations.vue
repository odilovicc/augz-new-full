<template>
  <div>
    <!-- Hero -->
    <section class="relative overflow-hidden bg-gray-950 min-h-[280px] md:min-h-[360px] flex items-end">
      <div class="absolute inset-0">
        <div class="absolute inset-0 bg-linear-to-br from-gray-950/95 via-gray-950/80 to-gray-900/70" />
      </div>

      <div class="relative container mx-auto px-4 pb-12 md:pb-16 pt-24 md:pt-28">
        <nav class="flex items-center gap-2 text-xs text-white/50 mb-5">
          <NuxtLink :to="localePath('/')" class="hover:text-white transition-colors">{{ t('nav.home') }}</NuxtLink>
          <span>/</span>
          <span class="text-white/80">{{ heroText('title_1') || t('regulations_page.heading_1') }} {{ heroText('title_2') || t('regulations_page.heading_2') }}</span>
        </nav>

        <span class="text-[10px] font-bold uppercase tracking-widest text-(--theme-color) mb-3 block">
          {{ heroText('badge') || t('regulations_page.badge') }}
        </span>
        <h1 class="text-3xl sm:text-5xl md:text-6xl font-black uppercase leading-[1.05] tracking-tight">
          <span class="text-white block">{{ heroText('title_1') || t('regulations_page.heading_1') }}</span>
          <span class="text-(--theme-color) block mt-1">{{ heroText('title_2') || t('regulations_page.heading_2') }}</span>
        </h1>
        <p class="mt-4 text-xs md:text-sm leading-relaxed text-white/50 max-w-xl">
          {{ heroText('subtitle') || t('regulations_page.subtitle') }}
        </p>
      </div>

      <div class="absolute right-10 bottom-10 opacity-10 hidden lg:block">
        <img src="~/assets/img/Logo.svg" alt="" class="h-20 brightness-0 invert" />
      </div>
    </section>

    <!-- Content -->
    <section class="section bg-gray-50">
      <div class="container mx-auto px-4">

        <!-- Search + filters card -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-3 md:p-4 mb-6 md:mb-8 flex flex-col gap-3">
          <!-- Search -->
          <div class="relative">
            <Icon name="heroicons:magnifying-glass" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" />
            <input
              v-model="searchQuery"
              type="search"
              :placeholder="t('regulations_page.search_placeholder')"
              class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-(--theme-color) transition-colors bg-gray-50 placeholder:text-gray-400"
            />
          </div>

          <!-- Type tabs — pill style, horizontal scroll on mobile -->
          <div class="flex items-center gap-2 overflow-x-auto scrollbar-none -mx-3 px-3 md:mx-0 md:px-0 md:flex-wrap">
            <button
              v-for="tab in tabs"
              :key="tab.id"
              class="flex items-center gap-1.5 px-3 md:px-4 py-1.5 rounded-full text-xs md:text-sm font-semibold transition-all duration-200 cursor-pointer whitespace-nowrap shrink-0"
              :class="activeType === tab.id
                ? 'bg-gray-900 text-white shadow-sm'
                : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50'"
              @click="activeType = tab.id"
            >
              <span
                class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full shrink-0"
                :style="{ background: dotColor(tab.id) }"
              />
              {{ t(`regulations_page.type.${tab.id}`) }}
            </button>
          </div>
        </div>

        <!-- Count -->
        <p class="text-xs md:text-sm text-gray-500 mb-4 md:mb-6">
          <span class="font-semibold text-gray-900">{{ filtered.length }}</span>
          {{ ' ' }}{{ filtered.length === 1 ? 'документ' : 'документов' }}
        </p>

        <!-- Table -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
          <div v-if="pending" class="py-20 flex justify-center">
            <Icon name="heroicons:arrow-path" class="w-5 h-5 animate-spin text-gray-300" />
          </div>

          <template v-else-if="filtered.length">
            <!-- Desktop table -->
            <table class="hidden md:table w-full text-sm">
              <thead class="border-b border-gray-100">
                <tr class="text-left text-gray-400 text-xs uppercase tracking-wide">
                  <th class="px-6 py-3 font-medium">Документ</th>
                  <th class="px-6 py-3 font-medium w-52">Номер и дата</th>
                  <th class="px-6 py-3 font-medium w-40">Тип</th>
                  <th class="px-6 py-3 font-medium w-28 text-right">Действие</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-50">
                <tr
                  v-for="doc in filtered"
                  :key="doc.id"
                  class="hover:bg-gray-50 transition-colors"
                >
                  <td class="px-6 py-4">
                    <span class="font-semibold text-gray-900 leading-snug">{{ doc.title }}</span>
                  </td>
                  <td class="px-6 py-4 text-gray-500 text-xs">{{ doc.number }}</td>
                  <td class="px-6 py-4">
                    <span
                      class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold"
                      :style="typeTagStyle(doc.type)"
                    >
                      <span class="w-1.5 h-1.5 rounded-full shrink-0" :style="{ background: dotColor(doc.type) }" />
                      {{ t(`regulations_page.type.${doc.type}`) }}
                    </span>
                  </td>
                  <td class="px-6 py-4 text-right">
                    <a
                      :href="doc.url"
                      target="_blank"
                      rel="noopener noreferrer"
                      class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-semibold bg-(--theme-color) text-white hover:opacity-90 transition-opacity"
                    >
                      {{ t('regulations_page.open_btn') }}
                      <Icon name="heroicons:arrow-top-right-on-square" class="w-3.5 h-3.5" />
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>

            <!-- Mobile cards -->
            <div class="md:hidden divide-y divide-gray-50">
              <div
                v-for="doc in filtered"
                :key="doc.id"
                class="p-4 flex flex-col gap-3"
              >
                <div class="flex items-start justify-between gap-3">
                  <p class="font-semibold text-gray-900 text-sm leading-snug flex-1">{{ doc.title }}</p>
                  <span
                    class="shrink-0 inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold"
                    :style="typeTagStyle(doc.type)"
                  >
                    <span class="w-1.5 h-1.5 rounded-full" :style="{ background: dotColor(doc.type) }" />
                    {{ t(`regulations_page.type.${doc.type}`) }}
                  </span>
                </div>
                <div class="flex items-center justify-between">
                  <span class="text-xs text-gray-400">{{ doc.number }}</span>
                  <a
                    :href="doc.url"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-(--theme-color) text-white hover:opacity-90 transition-opacity"
                  >
                    {{ t('regulations_page.open_btn') }}
                    <Icon name="heroicons:arrow-top-right-on-square" class="w-3 h-3" />
                  </a>
                </div>
              </div>
            </div>
          </template>

          <div v-else class="py-20 text-center text-gray-400">
            {{ t('regulations_page.empty') }}
          </div>
        </div>

      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
const { t, locale } = useI18n()
const localePath = useLocalePath()
const config = useRuntimeConfig()
const siteUrl = config.public.siteUrl as string

useSeoMeta({
  title: t('regulations_page.seo_title'),
  description: t('regulations_page.seo_desc'),
  ogType: 'website',
  ogSiteName: 'АУГЗ',
  ogTitle: t('regulations_page.seo_title'),
  ogDescription: t('regulations_page.seo_desc'),
  ogImage: `${siteUrl}/og-default.jpeg`,
})
useHead({
  link: [{ rel: 'canonical', href: `${siteUrl}/regulations` }],
})

interface RegulatoryDocument {
  id: number
  title: string
  type: string
  number: string | null
  url: string
}

const activeType  = ref('all')
const searchQuery = ref('')

const tabs = [
  { id: 'all' },
  { id: 'law' },
  { id: 'decree' },
  { id: 'resolution' },
  { id: 'order' },
]

// CMS page content (hero static text)
const { data: pageData } = await useAsyncData(
  'page-regulations',
  () => $fetch<{ slug: string; content: any }>(`${config.public.apiBase}/page/regulations`),
)

const hero = computed(() => pageData.value?.content?.hero ?? {})

function heroText(field: string): string {
  const val = hero.value[field]
  if (!val) return ''
  return val[locale.value] ?? val.ru ?? ''
}

// Documents list
const { data: rawDocs, pending } = await useAsyncData(
  'regulatory-documents',
  () => $fetch<{ data: RegulatoryDocument[] }>(`${config.public.apiBase}/regulatory-documents`),
)

const documents = computed(() => rawDocs.value?.data ?? [])

const filtered = computed(() => {
  let list = documents.value

  if (activeType.value !== 'all') {
    list = list.filter(d => d.type === activeType.value)
  }

  const q = searchQuery.value.trim().toLowerCase()
  if (q) {
    list = list.filter(d =>
      d.title.toLowerCase().includes(q) ||
      (d.number ?? '').toLowerCase().includes(q),
    )
  }

  return list
})

const DOT_COLORS: Record<string, string> = {
  all:        '#9ca3af',
  law:        '#3b82f6',
  decree:     '#D1832C',
  resolution: '#10b981',
  order:      '#8b5cf6',
}

function dotColor(type: string): string {
  return DOT_COLORS[type] ?? '#9ca3af'
}

function typeTagStyle(type: string) {
  const color = dotColor(type)
  return {
    background: `${color}18`,
    color,
  }
}
</script>
