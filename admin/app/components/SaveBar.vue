<template>
  <div class="flex items-center gap-3 pt-2 border-t border-gray-100 dark:border-gray-800">
    <UButton type="button" :loading="saving" @click="emit('save')">Сохранить</UButton>
    <p v-if="error" class="text-sm text-red-500">{{ error }}</p>
    <p v-if="saved" class="text-sm text-green-500">Сохранено</p>
  </div>
</template>

<script setup lang="ts">
const props = defineProps<{ saving: boolean; error: string }>()
const emit = defineEmits<{ save: [] }>()

const saved = ref(false)
watch(() => props.saving, (val, old) => {
  if (old && !val && !props.error) {
    saved.value = true
    setTimeout(() => { saved.value = false }, 2000)
  }
})
</script>
