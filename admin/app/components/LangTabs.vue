<template>
  <div class="flex gap-1 p-1 bg-gray-100 dark:bg-gray-800 rounded-xl">
    <button
      v-for="lang in langs"
      :key="lang.code"
      type="button"
      class="flex-1 flex items-center justify-center gap-2 py-2 px-3 rounded-lg text-sm font-semibold transition-all"
      :class="modelValue === lang.code
        ? 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm'
        : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-300'"
      @click="$emit('update:modelValue', lang.code)"
    >
      <span>{{ lang.flag }}</span>
      <span>{{ lang.label }}</span>
    </button>
  </div>
</template>

<script setup lang="ts">
defineProps<{ modelValue: 'ru' | 'uz' | 'en' }>()
defineEmits<{ 'update:modelValue': [val: 'ru' | 'uz' | 'en'] }>()

const langs = [
  { code: 'ru' as const, label: 'Русский', flag: '🇷🇺' },
  { code: 'uz' as const, label: 'Ўзбекча', flag: '🇺🇿' },
  { code: 'en' as const, label: 'English',  flag: '🇬🇧' },
]
</script>
