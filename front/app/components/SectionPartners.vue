<template>
  <section class="section bg-gray-100 border-y border-gray-200 overflow-hidden">
    <div class="container mx-auto px-4 mb-10 -mt-10">
      <p class="text-center text-xl font-bold text-(--theme-color) uppercase tracking-widest">
        {{ lt(partners?.heading) }}
      </p>
    </div>

    <div class="relative overflow-hidden" style="mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);">
      <div class="flex gap-20 items-center animate-marquee w-max">
        <img v-for="(logo, i) in [...logos, ...logos]" :key="i"
             :src="logo.src" :alt="logo.alt" class="h-12 w-auto object-contain" />
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
const pageContent = usePageContent()
const lt = useLocaleText()

const partners = computed(() => pageContent.value?.partners)
const logos = computed(() => partners.value?.logos ?? [])
</script>

<style scoped>
@keyframes marquee {
  from { transform: translateX(0); }
  to   { transform: translateX(-50%); }
}
.animate-marquee { animation: marquee 22s linear infinite; }
.animate-marquee:hover { animation-play-state: paused; }
</style>
