<template>
  <div>
    <!-- Hero -->
    <div class="relative overflow-hidden bg-[#1a2236] text-white">
      <div class="absolute inset-0 opacity-5" style="background-image: repeating-linear-gradient(45deg, #fff 0, #fff 1px, transparent 0, transparent 50%); background-size: 20px 20px;" />
      <div class="relative container mx-auto px-4 pt-32 pb-16">
        <nav class="flex items-center gap-1.5 text-xs text-white/40 mb-8">
          <NuxtLink :to="localePath('/')" class="hover:text-white/70 transition-colors">{{ t('privacy_page.breadcrumb_home') }}</NuxtLink>
          <span>/</span>
          <span class="text-white/70">{{ t('privacy_page.breadcrumb_current') }}</span>
        </nav>
        <div class="flex items-center gap-2 mb-5">
          <span class="w-8 h-0.5 bg-(--theme-color)" />
          <span class="text-xs font-bold uppercase tracking-[0.2em] text-(--theme-color)">{{ t('privacy_page.badge') }}</span>
        </div>
        <h1 class="text-4xl sm:text-5xl font-black uppercase leading-none mb-4">
          {{ t('privacy_page.title') }}<br>
          <span class="text-(--theme-color)">{{ t('privacy_page.title_accent') }}</span>
        </h1>
        <p class="text-white/50 text-sm mt-4">{{ t('privacy_page.subtitle') }}</p>
      </div>
    </div>

    <!-- Content -->
    <div class="bg-[#f5f5f0] py-16">
      <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">

          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <!-- Intro -->
            <div class="px-8 py-8 border-b border-gray-100 bg-orange-50/40">
              <p class="text-sm text-gray-600 leading-relaxed">{{ t('privacy_page.intro') }}</p>
            </div>

            <div class="px-8 py-8 flex flex-col gap-10">

              <!-- 1 -->
              <section>
                <h2 class="flex items-center gap-3 text-lg font-bold text-gray-900 mb-4">
                  <span class="w-8 h-8 rounded-lg bg-(--theme-color) text-white text-sm font-bold flex items-center justify-center shrink-0">1</span>
                  {{ t('privacy_page.s1_title') }}
                </h2>
                <div class="pl-11 flex flex-col gap-3 text-sm text-gray-700 leading-relaxed">
                  <p>{{ t('privacy_page.s1_p1') }}</p>
                  <p>{{ t('privacy_page.s1_p2') }}</p>
                  <p>{{ t('privacy_page.s1_p3') }}</p>
                </div>
              </section>

              <!-- 2 -->
              <section>
                <h2 class="flex items-center gap-3 text-lg font-bold text-gray-900 mb-4">
                  <span class="w-8 h-8 rounded-lg bg-(--theme-color) text-white text-sm font-bold flex items-center justify-center shrink-0">2</span>
                  {{ t('privacy_page.s2_title') }}
                </h2>
                <div class="pl-11">
                  <p class="text-sm text-gray-700 leading-relaxed mb-3">{{ t('privacy_page.s2_intro') }}</p>
                  <ul class="flex flex-col gap-2">
                    <li v-for="item in tm('privacy_page.s2_items') as string[]" :key="item" class="flex items-start gap-2.5 text-sm text-gray-700">
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
                  {{ t('privacy_page.s3_title') }}
                </h2>
                <div class="pl-11">
                  <p class="text-sm text-gray-700 leading-relaxed mb-3">{{ t('privacy_page.s3_intro') }}</p>
                  <ul class="flex flex-col gap-2">
                    <li v-for="item in tm('privacy_page.s3_items') as string[]" :key="item" class="flex items-start gap-2.5 text-sm text-gray-700">
                      <span class="w-1.5 h-1.5 rounded-full bg-(--theme-color) mt-1.5 shrink-0" />
                      {{ item }}
                    </li>
                  </ul>
                </div>
              </section>

              <!-- 4 -->
              <section>
                <h2 class="flex items-center gap-3 text-lg font-bold text-gray-900 mb-4">
                  <span class="w-8 h-8 rounded-lg bg-(--theme-color) text-white text-sm font-bold flex items-center justify-center shrink-0">4</span>
                  {{ t('privacy_page.s4_title') }}
                </h2>
                <div class="pl-11 flex flex-col gap-3 text-sm text-gray-700 leading-relaxed">
                  <p>{{ t('privacy_page.s4_p1') }}</p>
                  <p>{{ t('privacy_page.s4_p2') }}</p>
                  <p>{{ t('privacy_page.s4_p3') }}</p>
                </div>
              </section>

              <!-- 5 -->
              <section>
                <h2 class="flex items-center gap-3 text-lg font-bold text-gray-900 mb-4">
                  <span class="w-8 h-8 rounded-lg bg-(--theme-color) text-white text-sm font-bold flex items-center justify-center shrink-0">5</span>
                  {{ t('privacy_page.s5_title') }}
                </h2>
                <div class="pl-11 flex flex-col gap-3 text-sm text-gray-700 leading-relaxed">
                  <p>{{ t('privacy_page.s5_p1') }}</p>
                  <p>{{ t('privacy_page.s5_p2') }}</p>
                </div>
              </section>

              <!-- 6 -->
              <section>
                <h2 class="flex items-center gap-3 text-lg font-bold text-gray-900 mb-4">
                  <span class="w-8 h-8 rounded-lg bg-(--theme-color) text-white text-sm font-bold flex items-center justify-center shrink-0">6</span>
                  {{ t('privacy_page.s6_title') }}
                </h2>
                <div class="pl-11">
                  <p class="text-sm text-gray-700 leading-relaxed mb-3">{{ t('privacy_page.s6_intro') }}</p>
                  <ul class="flex flex-col gap-2 mb-4">
                    <li v-for="item in tm('privacy_page.s6_items') as string[]" :key="item" class="flex items-start gap-2.5 text-sm text-gray-700">
                      <span class="w-1.5 h-1.5 rounded-full bg-(--theme-color) mt-1.5 shrink-0" />
                      {{ item }}
                    </li>
                  </ul>
                  <p class="text-sm text-gray-700">
                    {{ t('privacy_page.s6_contact_pre') }}
                    <a href="mailto:info@augz.uz" class="text-(--theme-color) font-semibold hover:underline">info@augz.uz</a>
                  </p>
                </div>
              </section>

              <!-- 7 -->
              <section class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                <h2 class="flex items-center gap-3 text-lg font-bold text-gray-900 mb-4">
                  <span class="w-8 h-8 rounded-lg bg-(--theme-color) text-white text-sm font-bold flex items-center justify-center shrink-0">7</span>
                  {{ t('privacy_page.s7_title') }}
                </h2>
                <div class="pl-11 flex flex-col gap-2 text-sm text-gray-700">
                  <p>{{ t('privacy_page.s7_intro') }}</p>
                  <div class="mt-2 flex flex-col gap-2">
                    <div class="flex items-start gap-2">
                      <Icon name="mdi:map-marker" class="w-4 h-4 text-(--theme-color) mt-0.5 shrink-0" />
                      <span>{{ t('privacy_page.s7_address') }}</span>
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
                </div>
              </section>

            </div>
          </div>

          <!-- Bottom nav -->
          <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <NuxtLink :to="localePath('/')" class="flex items-center gap-2 text-sm text-gray-500 hover:text-(--theme-color) transition-colors">
              <Icon name="heroicons:arrow-left" class="w-4 h-4" />
              {{ t('privacy_page.nav_back') }}
            </NuxtLink>
            <NuxtLink :to="localePath('/appeals-rules')" class="flex items-center gap-2 text-sm text-(--theme-color) font-semibold hover:underline transition-colors">
              {{ t('privacy_page.nav_next') }}
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

useSeoMeta({
  title: () => t('privacy_page.seo_title'),
  description: () => t('privacy_page.seo_desc'),
  ogTitle: () => t('privacy_page.seo_title'),
  ogDescription: () => t('privacy_page.seo_desc'),
  ogUrl: 'https://augz.uz/privacy',
  ogType: 'website',
  robots: 'index, follow',
})
</script>
