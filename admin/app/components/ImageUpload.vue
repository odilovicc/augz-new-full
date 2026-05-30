<template>
  <div :class="compact ? 'flex items-center gap-2' : 'space-y-3'">

    <!-- full preview -->
    <div v-if="modelValue && !compact" class="relative group w-full rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800" style="aspect-ratio: 16/9; max-height: 320px;">
      <img :src="modelValue" alt="preview" class="w-full h-full object-cover" />
      <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors flex items-center justify-center">
        <label class="opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-2 bg-white/90 dark:bg-gray-900/90 text-gray-800 dark:text-white text-xs font-medium px-3 py-2 rounded-lg cursor-pointer shadow">
          <UIcon name="i-lucide-upload-cloud" class="w-4 h-4" />
          Заменить
          <input type="file" accept="image/*" class="hidden" :disabled="uploading" @change="onFileChange" />
        </label>
      </div>
      <div v-if="uploading" class="absolute inset-0 bg-black/40 flex items-center justify-center">
        <UIcon name="i-lucide-loader-2" class="w-6 h-6 text-white animate-spin" />
      </div>
    </div>

    <!-- drop zone (shown when no image yet, or always in compact mode) -->
    <label
      v-if="!modelValue || compact"
      class="flex items-center justify-center gap-2 cursor-pointer rounded-xl border-2 border-dashed transition-colors"
      :class="[
        compact ? 'h-9 w-32 text-xs shrink-0' : 'h-40 w-full',
        dragOver
          ? 'border-primary-400 bg-primary-50 dark:bg-primary-950'
          : 'border-gray-200 dark:border-gray-700 hover:border-primary-300 hover:bg-gray-50 dark:hover:bg-gray-800',
      ]"
      @dragover.prevent="dragOver = true"
      @dragleave="dragOver = false"
      @drop.prevent="onDrop"
    >
      <UIcon name="i-lucide-upload-cloud" class="w-5 h-5" :class="dragOver ? 'text-primary-500' : 'text-gray-300'" />
      <span v-if="uploading" class="text-xs text-gray-400">Загрузка...</span>
      <span v-else-if="!compact" class="text-sm text-gray-400">Перетащите или <span class="text-primary-500 font-medium">выберите файл</span></span>
      <input type="file" accept="image/*" class="hidden" :disabled="uploading" @change="onFileChange" />
    </label>

    <!-- url input -->
    <p v-if="!compact" class="text-xs text-gray-400">или вставьте URL изображения</p>
    <UInput
      v-if="!compact"
      :model-value="modelValue"
      class="w-full"
      placeholder="или вставьте URL изображения"
      @update:model-value="emit('update:modelValue', $event)"
    />

    <p v-if="uploadError && !compact" class="text-xs text-red-500">{{ uploadError }}</p>
  </div>
</template>

<script setup lang="ts">
const props = defineProps<{
  modelValue: string
  compact?: boolean
}>()
const emit = defineEmits<{ 'update:modelValue': [value: string] }>()

const config = useRuntimeConfig()
const token = useCookie('admin_token')
const uploading = ref(false)
const dragOver = ref(false)
const uploadError = ref('')

async function uploadFile(file: File) {
  if (!file.type.startsWith('image/')) return
  uploadError.value = ''
  uploading.value = true
  try {
    const fd = new FormData()
    fd.append('image', file)
    const res = await $fetch<{ url: string }>(`${config.public.apiBase}/admin/upload/image`, {
      method: 'POST',
      body: fd,
      headers: {
        Authorization: `Bearer ${token.value}`,
        Accept: 'application/json',
      },
    })
    emit('update:modelValue', res.url)
  }
  catch (e: any) {
    if (e?.status === 401 || e?.response?.status === 401) {
      await navigateTo('/login')
      return
    }
    uploadError.value = e?.data?.message ?? e?.message ?? 'Ошибка загрузки'
  }
  finally {
    uploading.value = false
  }
}

function onFileChange(e: Event) {
  const file = (e.target as HTMLInputElement).files?.[0]
  if (file) uploadFile(file)
}

function onDrop(e: DragEvent) {
  dragOver.value = false
  const file = e.dataTransfer?.files?.[0]
  if (file) uploadFile(file)
}
</script>
