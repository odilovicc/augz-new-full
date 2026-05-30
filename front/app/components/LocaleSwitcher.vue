<template>
  <div class="relative" ref="container">
    <button
      @click="open = !open"
      class="flex items-center gap-1 text-sm font-medium px-2 py-1 rounded-md hover:bg-gray-50 transition select-none"
    >
      {{ t(`lang.${locale}`) }}
      <svg
        class="w-3.5 h-3.5 text-gray-400 transition-transform duration-200"
        :class="open ? 'rotate-180' : ''"
        fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
      >
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
      </svg>
    </button>

    <Transition
      enter-active-class="transition duration-150 ease-out"
      enter-from-class="opacity-0 translate-y-1"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition duration-100 ease-in"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 translate-y-1"
    >
      <div
        v-if="open"
        class="absolute right-0 mt-1 w-32 bg-white border border-gray-100 rounded-xl shadow-lg overflow-hidden z-50 max-sm:left-0 max-sm:right-auto"
      >
        <button
          v-for="loc in locales"
          :key="loc.code"
          @click="select(loc.code)"
          class="w-full flex items-center justify-between px-3 py-2 text-sm transition hover:bg-gray-50"
          :class="locale === loc.code ? 'text-(--theme-color) font-semibold' : 'text-gray-700'"
        >
          {{ loc.name }}
          <svg v-if="locale === loc.code" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
          </svg>
        </button>
      </div>
    </Transition>
  </div>
</template>

<script setup lang="ts">
const { locale, locales, t } = useI18n()
const switchLocalePath = useSwitchLocalePath()
const router = useRouter()

const open = ref(false)
const container = ref<HTMLElement | null>(null)

function select(code: string) {
  open.value = false
  router.push(switchLocalePath(code))
}

onMounted(() => {
  document.addEventListener('click', onOutsideClick)
})
onUnmounted(() => {
  document.removeEventListener('click', onOutsideClick)
})

function onOutsideClick(e: MouseEvent) {
  if (container.value && !container.value.contains(e.target as Node)) {
    open.value = false
  }
}
</script>
