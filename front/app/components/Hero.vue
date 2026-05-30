<template>
  <div
    class="relative overflow-hidden min-h-[100svh] md:min-h-[88vh] flex items-start md:items-center"
    :style="hero?.image ? `background: url('${hero.image}') no-repeat center top / cover` : ''"
  >

    <div class="absolute inset-x-0 bottom-0 h-40 bg-linear-to-t from-white/40 to-transparent pointer-events-none md:hidden" />

    <div class="relative container mx-auto px-4 pb-14 pt-28 md:py-24">
      <div class="flex flex-col gap-y-5 md:gap-y-8 max-w-2xl">

        <h1 class="text-[2.6rem] leading-[1.1] sm:text-5xl md:text-6xl flex flex-col gap-y-1.5 md:gap-y-3">
          <b>{{ lt(hero?.title_1) }}</b>
          <b class="text-(--theme-color)">{{ lt(hero?.title_2) }}</b>
          <b>{{ lt(hero?.title_3) }}</b>
        </h1>

        <p class="text-sm sm:text-base leading-relaxed text-gray-700 max-w-sm md:max-w-md">
          {{ lt(hero?.subtitle) }}
        </p>

        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
          <UiButton class="w-full sm:w-auto" @click="scrollTo(hero?.btn_primary?.href ?? '#about')">
            {{ lt(hero?.btn_primary?.label) }}
          </UiButton>
          <UiButton class="w-full sm:w-auto hidden md:block" variant="outlined" @click="scrollTo(hero?.btn_secondary?.href ?? '#services')">
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
