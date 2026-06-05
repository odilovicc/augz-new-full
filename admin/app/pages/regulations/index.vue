<template>
  <div class="p-8">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Нормативные документы</h1>
        <p class="text-sm text-gray-400 mt-0.5">{{ documents.length }} документов</p>
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
            <th class="px-5 py-3 font-medium">Название</th>
            <th class="px-5 py-3 font-medium w-48">Номер и дата</th>
            <th class="px-5 py-3 font-medium w-40">Тип</th>
            <th class="px-5 py-3 font-medium w-24 text-center">Активен</th>
            <th class="px-5 py-3 font-medium w-16 text-center">№</th>
            <th class="px-5 py-3 font-medium text-right">Действия</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
          <tr v-for="item in documents" :key="item.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
            <td class="px-5 py-3 max-w-sm">
              <a :href="item.url" target="_blank" class="font-medium text-gray-900 dark:text-white hover:text-primary-600 transition-colors line-clamp-2">
                {{ item.title }}
              </a>
            </td>
            <td class="px-5 py-3 text-gray-500 text-xs">{{ item.number || '—' }}</td>
            <td class="px-5 py-3">
              <UBadge variant="soft" color="neutral" size="xs">{{ typeLabel(item.type) }}</UBadge>
            </td>
            <td class="px-5 py-3 text-center">
              <UIcon v-if="item.is_active" name="i-lucide-check-circle" class="w-4 h-4 text-green-500" />
              <UIcon v-else name="i-lucide-minus" class="w-4 h-4 text-gray-300" />
            </td>
            <td class="px-5 py-3 text-center text-gray-400">{{ item.sort_order }}</td>
            <td class="px-5 py-3">
              <div class="flex items-center justify-end gap-1">
                <UButton size="xs" variant="ghost" icon="i-lucide-pencil" @click="openEdit(item)" />
                <UButton size="xs" variant="ghost" color="error" icon="i-lucide-trash-2" :loading="deleting === item.id" @click="deleteItem(item.id)" />
              </div>
            </td>
          </tr>
          <tr v-if="!documents.length">
            <td colspan="6" class="px-5 py-12 text-center text-gray-400">Нет документов</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <USlideover v-model:open="slideOpen" :title="editItem ? 'Редактировать документ' : 'Новый документ'" side="right" class="w-full max-w-xl">
    <template #body>
      <form class="flex flex-col gap-5 p-6" @submit.prevent="save">

        <UFormField label="Название (RU)" required>
          <UInput v-model="form.title" class="w-full" placeholder="Закон РУз «О государственных закупках»" />
        </UFormField>

        <UFormField label="Тип документа" required>
          <USelect v-model="form.type" :items="typeOptions" class="w-full" />
        </UFormField>

        <UFormField label="Номер и дата">
          <UInput v-model="form.number" class="w-full" placeholder="№ЗРУ-684, 22.04.2021" />
        </UFormField>

        <UFormField label="Ссылка (URL)" required>
          <UInput v-model="form.url" class="w-full" placeholder="https://lex.uz/docs/..." />
        </UFormField>

        <UFormField label="Порядок сортировки">
          <UInput v-model.number="form.sort_order" type="number" min="0" class="w-32" />
        </UFormField>

        <UCheckbox v-model="form.is_active" label="Активен (показывать на сайте)" />

        <p v-if="saveError" class="text-sm text-red-500">{{ saveError }}</p>
      </form>
    </template>

    <template #footer>
      <div class="flex gap-3 p-4 border-t border-gray-100 dark:border-gray-800">
        <UButton type="button" :loading="saving" class="flex-1 justify-center" @click="save">
          {{ editItem ? 'Сохранить' : 'Создать' }}
        </UButton>
        <UButton variant="outline" @click="slideOpen = false">Отмена</UButton>
      </div>
    </template>
  </USlideover>
</template>

<script setup lang="ts">
definePageMeta({ middleware: 'auth' })

const { apiFetch } = useApi()

const slideOpen = ref(false)
const editItem  = ref<any>(null)
const deleting  = ref<number | null>(null)
const saving    = ref(false)
const saveError = ref('')

const typeOptions = [
  { label: 'Закон',               value: 'law' },
  { label: 'Указ Президента',     value: 'decree' },
  { label: 'Постановление КМ',    value: 'resolution' },
  { label: 'Приказ',              value: 'order' },
]

const typeLabels: Record<string, string> = {
  law:        'Закон',
  decree:     'Указ',
  resolution: 'Пост. КМ',
  order:      'Приказ',
}

function typeLabel(type: string): string {
  return typeLabels[type] ?? type
}

const defaultForm = () => ({
  title:      '',
  type:       'law',
  number:     '',
  url:        '',
  is_active:  true,
  sort_order: 0,
})

const form = reactive(defaultForm())

const { data: rawDocs, pending, refresh } = await useAsyncData(
  'admin-regulatory-documents',
  () => apiFetch<{ data: any[] }>('/admin/regulatory-documents'),
)

const documents = computed(() => rawDocs.value?.data ?? [])

function openCreate() {
  editItem.value = null
  Object.assign(form, defaultForm())
  saveError.value = ''
  slideOpen.value = true
}

function openEdit(item: any) {
  editItem.value = item
  Object.assign(form, {
    title:      item.title,
    type:       item.type,
    number:     item.number ?? '',
    url:        item.url,
    is_active:  item.is_active,
    sort_order: item.sort_order,
  })
  saveError.value = ''
  slideOpen.value = true
}

async function save() {
  saveError.value = ''
  saving.value    = true
  try {
    const body = {
      title:      form.title,
      type:       form.type,
      number:     form.number || null,
      url:        form.url,
      is_active:  form.is_active,
      sort_order: form.sort_order,
    }

    if (editItem.value) {
      await apiFetch(`/admin/regulatory-documents/${editItem.value.id}`, { method: 'PUT', body })
    } else {
      await apiFetch('/admin/regulatory-documents', { method: 'POST', body })
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
  if (!confirm('Удалить документ?')) return
  deleting.value = id
  try {
    await apiFetch(`/admin/regulatory-documents/${id}`, { method: 'DELETE' })
    await refresh()
  } finally {
    deleting.value = null
  }
}
</script>
