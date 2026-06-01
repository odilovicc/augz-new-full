<template>
  <div>
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gray-950 min-h-[320px] md:min-h-[420px] flex items-end">
      <!-- Background image with overlay -->
      <div class="absolute inset-0">
        <img
          src="https://images.unsplash.com/photo-1486325212027-8081e485255e?w=1600&q=80"
          alt=""
          class="w-full h-full object-cover opacity-40"
        />
        <div class="absolute inset-0 bg-linear-to-br from-gray-950/90 via-gray-950/60 to-transparent" />
      </div>

      <!-- Diagonal white cut at bottom -->
      <div class="absolute bottom-0 left-0 right-0 h-12 md:h-24 hidden bg-white" style="clip-path: polygon(0 100%, 100% 100%, 100% 40%, 0 100%)" />

      <div class="relative container mx-auto px-4 pb-14 md:pb-20 pt-24 md:pt-32">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs md:text-sm text-white/50 mb-5 md:mb-8">
          <a href="/" class="hover:text-white transition-colors">{{ t('nav.home') }}</a>
          <span>/</span>
          <span class="text-white/80">{{ t('news_page.title_plain') }}</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5 md:gap-8">
          <div class="max-w-lg">
            <h1 class="text-3xl sm:text-5xl md:text-6xl font-black uppercase leading-[1.05] tracking-tight">
              <span class="text-white block">{{ t('news_page.heading_1') }}</span>
              <span class="text-(--theme-color) block mt-2">{{ t('news_page.heading_2') }}</span>
            </h1>
            <p class="mt-3 md:mt-5 text-xs md:text-sm leading-relaxed text-white/60 max-w-sm">
              {{ t('news_page.subtitle') }}
            </p>
          </div>

          <!-- Stats row -->
          <div class="flex gap-6 md:gap-10 pb-1">
            <div v-for="stat in heroStats" :key="stat.value" class="flex flex-col gap-1">
              <span class="text-xl md:text-3xl font-black text-white">{{ stat.value }}</span>
              <span class="text-[10px] md:text-xs text-white/40 uppercase tracking-wider">{{ stat.label }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Logo watermark -->
      <div class="absolute right-10 bottom-20 opacity-20 hidden lg:block">
        <img src="~/assets/img/Logo.svg" alt="" class="h-20 brightness-0 invert" />
      </div>
    </section>

    <!-- Featured articles row -->
    <section class="bg-white border-b border-gray-100">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-gray-100">
          <NuxtLink
            v-for="article in featuredArticles"
            :key="article.id"
            :to="localePath(`/news/${article.id}`)"
            class="group py-5 md:py-8 md:px-8 first:pl-0 last:pr-0 flex flex-col gap-2 md:gap-3"
          >
            <span class="text-[10px] font-bold uppercase tracking-widest" :style="{ color: categoryColor(article.category) }">
              {{ t(`news_page.category.${article.category}`) }}
            </span>
            <h3 class="font-bold text-sm md:text-base leading-snug group-hover:text-(--theme-color) transition-colors line-clamp-2 md:line-clamp-3">
              {{ article.title }}
            </h3>
            <p class="hidden md:block text-sm text-gray-500 leading-relaxed line-clamp-3">{{ article.excerpt }}</p>
            <div class="flex items-center justify-between mt-auto pt-1 md:pt-2">
              <span class="text-xs text-gray-400">{{ formatDate(article.published_at) }}</span>
              <span class="text-xs md:text-sm font-semibold text-(--theme-color) flex items-center gap-1 group-hover:gap-2 transition-all">
                {{ t('news_page.read') }} →
              </span>
            </div>
          </NuxtLink>
        </div>
      </div>
    </section>

    <!-- Main content: filters + list + sidebar -->
    <section class="section bg-gray-50">
      <div class="container mx-auto px-4">

        <!-- Filter bar -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-3 md:p-4 mb-6 md:mb-8 flex flex-col gap-3">
          <!-- Search input -->
          <div class="relative">
            <Icon name="heroicons:magnifying-glass" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" />
            <input
              v-model="searchQuery"
              type="search"
              :placeholder="t('news_page.search_placeholder') || 'Поиск по новостям...'"
              class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-(--theme-color) transition-colors bg-gray-50 placeholder:text-gray-400"
              @input="onSearchInput"
            />
          </div>

          <!-- Category tabs — horizontal scroll on mobile -->
          <div class="flex items-center gap-2 overflow-x-auto scrollbar-none -mx-3 px-3 md:mx-0 md:px-0 md:flex-wrap">
            <button
              v-for="cat in categories"
              :key="cat.id"
              class="flex items-center gap-1.5 px-3 md:px-4 py-1.5 rounded-full text-xs md:text-sm font-semibold transition-all duration-200 cursor-pointer whitespace-nowrap shrink-0"
              :class="activeCategory === cat.id
                ? 'bg-gray-900 text-white shadow-sm'
                : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50'"
              @click="setCategory(cat.id)"
            >
              <span
                v-if="cat.id !== 'all'"
                class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full shrink-0"
                :style="{ background: categoryColor(cat.id) }"
              />
              {{ t(`news_page.category.${cat.id}`) }}
            </button>
          </div>

          <!-- Sort buttons -->
          <div class="flex items-center gap-1 overflow-x-auto scrollbar-none -mx-3 px-3 md:mx-0 md:px-0">
            <button
              v-for="sort in sorts"
              :key="sort.id"
              class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 cursor-pointer whitespace-nowrap shrink-0"
              :class="activeSort === sort.id
                ? 'bg-gray-900 text-white'
                : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50'"
              @click="activeSort = sort.id"
            >
              {{ t(`news_page.sort.${sort.id}`) }}
            </button>
          </div>
        </div>

        <!-- Active tag indicator -->
        <div v-if="activeTag" class="flex items-center gap-2 mb-4">
          <span class="text-sm text-gray-500">Тег:</span>
          <span class="flex items-center gap-1 text-sm font-semibold bg-(--theme-color) text-white px-3 py-1 rounded-full">
            {{ activeTag }}
            <button class="hover:opacity-70 transition-opacity cursor-pointer ml-1" @click="activeTag = null">×</button>
          </span>
        </div>

        <!-- Results count -->
        <p class="text-xs md:text-sm text-gray-500 mb-4 md:mb-6">
          <span class="font-semibold text-gray-900">{{ totalCount }}</span>
          {{ ' ' }}{{ t('news_page.materials') }}
        </p>

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_300px] gap-8">

          <!-- Left column: article list + pagination -->
          <div class="flex flex-col gap-4">
          <div class="flex flex-col divide-y divide-gray-200 bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
            <TransitionGroup name="list">
              <NuxtLink
                v-for="article in filteredArticles"
                :key="article.id"
                :to="localePath(`/news/${article.id}`)"
                class="group flex flex-col sm:flex-row gap-3 p-4 sm:p-6 hover:bg-gray-50 transition-colors"
              >
                <!-- Image: top on mobile, right on sm+ -->
                <div v-if="article.image" class="sm:hidden w-full h-40 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                  <img
                    :src="article.image"
                    :alt="article.title"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                  />
                </div>

                <div class="flex flex-col gap-2 flex-1 min-w-0">
                  <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-[10px] font-bold uppercase tracking-widest" :style="{ color: categoryColor(article.category) }">
                      {{ t(`news_page.category.${article.category}`) }}
                    </span>
                    <span class="text-xs text-gray-300">·</span>
                    <span class="text-xs text-gray-400 truncate max-w-[120px]">{{ article.source }}</span>
                    <span class="text-xs text-gray-400 ml-auto">{{ formatDate(article.published_at) }}</span>
                  </div>
                  <h3 class="font-bold text-sm sm:text-base leading-snug group-hover:text-(--theme-color) transition-colors">
                    {{ article.title }}
                  </h3>
                  <span
                    v-if="article.source_url"
                    role="link"
                    class="text-xs text-gray-400 hover:text-(--theme-color) transition-colors truncate cursor-pointer"
                    @click.prevent.stop="openUrl(article.source_url)"
                  >{{ article.source_url }}</span>
                  <p class="text-xs sm:text-sm text-gray-500 leading-relaxed line-clamp-2">{{ article.excerpt }}</p>
                  <div class="flex items-center justify-between pt-1">
                    <div class="flex flex-wrap gap-1.5">
                      <span
                        v-for="tag in article.tags"
                        :key="tag"
                        class="text-xs rounded-full px-2.5 py-0.5 transition-colors cursor-pointer"
                        :class="activeTag === tag
                          ? 'bg-(--theme-color) text-white'
                          : 'text-gray-500 bg-gray-100 hover:bg-gray-200'"
                        @click.stop="setTag(tag)"
                      >
                        {{ tag }}
                      </span>
                    </div>
                    <span class="text-xs sm:text-sm font-semibold text-(--theme-color) flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity shrink-0 ml-4">
                      {{ t('news_page.read') }} →
                    </span>
                  </div>
                </div>

                <!-- Image: right column on sm+ -->
                <div class="hidden sm:block shrink-0 w-28 h-20 rounded-xl overflow-hidden bg-gray-100 self-start mt-1">
                  <img
                    v-if="article.image"
                    :src="article.image"
                    :alt="article.title"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                  />
                </div>
              </NuxtLink>
            </TransitionGroup>

            <div v-if="filteredArticles.length === 0 && !listPending" class="p-16 text-center text-gray-400">
              {{ t('news_page.empty') }}
            </div>

            <!-- Loading spinner -->
            <div v-if="listPending" class="p-8 flex justify-center">
              <Icon name="heroicons:arrow-path" class="w-5 h-5 animate-spin text-gray-300" />
            </div>
          </div>

          <!-- Pagination -->
          <div v-if="totalPages > 1" class="flex items-center justify-center gap-1">
            <button
              class="w-9 h-9 rounded-lg flex items-center justify-center text-sm font-semibold transition-colors disabled:opacity-30 disabled:cursor-not-allowed cursor-pointer border border-gray-200 hover:border-gray-400 text-gray-500"
              :disabled="currentPage === 1"
              @click="goToPage(currentPage - 1)"
            >
              ←
            </button>

            <template v-for="p in paginationPages" :key="p">
              <span v-if="p === '...'" class="w-9 h-9 flex items-center justify-center text-gray-400 text-sm">…</span>
              <button
                v-else
                class="w-9 h-9 rounded-lg flex items-center justify-center text-sm font-semibold transition-colors cursor-pointer"
                :class="currentPage === p
                  ? 'bg-gray-900 text-white'
                  : 'border border-gray-200 hover:border-gray-400 text-gray-700'"
                @click="goToPage(Number(p))"
              >
                {{ p }}
              </button>
            </template>

            <button
              class="w-9 h-9 rounded-lg flex items-center justify-center text-sm font-semibold transition-colors disabled:opacity-30 disabled:cursor-not-allowed cursor-pointer border border-gray-200 hover:border-gray-400 text-gray-500"
              :disabled="currentPage === totalPages"
              @click="goToPage(currentPage + 1)"
            >
              →
            </button>
          </div>
          </div><!-- end left column -->

          <!-- Sidebar -->
          <aside class="flex flex-col gap-6">

            <!-- Categories widget -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-5">
              <h4 class="font-bold text-xs uppercase tracking-widest text-gray-400 mb-4">{{ t('news_page.categories_label') }}</h4>
              <ul class="flex flex-col gap-2">
                <li
                  v-for="cat in categoriesWithCount"
                  :key="cat.id"
                  class="flex items-center justify-between gap-2 cursor-pointer group"
                  @click="setCategory(cat.id)"
                >
                  <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full shrink-0" :style="{ background: categoryColor(cat.id) }" />
                    <span class="text-sm group-hover:text-(--theme-color) transition-colors" :class="activeCategory === cat.id ? 'font-semibold text-(--theme-color)' : 'text-gray-700'">
                      {{ t(`news_page.category.${cat.id}`) }}
                    </span>
                  </div>
                  <span class="text-xs text-gray-400 font-medium">{{ cat.count }}</span>
                </li>
              </ul>
            </div>

            <!-- Popular widget -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-5">
              <h4 class="font-bold text-xs uppercase tracking-widest text-gray-400 mb-4">{{ t('news_page.popular_label') }}</h4>
              <ul class="flex flex-col gap-4">
                <li v-for="(article, i) in popularArticles" :key="article.id" class="flex gap-3 group cursor-pointer">
                  <span class="text-xl font-black text-gray-100 leading-none shrink-0 w-6">{{ i + 1 }}</span>
                  <div class="flex flex-col gap-1 min-w-0">
                    <p class="text-sm font-semibold leading-snug line-clamp-2 group-hover:text-(--theme-color) transition-colors">{{ article.title }}</p>
                    <div class="flex items-center gap-1 text-xs text-gray-400">
                      <span>{{ article.source }}</span>
                      <span>·</span>
                      <span>{{ article.published_at?.slice(0, 7) }}</span>
                    </div>
                  </div>
                </li>
              </ul>
            </div>

            <!-- Tags widget -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-5">
              <h4 class="font-bold text-xs uppercase tracking-widest text-gray-400 mb-4">{{ t('news_page.tags_label') }}</h4>
              <div class="flex flex-wrap gap-2">
                <span
                  v-for="tag in allTags"
                  :key="tag"
                  class="text-xs px-3 py-1 rounded-full transition-all cursor-pointer"
                  :class="activeTag === tag
                    ? 'bg-(--theme-color) text-white'
                    : 'bg-gray-100 text-gray-600 hover:bg-(--theme-color) hover:text-white'"
                  @click="setTag(tag)"
                >
                  {{ tag }}
                </span>
              </div>
            </div>

            <!-- Newsletter widget -->
            <div class="bg-gray-900 rounded-2xl p-5 flex flex-col gap-4">
              <div>
                <h4 class="font-bold text-white text-sm">{{ t('news_page.newsletter_title') }}</h4>
                <p class="text-xs text-white/50 mt-1 leading-relaxed">{{ t('news_page.newsletter_desc') }}</p>
              </div>
              <div class="flex flex-col gap-2">
                <input
                  type="email"
                  :placeholder="t('news_page.newsletter_placeholder')"
                  class="w-full rounded-lg bg-white/10 border border-white/10 px-3 py-2.5 text-sm text-white placeholder:text-white/30 focus:outline-none focus:border-white/30 transition-colors"
                />
                <button class="w-full bg-(--theme-color) hover:opacity-90 text-white text-sm font-semibold py-2.5 rounded-lg transition-opacity cursor-pointer">
                  {{ t('news_page.newsletter_btn') }}
                </button>
              </div>
            </div>

          </aside>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
const { t, locale } = useI18n()
const config = useRuntimeConfig()
const localePath = useLocalePath()

// SEO for the news listing page
const siteUrl = config.public.siteUrl as string
useSeoMeta({
  title: 'Новости и аналитика — АУГЗ',
  description: 'Актуальные новости, аналитика и события в сфере государственных закупок Узбекистана. Законодательство, расследования, официальные сообщения.',
  ogType: 'website',
  ogSiteName: 'АУГЗ',
  ogTitle: 'Новости и аналитика — АУГЗ',
  ogDescription: 'Актуальные новости, аналитика и события в сфере государственных закупок Узбекистана.',
  ogImage: `${siteUrl}/og-default.jpeg`,
  ogUrl: `${siteUrl}/news`,
  twitterCard: 'summary_large_image',
})
useHead({
  link: [{ rel: 'canonical', href: `${siteUrl}/news` }],
})

// ── Static stats ──────────────────────────────────────────────────────────

const heroStats = [
  { value: '21', label: t('news_page.stat_publications') },
  { value: '2022–2026', label: t('news_page.stat_period') },
  { value: '5+', label: t('news_page.stat_editions') },
]

// ── Types ─────────────────────────────────────────────────────────────────

interface Article {
  id: number
  title: string
  excerpt: string
  image: string | null
  category: string
  source: string | null
  source_url: string | null
  tags: string[]
  views: number
  is_featured: boolean
  published_at: string | null
}

type SortId = 'newest' | 'oldest' | 'popular' | 'analytics_only'

// ── Filter state ──────────────────────────────────────────────────────────

const activeCategory = ref<string>('all')
const activeSort     = ref<SortId>('newest')
const activeTag      = ref<string | null>(null)
const searchQuery    = ref('')
const currentPage    = ref(1)
const PER_PAGE       = 10

let searchTimer: ReturnType<typeof setTimeout> | null = null

function onSearchInput() {
  if (searchTimer) clearTimeout(searchTimer)
  searchTimer = setTimeout(() => {
    currentPage.value = 1
    fetchList()
  }, 350)
}

const categories = [
  { id: 'all' },
  { id: 'news' },
  { id: 'analytics' },
  { id: 'event' },
  { id: 'legislation' },
  { id: 'investigation' },
] as const

const sorts: { id: SortId }[] = [
  { id: 'newest' },
  { id: 'oldest' },
  { id: 'popular' },
  { id: 'analytics_only' },
]

// ── SSR: fetch featured + static sidebar data once ───────────────────────

const { data: featuredData } = await useAsyncData(
  'news-page-featured',
  () => $fetch<{ data: Article[] }>(`${config.public.apiBase}/news/featured?lang=${locale.value}`),
  { watch: [locale] },
)

const { data: categoryCountsData } = await useAsyncData(
  'news-page-counts',
  () => $fetch<Record<string, number>>(`${config.public.apiBase}/news/category-counts`),
)

const { data: tagsData } = await useAsyncData(
  'news-page-tags',
  () => $fetch<{ tag: string; count: number }[]>(`${config.public.apiBase}/news/tags`),
)

// ── Article list — reactive to filters ───────────────────────────────────
// useAsyncData watch doesn't track computed refs — use a plain ref key instead

const listData = ref<{ data: Article[]; meta: { total: number } } | null>(null)
const listPending = ref(false)

async function fetchList() {
  const sort     = activeSort.value === 'analytics_only' ? 'newest' : activeSort.value
  const category = activeSort.value === 'analytics_only'
    ? 'analytics'
    : activeCategory.value === 'all' ? '' : activeCategory.value

  const params = new URLSearchParams({
    lang: locale.value,
    sort,
    per_page: String(PER_PAGE),
    page: String(currentPage.value),
  })
  if (category)            params.set('category', category)
  if (activeTag.value)     params.set('tag', activeTag.value)
  if (searchQuery.value)   params.set('search', searchQuery.value.trim())

  listPending.value = true
  try {
    listData.value = await $fetch<{ data: Article[]; meta: { total: number; last_page: number } }>(
      `${config.public.apiBase}/news?${params}`,
    )
  } finally {
    listPending.value = false
  }
}

// Initial load on SSR
await fetchList()

// Re-fetch on filter or locale change (resets page)
watch([activeCategory, activeSort, activeTag, locale], () => {
  currentPage.value = 1
  fetchList()
})

// ── Derived values ────────────────────────────────────────────────────────

const featuredArticles  = computed(() => featuredData.value?.data ?? [])
const filteredArticles  = computed(() => listData.value?.data ?? [])
const totalCount        = computed(() => listData.value?.meta?.total ?? 0)
const totalPages        = computed(() => listData.value?.meta?.last_page ?? 1)

const paginationPages = computed(() => {
  const total = totalPages.value
  const cur   = currentPage.value
  if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1)
  const pages: (number | '...')[] = [1]
  if (cur > 3) pages.push('...')
  for (let p = Math.max(2, cur - 1); p <= Math.min(total - 1, cur + 1); p++) pages.push(p)
  if (cur < total - 2) pages.push('...')
  pages.push(total)
  return pages
})

function goToPage(p: number) {
  currentPage.value = p
  fetchList()
  window.scrollTo({ top: 0, behavior: 'smooth' })
}

const categoriesWithCount = computed(() =>
  (['news', 'analytics', 'event', 'legislation', 'investigation'] as const).map(id => ({
    id,
    count: categoryCountsData.value?.[id] ?? 0,
  })),
)

const popularArticles = computed(() =>
  [...(listData.value?.data ?? [])]
    .sort((a, b) => b.views - a.views)
    .slice(0, 5),
)

const allTags = computed(() => (tagsData.value ?? []).map(t => t.tag))

// ── Actions ───────────────────────────────────────────────────────────────

function setCategory(id: string) {
  activeCategory.value = id
  activeTag.value = null
}

function setTag(tag: string) {
  activeTag.value = activeTag.value === tag ? null : tag
  activeCategory.value = 'all'
}

// ── Helpers ───────────────────────────────────────────────────────────────

const CATEGORY_COLORS: Record<string, string> = {
  news:          '#6366f1',
  analytics:     '#D1832C',
  event:         '#10b981',
  legislation:   '#3b82f6',
  investigation: '#ef4444',
}

function categoryColor(cat: string): string {
  return CATEGORY_COLORS[cat] ?? '#9ca3af'
}

function formatDate(iso: string | null): string {
  if (!iso) return ''
  return new Date(iso).toLocaleDateString('ru-RU', { day: 'numeric', month: 'long', year: 'numeric' })
}

function openUrl(url: string) {
  window.open(url, '_blank', 'noopener,noreferrer')
}
</script>

<style scoped>
.list-move,
.list-enter-active,
.list-leave-active {
  transition: all 0.3s ease;
}
.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateY(8px);
}
.list-leave-active {
  position: absolute;
  width: 100%;
}
</style>
