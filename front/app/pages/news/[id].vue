<template>
  <div>
    <div v-if="pending" class="min-h-screen flex items-center justify-center">
      <div class="w-8 h-8 border-2 border-gray-200 border-t-(--theme-color) rounded-full animate-spin" />
    </div>

    <div v-else-if="!article" class="min-h-screen flex flex-col items-center justify-center gap-4 text-gray-400">
      <span class="text-6xl">404</span>
      <p>Материал не найден</p>
      <NuxtLink :to="localePath('/news')" class="text-sm font-semibold text-(--theme-color) hover:underline">← Все материалы</NuxtLink>
    </div>

    <template v-else>
      <!-- Hero -->
      <section
        class="relative min-h-[380px] flex items-end overflow-hidden"
        :class="article.image ? '' : 'bg-gray-950'"
      >
        <template v-if="article.image">
          <img :src="article.image" :alt="article.title" class="absolute inset-0 w-full h-full object-cover" />
          <div class="absolute inset-0 bg-linear-to-t from-black/85 via-black/40 to-black/10" />
        </template>
        <div v-else class="absolute inset-0 bg-linear-to-br from-gray-950 to-gray-800" />

        <div class="relative w-full max-w-7xl mx-auto px-4 pb-12 pt-32">
          <!-- Breadcrumb -->
          <nav class="flex items-center gap-2 text-sm text-white/50 mb-6">
            <NuxtLink :to="localePath('/')" class="hover:text-white transition-colors">{{ t('nav.home') }}</NuxtLink>
            <span>/</span>
            <NuxtLink :to="localePath('/news')" class="hover:text-white transition-colors">{{ t('news_page.title_plain') }}</NuxtLink>
            <span>/</span>
            <span class="text-white/70 line-clamp-1 max-w-xs">{{ article.title }}</span>
          </nav>

          <!-- Category badge -->
          <div class="mb-4">
            <span
              class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-widest px-3 py-1.5 rounded-full"
              :style="categoryBadgeStyle(article.category)"
            >
              <span class="w-1.5 h-1.5 rounded-full bg-current" />
              {{ t(`news_page.category.${article.category}`) }}
            </span>
          </div>

          <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-white leading-tight max-w-4xl">
            {{ article.title }}
          </h1>

          <!-- Meta row -->
          <div class="flex flex-wrap items-center gap-4 mt-6 text-sm text-white/50">
            <span v-if="article.source" class="flex items-center gap-1.5">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 015.656 0l4 4a4 4 0 01-5.656 5.656l-1.1-1.1" />
              </svg>
              {{ article.source }}
            </span>
            <span v-if="article.published_at" class="flex items-center gap-1.5">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                <line x1="16" y1="2" x2="16" y2="6" /><line x1="8" y1="2" x2="8" y2="6" /><line x1="3" y1="10" x2="21" y2="10" />
              </svg>
              {{ formatDate(article.published_at) }}
            </span>
            <span class="flex items-center gap-1.5">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
              {{ article.views + 1 }} просмотров
            </span>
          </div>
        </div>
      </section>

      <!-- Body -->
      <section class="section bg-white">
        <div class="w-full max-w-7xl mx-auto px-4">
          <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1fr)_320px] gap-12">

            <!-- Main content -->
            <article class="min-w-0 overflow-hidden">
              <!-- Excerpt lead -->
              <p class="text-lg leading-relaxed text-gray-600 font-medium border-l-4 pl-5 mb-8" :style="{ borderColor: categoryColor(article.category) }">
                {{ article.excerpt }}
              </p>

              <!-- Rich HTML content -->
              <div
                v-if="article.content"
                class="article-body"
                v-html="sanitizedContent"
              />

              <!-- Tags -->
              <div v-if="article.tags?.length" class="flex flex-wrap gap-2 mt-10 pt-8 border-t border-gray-100">
                <NuxtLink
                  v-for="tag in article.tags"
                  :key="tag"
                  :to="localePath('/news')"
                  class="text-xs px-3 py-1.5 rounded-full bg-gray-100 text-gray-600 hover:bg-(--theme-color) hover:text-white transition-all"
                >
                  {{ tag }}
                </NuxtLink>
              </div>

              <!-- Back link -->
              <div class="mt-10">
                <NuxtLink
                  :to="localePath('/news')"
                  class="inline-flex items-center gap-2 text-sm font-semibold text-(--theme-color) hover:gap-3 transition-all"
                >
                  ← {{ t('news_page.back_to_list') }}
                </NuxtLink>
              </div>
            </article>

            <!-- Sidebar wrapper — full grid height; inner div is sticky -->
            <div class="hidden lg:block">
            <aside class="flex flex-col gap-6 sticky top-24 max-h-[calc(100vh-7rem)] overflow-y-auto">

              <!-- More articles -->
              <div class="bg-gray-50 rounded-2xl p-5">
                <h4 class="font-bold text-xs uppercase tracking-widest text-gray-400 mb-4">{{ t('news_page.more_articles') }}</h4>
                <ul class="flex flex-col gap-4">
                  <li v-for="item in relatedArticles" :key="item.id" class="group">
                    <NuxtLink :to="`/news/${item.id}`" class="flex flex-col gap-1.5">
                      <span
                        class="text-[10px] font-bold uppercase tracking-widest"
                        :style="{ color: categoryColor(item.category) }"
                      >
                        {{ t(`news_page.category.${item.category}`) }}
                      </span>
                      <p class="text-sm font-semibold leading-snug line-clamp-2 group-hover:text-(--theme-color) transition-colors">
                        {{ item.title }}
                      </p>
                      <span class="text-xs text-gray-400">{{ formatDate(item.published_at) }}</span>
                    </NuxtLink>
                  </li>
                </ul>
              </div>

              <!-- Share -->
              <div class="bg-gray-50 rounded-2xl p-5">
                <h4 class="font-bold text-xs uppercase tracking-widest text-gray-400 mb-4">{{ t('news_page.share') }}</h4>
                <div class="flex gap-2">
                  <button
                    class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl bg-[#2AABEE] text-white text-sm font-semibold hover:opacity-90 transition-opacity cursor-pointer"
                    @click="shareTelegram"
                  >
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z" />
                    </svg>
                    Telegram
                  </button>
                  <button
                    class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl bg-gray-200 text-gray-700 text-sm font-semibold hover:bg-gray-300 transition-colors cursor-pointer"
                    @click="copyLink"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    {{ copied ? 'Скопировано!' : 'Скопировать' }}
                  </button>
                </div>
              </div>

            </aside>
            </div>
          </div>
        </div>
      </section>
    </template>
  </div>
</template>

<script setup lang="ts">
import DOMPurify from 'dompurify'
const localePath = useLocalePath()

const { t, locale } = useI18n()
const config = useRuntimeConfig()
const route  = useRoute()

// id is static per-page — no need for computed
const articleId = route.params.id as string

interface Article {
  id: number
  title: string
  excerpt: string
  content: string | null
  image: string | null
  category: string
  source: string | null
  tags: string[]
  views: number
  is_featured: boolean
  published_at: string | null
}

// Fetch article — key is stable, locale triggers re-fetch via watch
const { data: articleData, pending } = await useAsyncData(
  `news-article-${articleId}`,
  () => $fetch<{ data: Article }>(`${config.public.apiBase}/news/${articleId}?lang=${locale.value}`),
  { watch: [locale] },
)

const article = computed<Article | null>(() => articleData.value?.data ?? null)

// Sanitize rich HTML before rendering (DOMPurify only runs on client)
const sanitizedContent = computed(() => {
  const html = article.value?.content ?? ''
  if (!html || !import.meta.client) return html
  return DOMPurify.sanitize(html, {
    ALLOWED_TAGS: ['p','br','b','strong','i','em','u','s','h1','h2','h3','h4','ol','ul','li','blockquote','pre','code','a','span','div'],
    ALLOWED_ATTR: ['href','target','rel','class'],
  })
})

// Related — fetched after article resolves, keyed by category
const { data: relatedData } = await useAsyncData(
  `news-related-${articleId}`,
  () => $fetch<{ data: Article[] }>(
    `${config.public.apiBase}/news?lang=${locale.value}&per_page=5` +
    (article.value?.category ? `&category=${article.value.category}` : ''),
  ),
  { watch: [locale] },
)

const relatedArticles = computed(() =>
  (relatedData.value?.data ?? [])
    .filter(a => a.id !== article.value?.id)
    .slice(0, 4),
)

// ── SEO ───────────────────────────────────────────────────────────────────

const siteUrl = config.public.siteUrl as string
const canonicalUrl = computed(() => `${siteUrl}/news/${articleId}`)

useSeoMeta({
  // Basic
  title: () => article.value ? `${article.value.title} — АУГЗ` : 'Материал — АУГЗ',
  description: () => article.value?.excerpt ?? '',
  keywords: () => article.value?.tags?.join(', ') ?? '',

  // Open Graph (Facebook, Telegram, VK, WhatsApp)
  ogType: 'article',
  ogSiteName: 'АУГЗ',
  ogTitle: () => article.value?.title ?? '',
  ogDescription: () => article.value?.excerpt ?? '',
  ogImage: () => article.value?.image ?? `${siteUrl}/og-default.jpeg`,
  ogImageWidth: '1200',
  ogImageHeight: '630',
  ogUrl: () => canonicalUrl.value,
  ogLocale: () => locale.value === 'uz' ? 'uz_UZ' : locale.value === 'en' ? 'en_US' : 'ru_RU',

  // Article-specific Open Graph
  articlePublishedTime: () => article.value?.published_at ?? undefined,
  articleSection: () => article.value?.category ?? undefined,
  articleTag: () => article.value?.tags ?? [],

  // Twitter / X Cards
  twitterCard: 'summary_large_image',
  twitterTitle: () => article.value?.title ?? '',
  twitterDescription: () => article.value?.excerpt ?? '',
  twitterImage: () => article.value?.image ?? `${siteUrl}/og-default.jpeg`,
})

// JSON-LD structured data (NewsArticle schema.org) — read by Google News, Search
const jsonLd = computed(() => {
  if (!article.value) return '{}'
  return JSON.stringify({
    '@context': 'https://schema.org',
    '@type': 'NewsArticle',
    'headline': article.value.title,
    'description': article.value.excerpt,
    'image': article.value.image
      ? [article.value.image]
      : [`${siteUrl}/og-default.jpeg`],
    'datePublished': article.value.published_at ?? undefined,
    'dateModified': article.value.published_at ?? undefined,
    'url': canonicalUrl.value,
    'inLanguage': locale.value === 'uz' ? 'uz' : locale.value === 'en' ? 'en' : 'ru',
    'publisher': {
      '@type': 'Organization',
      'name': 'АУГЗ — Ассоциация участников государственных закупок',
      'url': siteUrl,
      'logo': {
        '@type': 'ImageObject',
        'url': `${siteUrl}/logo.png`,
      },
    },
    'mainEntityOfPage': {
      '@type': 'WebPage',
      '@id': canonicalUrl.value,
    },
    'keywords': article.value.tags?.join(', ') ?? undefined,
    'articleSection': article.value.category ?? undefined,
    'isAccessibleForFree': true,
  })
})

const breadcrumbLd = computed(() => JSON.stringify({
  '@context': 'https://schema.org',
  '@type': 'BreadcrumbList',
  'itemListElement': [
    { '@type': 'ListItem', position: 1, name: 'Главная', item: siteUrl },
    { '@type': 'ListItem', position: 2, name: 'Новости', item: `${siteUrl}/news` },
    { '@type': 'ListItem', position: 3, name: article.value?.title ?? '', item: canonicalUrl.value },
  ],
}))

useHead({
  link: [{ rel: 'canonical', href: () => canonicalUrl.value }],
  script: [
    { type: 'application/ld+json', innerHTML: () => jsonLd.value },
    { type: 'application/ld+json', innerHTML: () => breadcrumbLd.value },
  ],
})

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

function categoryBadgeStyle(cat: string) {
  const c = categoryColor(cat)
  return { color: c, background: `${c}20` }
}

function formatDate(iso: string | null): string {
  if (!iso) return ''
  return new Date(iso).toLocaleDateString('ru-RU', { day: 'numeric', month: 'long', year: 'numeric' })
}

// ── Share ─────────────────────────────────────────────────────────────────

function shareTelegram() {
  if (!import.meta.client) return
  const url = encodeURIComponent(window.location.href)
  const text = encodeURIComponent(article.value?.title ?? '')
  window.open(`https://t.me/share/url?url=${url}&text=${text}`, '_blank')
}

const copied = ref(false)
async function copyLink() {
  if (!import.meta.client) return
  await navigator.clipboard.writeText(window.location.href)
  copied.value = true
  setTimeout(() => { copied.value = false }, 2000)
}
</script>

<style>
/* Article rich text body styles */
.article-body {
  color: rgb(17 24 39);
  line-height: 1.8;
  font-size: 1rem;
  overflow-wrap: break-word;
  word-break: break-word;
  min-width: 0;
}

.article-body h1,
.article-body h2,
.article-body h3 {
  font-weight: 700;
  line-height: 1.3;
  margin-top: 2rem;
  margin-bottom: 0.75rem;
}

.article-body h1 { font-size: 1.75rem; }
.article-body h2 { font-size: 1.4rem; }
.article-body h3 { font-size: 1.15rem; }

.article-body p {
  margin-bottom: 1rem;
}

.article-body ul,
.article-body ol {
  padding-left: 1.5rem;
  margin-bottom: 1rem;
}

.article-body ul { list-style: disc; }
.article-body ol { list-style: decimal; }

.article-body li {
  margin-bottom: 0.35rem;
}

.article-body blockquote {
  border-left: 4px solid #D1832C;
  padding: 0.75rem 1.25rem;
  margin: 1.5rem 0;
  background: rgb(249 250 251);
  border-radius: 0 0.5rem 0.5rem 0;
  color: rgb(75 85 99);
  font-style: italic;
}

.article-body pre {
  background: rgb(17 24 39);
  color: rgb(229 231 235);
  padding: 1rem 1.25rem;
  border-radius: 0.75rem;
  overflow-x: auto;
  font-size: 0.85rem;
  margin: 1.5rem 0;
}

.article-body code {
  font-family: 'Menlo', 'Monaco', monospace;
}

.article-body a {
  color: #D1832C;
  text-decoration: underline;
  text-underline-offset: 3px;
}

.article-body a:hover {
  opacity: 0.8;
}

.article-body strong,
.article-body b {
  font-weight: 700;
}

.article-body em,
.article-body i {
  font-style: italic;
}
</style>
