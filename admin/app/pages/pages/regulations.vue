<template>
  <div class="p-8 max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
      <NuxtLink to="/" class="text-gray-400 hover:text-gray-600 transition-colors">
        <UIcon name="i-lucide-chevron-left" class="w-5 h-5" />
      </NuxtLink>
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Нормативные документы — страница</h1>
        <p class="text-sm text-gray-400 mt-0.5">Статический контент hero-секции</p>
      </div>
    </div>

    <div v-if="pending" class="flex items-center justify-center py-20">
      <UIcon name="i-lucide-loader-2" class="w-6 h-6 animate-spin text-gray-300" />
    </div>

    <div v-else-if="hero" class="space-y-6">
      <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Hero</h2>

        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Badge (подпись над заголовком)</p>
          <I18nField v-model="hero.badge" />
        </div>

        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок — строка 1</p>
          <I18nField v-model="hero.title_1" />
        </div>

        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок — строка 2 (акцент)</p>
          <I18nField v-model="hero.title_2" />
        </div>

        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подзаголовок</p>
          <I18nField v-model="hero.subtitle" :textarea="true" />
        </div>
      </div>

      <p v-if="saveError" class="text-sm text-red-500">{{ saveError }}</p>

      <div class="flex items-center gap-3">
        <UButton :loading="saving" @click="save">Сохранить изменения</UButton>
        <span v-if="saved" class="text-sm text-green-600 flex items-center gap-1">
          <UIcon name="i-lucide-check" class="w-4 h-4" /> Сохранено
        </span>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ middleware: 'auth' })

const { apiFetch } = useApi()

const saving    = ref(false)
const saved     = ref(false)
const saveError = ref('')

const { data: pageData, pending } = await useAsyncData(
  'admin-page-regulations',
  () => apiFetch<{ slug: string; content: any }>('/admin/page/regulations'),
)

const hero = computed({
  get: () => pageData.value?.content?.hero ?? {
    badge:    { ru: '', uz: '', en: '' },
    title_1:  { ru: '', uz: '', en: '' },
    title_2:  { ru: '', uz: '', en: '' },
    subtitle: { ru: '', uz: '', en: '' },
  },
  set: (val) => {
    if (pageData.value) {
      pageData.value = { ...pageData.value, content: { ...pageData.value.content, hero: val } }
    }
  },
})

async function save() {
  saving.value    = true
  saved.value     = false
  saveError.value = ''
  try {
    await apiFetch('/admin/page/regulations', {
      method: 'PUT',
      body: { content: pageData.value?.content ?? {} },
    })
    saved.value = true
    setTimeout(() => { saved.value = false }, 3000)
  } catch (e: any) {
    saveError.value = e?.data?.message ?? 'Ошибка сохранения'
  } finally {
    saving.value = false
  }
}
</script>
