<template>
  <div class="p-8">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Лиды</h1>
        <p class="text-sm text-gray-400 mt-0.5">{{ total }} заявок</p>
      </div>
      <div class="flex gap-2">
        <!-- Source filter -->
        <select
          v-model="activeSource"
          class="text-sm border border-gray-200 dark:border-gray-700 rounded-lg px-3 py-1.5 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200"
        >
          <option value="">Все источники</option>
          <option value="tenderzone">TenderZone</option>
          <option value="membership">Членство</option>
          <option value="services-page">Страница услуг</option>
          <option value="unknown">Прочие</option>
        </select>
        <!-- Status tabs -->
        <div class="flex gap-1 p-1 bg-gray-100 dark:bg-gray-800 rounded-xl">
          <button
            v-for="tab in tabs"
            :key="tab.value"
            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold transition-all"
            :class="activeStatus === tab.value
              ? 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm'
              : 'text-gray-400 hover:text-gray-700 dark:hover:text-gray-200'"
            @click="activeStatus = tab.value"
          >
            {{ tab.label }}
            <span
              v-if="counts[tab.value]"
              class="text-[10px] font-bold px-1.5 py-0.5 rounded-full"
              :class="tab.value === 'new' ? 'bg-red-100 text-red-600 dark:bg-red-950 dark:text-red-400' : 'bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-300'"
            >{{ counts[tab.value] }}</span>
          </button>
        </div>
      </div>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">
      <div v-if="pending" class="flex items-center justify-center py-20">
        <UIcon name="i-lucide-loader-2" class="w-6 h-6 animate-spin text-gray-300" />
      </div>

      <table v-else class="w-full text-sm">
        <thead class="border-b border-gray-100 dark:border-gray-800">
          <tr class="text-left text-gray-400 text-xs uppercase tracking-wide">
            <th class="px-5 py-3 font-medium">Контакт</th>
            <th class="px-5 py-3 font-medium">Источник</th>
            <th class="px-5 py-3 font-medium">Тип</th>
            <th class="px-5 py-3 font-medium">Статус</th>
            <th class="px-5 py-3 font-medium">Дата</th>
            <th class="px-5 py-3 font-medium text-right">Действия</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
          <tr v-for="item in filtered" :key="item.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
            <td class="px-5 py-3">
              <p class="font-medium text-gray-900 dark:text-white">{{ item.name }}</p>
              <p class="text-xs text-gray-400 mt-0.5">{{ item.phone }}</p>
              <p v-if="item.email" class="text-xs text-gray-400">{{ item.email }}</p>
            </td>
            <td class="px-5 py-3">
              <UBadge variant="soft" color="neutral" size="xs">{{ sourceLabel(item.source) }}</UBadge>
            </td>
            <td class="px-5 py-3">
              <span
                class="inline-flex items-center text-xs font-semibold px-2.5 py-1 rounded-full"
                :class="item.type === 'demo' ? 'bg-purple-50 text-purple-700 dark:bg-purple-950 dark:text-purple-300' : 'bg-green-50 text-green-700 dark:bg-green-950 dark:text-green-300'"
              >
                {{ item.type === 'demo' ? 'Демо' : 'Бесплатно' }}
              </span>
            </td>
            <td class="px-5 py-3">
              <span
                class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full"
                :class="badgeMap[item.status] ?? 'bg-gray-100 text-gray-600'"
              >
                <span class="w-1.5 h-1.5 rounded-full shrink-0" :class="statuses.find(s => s.value === item.status)?.dot ?? 'bg-gray-400'" />
                {{ statuses.find(s => s.value === item.status)?.label ?? item.status }}
              </span>
            </td>
            <td class="px-5 py-3 text-xs text-gray-400">{{ formatDate(item.created_at) }}</td>
            <td class="px-5 py-3">
              <div class="flex items-center justify-end gap-1">
                <UButton size="xs" variant="ghost" icon="i-lucide-pencil" @click="openEdit(item)" />
                <UButton size="xs" variant="ghost" color="error" icon="i-lucide-trash-2" :loading="deleting === item.id" @click="deleteItem(item.id)" />
              </div>
            </td>
          </tr>
          <tr v-if="!filtered.length">
            <td colspan="6" class="px-5 py-12 text-center text-gray-400">Нет лидов</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <USlideover v-model:open="slideOpen" title="Лид" side="right" class="w-full max-w-sm">
    <template #body>
      <div v-if="editItem" class="flex flex-col gap-5 p-6">
        <div class="flex flex-col gap-3 p-4 rounded-xl bg-gray-50 dark:bg-gray-800 text-sm">
          <div><p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-0.5">Имя</p><p class="font-medium text-gray-900 dark:text-white">{{ editItem.name }}</p></div>
          <div><p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-0.5">Телефон</p><p class="text-gray-700 dark:text-gray-200">{{ editItem.phone }}</p></div>
          <div><p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-0.5">Email</p><p class="text-gray-700 dark:text-gray-200">{{ editItem.email || '—' }}</p></div>
          <div><p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-0.5">Источник</p><p class="text-gray-700 dark:text-gray-200">{{ sourceLabel(editItem.source) }}</p></div>
          <div v-if="editItem.service"><p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-0.5">Услуга</p><p class="text-gray-700 dark:text-gray-200">{{ editItem.service }}</p></div>
          <div><p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-0.5">Тип</p><p class="text-gray-700 dark:text-gray-200">{{ editItem.type === 'demo' ? 'Демо' : 'Бесплатно' }}</p></div>
          <div><p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-0.5">Дата</p><p class="text-sm text-gray-500">{{ formatDate(editItem.created_at) }}</p></div>
        </div>

        <UDivider label="Статус" />

        <div class="grid grid-cols-3 gap-2">
          <button
            v-for="s in statuses"
            :key="s.value"
            type="button"
            class="flex items-center gap-2 px-3 py-2.5 rounded-xl border text-sm font-semibold transition-all"
            :class="form.status === s.value
              ? `${s.activeBg} ${s.activeText} border-transparent`
              : 'border-gray-200 dark:border-gray-700 text-gray-500 hover:border-gray-300'"
            @click="form.status = s.value"
          >
            <span class="w-2 h-2 rounded-full shrink-0" :class="s.dot" />
            {{ s.label }}
          </button>
        </div>

        <p v-if="saveError" class="text-sm text-red-500">{{ saveError }}</p>
        <div class="flex gap-3 pt-2">
          <UButton :loading="saving" class="flex-1 justify-center" @click="save">Сохранить</UButton>
          <UButton variant="outline" @click="slideOpen = false">Закрыть</UButton>
        </div>
      </div>
    </template>
  </USlideover>
</template>

<script setup lang="ts">
definePageMeta({ middleware: 'auth' })

const { apiFetch } = useApi()

const slideOpen   = ref(false)
const editItem    = ref<any>(null)
const deleting    = ref<number | null>(null)
const saving      = ref(false)
const saveError   = ref('')
const activeStatus = ref('all')
const activeSource = ref('')

const statuses = [
  { value: 'new',       label: 'Новый',     dot: 'bg-blue-500',   activeBg: 'bg-blue-50 dark:bg-blue-950',   activeText: 'text-blue-700 dark:text-blue-300' },
  { value: 'contacted', label: 'Связались', dot: 'bg-amber-500',  activeBg: 'bg-amber-50 dark:bg-amber-950', activeText: 'text-amber-700 dark:text-amber-300' },
  { value: 'converted', label: 'Клиент',    dot: 'bg-green-500',  activeBg: 'bg-green-50 dark:bg-green-950', activeText: 'text-green-700 dark:text-green-300' },
]

const tabs = [{ value: 'all', label: 'Все' }, ...statuses]

const badgeMap: Record<string, string> = {
  new:       'bg-blue-50 text-blue-700 dark:bg-blue-950 dark:text-blue-300',
  contacted: 'bg-amber-50 text-amber-700 dark:bg-amber-950 dark:text-amber-300',
  converted: 'bg-green-50 text-green-700 dark:bg-green-950 dark:text-green-300',
}

const sourceLabels: Record<string, string> = {
  tenderzone:    'TenderZone',
  membership:    'Членство',
  'services-page': 'Страница услуг',
  unknown:       'Прочие',
}
function sourceLabel(s: string) { return sourceLabels[s] ?? s }

function formatDate(iso: string) {
  return new Date(iso).toLocaleDateString('ru-RU', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' })
}

const form = reactive({ status: 'new' })

const { data, pending, refresh } = await useAsyncData(
  'admin-leads',
  () => apiFetch<{ data: any[] }>('/admin/leads'),
)

const items   = computed(() => data.value?.data ?? [])
const total   = computed(() => items.value.length)

const filtered = computed(() => {
  let list = items.value
  if (activeStatus.value !== 'all') list = list.filter(i => i.status === activeStatus.value)
  if (activeSource.value)           list = list.filter(i => i.source === activeSource.value)
  return list
})

const counts = computed(() => {
  const c: Record<string, number> = {}
  for (const s of statuses) {
    const n = items.value.filter(i => i.status === s.value).length
    if (n) c[s.value] = n
  }
  return c
})

function openEdit(item: any) {
  editItem.value = item
  form.status    = item.status
  saveError.value = ''
  slideOpen.value = true
}

async function save() {
  saving.value = true
  saveError.value = ''
  try {
    await apiFetch(`/admin/leads/${editItem.value.id}`, { method: 'PUT', body: { status: form.status } })
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
    await apiFetch(`/admin/leads/${id}`, { method: 'DELETE' })
    await refresh()
  } finally {
    deleting.value = null
  }
}
</script>
