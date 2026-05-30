<template>
  <section class="section bg-gray-50 mt-0 py-0">
    <div class="container mx-auto px-4">
      <div class="bg-white rounded-3xl px-8 py-10 md:px-12 md:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 lg:gap-6 items-center">

          <div class="lg:col-span-1 flex flex-col gap-2">
            <span class="text-sm font-bold text-(--theme-color) uppercase tracking-widest">{{ lt(stats?.label) }}</span>
            <h2 class="text-3xl md:text-4xl font-black uppercase tracking-tight leading-none">{{ lt(stats?.heading) }}</h2>
          </div>

          <div class="lg:col-span-4 grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-4">
            <div
              v-for="(item, i) in items"
              :key="i"
              class="relative flex flex-col items-center text-center gap-3 pt-4 overflow-hidden"
            >
              <div class="absolute top-0 right-2 w-16 h-16 rounded-full bg-gray-100 z-0" />
              <div class="relative z-10 w-14 h-14 bg-white rounded-2xl shadow-md border border-gray-100 flex items-center justify-center shrink-0">
                <Icon :name="item.icon" class="w-7 h-7 text-gray-800" />
              </div>
              <div class="text-3xl md:text-4xl font-black text-gray-900 leading-none">{{ lt(item.value) }}</div>
              <div class="text-sm text-gray-500 leading-snug">{{ lt(item.label) }}</div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
const pageContent = usePageContent()
const lt = useLocaleText()

const stats = computed(() => pageContent.value?.stats)
const items = computed(() => stats.value?.items ?? [])
</script>
