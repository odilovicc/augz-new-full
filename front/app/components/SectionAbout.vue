<template>
  <section id="about" class="section">

    <!-- Feature cards -->
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-px bg-gray-100 border border-gray-100 rounded-2xl overflow-hidden shadow-sm">
        <div
          v-for="(feature, i) in features"
          :key="i"
          class="relative bg-white px-7 py-8 flex flex-col gap-4 group hover:bg-gray-950 transition-colors duration-300 overflow-hidden"
        >
          <span class="absolute -top-2 right-4 text-8xl font-black text-gray-50 group-hover:text-white/5 transition-colors select-none leading-none pointer-events-none">
            0{{ i + 1 }}
          </span>
          <div class="h-0.5 w-6 bg-(--theme-color) group-hover:w-10 transition-all duration-300 mb-1" />
          <Icon :name="feature.icon" class="w-8 h-8 text-(--theme-color) shrink-0" />
          <h3 class="font-bold text-gray-900 group-hover:text-white transition-colors leading-snug">
            {{ lt(feature.title) }}
          </h3>
          <p class="text-sm text-gray-500 group-hover:text-gray-400 transition-colors leading-relaxed">
            {{ lt(feature.desc) }}
          </p>
        </div>
      </div>
    </div>

  </section>
</template>

<script setup lang="ts">
const pageContent = usePageContent()
const lt = useLocaleText()

const about = computed(() => pageContent.value?.about)
const features = computed(() => about.value?.features ?? [])
</script>
