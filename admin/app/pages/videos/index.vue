<template>
  <div class="p-8">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Видео</h1>
        <p class="text-sm text-gray-400 mt-0.5">{{ videos?.length ?? 0 }} записей</p>
      </div>
      <UButton icon="i-lucide-plus" @click="openCreate">Добавить</UButton>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">
      <div v-if="pending" class="flex items-center justify-center py-20">
        <UIcon name="i-lucide-loader-2" class="w-6 h-6 animate-spin text-gray-300" />
      </div>

      <table v-else class="w-full text-sm">
        <thead class="border-b border-gray-100 dark:border-gray-800">
          <tr class="text-left text-gray-400 text-xs uppercase tracking-wide">
            <th class="px-5 py-3 font-medium w-24">Превью</th>
            <th class="px-5 py-3 font-medium">Название</th>
            <th class="px-5 py-3 font-medium text-center">Порядок</th>
            <th class="px-5 py-3 font-medium text-right">Действия</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
          <tr v-for="item in videos" :key="item.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
            <td class="px-5 py-3">
              <div class="w-16 h-10 rounded-lg bg-gray-100 dark:bg-gray-800 overflow-hidden">
                <img v-if="item.thumbnail" :src="item.thumbnail" :alt="item.title" class="w-full h-full object-cover" />
                <div v-else class="w-full h-full flex items-center justify-center">
                  <UIcon name="i-lucide-video" class="w-4 h-4 text-gray-300" />
                </div>
              </div>
            </td>
            <td class="px-5 py-3 max-w-xs">
              <p class="font-medium text-gray-900 dark:text-white line-clamp-1">{{ item.title }}</p>
              <p class="text-gray-400 text-xs line-clamp-1 mt-0.5 font-mono">{{ item.url }}</p>
            </td>
            <td class="px-5 py-3 text-center text-gray-500">{{ item.sort_order }}</td>
            <td class="px-5 py-3">
              <div class="flex items-center justify-end gap-1">
                <UButton size="xs" variant="ghost" icon="i-lucide-pencil" @click="openEdit(item)" />
                <UButton size="xs" variant="ghost" color="error" icon="i-lucide-trash-2" :loading="deleting === item.id" @click="deleteItem(item.id)" />
              </div>
            </td>
          </tr>
          <tr v-if="!videos?.length">
            <td colspan="4" class="px-5 py-12 text-center text-gray-400">Нет видео</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Slideover: create (only URL) -->
  <USlideover v-model:open="createOpen" title="Новое видео" side="right" class="w-full max-w-md">
    <template #body>
      <form class="flex flex-col gap-5 p-6" @submit.prevent="create">
        <UFormField label="Ссылка на YouTube" required>
          <UInput
            v-model="newUrl"
            class="w-full"
            placeholder="https://youtu.be/... или https://youtube.com/watch?v=..."
            autofocus
          />
          <template #hint>
            <span class="text-xs text-gray-400">Название и превью подтянутся автоматически</span>
          </template>
        </UFormField>

        <p v-if="saveError" class="text-sm text-red-500">{{ saveError }}</p>

        <div class="flex gap-3 pt-2">
          <UButton type="submit" :loading="saving" class="flex-1 justify-center">Добавить</UButton>
          <UButton variant="outline" @click="createOpen = false">Отмена</UButton>
        </div>
      </form>
    </template>
  </USlideover>

  <!-- Slideover: edit (title + sort_order) -->
  <USlideover v-model:open="editOpen" title="Редактировать видео" side="right" class="w-full max-w-md">
    <template #body>
      <form class="flex flex-col gap-5 p-6" @submit.prevent="saveEdit">
        <div v-if="editItem?.thumbnail" class="w-full aspect-video rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800">
          <img :src="editItem.thumbnail" :alt="editItem.title" class="w-full h-full object-cover" />
        </div>

        <UFormField label="Название">
          <UInput v-model="editForm.title" class="w-full" />
        </UFormField>

        <UFormField label="Порядок сортировки">
          <UInput v-model.number="editForm.sort_order" type="number" class="w-full" />
        </UFormField>

        <p v-if="saveError" class="text-sm text-red-500">{{ saveError }}</p>

        <div class="flex gap-3 pt-2">
          <UButton type="submit" :loading="saving" class="flex-1 justify-center">Сохранить</UButton>
          <UButton variant="outline" @click="editOpen = false">Отмена</UButton>
        </div>
      </form>
    </template>
  </USlideover>
</template>

<script setup lang="ts">
definePageMeta({ middleware: 'auth' })

const { apiFetch } = useApi()

const createOpen = ref(false)
const editOpen = ref(false)
const editItem = ref<any>(null)
const deleting = ref<number | null>(null)
const saving = ref(false)
const saveError = ref('')

const newUrl = ref('')
const editForm = reactive({ title: '', sort_order: 0 })

const { data, pending, refresh } = await useAsyncData(
  'admin-videos',
  () => apiFetch<any>('/admin/videos'),
)

const videos = computed(() => data.value?.data ?? [])

function openCreate() {
  newUrl.value = ''
  saveError.value = ''
  createOpen.value = true
}

function openEdit(item: any) {
  editItem.value = item
  editForm.title = item.title ?? ''
  editForm.sort_order = item.sort_order ?? 0
  saveError.value = ''
  editOpen.value = true
}

async function create() {
  if (!newUrl.value.trim()) return
  saving.value = true
  saveError.value = ''
  try {
    await apiFetch('/admin/videos', { method: 'POST', body: { url: newUrl.value.trim() } })
    createOpen.value = false
    await refresh()
  }
  catch (e: any) {
    saveError.value = e?.data?.message ?? 'Ошибка сохранения'
  }
  finally {
    saving.value = false
  }
}

async function saveEdit() {
  saving.value = true
  saveError.value = ''
  try {
    await apiFetch(`/admin/videos/${editItem.value.id}`, { method: 'PUT', body: { ...editForm } })
    editOpen.value = false
    await refresh()
  }
  catch (e: any) {
    saveError.value = e?.data?.message ?? 'Ошибка сохранения'
  }
  finally {
    saving.value = false
  }
}

async function deleteItem(id: number) {
  deleting.value = id
  try {
    await apiFetch(`/admin/videos/${id}`, { method: 'DELETE' })
    await refresh()
  }
  finally {
    deleting.value = null
  }
}
</script>
