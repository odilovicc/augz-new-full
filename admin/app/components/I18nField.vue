<template>
  <div class="space-y-2">
    <div v-for="lang in langs" :key="lang.code" class="flex items-start gap-2">
      <span class="shrink-0 mt-2 text-xs font-bold uppercase text-gray-400 w-6 text-center">{{ lang.code }}</span>
      <UTextarea
        v-if="textarea"
        :model-value="modelValue ? modelValue[lang.code] : ''"
        :rows="3"
        class="flex-1"
        :placeholder="lang.placeholder"
        @update:model-value="update(lang.code, $event)"
      />
      <UInput
        v-else
        :model-value="modelValue ? modelValue[lang.code] : ''"
        class="flex-1"
        :placeholder="lang.placeholder"
        @update:model-value="update(lang.code, $event)"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
const props = defineProps<{
  modelValue: { ru: string; uz: string; en: string }
  textarea?: boolean
}>()

const emit = defineEmits<{
  'update:modelValue': [value: { ru: string; uz: string; en: string }]
}>()

const langs = [
  { code: 'ru' as const, placeholder: 'Русский...' },
  { code: 'uz' as const, placeholder: "O'zbek..." },
  { code: 'en' as const, placeholder: 'English...' },
]

function update(code: 'ru' | 'uz' | 'en', value: string) {
  const current = props.modelValue || { ru: '', uz: '', en: '' }
  emit('update:modelValue', { ...current, [code]: value })
}
</script>
