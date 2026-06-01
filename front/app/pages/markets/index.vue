<template>
  <div>
    <!-- Hero -->
    <div class="relative overflow-hidden min-h-[60vh] md:min-h-[72vh] flex items-center bg-gray-100">
      <img src="/img/Hero.png" alt="" class="absolute inset-0 w-full h-full object-cover object-center" />
      <div class="absolute inset-0 bg-linear-to-r from-white/95 via-white/70 to-white/10" />

      <div class="relative container mx-auto px-4 pb-16 pt-32">
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
          <NuxtLink :to="localePath('/')" class="hover:text-(--theme-color) transition-colors">{{ t('nav.home') }}</NuxtLink>
          <span>/</span>
          <NuxtLink :to="localePath('/services')" class="hover:text-(--theme-color) transition-colors">{{ t('nav.services') }}</NuxtLink>
          <span>/</span>
          <span class="text-(--theme-color) font-medium">{{ t('nav.markets') }}</span>
        </nav>

        <div class="flex items-center gap-2 mb-5">
          <span class="w-8 h-0.5 bg-(--theme-color)" />
          <span class="text-xs font-bold uppercase tracking-[0.2em] text-gray-600">{{ heroText('badge') || t('markets_page.badge') }}</span>
        </div>

        <h1 class="text-4xl sm:text-5xl md:text-6xl font-black uppercase leading-none mb-5">
          <span class="block">{{ heroText('title_1') || t('markets_page.title_1') }}</span>
          <span class="block text-(--theme-color)">{{ heroText('title_2') || t('markets_page.title_2') }}</span>
        </h1>

        <p class="text-sm sm:text-base text-gray-600 max-w-sm leading-relaxed">
          {{ heroText('subtitle') || t('markets_page.subtitle') }}
        </p>
      </div>
    </div>

    <!-- Sticky filter bar -->
    <div class="sticky top-0 z-20 bg-white border-b border-gray-100 shadow-xs">
      <div class="container mx-auto px-4">
        <div class="flex items-center gap-2 py-3 overflow-x-auto scrollbar-hide">
          <button
            v-for="cat in categories"
            :key="cat.id"
            class="flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-semibold whitespace-nowrap border transition-all shrink-0"
            :class="activeCategory === cat.id
              ? 'bg-gray-900 text-white border-gray-900'
              : 'text-gray-600 border-gray-200 hover:border-gray-400 hover:text-gray-900 bg-white'"
            @click="activeCategory = cat.id"
          >
            {{ cat.label }}
          </button>

          <div class="relative ml-auto shrink-0">
            <Icon name="heroicons:magnifying-glass" class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400 pointer-events-none" />
            <input
              v-model="searchQuery"
              type="search"
              :placeholder="t('markets_page.search_placeholder')"
              class="pl-8 pr-3 py-1.5 text-sm rounded-full border border-gray-200 bg-gray-50 focus:outline-none focus:border-(--theme-color) transition-colors w-48"
            />
          </div>
        </div>
      </div>
    </div>

    <!-- Main layout: content + sidebar -->
    <section class="section bg-[#f5f5f0]">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-[1fr_300px] gap-8 items-start">

          <!-- Left: grouped market sections -->
          <div class="flex flex-col gap-10">

            <template v-for="group in visibleGroups" :key="group.id">
              <!-- Group heading -->
              <div>
                <div class="flex items-center gap-2 mb-3">
                  <span class="w-6 h-0.5 bg-(--theme-color)" />
                  <span class="text-xs font-bold uppercase tracking-[0.18em] text-(--theme-color)">{{ group.label }}</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black uppercase leading-tight mb-6">{{ group.heading }}</h2>

                <!-- Market rows -->
                <div class="flex flex-col gap-3">
                  <a
                    v-for="market in group.paged"
                    :key="market.id"
                    :href="market.url"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="group bg-white rounded-xl border border-gray-100 hover:border-(--theme-color)/40 hover:shadow-sm transition-all flex items-center gap-4 p-4"
                  >
                    <!-- Logo -->
                    <div
                      class="w-16 h-16 rounded-xl shrink-0 flex items-center justify-center overflow-hidden text-white font-black text-lg select-none"
                      :style="market.logo_color ? `background:${market.logo_color}` : 'background:#e5e7eb'"
                    >
                      <img
                        v-if="market.logo"
                        :src="market.logo"
                        :alt="market.name"
                        class="w-full h-full object-contain"
                      />
                      <span v-else class="text-sm font-black text-gray-400">{{ market.name.slice(0, 2).toUpperCase() }}</span>
                    </div>

                    <!-- Text -->
                    <div class="flex-1 min-w-0">
                      <p class="font-bold text-gray-900 group-hover:text-(--theme-color) transition-colors leading-snug mb-0.5">{{ market.name }}</p>
                      <p class="text-sm font-semibold text-gray-500 mb-1.5">{{ market.subtitle }}</p>
                      <p class="text-sm text-gray-400 leading-relaxed line-clamp-2">{{ market.desc }}</p>
                      <div class="flex flex-wrap gap-1.5 mt-2">
                        <span
                          v-for="tag in market.tags"
                          :key="tag"
                          class="text-[10px] font-bold uppercase tracking-wide px-2 py-0.5 rounded bg-gray-100 text-gray-500"
                        >{{ tag }}</span>
                      </div>
                    </div>

                    <!-- Action -->
                    <div class="shrink-0 flex flex-col items-end gap-1.5 ml-2">
                      <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-(--theme-color) text-white text-sm font-semibold rounded-lg group-hover:opacity-90 transition-opacity whitespace-nowrap">
                        {{ $t('markets_page_ui.visit_btn') }}
                      </span>
                    </div>
                  </a>
                </div>

                <!-- Pagination -->
                <div v-if="group.totalPages > 1" class="flex items-center gap-1 mt-5">
                  <button
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-semibold border border-gray-200 text-gray-400 hover:border-gray-400 hover:text-gray-700 transition-colors disabled:opacity-30 disabled:cursor-not-allowed"
                    :disabled="group.page === 1"
                    @click="setPage(group.id, group.page - 1)"
                  >←</button>

                  <template v-for="p in group.totalPages" :key="p">
                    <button
                      class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-semibold transition-colors"
                      :class="group.page === p
                        ? 'bg-gray-900 text-white'
                        : 'border border-gray-200 text-gray-600 hover:border-gray-400'"
                      @click="setPage(group.id, p)"
                    >{{ p }}</button>
                  </template>

                  <button
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-semibold border border-gray-200 text-gray-400 hover:border-gray-400 hover:text-gray-700 transition-colors disabled:opacity-30 disabled:cursor-not-allowed"
                    :disabled="group.page === group.totalPages"
                    @click="setPage(group.id, group.page + 1)"
                  >→</button>

                  <span class="ml-2 text-xs text-gray-400">{{ group.items.length }} {{ $t('markets_page_ui.pagination_suffix') }}</span>
                </div>
              </div>
            </template>

            <!-- Empty state -->
            <div v-if="visibleGroups.length === 0" class="text-center py-20 text-gray-400">
              <Icon name="heroicons:magnifying-glass" class="w-10 h-10 mx-auto mb-3 opacity-30" />
              <p class="text-sm">{{ t('markets_page.empty') }}</p>
            </div>
          </div>

          <!-- Sidebar -->
          <aside class="flex flex-col gap-5 lg:sticky lg:top-20">

            <!-- Quick access -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
              <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-4">{{ $t('markets_page_ui.quick_access') }}</p>
              <div class="flex flex-col gap-1">
                <a
                  v-for="market in quickAccess"
                  :key="market.id"
                  :href="market.url"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-50 transition-colors group"
                >
                  <div class="flex items-center gap-2.5">
                    <div
                      class="w-7 h-7 rounded-md shrink-0 flex items-center justify-center overflow-hidden text-white text-[10px] font-black"
                      :style="market.logo_color ? `background:${market.logo_color}` : 'background:#e5e7eb'"
                    >
                      <img v-if="market.logo" :src="market.logo" :alt="market.name" class="w-full h-full object-contain" />
                      <span v-else class="text-gray-400">{{ market.name.slice(0, 1) }}</span>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-(--theme-color) transition-colors">
                      {{ stripProtocol(market.url) }}
                    </span>
                  </div>
                  <Icon name="heroicons:arrow-right" class="w-3.5 h-3.5 text-gray-300 group-hover:text-(--theme-color) transition-colors shrink-0" />
                </a>
              </div>
            </div>

            <!-- Help block -->
            <div class="bg-gray-900 rounded-2xl p-5 flex flex-col gap-3">
              <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ $t('markets_page_ui.need_help') }}</p>
              <div>
                <p class="font-bold text-white text-sm leading-snug mb-1">{{ $t('markets_page_ui.help_title') }}</p>
                <p class="text-xs text-gray-400 leading-relaxed">{{ $t('markets_page_ui.help_desc') }}</p>
              </div>
              <button class="w-full px-4 py-2.5 bg-(--theme-color) text-white text-sm font-semibold rounded-lg hover:opacity-90 transition-opacity">
                {{ $t('markets_page_ui.help_btn') }}
              </button>
            </div>

            <!-- Stats -->
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
              <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-4">{{ $t('markets_page_ui.stats_title') }}</p>
              <div class="flex flex-col gap-2.5">
                <div
                  v-for="cat in statsCategories"
                  :key="cat.id"
                  class="flex items-center justify-between cursor-pointer group"
                  @click="activeCategory = cat.id"
                >
                  <span class="text-sm text-gray-600 group-hover:text-(--theme-color) transition-colors">{{ cat.label }}</span>
                  <span class="text-sm font-bold text-gray-900">{{ countByCategory(cat.id) }}</span>
                </div>
              </div>
            </div>

          </aside>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
const { t, locale, t: $t } = useI18n()
const config = useRuntimeConfig()
const localePath = useLocalePath()

const siteUrl = config.public.siteUrl as string
useSeoMeta({
  title: 'Торговые площадки Узбекистана — АУГЗ',
  description: 'Полный каталог государственных и корпоративных закупочных платформ Узбекистана: официальные ссылки, описания и инструкции по регистрации.',
  ogType: 'website',
  ogSiteName: 'АУГЗ',
  ogTitle: 'Торговые площадки Узбекистана — АУГЗ',
  ogDescription: 'Полный каталог закупочных платформ Узбекистана.',
  ogImage: `${siteUrl}/og-default.jpeg`,
  ogUrl: `${siteUrl}/markets`,
  twitterCard: 'summary_large_image',
})
useHead({
  link: [{ rel: 'canonical', href: `${siteUrl}/markets` }],
})

// ── Hero from CMS ─────────────────────────────────────────────────────────

const { data: pageData } = await useAsyncData(
  'markets-page',
  () => $fetch<{ slug: string; content: any }>(`${config.public.apiBase}/page/markets`),
)

const hero = computed(() => pageData.value?.content?.hero ?? {})
function heroText(field: string): string {
  const val = hero.value[field]
  if (!val) return ''
  if (typeof val === 'string') return val
  return val[locale.value] ?? val.ru ?? ''
}

// ── Types ─────────────────────────────────────────────────────────────────

interface Market {
  id: number
  name: string
  subtitle: string
  desc: string
  url: string
  logo?: string
  logo_color?: string
  category: 'government' | 'corporate' | 'aggregator' | 'international'
  tags: string[]
}

// ── Platforms from API ────────────────────────────────────────────────────

const { data: platformsData } = await useAsyncData(
  'trading-platforms',
  () => $fetch<{ data: Market[] }>(`${config.public.apiBase}/trading-platforms?lang=${locale.value}`),
  { watch: [locale] },
)

const markets = computed<Market[]>(() => platformsData.value?.data ?? [])

const categoryGroups = computed(() => [
  {
    id: 'government',
    label: $t('markets_page_ui.category_government_label'),
    heading: $t('markets_page_ui.category_government_heading'),
  },
  {
    id: 'corporate',
    label: $t('markets_page_ui.category_corporate_label'),
    heading: $t('markets_page_ui.category_corporate_heading'),
  },
  {
    id: 'aggregator',
    label: $t('markets_page_ui.category_aggregator_label'),
    heading: $t('markets_page_ui.category_aggregator_heading'),
  },
  {
    id: 'international',
    label: $t('markets_page_ui.category_international_label'),
    heading: $t('markets_page_ui.category_international_heading'),
  },
])

const categories = computed(() => [
  { id: 'all', label: $t('markets_page_ui.category_all') },
  ...categoryGroups.value.filter(g => markets.value.some(m => m.category === g.id)),
])

// ── Filter state ──────────────────────────────────────────────────────────

const activeCategory = ref('all')
const searchQuery    = ref('')
const PER_PAGE       = 3
const pageByGroup    = reactive<Record<string, number>>({})

function setPage(groupId: string, page: number) {
  pageByGroup[groupId] = page
}

// Reset pages when filter/search changes
watch([activeCategory, searchQuery], () => {
  categoryGroups.value.forEach(g => { pageByGroup[g.id] = 1 })
})

// ── Derived ───────────────────────────────────────────────────────────────

const visibleGroups = computed(() => {
  const q = searchQuery.value.trim().toLowerCase()
  return categoryGroups.value
    .filter(g => activeCategory.value === 'all' || activeCategory.value === g.id)
    .map(g => {
      const items = markets.value.filter(m => {
        if (m.category !== g.id) return false
        if (!q) return true
        return (
          m.name.toLowerCase().includes(q) ||
          m.subtitle.toLowerCase().includes(q) ||
          m.desc.toLowerCase().includes(q) ||
          m.tags.some(tag => tag.toLowerCase().includes(q))
        )
      })
      const totalPages = Math.ceil(items.length / PER_PAGE)
      const page       = Math.min(pageByGroup[g.id] ?? 1, totalPages || 1)
      const paged      = items.slice((page - 1) * PER_PAGE, page * PER_PAGE)
      return { ...g, items, paged, page, totalPages }
    })
    .filter(g => g.items.length > 0)
})

const quickAccess = computed(() => markets.value.slice(0, 6))

const statsCategories = computed(() => categoryGroups.value.map(g => ({ id: g.id, label: g.heading })))

function stripProtocol(url: string) { return url.replace(/^https?:\/\//, '') }

function countByCategory(catId: string) {
  return markets.value.filter(m => m.category === catId).length
}
</script>
