<template>
  <!-- ─── HERO ─── -->
  <div
    class="relative overflow-hidden bg-white min-h-85 md:min-h-100 flex items-center"
    :style="hero?.image ? `background: url('${hero.image}') no-repeat center / cover` : ''"
  >
    <div v-if="!hero?.image" class="absolute inset-y-0 right-0 w-1/2 md:w-[55%] pointer-events-none select-none">
      <div class="absolute inset-0 bg-linear-to-r from-white via-white/60 to-transparent z-10" />
      <img src="/img/hero.png" alt="АУГЗ здание" class="w-full h-full object-cover object-right" />
    </div>
    <div v-else class="absolute inset-0 bg-linear-to-r from-white via-white/70 to-transparent pointer-events-none" />

    <div class="relative z-10 container mx-auto px-4 py-20 md:py-28 mr-auto">
      <nav class="flex items-center gap-1.5 text-xs text-gray-400 mb-8">
        <a href="/" class="hover:text-(--theme-color) transition-colors">Главная</a>
        <span>/</span>
        <span class="text-gray-700">О нас</span>
      </nav>

      <h1 class="text-3xl sm:text-5xl md:text-6xl font-black uppercase tracking-tight leading-none mb-5">
        {{ lt(hero?.heading) || 'О НАС' }}
      </h1>

      <p class="text-sm sm:text-base leading-relaxed text-gray-600 max-w-sm mb-8">
        {{ lt(hero?.subtitle) || '' }}
      </p>

      <a
        :href="hero?.btn_href || '#contacts'"
        class="inline-block px-5 py-2.5 rounded-md bg-(--theme-color) text-white text-sm font-semibold hover:bg-white hover:text-(--theme-color) border border-(--theme-color) transition-colors"
      >{{ lt(hero?.btn_label) || 'Связаться с нами' }}</a>
    </div>
  </div>

  <AboutSectionIntro />

  <!-- ─── MISSION + STATS ─── -->
  <section class="section bg-white border-b border-gray-100">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">

        <div class="flex flex-col gap-6">
          <div class="flex flex-col gap-3">
            <span class="text-xs font-bold uppercase tracking-widest text-(--theme-color)">{{ lt(mission?.label) }}</span>
            <h2 class="text-3xl md:text-4xl font-black tracking-tight leading-tight text-gray-900">
              {{ lt(mission?.heading) }}
            </h2>
          </div>
          <p class="text-base leading-relaxed text-gray-500">{{ lt(mission?.text) }}</p>
          <div class="h-px w-full bg-gray-100" />
          <div class="flex items-center gap-3 text-sm text-gray-400">
            <Icon name="i-lucide-map-pin" class="w-4 h-4 text-(--theme-color) shrink-0" />
            {{ lt(mission?.location) }}
          </div>
        </div>

        <div class="grid grid-cols-2 gap-px bg-gray-100 rounded-2xl overflow-hidden shadow-sm">
          <div
            v-for="stat in missionStats"
            :key="stat.icon"
            class="bg-white flex flex-col gap-2 px-7 py-8"
          >
            <div class="w-10 h-10 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center shrink-0">
              <Icon :name="stat.icon" class="w-5 h-5 text-(--theme-color)" />
            </div>
            <div class="text-2xl md:text-4xl font-black text-gray-900 leading-none mt-2">{{ stat.value }}</div>
            <div class="text-xs text-gray-400 font-medium leading-snug">{{ lt(stat.label) }}</div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ─── VALUES ─── -->
  <section class="section bg-gray-950">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl md:text-4xl font-black uppercase tracking-tight leading-none text-white mb-10">
        {{ lt(values?.heading) || 'НАШИ ЦЕННОСТИ' }}
      </h2>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div
          v-for="(val, i) in valueItems"
          :key="i"
          class="group relative overflow-hidden rounded-2xl border border-white/10 bg-white/5 p-7 flex flex-col gap-4 hover:bg-white/10 hover:border-white/20 transition-all duration-300"
        >
          <div class="h-0.5 w-6 bg-(--theme-color) group-hover:w-10 transition-all duration-300" />
          <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
            <Icon :name="val.icon" class="w-6 h-6 text-(--theme-color)" />
          </div>
          <div class="flex flex-col gap-1.5">
            <h3 class="font-bold text-white text-lg leading-snug">{{ lt(val.title) }}</h3>
            <p class="text-sm text-gray-400 leading-relaxed">{{ lt(val.desc) }}</p>
          </div>
          <span class="absolute bottom-3 right-4 text-7xl font-black text-white/4 select-none leading-none pointer-events-none">
            {{ String(i + 1).padStart(2, '0') }}
          </span>
        </div>
      </div>
    </div>
  </section>

    <!-- ─── TIMELINE ─── -->
  <section class="section bg-white border-t border-gray-100">
    <div class="container mx-auto px-4">

      <div class="mb-12">
        <span class="text-xs font-bold uppercase tracking-widest text-(--theme-color)">{{ lt(timeline?.label) || 'С 2013 года' }}</span>
        <h2 class="text-3xl md:text-4xl font-black tracking-tight leading-tight text-gray-900 mt-2">
          {{ lt(timeline?.heading) || 'НАША ИСТОРИЯ' }}
        </h2>
      </div>

      <div ref="timelineRef" class="relative">
        <!-- Horizontal line (desktop) -->
        <div class="hidden md:block absolute top-2.75 left-0 right-0 h-px bg-orange-100 z-0" />
        <!-- Vertical line (mobile) -->
        <div class="md:hidden absolute left-2.5 top-0 bottom-0 w-px bg-orange-100 z-0" />

        <div class="grid grid-cols-1 md:grid-cols-5 gap-0 md:gap-6">
          <div
            v-for="(event, i) in timelineItems"
            :key="event.year"
            class="relative flex flex-row md:flex-col items-start gap-5 md:gap-3 pb-10 md:pb-0 pl-10 md:pl-0"
            :style="{
              opacity: timelineVisible ? 1 : 0,
              transform: timelineVisible ? 'translateY(0)' : 'translateY(16px)',
              transition: timelineVisible
                ? `opacity 400ms ease-out ${200 + i * 120}ms, transform 400ms ease-out ${200 + i * 120}ms`
                : 'none',
            }"
          >
            <div
              class="absolute left-0 top-0 md:static shrink-0 rounded-full border-2 z-10 flex items-center justify-center md:mb-3"
              :class="event.year === '2026'
                ? 'w-4 h-4 border-(--theme-color) bg-white'
                : 'w-5.5 h-5.5 border-orange-200 bg-orange-200'"
              :style="{
                transform: timelineVisible ? 'scale(1)' : 'scale(0)',
                transition: timelineVisible
                  ? `transform 300ms cubic-bezier(0.34,1.56,0.64,1) ${300 + i * 120}ms`
                  : 'none',
              }"
            />
            <div class="flex flex-col gap-1">
              <span
                class="text-2xl font-black leading-none"
                :class="event.year === '2026' ? 'text-gray-900' : 'text-gray-400'"
              >{{ event.year }}</span>
              <span
                class="text-[11px] font-bold uppercase tracking-wider mt-0.5"
                :class="event.year === '2026' ? 'text-(--theme-color)' : 'text-gray-400'"
              >{{ lt(event.title) }}</span>
              <p class="text-xs text-gray-500 leading-relaxed mt-1 max-w-45 hidden">{{ lt(event.desc) }}</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- ─── LEADERS ─── -->
  <section class="section relative overflow-hidden" style="background-color: #1a1a1a;">
    <div
      class="absolute inset-0 opacity-10 pointer-events-none"
      style="background-image: url('/img/bg-pattern.png'); background-size: 400px; background-repeat: repeat;"
    />

    <div class="relative container mx-auto px-4">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-20 mb-12 items-end">
        <div class="flex flex-col gap-4">
          <div class="flex items-center gap-3">
            <div class="w-6 h-px bg-(--theme-color)" />
            <span class="text-xs font-bold uppercase tracking-widest text-(--theme-color)">{{ lt(leadersSection?.label) || 'Руководство АУГЗ' }}</span>
          </div>
          <h2 class="text-2xl sm:text-4xl md:text-5xl font-black leading-tight text-white uppercase whitespace-pre-line">
            {{ lt(leadersSection?.heading) || "ЛИДЕРЫ\nКОТОРЫЕ РАЗВИВАЮТ\nБУДУЩЕЕ" }}
          </h2>
        </div>
        <p class="text-sm leading-relaxed text-gray-400 max-w-sm lg:max-w-none self-end pb-1">
          {{ lt(leadersSection?.subtitle) }}
        </p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div
          v-for="leader in leaders"
          :key="leader.slug"
          class="group relative overflow-hidden rounded-2xl bg-white/5 border border-white/10 hover:border-(--theme-color)/50 transition-all duration-300 cursor-pointer min-h-72"
          @click="openLeader(leader)"
        >
          <img
            v-if="leader.photo"
            :src="leader.photo"
            :alt="lt(leader.name)"
            class="absolute bottom-0 right-0 h-[90%] w-[55%] object-cover object-top select-none pointer-events-none opacity-80 group-hover:opacity-100 transition-opacity duration-300"
          />
          <div class="absolute inset-0 bg-linear-to-r from-[#1a1a1a] via-[#1a1a1a]/80 to-transparent" />
          <div class="absolute inset-0 bg-linear-to-t from-[#1a1a1a]/60 via-transparent to-transparent" />

          <div class="relative z-10 flex flex-col h-full p-6 gap-3 min-h-72">
            <div class="flex-1 flex flex-col gap-3">
              <h3 class="text-lg font-black text-white leading-tight whitespace-pre-line">{{ lt(leader.name) }}</h3>
              <div class="w-8 h-0.5 bg-(--theme-color)" />
              <p class="text-xs text-gray-400 leading-relaxed max-w-45">{{ lt(leader.role) }}</p>
            </div>
            <div class="flex items-center gap-2 text-xs font-semibold text-(--theme-color) group-hover:gap-3 transition-all duration-200">
              {{ $t('news.read_more') }} <span class="text-base leading-none">→</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ─── LEADER MODAL ─── -->
  <Teleport to="body">
    <Transition
      enter-active-class="transition duration-200"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-150"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="activeLeader"
        class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4"
        @click.self="activeLeader = null"
      >
        <!-- backdrop -->
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" @click="activeLeader = null" />

        <!-- dialog -->
        <Transition
          enter-active-class="transition duration-200"
          enter-from-class="opacity-0 translate-y-4 sm:scale-95"
          enter-to-class="opacity-100 translate-y-0 sm:scale-100"
          leave-active-class="transition duration-150"
          leave-from-class="opacity-100 translate-y-0 sm:scale-100"
          leave-to-class="opacity-0 translate-y-4 sm:scale-95"
        >
          <div
            v-if="activeLeader"
            class="relative z-10 w-full sm:max-w-2xl bg-[#1a1a1a] border border-white/10 rounded-t-3xl sm:rounded-2xl overflow-hidden shadow-2xl"
          >
            <!-- close -->
            <button
              class="absolute top-4 right-4 z-20 w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors"
              @click="activeLeader = null"
            >
              <Icon name="heroicons:x-mark" class="w-4 h-4 text-white" />
            </button>

            <div class="flex flex-col sm:flex-row">
              <!-- photo -->
              <div v-if="activeLeader.photo" class="relative sm:w-52 shrink-0 h-56 sm:h-auto overflow-hidden">
                <img
                  :src="activeLeader.photo"
                  :alt="lt(activeLeader.name)"
                  class="w-full h-full object-cover object-top"
                />
                <div class="absolute inset-0 bg-linear-to-t from-[#1a1a1a] via-transparent to-transparent sm:bg-linear-to-r sm:from-transparent sm:via-transparent sm:to-[#1a1a1a]" />
              </div>

              <!-- content -->
              <div class="flex flex-col gap-4 p-6 flex-1 min-w-0 sm:max-h-[70vh] sm:overflow-y-auto">
                <div>
                  <h3 class="text-xl font-black text-white leading-tight whitespace-pre-line">{{ lt(activeLeader.name) }}</h3>
                  <div class="w-8 h-0.5 bg-(--theme-color) mt-2 mb-2" />
                  <p class="text-sm text-(--theme-color) font-semibold">{{ lt(activeLeader.role) }}</p>
                </div>

                <p v-if="lt(activeLeader.bio)" class="text-sm text-gray-400 leading-relaxed">
                  {{ lt(activeLeader.bio) }}
                </p>

                <!-- social links -->
                <div v-if="activeLeader.social_links?.length" class="flex flex-wrap gap-2 mt-1">
                  <a
                    v-for="link in activeLeader.social_links"
                    :key="link.url"
                    :href="link.url"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/8 hover:bg-white/15 text-xs font-semibold text-gray-300 hover:text-white transition-colors"
                  >
                    <Icon name="heroicons:arrow-top-right-on-square" class="w-3 h-3 shrink-0" />
                    {{ link.label }}
                  </a>
                </div>
              </div>
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup lang="ts">
const config = useRuntimeConfig()
const lt = useLocaleText()
const aboutContent = useAboutPageContent()

// ── API sections ──────────────────────────────────────────────
const hero         = computed(() => aboutContent.value?.hero)
const mission      = computed(() => aboutContent.value?.mission)
const missionStats = computed(() => mission.value?.stats ?? [])
const values       = computed(() => aboutContent.value?.values)
const valueItems   = computed(() => values.value?.items ?? [])
const leadersSection = computed(() => aboutContent.value?.leaders)
const timeline     = computed(() => aboutContent.value?.timeline)
const timelineItems = computed(() => timeline.value?.items ?? [])

// ── Leaders from API ──────────────────────────────────────────
interface Leader {
  id: number
  slug: string
  photo: string | null
  name: string
  role: { ru: string; uz: string; en: string }
  bio: { ru: string; uz: string; en: string }
  social_links: Array<{ label: string; url: string }>
  sort_order: number
}

const { data: leadersData } = await useAsyncData(
  'leaders-list',
  () => $fetch<{ data: Leader[] }>(`${config.public.apiBase}/leaders`),
  {
    default: () => ({ data: [] }),
    getCachedData: (key, nuxtApp) => nuxtApp.payload.data[key] ?? nuxtApp.static.data[key],
  },
)

const leaders = computed(() => leadersData.value?.data ?? [])

// ── Leader modal ──────────────────────────────────────────────
const activeLeader = ref<Leader | null>(null)

function openLeader(leader: Leader) {
  activeLeader.value = leader
}

onMounted(() => {
  const onKey = (e: KeyboardEvent) => { if (e.key === 'Escape') activeLeader.value = null }
  window.addEventListener('keydown', onKey)
  onUnmounted(() => window.removeEventListener('keydown', onKey))
})

// ── Timeline scroll animation ─────────────────────────────────
const timelineRef = ref<HTMLElement | null>(null)
const timelineVisible = ref(false)

onMounted(() => {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    timelineVisible.value = true
    return
  }
  const observer = new IntersectionObserver(
    (entries) => {
      if (entries[0]?.isIntersecting) {
        timelineVisible.value = true
        observer.disconnect()
      }
    },
    { threshold: 0.15 },
  )
  if (timelineRef.value) observer.observe(timelineRef.value)
})
</script>
