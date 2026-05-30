<template>
  <section class="section bg-[#f4f6f9]">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">

        <!-- Left: text -->
        <div class="flex flex-col gap-6">
          <!-- Badge -->
          <div class="inline-flex self-start">
            <span class="bg-(--theme-color) text-white text-sm font-semibold px-4 py-1.5 rounded-md">
              {{ lt(intro?.badge) || 'С 2013 года' }}
            </span>
          </div>

          <h2 class="text-3xl md:text-4xl font-black uppercase leading-tight text-gray-900">
            {{ lt(intro?.heading) || 'АССОЦИАЦИЯ ПРОФЕССИОНАЛОВ В СФЕРЕ УСЛУГ' }}
          </h2>

          <p class="text-sm leading-relaxed text-gray-500 max-w-sm">
            {{ lt(intro?.desc) || 'Развиваем профессиональное сообщество и создаём возможности для роста.' }}
          </p>

          <a
            :href="intro?.btn_href || '#contacts'"
            class="self-start flex items-center gap-2 px-6 py-3 rounded-md border-2 border-(--theme-color) text-(--theme-color) text-sm font-semibold hover:bg-(--theme-color) hover:text-white transition-colors duration-200"
          >
            {{ lt(intro?.btn_label) || 'Вступить в ассоциацию' }}
            <span>→</span>
          </a>
        </div>

        <!-- Right: stat cards -->
        <div class="flex flex-col gap-4">
          <div
            v-for="(stat, i) in stats"
            :key="i"
            class="flex items-center gap-5 bg-white rounded-2xl px-6 py-6 shadow-sm border border-gray-100 overflow-hidden relative"
            :style="{ borderLeftWidth: '4px', borderLeftColor: stat.accent_color || '#D1832C' }"
          >
            <!-- decorative large number in background -->
            <div
              class="absolute right-4 top-1/2 -translate-y-1/2 text-7xl font-black leading-none select-none pointer-events-none"
              :style="{ color: hexToAlpha(stat.accent_color || '#D1832C', 0.06) }"
            >
              {{ stat.value }}
            </div>

            <!-- icon -->
            <div
              class="relative shrink-0 w-14 h-14 rounded-xl flex items-center justify-center"
              :style="{ background: hexToAlpha(stat.accent_color || '#D1832C', 0.1) }"
            >
              <Icon :name="stat.icon || 'heroicons:users'" class="w-7 h-7" :style="{ color: stat.accent_color || '#D1832C' }" />
            </div>

            <!-- text -->
            <div class="relative flex flex-col gap-0.5 min-w-0">
              <div class="text-3xl font-black leading-none tracking-tight" :style="{ color: stat.accent_color || '#D1832C' }">
                {{ stat.value }}
              </div>
              <div class="text-sm text-gray-500 leading-snug mt-1">{{ lt(stat.label) }}</div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
const aboutContent = useAboutPageContent()
const lt = useLocaleText()

const intro = computed(() => aboutContent.value?.intro)
const stats = computed(() => intro.value?.stats ?? [])

function hexToAlpha(hex: string, alpha: number): string {
  const r = parseInt(hex.slice(1, 3), 16)
  const g = parseInt(hex.slice(3, 5), 16)
  const b = parseInt(hex.slice(5, 7), 16)
  return `rgba(${r},${g},${b},${alpha})`
}
</script>
