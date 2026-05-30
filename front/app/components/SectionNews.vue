<template>
  <section id="news" class="section bg-gray-50">
    <div class="container mx-auto px-4">

      <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
        <h2 class="text-3xl md:text-4xl font-black uppercase tracking-tight leading-none">
          {{ t('news.heading') }}
        </h2>
        <div class="flex items-center bg-white rounded-full p-1 shadow-sm border border-gray-100 self-start sm:self-auto shrink-0">
          <button
            v-for="tab in tabs"
            :key="tab.id"
            class="relative px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300 cursor-pointer"
            :class="activeTab === tab.id ? 'bg-(--theme-color) text-white shadow-sm' : 'text-gray-500 hover:text-gray-800'"
            @click="activeTab = tab.id"
          >
            {{ t(tab.labelKey) }}
          </button>
        </div>
      </div>

      <Transition name="tab-fade" mode="out-in">
        <div v-if="activeTab === 'news'" key="news" class="grid grid-cols-1 lg:grid-cols-2 gap-6">

          <div class="flex flex-col divide-y divide-gray-200">
            <article v-for="(item, i) in news" :key="i" class="group flex gap-4 py-5 first:pt-0 last:pb-0">
              <NuxtLink :to="localePath(`/news/${item.id}`)" class="shrink-0 w-28 h-20 rounded-xl overflow-hidden bg-gray-200">
                <img v-if="item.image" :src="item.image" :alt="item.title"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
              </NuxtLink>
              <div class="flex flex-col gap-1 min-w-0">
                <span class="text-xs text-gray-400">{{ item.date }}</span>
                <NuxtLink :to="localePath(`/news/${item.id}`)" class="font-semibold leading-snug line-clamp-2 group-hover:text-(--theme-color) transition-colors">{{ item.title }}</NuxtLink>
                <p class="text-sm text-gray-500 leading-relaxed line-clamp-2">{{ item.excerpt }}</p>
                <NuxtLink :to="localePath(`/news/${item.id}`)" class="text-sm font-semibold text-(--theme-color) flex items-center gap-1 mt-auto pt-1">
                  {{ t('news.read_more') }}
                  <span class="group-hover:translate-x-1 transition-transform inline-block">→</span>
                </NuxtLink>
              </div>
            </article>
          </div>

          <div class="relative rounded-2xl overflow-hidden min-h-80 lg:min-h-auto bg-gray-100">
            <template v-for="(item, i) in featured" :key="i">
              <img :src="item.image" :alt="item.title"
                   class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700"
                   :class="i === activeSlide ? 'opacity-100' : 'opacity-0'" />
            </template>
            <div class="absolute inset-0 bg-linear-to-t from-black/85 via-black/20 to-transparent" />
            <div v-if="featured[activeSlide]" class="absolute inset-x-0 bottom-0 p-6 md:p-8 flex flex-col gap-3">
              <span class="text-[10px] font-bold uppercase tracking-widest text-white/50">{{ t('news.featured_label') }}</span>
              <h3 class="text-xl md:text-2xl font-bold text-white leading-snug">{{ featured[activeSlide]!.title }}</h3>
              <p class="text-sm text-white/70 leading-relaxed">{{ featured[activeSlide]!.description }}</p>
              <div class="flex items-center justify-between mt-1">
                <NuxtLink :to="localePath(`/news/${featured[activeSlide]!.id}`)" class="flex items-center gap-2 bg-(--theme-color) text-white text-sm font-semibold px-5 py-2.5 rounded-full hover:opacity-90 transition-opacity">
                  {{ t('news.read_more') }} →
                </NuxtLink>
                <div class="flex gap-2">
                  <button v-for="(_, i) in featured" :key="i"
                          class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                          :class="i === activeSlide ? 'w-6 bg-white' : 'w-2 bg-white/40 hover:bg-white/60'"
                          @click="goTo(i)" />
                </div>
              </div>
            </div>
          </div>

        </div>

        <div v-else-if="activeTab === 'videos'" key="videos">
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <VideoCard v-for="video in videos" :key="video.id" :video="video" @play="openPlayer" />
          </div>
          <div class="flex justify-center mt-8">
            <NuxtLink :to="localePath('/news')" class="flex items-center gap-2 text-sm font-semibold text-(--theme-color) border border-(--theme-color) px-6 py-2.5 rounded-full hover:bg-(--theme-color) hover:text-white transition-all duration-200">
              {{ t('news.all_videos') }} →
            </NuxtLink>
          </div>
        </div>
      </Transition>

    </div>

    <Teleport to="body">
      <Transition name="modal">
        <div v-if="playerVideo" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm" @click.self="closePlayer">
          <div class="relative w-full max-w-4xl rounded-2xl overflow-hidden bg-black shadow-2xl">
            <button class="absolute top-3 right-3 z-10 w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-colors cursor-pointer" @click="closePlayer">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
            <div class="aspect-video w-full">
              <iframe v-if="playerVideo.url" :src="playerVideo.url" :title="playerVideo.title"
                      class="w-full h-full" frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen />
              <div v-else class="w-full h-full flex flex-col items-center justify-center gap-3 bg-gray-900">
                <img v-if="playerVideo.thumbnail" :src="playerVideo.thumbnail" class="absolute inset-0 w-full h-full object-cover opacity-30" />
                <div class="relative z-10 text-center px-6">
                  <p class="text-white/50 text-sm">{{ t('news.video_unavailable') }}</p>
                  <p class="text-white font-semibold mt-1">{{ playerVideo.title }}</p>
                </div>
              </div>
            </div>
            <div class="px-5 py-4 bg-gray-950">
              <p class="text-white font-semibold text-sm leading-snug">{{ playerVideo.title }}</p>
              <p v-if="playerVideo.duration" class="text-white/40 text-xs mt-1">{{ playerVideo.duration }}</p>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </section>
</template>

<script setup lang="ts">
import type { Video } from '~/components/ui/VideoCard.vue'
import VideoCard from '~/components/ui/VideoCard.vue'

const { t, locale } = useI18n()
const localePath = useLocalePath()

type Tab = 'news' | 'videos'
const tabs: { id: Tab; labelKey: string }[] = [
  { id: 'news',   labelKey: 'news.tab_news' },
  { id: 'videos', labelKey: 'news.tab_videos' },
]
const activeTab = ref<Tab>('news')

const config = useRuntimeConfig()

interface NewsItem {
  id: number
  title: string
  excerpt: string
  image: string | null
  published_at: string | null
}

const { data: newsData } = await useAsyncData(
  'news-list',
  () => $fetch<{ data: NewsItem[] }>(`${config.public.apiBase}/news?lang=${locale.value}`),
  { watch: [locale] },
)
const { data: featuredData } = await useAsyncData(
  'news-featured',
  () => $fetch<{ data: NewsItem[] }>(`${config.public.apiBase}/news/featured?lang=${locale.value}`),
  { watch: [locale] },
)
const { data: videosData } = await useAsyncData('videos-list', () =>
  $fetch<{ data: Video[] }>(`${config.public.apiBase}/videos`),
)

const news = computed(() => (newsData.value?.data ?? []).slice(0, 3).map(item => ({
  id: item.id,
  date: item.published_at
    ? new Date(item.published_at).toLocaleDateString('ru-RU', { day: 'numeric', month: 'long', year: 'numeric' })
    : '',
  image: item.image ?? undefined,
  title: item.title,
  excerpt: item.excerpt,
})))

const featured = computed(() => (featuredData.value?.data ?? []).map(item => ({
  id: item.id,
  image: item.image ?? undefined,
  title: item.title,
  description: item.excerpt,
})))

const featuredWithImage = computed(() => featured.value.filter(item => !!item.image))

const videos = computed(() => videosData.value?.data ?? [])

const activeSlide = ref(0)
let timer: ReturnType<typeof setInterval>
function goTo(i: number) { activeSlide.value = i; restartTimer() }
function restartTimer() {
  clearInterval(timer)
  const len = featured.value.length
  if (len > 1) {
    timer = setInterval(() => { activeSlide.value = (activeSlide.value + 1) % len }, 4500)
  }
}
onMounted(() => {
  restartTimer()
  watch(featured, () => { activeSlide.value = 0; restartTimer() })
})
onUnmounted(() => clearInterval(timer))

const playerVideo = ref<Video | null>(null)
function openPlayer(video: Video) { playerVideo.value = video }
function closePlayer() { playerVideo.value = null }
</script>

<style scoped>
.tab-fade-enter-active, .tab-fade-leave-active { transition: opacity 0.25s ease, transform 0.25s ease; }
.tab-fade-enter-from { opacity: 0; transform: translateY(6px); }
.tab-fade-leave-to   { opacity: 0; transform: translateY(-6px); }
.modal-enter-active, .modal-leave-active { transition: opacity 0.25s ease; }
.modal-enter-from, .modal-leave-to { opacity: 0; }
.modal-enter-active .relative, .modal-leave-active .relative { transition: transform 0.25s ease; }
.modal-enter-from .relative { transform: scale(0.95); }
.modal-leave-to .relative   { transform: scale(0.95); }
</style>
