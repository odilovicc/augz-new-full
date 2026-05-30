<template>
  <div>
    <!-- Hero -->
    <div class="relative overflow-hidden bg-[#1a2236] text-white">
      <div class="absolute inset-0 opacity-5" style="background-image: repeating-linear-gradient(45deg, #fff 0, #fff 1px, transparent 0, transparent 50%); background-size: 20px 20px;" />
      <div class="relative container mx-auto px-4 pt-32 pb-16">
        <nav class="flex items-center gap-1.5 text-xs text-white/40 mb-8">
          <NuxtLink :to="localePath('/')" class="hover:text-white/70 transition-colors">{{ t('appeals_page.breadcrumb_home') }}</NuxtLink>
          <span>/</span>
          <span class="text-white/70">{{ t('appeals_page.breadcrumb_current') }}</span>
        </nav>
        <div class="flex items-center gap-2 mb-5">
          <span class="w-8 h-0.5 bg-(--theme-color)" />
          <span class="text-xs font-bold uppercase tracking-[0.2em] text-(--theme-color)">{{ t('appeals_page.badge') }}</span>
        </div>
        <h1 class="text-4xl sm:text-5xl font-black uppercase leading-none mb-4">
          {{ t('appeals_page.title') }}<br>
          <span class="text-(--theme-color)">{{ t('appeals_page.title_accent') }}</span>
        </h1>
        <p class="text-white/50 text-sm mt-4">{{ t('appeals_page.subtitle') }}</p>
      </div>
    </div>

    <!-- Content -->
    <div class="bg-[#f5f5f0] py-16">
      <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">

          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <!-- Intro -->
            <div class="px-8 py-8 border-b border-gray-100 bg-orange-50/40">
              <p class="text-sm text-gray-600 leading-relaxed">{{ t('appeals_page.intro') }}</p>
            </div>

            <div class="px-8 py-8 flex flex-col gap-10">

              <!-- 1 -->
              <section>
                <h2 class="flex items-center gap-3 text-lg font-bold text-gray-900 mb-4">
                  <span class="w-8 h-8 rounded-lg bg-(--theme-color) text-white text-sm font-bold flex items-center justify-center shrink-0">1</span>
                  {{ t('appeals_page.s1_title') }}
                </h2>
                <div class="pl-11 flex flex-col gap-3 text-sm text-gray-700 leading-relaxed">
                  <p>{{ t('appeals_page.s1_p1') }}</p>
                  <p>{{ t('appeals_page.s1_p2') }}</p>
                  <p>{{ t('appeals_page.s1_p3') }}</p>
                </div>
              </section>

              <!-- 2 -->
              <section>
                <h2 class="flex items-center gap-3 text-lg font-bold text-gray-900 mb-4">
                  <span class="w-8 h-8 rounded-lg bg-(--theme-color) text-white text-sm font-bold flex items-center justify-center shrink-0">2</span>
                  {{ t('appeals_page.s2_title') }}
                </h2>
                <div class="pl-11">
                  <p class="text-sm text-gray-700 leading-relaxed mb-3">{{ t('appeals_page.s2_intro') }}</p>
                  <ul class="flex flex-col gap-2">
                    <li v-for="item in tm('appeals_page.s2_items') as string[]" :key="item" class="flex items-start gap-2.5 text-sm text-gray-700">
                      <span class="w-1.5 h-1.5 rounded-full bg-(--theme-color) mt-1.5 shrink-0" />
                      {{ item }}
                    </li>
                  </ul>
                </div>
              </section>

              <!-- 3 -->
              <section>
                <h2 class="flex items-center gap-3 text-lg font-bold text-gray-900 mb-4">
                  <span class="w-8 h-8 rounded-lg bg-(--theme-color) text-white text-sm font-bold flex items-center justify-center shrink-0">3</span>
                  {{ t('appeals_page.s3_title') }}
                </h2>
                <div class="pl-11">
                  <p class="text-sm text-gray-700 leading-relaxed mb-3">{{ t('appeals_page.s3_intro') }}</p>
                  <ul class="flex flex-col gap-2 mb-4">
                    <li v-for="item in tm('appeals_page.s3_items') as string[]" :key="item" class="flex items-start gap-2.5 text-sm text-gray-700">
                      <span class="w-1.5 h-1.5 rounded-full bg-(--theme-color) mt-1.5 shrink-0" />
                      {{ item }}
                    </li>
                  </ul>
                  <div class="bg-orange-50 border border-orange-100 rounded-xl p-4 text-sm text-gray-700">
                    <span class="font-semibold text-(--theme-color)">{{ t('appeals_page.s3_tip_label') }}</span>
                    {{ ' ' }}{{ t('appeals_page.s3_tip') }}
                  </div>
                </div>
              </section>

              <!-- 4 — Stages -->
              <section>
                <h2 class="flex items-center gap-3 text-lg font-bold text-gray-900 mb-6">
                  <span class="w-8 h-8 rounded-lg bg-(--theme-color) text-white text-sm font-bold flex items-center justify-center shrink-0">4</span>
                  {{ t('appeals_page.s4_title') }}
                </h2>
                <div class="pl-11 flex flex-col gap-0">
                  <div
                    v-for="(stage, i) in stages"
                    :key="stage.title"
                    class="relative flex gap-4"
                  >
                    <div class="flex flex-col items-center">
                      <div class="w-8 h-8 rounded-full border-2 border-(--theme-color) bg-white flex items-center justify-center shrink-0 z-10">
                        <span class="text-xs font-bold text-(--theme-color)">{{ i + 1 }}</span>
                      </div>
                      <div v-if="i < stages.length - 1" class="w-px flex-1 bg-gray-200 my-1" />
                    </div>
                    <div class="pb-6 flex-1 min-w-0">
                      <div class="flex flex-wrap items-center gap-2 mb-1">
                        <span class="font-bold text-sm text-gray-900">{{ stage.title }}</span>
                        <span v-if="stage.duration" class="text-xs font-semibold px-2 py-0.5 rounded-full bg-orange-100 text-(--theme-color)">{{ stage.duration }}</span>
                      </div>
                      <p class="text-sm text-gray-600 leading-relaxed">{{ stage.desc }}</p>
                      <p class="text-xs text-gray-400 mt-1">{{ t('appeals_page.s4_responsible') }} {{ stage.responsible }}</p>
                    </div>
                  </div>
                </div>
                <div class="pl-11 mt-2">
                  <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-700">
                    <span class="font-bold">{{ t('appeals_page.s4_total') }}</span>
                    {{ ' ' }}
                    <span class="text-(--theme-color) font-bold">{{ t('appeals_page.s4_total_days') }}</span>
                    {{ ' ' }}{{ t('appeals_page.s4_total_from') }}
                    {{ ' ' }}{{ t('appeals_page.s4_total_ext') }}
                  </div>
                </div>
              </section>

              <!-- 5 -->
              <section>
                <h2 class="flex items-center gap-3 text-lg font-bold text-gray-900 mb-4">
                  <span class="w-8 h-8 rounded-lg bg-(--theme-color) text-white text-sm font-bold flex items-center justify-center shrink-0">5</span>
                  {{ t('appeals_page.s5_title') }}
                </h2>
                <div class="pl-11 flex flex-col gap-3 text-sm text-gray-700 leading-relaxed">
                  <p>
                    {{ t('appeals_page.s5_p1') }}
                    <span class="font-mono font-semibold bg-gray-100 px-1.5 py-0.5 rounded text-xs">DXU-ГГГГ-ХХХХ</span>.
                  </p>
                  <p>{{ t('appeals_page.s5_p2') }}</p>
                  <p>{{ t('appeals_page.s5_p3') }}</p>
                </div>
              </section>

              <!-- 6 -->
              <section>
                <h2 class="flex items-center gap-3 text-lg font-bold text-gray-900 mb-4">
                  <span class="w-8 h-8 rounded-lg bg-(--theme-color) text-white text-sm font-bold flex items-center justify-center shrink-0">6</span>
                  {{ t('appeals_page.s6_title') }}
                </h2>
                <div class="pl-11">
                  <p class="text-sm text-gray-700 leading-relaxed mb-3">{{ t('appeals_page.s6_intro') }}</p>
                  <ul class="flex flex-col gap-2 mb-4">
                    <li v-for="item in tm('appeals_page.s6_items') as string[]" :key="item" class="flex items-start gap-2.5 text-sm text-gray-700">
                      <Icon name="heroicons:x-circle" class="w-4 h-4 text-red-400 mt-0.5 shrink-0" />
                      {{ item }}
                    </li>
                  </ul>
                  <p class="text-sm text-gray-500">{{ t('appeals_page.s6_notice') }}</p>
                </div>
              </section>

              <!-- 7 -->
              <section class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                <h2 class="flex items-center gap-3 text-lg font-bold text-gray-900 mb-4">
                  <span class="w-8 h-8 rounded-lg bg-(--theme-color) text-white text-sm font-bold flex items-center justify-center shrink-0">7</span>
                  {{ t('appeals_page.s7_title') }}
                </h2>
                <div class="pl-11 flex flex-col gap-2 text-sm text-gray-700">
                  <div class="flex items-center gap-2">
                    <Icon name="heroicons:globe-alt" class="w-4 h-4 text-(--theme-color) shrink-0" />
                    <span>
                      {{ t('appeals_page.s7_online') }}
                      <NuxtLink :to="localePath('/report')" class="text-(--theme-color) font-semibold hover:underline">{{ t('appeals_page.s7_online_link') }}</NuxtLink>
                    </span>
                  </div>
                  <div class="flex items-start gap-2">
                    <Icon name="mdi:map-marker" class="w-4 h-4 text-(--theme-color) mt-0.5 shrink-0" />
                    <span>{{ t('appeals_page.s7_address') }}</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <Icon name="mdi:phone" class="w-4 h-4 text-(--theme-color) shrink-0" />
                    <a href="tel:+998555031221" class="text-(--theme-color) hover:underline">+998 55 503 12 21</a>
                  </div>
                  <div class="flex items-center gap-2">
                    <Icon name="mdi:email" class="w-4 h-4 text-(--theme-color) shrink-0" />
                    <a href="mailto:info@augz.uz" class="text-(--theme-color) hover:underline">info@augz.uz</a>
                  </div>
                </div>
              </section>

            </div>
          </div>

          <!-- Bottom nav -->
          <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <NuxtLink :to="localePath('/privacy')" class="flex items-center gap-2 text-sm text-gray-500 hover:text-(--theme-color) transition-colors">
              <Icon name="heroicons:arrow-left" class="w-4 h-4" />
              {{ t('appeals_page.nav_back') }}
            </NuxtLink>
            <NuxtLink :to="localePath('/report')" class="flex items-center gap-2 text-sm text-(--theme-color) font-semibold hover:underline transition-colors">
              {{ t('appeals_page.nav_next') }}
              <Icon name="heroicons:arrow-right" class="w-4 h-4" />
            </NuxtLink>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
const { t, tm } = useI18n()
const localePath = useLocalePath()

const stages = computed(() => tm('appeals_page.s4_stages') as Array<{
  title: string
  duration: string
  desc: string
  responsible: string
}>)

useSeoMeta({
  title: () => t('appeals_page.seo_title'),
  description: () => t('appeals_page.seo_desc'),
  ogTitle: () => t('appeals_page.seo_title'),
  ogDescription: () => t('appeals_page.seo_desc'),
  ogUrl: 'https://augz.uz/appeals-rules',
  ogType: 'website',
  robots: 'index, follow',
})
</script>
