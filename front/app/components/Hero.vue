<template>
  <div
    class="relative overflow-hidden bg-white min-h-85 md:min-h-100 flex items-center"
    :style="hero?.image ? `background: url('${hero.image}') no-repeat center / cover` : ''"
  >

    <div v-if="!hero?.image" class="absolute inset-y-0 right-0 w-2/5 sm:w-1/2 md:w-[55%] pointer-events-none select-none">
      <div class="absolute inset-0 bg-linear-to-r from-white via-white/90 to-transparent to-60% z-10" />
      <img src="/img/Hero.png" alt="АУГЗ здание" class="w-full h-full object-cover object-right" />
    </div>
    <div v-else class="absolute inset-0 bg-linear-to-r from-white via-white/70 to-transparent pointer-events-none" />

    <div class="relative container mx-auto px-4 pb-10 pt-24 md:py-24">
      <div class="flex flex-col gap-y-4 md:gap-y-8 max-w-[58%] sm:max-w-[55%] md:max-w-2xl">

        <h1 class="text-3xl sm:text-5xl md:text-6xl leading-[1.1] flex flex-col gap-y-1.5 md:gap-y-3">
          <b>{{ lt(hero?.title_1) }}</b>
          <b class="text-(--theme-color)">{{ lt(hero?.title_2) }}</b>
          <b>{{ lt(hero?.title_3) }}</b>
        </h1>

        <p class="text-sm sm:text-base leading-relaxed text-gray-700 max-w-sm md:max-w-md">
          {{ lt(hero?.subtitle) }}
        </p>

        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto max-w-full">
          <UiButton class="w-full sm:w-auto" @click="scrollTo(hero?.btn_primary?.href ?? '#about')">
            {{ lt(hero?.btn_primary?.label) }}
          </UiButton>
          <UiButton class="w-full sm:w-auto hidden md:block" variant="outlined" @click="scrollTo(hero?.btn_secondary?.href ?? '/services')">
            {{ lt(hero?.btn_secondary?.label) }}
          </UiButton>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
const pageContent = usePageContent()
const lt = useLocaleText()

const hero = computed(() => pageContent.value?.hero)

function scrollTo(href: string) {
  document.querySelector(href)?.scrollIntoView({ behavior: 'smooth' })
}
</script>
