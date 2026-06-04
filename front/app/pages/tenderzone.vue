<template>
  <div>

    <!-- ─── HERO ─── -->
    <div class="relative overflow-hidden bg-white min-h-85 md:min-h-105 flex items-center">
      <div class="absolute inset-y-0 right-0 w-1/2 md:w-[55%] pointer-events-none select-none">
        <div class="absolute inset-0 bg-linear-to-r from-white via-white/60 to-transparent z-10" />
        <img src="/img/hero.png" alt="TenderZone" class="w-full h-full object-cover object-right" />
      </div>

      <div class="relative z-10 container mx-auto px-4 py-20 md:py-28">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-orange-200 bg-orange-50 text-xs font-bold text-(--theme-color) mb-6">
          <Icon name="ph:star-fill" class="w-3 h-3" />
          {{ t(c?.hero?.badge) }}
        </div>

        <h1 class="text-5xl md:text-6xl font-black uppercase tracking-tight leading-none mb-5">
          {{ t(c?.hero?.title_1) }}<br>
          <span class="text-(--theme-color)">{{ t(c?.hero?.title_2) }}</span> {{ t(c?.hero?.title_3) }}<br>
          <span class="text-(--theme-color)">{{ t(c?.hero?.title_accent) }}</span>
        </h1>

        <p class="text-sm sm:text-base leading-relaxed text-gray-600 max-w-sm mb-8">
          {{ t(c?.hero?.subtitle) }}
        </p>

        <div class="flex flex-col sm:flex-row gap-3">
          <UiButton @click="leadModalOpen = true; leadType = 'free'">
            {{ t(c?.hero?.btn_primary?.label) }}
          </UiButton>
          <UiButton variant="outlined" @click="leadModalOpen = true; leadType = 'demo'">
            {{ t(c?.hero?.btn_secondary?.label) }}
          </UiButton>
        </div>

        <div class="flex flex-wrap gap-x-8 gap-y-4 mt-10">
          <div v-for="stat in c?.hero?.stats" :key="stat.value">
            <div class="text-2xl font-black text-gray-900">{{ stat.value }}</div>
            <div class="text-xs text-gray-500 mt-0.5">{{ t(stat.label) }}</div>
          </div>
        </div>
      </div>
    </div>

    <!-- ─── FEATURES ─── -->
    <section id="features" class="section bg-gray-50 border-b border-gray-100">
      <div class="container mx-auto px-4">
        <div class="mb-10">
          <span class="text-xs font-bold uppercase tracking-widest text-(--theme-color)">{{ t(c?.features?.badge) }}</span>
          <h2 class="text-3xl md:text-4xl font-black uppercase tracking-tight leading-tight mt-2">
            {{ t(c?.features?.heading) }}
          </h2>
          <p class="text-sm text-gray-500 leading-relaxed mt-3 max-w-md">
            {{ t(c?.features?.subtitle) }}
          </p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
          <div
            v-for="f in c?.features?.items"
            :key="t(f.title)"
            class="bg-white rounded-xl border-t-4 border border-gray-100 p-6 flex flex-col gap-4 shadow-sm hover:shadow-md transition"
            :class="f.border_color"
          >
            <div class="w-10 h-10 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center">
              <Icon :name="f.icon" class="w-5 h-5" :class="f.icon_color" />
            </div>
            <div>
              <h3 class="font-bold text-base mb-1.5">{{ t(f.title) }}</h3>
              <p class="text-sm text-gray-500 leading-relaxed">{{ t(f.desc) }}</p>
            </div>
            <div>
              <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold tracking-wide border" :class="f.badge_color">
                {{ t(f.badge) }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ─── HOW IT WORKS ─── -->
    <section id="how" class="section bg-[#f0ede8] border-b border-gray-200">
      <div class="container mx-auto px-4">
        <div class="mb-10">
          <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-(--theme-color) mb-3">
            <span class="w-6 h-px bg-(--theme-color)" />
            {{ t(c?.how?.badge) }}
          </div>
          <h2 class="text-3xl md:text-4xl font-black uppercase tracking-tight leading-tight">
            {{ t(c?.how?.heading) }}
          </h2>
        </div>

        <div class="relative">
          <div class="hidden md:block absolute top-7 left-0 right-0 h-px z-0">
            <div class="absolute inset-0 bg-gray-300" />
            <div class="absolute inset-y-0 left-0 w-1/5 bg-(--theme-color)" />
          </div>

          <div class="grid grid-cols-2 md:grid-cols-5 gap-y-8 gap-x-4 relative z-10">
            <div v-for="(step, i) in c?.how?.steps" :key="i" class="flex flex-col items-center text-center">
              <div
                class="w-14 h-14 rounded-full flex items-center justify-center text-sm font-black mb-4 border-2"
                :class="i === 0
                  ? 'bg-(--theme-color) border-(--theme-color) text-white'
                  : 'border-gray-300 text-gray-400 bg-white'"
              >
                {{ String(i + 1).padStart(2, '0') }}
              </div>
              <div class="font-bold text-sm mb-1">{{ t(step.title) }}</div>
              <div class="text-xs text-gray-500 leading-relaxed max-w-36">{{ t(step.desc) }}</div>
            </div>
          </div>
        </div>

        <div class="mt-14 flex flex-col items-center gap-4">
          <div class="flex flex-col sm:flex-row gap-3">
            <button
              class="px-8 py-3.5 rounded-xl bg-(--theme-color) text-white text-sm font-bold hover:brightness-110 active:scale-[0.98] transition-all"
              @click="leadModalOpen = true; leadType = 'free'"
            >
              {{ t(c?.how?.btn_primary?.label) }}
            </button>
            <button
              class="px-8 py-3.5 rounded-xl border-2 border-(--theme-color) text-(--theme-color) text-sm font-bold hover:bg-(--theme-color) hover:text-white transition-all"
              @click="leadModalOpen = true; leadType = 'demo'"
            >
              {{ t(c?.how?.btn_secondary?.label) }}
            </button>
          </div>
          <p class="text-sm text-gray-500 text-center">{{ t(c?.how?.cta_hint) }}</p>
        </div>
      </div>
    </section>

    <!-- Lead modal -->
    <Teleport to="body">
      <Transition name="modal">
        <div
          v-if="leadModalOpen"
          class="fixed inset-0 z-50 flex items-center justify-center p-4"
        >
          <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="leadModalOpen = false" />
          <div class="relative z-10 w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">
            <button
              class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors"
              @click="leadModalOpen = false"
            >
              <Icon name="heroicons:x-mark" class="w-5 h-5" />
            </button>

            <div class="mb-6">
              <p class="text-xs font-bold tracking-widest uppercase text-(--theme-color) mb-1">TenderZone</p>
              <h2 class="text-2xl font-black uppercase text-gray-900 leading-tight">
                {{ leadType === 'demo' ? t(c?.modal?.demo_title) : t(c?.modal?.free_title) }}
              </h2>
              <p class="text-sm text-gray-500 mt-1">
                {{ leadType === 'demo' ? t(c?.modal?.demo_desc) : t(c?.modal?.free_desc) }}
              </p>
            </div>

            <UiLeadForm source="tenderzone" :show-demo="false" :initial-type="leadType" />
          </div>
        </div>
      </Transition>
    </Teleport>

  </div>
</template>

<script setup lang="ts">
const config = useRuntimeConfig()
const { data: pageData } = await useFetch<{ slug: string; content: any }>(
  `${config.public.apiBase}/page/tenderzone`,
  { key: 'tenderzone-page', server: true },
)

const c = computed(() => pageData.value?.content ?? null)
const t = useLocaleText()

const leadModalOpen = ref(false)
const leadType = ref<'free' | 'demo'>('free')

useSeoMeta({
  title: 'TenderZone — платформа для участников тендеров | АУГЗ',
  description: 'TenderZone от АУГЗ: AI-помощник для подготовки тендерных заявок, мониторинг площадок, аналитика победителей и уведомления в Telegram. Попробуйте бесплатно.',
  ogTitle: 'TenderZone — платформа для участников тендеров',
  ogDescription: 'TenderZone от АУГЗ: AI-помощник для подготовки тендерных заявок, мониторинг площадок, аналитика победителей.',
  ogImage: '/og-default.jpg',
  ogUrl: 'https://augz.uz/tenderzone',
  ogType: 'website',
  twitterCard: 'summary_large_image',
  twitterTitle: 'TenderZone — платформа для участников тендеров | АУГЗ',
  twitterDescription: 'AI-помощник для подготовки тендерных заявок и мониторинга площадок. Попробуйте бесплатно.',
})
</script>

<style scoped>
details > summary::-webkit-details-marker { display: none; }
</style>
