<template>
  <div
    class="relative overflow-hidden min-h-[60vh] md:min-h-[72vh] flex items-end"
    :style="hero?.image ? `background: url('${hero.image}') no-repeat center top / cover` : 'background: #f5f5f5'"
  >
    <!-- bottom fade -->
    <div class="absolute inset-x-0 bottom-0 h-64 bg-linear-to-t from-white via-white/60 to-transparent pointer-events-none" />

    <div class="relative container mx-auto px-4 pb-16 pt-32">
      <!-- Badge -->
      <div class="flex items-center gap-2 mb-6">
        <span class="w-8 h-0.5 bg-(--theme-color)" />
        <span class="text-xs font-bold uppercase tracking-[0.2em] text-gray-700">{{ lt(hero?.badge) }}</span>
      </div>

      <!-- Title -->
      <h1 class="text-4xl sm:text-5xl md:text-6xl font-black uppercase leading-none mb-4">
        {{ lt(hero?.title_1) }}
        <span class="text-(--theme-color)">{{ lt(hero?.title_2) }}</span>
      </h1>

      <!-- Subtitle -->
      <p class="text-sm sm:text-base text-gray-700 max-w-sm leading-relaxed mb-8">
        {{ lt(hero?.subtitle) }}
      </p>

      <!-- Category pills -->
      <div class="flex flex-wrap gap-2">
        <button
          v-for="(cat, i) in categories"
          :key="i"
          :class="[
            'flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold border transition',
            activeCategory === i
              ? 'bg-gray-900 text-white border-gray-900'
              : 'bg-white/80 text-gray-700 border-gray-200 hover:border-gray-400'
          ]"
          @click="activeCategory = i"
        >
          <span
            class="w-2 h-2 rounded-full shrink-0"
            :style="`background: ${cat.color}`"
          />
          {{ lt(cat.label) }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
const content = useServicesPageContent()
const lt = useLocaleText()

const hero = computed(() => content.value?.hero)
const categories = computed(() => hero.value?.categories ?? [])
const activeCategory = ref(0)
</script>
