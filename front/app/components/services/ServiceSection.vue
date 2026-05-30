<template>
  <section :id="section.id" class="section border-t border-gray-100">
    <div class="container mx-auto px-4">

      <!-- Section header -->
      <div class="mb-10">
        <div class="flex items-center gap-2 mb-3">
          <span class="w-6 h-0.5 bg-(--theme-color)" />
          <span class="text-xs font-bold uppercase tracking-[0.18em] text-(--theme-color)">{{ lt(section.badge) }}</span>
        </div>
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-black uppercase leading-tight mb-3">
          {{ lt(section.heading) }}
        </h2>
        <p class="text-sm text-gray-500 max-w-lg leading-relaxed">{{ lt(section.subtitle) }}</p>
      </div>

      <!-- Two-column layout -->
      <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 lg:gap-8">

        <!-- Left: service items list -->
        <div class="lg:col-span-3 flex flex-col divide-y divide-gray-100">
          <div
            v-for="(item, i) in section.items"
            :key="i"
            class="group py-6 flex gap-5 cursor-default"
          >
            <span class="text-xs text-gray-300 font-bold mt-1 shrink-0 w-5">{{ item.number }}</span>
            <div class="flex flex-col gap-2 flex-1">
              <h3 class="font-bold text-gray-900 group-hover:text-(--theme-color) transition-colors leading-snug">
                {{ lt(item.title) }}
              </h3>
              <p class="text-sm text-gray-500 leading-relaxed">{{ lt(item.desc) }}</p>
              <div class="flex flex-wrap gap-1.5 mt-1">
                <span
                  v-for="tag in item.tags"
                  :key="tag"
                  class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] font-bold uppercase tracking-wide rounded"
                >
                  {{ tag }}
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Right: stats + CTA panel -->
        <div class="lg:col-span-2 flex flex-col gap-4">

          <!-- Stats card -->
          <div class="rounded-2xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
              <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">{{ lt(section.stats_label) }}</span>
            </div>
            <div class="grid grid-cols-2 divide-x divide-y divide-gray-100">
              <div
                v-for="(stat, i) in section.stats"
                :key="i"
                class="px-5 py-4 flex flex-col gap-0.5"
              >
                <span class="text-2xl font-black text-gray-900 leading-none">{{ stat.value }}</span>
                <span class="text-xs text-gray-500 leading-snug">{{ lt(stat.label) }}</span>
              </div>
            </div>
            <div class="px-5 py-4 border-t border-gray-100 bg-gray-50">
              <p class="text-xs text-gray-500 leading-relaxed">{{ lt(section.stats_desc) }}</p>
            </div>
          </div>

          <!-- CTA button -->
          <a
            :href="section.cta_href"
            class="block w-full text-center px-5 py-3 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-(--theme-color) transition-colors"
          >
            {{ lt(section.cta_label) }} →
          </a>

          <!-- Express card -->
          <div class="rounded-2xl bg-gray-900 px-5 py-5 flex flex-col gap-3">
            <h4 class="text-white font-bold text-sm">{{ lt(section.express_title) }}</h4>
            <p class="text-gray-400 text-xs leading-relaxed">{{ lt(section.express_desc) }}</p>
            <button class="w-full px-4 py-2.5 bg-(--theme-color) text-white text-sm font-semibold rounded-lg hover:opacity-90 transition-opacity">
              {{ lt(section.express_btn) }}
            </button>
          </div>

        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import type { ServiceSection } from '~/composables/useServicesPageContent'

defineProps<{
  section: ServiceSection
  index: number
}>()

const lt = useLocaleText()
</script>
