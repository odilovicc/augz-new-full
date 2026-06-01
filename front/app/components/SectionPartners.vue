<template>
  <section class="section bg-gray-100 border-y border-gray-200 overflow-hidden">
    <div class="container mx-auto px-4 mb-10 -mt-10">
      <p class="text-center text-xl font-bold text-(--theme-color) uppercase tracking-widest">
        {{ lt(partners?.heading) }}
      </p>
    </div>

    <div class="relative overflow-hidden" style="mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent); -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);">
      <div class="marquee-track">
        <div v-for="n in 4" :key="n" class="marquee-content" :aria-hidden="n > 1 ? 'true' : undefined">
          <img v-for="(logo, i) in logos" :key="i"
               :src="logo.src" :alt="logo.alt" class="h-12 w-auto object-contain flex-shrink-0" />
        </div>
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
  to   { transform: translateX(-25%); }
}

.marquee-track {
  display: flex;
  width: max-content;
  animation: marquee 22s linear infinite;
  will-change: transform;
}

.marquee-content {
  display: flex;
  align-items: center;
  gap: 5rem;
  padding-right: 5rem;
}
</style>
