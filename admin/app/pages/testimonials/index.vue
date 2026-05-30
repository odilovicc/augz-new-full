<template>
  <div class="p-8">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Отзывы</h1>
        <p class="text-sm text-gray-400 mt-0.5">{{ items.length }} отзывов</p>
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
            <th class="px-5 py-3 font-medium w-12">Аватар</th>
            <th class="px-5 py-3 font-medium">Автор</th>
            <th class="px-5 py-3 font-medium">Текст</th>
            <th class="px-5 py-3 font-medium w-16 text-center">№</th>
            <th class="px-5 py-3 font-medium text-right">Действия</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
          <tr v-for="item in items" :key="item.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
            <td class="px-5 py-3">
              <div
                class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-black text-white shrink-0"
                :style="{ background: item.avatar_color || '#374151' }"
              >
                {{ item.initials }}
              </div>
            </td>
            <td class="px-5 py-3">
              <p class="font-medium text-gray-900 dark:text-white">{{ item.author }}</p>
              <p class="text-gray-400 text-xs mt-0.5">{{ item.role }}</p>
            </td>
            <td class="px-5 py-3 max-w-sm">
              <p class="text-gray-500 line-clamp-2 text-xs">{{ item.text }}</p>
            </td>
            <td class="px-5 py-3 text-center text-gray-400">{{ item.sort_order }}</td>
            <td class="px-5 py-3">
              <div class="flex items-center justify-end gap-1">
                <UButton size="xs" variant="ghost" icon="i-lucide-pencil" @click="openEdit(item)" />
                <UButton size="xs" variant="ghost" color="error" icon="i-lucide-trash-2" :loading="deleting === item.id" @click="deleteItem(item.id)" />
              </div>
            </td>
          </tr>
          <tr v-if="!items.length">
            <td colspan="5" class="px-5 py-12 text-center text-gray-400">Нет отзывов</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <USlideover v-model:open="slideOpen" :title="editItem ? 'Редактировать отзыв' : 'Новый отзыв'" side="right" class="w-full max-w-lg">
    <template #body>
      <form class="flex flex-col gap-5 p-6" @submit.prevent="save">

        <UFormField label="Текст отзыва" required>
          <UTextarea v-model="form.text" :rows="4" class="w-full" placeholder="«Благодаря АУГЗ мы выиграли...»" />
        </UFormField>

        <UFormField label="Автор" required>
          <UInput v-model="form.author" class="w-full" placeholder="Алишер Каримов" />
        </UFormField>

        <UFormField label="Должность / компания">
          <UInput v-model="form.role" class="w-full" placeholder="Директор, ООО «ТендерПро»" />
        </UFormField>

        <div class="grid grid-cols-2 gap-4">
          <UFormField label="Инициалы" required>
            <UInput v-model="form.initials" class="w-full" placeholder="АК" maxlength="4" />
          </UFormField>
          <UFormField label="Порядок">
            <UInput v-model.number="form.sort_order" type="number" min="0" class="w-full" />
          </UFormField>
        </div>

        <!-- Avatar color picker -->
        <UFormField label="Цвет аватара">
          <div class="flex flex-wrap gap-2">
            <button
              v-for="preset in colorPresets"
              :key="preset.value"
              type="button"
              class="w-8 h-8 rounded-full border-2 transition-all"
              :style="{ background: preset.value }"
              :class="form.avatar_color === preset.value ? 'border-gray-900 dark:border-white scale-110' : 'border-transparent'"
              :title="preset.label"
              @click="form.avatar_color = preset.value"
            />
          </div>
          <UInput v-model="form.avatar_color" class="w-full mt-2" placeholder="linear-gradient(135deg, #1e3a5f, #2d6a9f)" />
        </UFormField>

        <!-- Preview -->
        <div class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 dark:bg-gray-800">
          <div
            class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-black text-white shrink-0"
            :style="{ background: form.avatar_color || '#374151' }"
          >
            {{ form.initials || '?' }}
          </div>
          <div>
            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ form.author || 'Имя автора' }}</p>
            <p class="text-xs text-gray-400">{{ form.role || 'Должность' }}</p>
          </div>
        </div>

        <p v-if="saveError" class="text-sm text-red-500">{{ saveError }}</p>

        <div class="flex gap-3 pt-2">
          <UButton type="submit" :loading="saving" class="flex-1 justify-center">
            {{ editItem ? 'Сохранить' : 'Создать' }}
          </UButton>
          <UButton variant="outline" @click="slideOpen = false">Отмена</UButton>
        </div>
      </form>
    </template>
  </USlideover>
</template>

<script setup lang="ts">
definePageMeta({ middleware: 'auth' })

const { apiFetch } = useApi()

const slideOpen = ref(false)
const editItem = ref<any>(null)
const deleting = ref<number | null>(null)
const saving = ref(false)
const saveError = ref('')

const colorPresets = [
  { label: 'Синий',    value: 'linear-gradient(135deg, #1e3a5f, #2d6a9f)' },
  { label: 'Зелёный',  value: 'linear-gradient(135deg, #1a3a2a, #2d7a4f)' },
  { label: 'Красный',  value: 'linear-gradient(135deg, #3a1a1a, #7a2d2d)' },
  { label: 'Фиолет.',  value: 'linear-gradient(135deg, #2a1a3a, #5a2d7a)' },
  { label: 'Оранжев.', value: 'linear-gradient(135deg, #3a2a1a, #7a5a2d)' },
  { label: 'Серый',    value: 'linear-gradient(135deg, #1f2937, #374151)' },
]

interface FormState {
  text: string
  author: string
  role: string
  initials: string
  avatar_color: string
  sort_order: number
}

const emptyForm = (): FormState => ({
  text: '', author: '', role: '', initials: '', avatar_color: colorPresets[0].value, sort_order: 0,
})

const form = reactive<FormState>(emptyForm())

const { data, pending, refresh } = await useAsyncData(
  'admin-testimonials',
  () => apiFetch<{ data: any[] }>('/admin/testimonials'),
)

const items = computed(() => data.value?.data ?? [])

function openCreate() {
  editItem.value = null
  Object.assign(form, emptyForm())
  saveError.value = ''
  slideOpen.value = true
}

function openEdit(item: any) {
  editItem.value = item
  form.text         = item.text         ?? ''
  form.author       = item.author       ?? ''
  form.role         = item.role         ?? ''
  form.initials     = item.initials     ?? ''
  form.avatar_color = item.avatar_color ?? colorPresets[0].value
  form.sort_order   = item.sort_order   ?? 0
  saveError.value   = ''
  slideOpen.value   = true
}

async function save() {
  saving.value = true
  saveError.value = ''
  try {
    const body = { ...form }
    if (editItem.value) {
      await apiFetch(`/admin/testimonials/${editItem.value.id}`, { method: 'PUT', body })
    } else {
      await apiFetch('/admin/testimonials', { method: 'POST', body })
    }
    slideOpen.value = false
    await refresh()
  } catch (e: any) {
    saveError.value = e?.data?.message ?? 'Ошибка сохранения'
  } finally {
    saving.value = false
  }
}

async function deleteItem(id: number) {
  deleting.value = id
  try {
    await apiFetch(`/admin/testimonials/${id}`, { method: 'DELETE' })
    await refresh()
  } finally {
    deleting.value = null
  }
}
</script>
