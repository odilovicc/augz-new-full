<template>
  <div class="p-8">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Жалобы</h1>
        <p class="text-sm text-gray-400 mt-0.5">{{ total }} обращений</p>
      </div>
      <div class="flex gap-1 p-1 bg-gray-100 dark:bg-gray-800 rounded-xl overflow-x-auto">
        <button
          v-for="tab in tabs"
          :key="tab.value"
          class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold transition-all whitespace-nowrap"
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

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">
      <div v-if="pending" class="flex items-center justify-center py-20">
        <UIcon name="i-lucide-loader-2" class="w-6 h-6 animate-spin text-gray-300" />
      </div>

      <table v-else class="w-full text-sm">
        <thead class="border-b border-gray-100 dark:border-gray-800">
          <tr class="text-left text-gray-400 text-xs uppercase tracking-wide">
            <th class="px-5 py-3 font-medium">Трек-код</th>
            <th class="px-5 py-3 font-medium">Организация</th>
            <th class="px-5 py-3 font-medium">Заявитель</th>
            <th class="px-5 py-3 font-medium">Статус</th>
            <th class="px-5 py-3 font-medium">Дата</th>
            <th class="px-5 py-3 font-medium text-right">Действия</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
          <tr
            v-for="item in filtered"
            :key="item.id"
            class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors cursor-pointer"
            @click="openEdit(item)"
          >
            <td class="px-5 py-3">
              <span class="font-mono text-xs font-bold text-gray-700 dark:text-gray-300">{{ item.track_code }}</span>
            </td>
            <td class="px-5 py-3">
              <p class="font-medium text-gray-900 dark:text-white">{{ item.organization || '—' }}</p>
              <p v-if="item.tender_number" class="text-xs text-gray-400 mt-0.5">{{ item.tender_number }}</p>
            </td>
            <td class="px-5 py-3">
              <span v-if="item.anonymous" class="text-xs text-gray-400 italic">Анонимно</span>
              <template v-else>
                <p class="text-gray-700 dark:text-gray-300 text-sm">{{ item.name || '—' }}</p>
                <p class="text-xs text-gray-400">{{ item.phone }}</p>
              </template>
            </td>
            <td class="px-5 py-3">
              <span
                class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full"
                :class="badgeClass(item.status)"
              >
                <span class="w-1.5 h-1.5 rounded-full shrink-0" :class="dotClass(item.status)" />
                {{ statusLabel(item.status) }}
              </span>
            </td>
            <td class="px-5 py-3 text-xs text-gray-400 whitespace-nowrap">{{ formatDate(item.created_at) }}</td>
            <td class="px-5 py-3">
              <div class="flex items-center justify-end gap-1" @click.stop>
                <UButton size="xs" variant="ghost" icon="i-lucide-pencil" @click="openEdit(item)" />
                <UButton size="xs" variant="ghost" color="error" icon="i-lucide-trash-2" :loading="deleting === item.id" @click="deleteItem(item.id)" />
              </div>
            </td>
          </tr>
          <tr v-if="!filtered.length">
            <td colspan="6" class="px-5 py-12 text-center text-gray-400">Нет жалоб</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Slideover -->
  <USlideover v-model:open="slideOpen" title="Жалоба" side="right" class="w-full max-w-2xl">
    <template #body>
      <div v-if="editItem" class="flex flex-col gap-5 p-6">

        <!-- Track code + status badge -->
        <div class="flex items-center justify-between gap-3">
          <span class="font-mono text-lg font-black text-gray-900 dark:text-white tracking-wide">{{ editItem.track_code }}</span>
          <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full" :class="badgeClass(editItem.status)">
            <span class="w-1.5 h-1.5 rounded-full" :class="dotClass(editItem.status)" />
            {{ statusLabel(editItem.status) }}
          </span>
        </div>

        <!-- Violation details -->
        <div class="rounded-xl bg-gray-50 dark:bg-gray-800 p-4 space-y-3 text-sm">
          <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Детали нарушения</p>
          <div v-if="editItem.organization" class="flex gap-2">
            <span class="text-gray-400 shrink-0 w-28">Организация</span>
            <span class="font-medium text-gray-900 dark:text-white">{{ editItem.organization }}</span>
          </div>
          <div v-if="editItem.tender_number" class="flex gap-2">
            <span class="text-gray-400 shrink-0 w-28">Тендер</span>
            <span class="font-mono text-gray-900 dark:text-white">{{ editItem.tender_number }}</span>
          </div>
          <div v-if="editItem.violation_date" class="flex gap-2">
            <span class="text-gray-400 shrink-0 w-28">Дата нарушения</span>
            <span class="text-gray-700 dark:text-gray-200">{{ editItem.violation_date }}</span>
          </div>
          <div class="flex gap-2">
            <span class="text-gray-400 shrink-0 w-28">Дата подачи</span>
            <span class="text-gray-700 dark:text-gray-200">{{ formatDate(editItem.created_at) }}</span>
          </div>
        </div>

        <!-- Description -->
        <div class="rounded-xl bg-gray-50 dark:bg-gray-800 p-4 space-y-2 text-sm">
          <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Суть обращения</p>
          <p class="text-gray-800 dark:text-gray-200 leading-relaxed whitespace-pre-wrap">{{ editItem.description }}</p>
        </div>

        <!-- Attachments from applicant -->
        <div v-if="editItem.attachments?.length" class="rounded-xl bg-gray-50 dark:bg-gray-800 p-4 space-y-3 text-sm">
          <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Приложенные документы</p>
          <div class="space-y-2">
            <a
              v-for="file in editItem.attachments"
              :key="file.url"
              :href="file.url"
              target="_blank"
              class="flex items-center gap-3 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2.5 hover:border-primary-400 transition-colors group"
            >
              <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center shrink-0">
                <UIcon
                  :name="file.mime?.startsWith('image/') ? 'i-lucide-image' : 'i-lucide-file-text'"
                  class="w-4 h-4 text-gray-400 group-hover:text-primary-500"
                />
              </div>
              <span class="text-sm text-gray-700 dark:text-gray-300 truncate flex-1 group-hover:text-primary-600 dark:group-hover:text-primary-400">{{ file.name }}</span>
              <UIcon name="i-lucide-external-link" class="w-3.5 h-3.5 text-gray-300 group-hover:text-primary-400 shrink-0" />
            </a>
          </div>
        </div>

        <!-- Sender -->
        <div class="rounded-xl bg-gray-50 dark:bg-gray-800 p-4 space-y-3 text-sm">
          <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Заявитель</p>
          <div v-if="editItem.anonymous" class="flex items-center gap-2 text-gray-500 italic">
            <UIcon name="i-lucide-eye-off" class="w-4 h-4" />
            Анонимная жалоба
          </div>
          <template v-else>
            <div class="grid grid-cols-2 gap-3">
              <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-0.5">Имя</p>
                <p class="text-gray-900 dark:text-white font-medium">{{ editItem.name || '—' }}</p>
              </div>
              <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-0.5">Организация</p>
                <p class="text-gray-700 dark:text-gray-200">{{ editItem.sender_org || '—' }}</p>
              </div>
              <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-0.5">Телефон</p>
                <p class="text-gray-700 dark:text-gray-200">{{ editItem.phone || '—' }}</p>
              </div>
              <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-0.5">Email</p>
                <p class="text-gray-700 dark:text-gray-200">{{ editItem.email || '—' }}</p>
              </div>
            </div>
          </template>
        </div>

        <UDivider label="Управление" />

        <!-- Status selector — all 6 pipeline stages -->
        <UFormField label="Статус жалобы">
          <div class="grid grid-cols-2 gap-2">
            <button
              v-for="st in statuses"
              :key="st.value"
              type="button"
              class="flex items-center gap-2 px-3 py-2.5 rounded-xl border text-sm font-semibold transition-all text-left"
              :class="form.status === st.value
                ? `${st.activeBg} ${st.activeText} border-transparent`
                : 'border-gray-200 dark:border-gray-700 text-gray-500 hover:border-gray-300'"
              @click="form.status = st.value"
            >
              <span class="w-2 h-2 rounded-full shrink-0" :class="st.dot" />
              {{ st.label }}
            </button>
          </div>
        </UFormField>

        <!-- Admin note (optional for all) -->
        <UFormField label="Внутренняя заметка">
          <UTextarea v-model="form.admin_note" :rows="2" class="w-full" placeholder="Для внутреннего использования..." />
        </UFormField>

        <!-- Official response block — required when status = official_response -->
        <Transition name="slide">
          <div v-if="form.status === 'official_response'" class="rounded-xl border-2 border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-950/30 p-4 space-y-4">
            <div class="flex items-center gap-2">
              <UIcon name="i-lucide-send" class="w-4 h-4 text-blue-600" />
              <p class="text-sm font-bold text-blue-800 dark:text-blue-300">Официальный ответ заявителю</p>
            </div>

            <UFormField label="Текст ответа" required>
              <UTextarea
                v-model="form.response_message"
                :rows="5"
                class="w-full"
                placeholder="Уважаемый заявитель, по результатам рассмотрения вашего обращения..."
              />
              <p v-if="responseMessageError" class="text-xs text-red-500 mt-1">{{ responseMessageError }}</p>
            </UFormField>

            <!-- File upload for response -->
            <div>
              <p class="text-xs font-bold uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-2">Прикреплённые файлы</p>

              <!-- Existing files from saved complaint -->
              <div v-if="editItem.response_files?.length" class="mb-3 space-y-2">
                <div
                  v-for="file in editItem.response_files"
                  :key="file.url"
                  class="flex items-center justify-between rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2"
                >
                  <div class="flex items-center gap-2 min-w-0">
                    <UIcon name="i-lucide-paperclip" class="w-4 h-4 text-gray-400 shrink-0" />
                    <a :href="file.url" target="_blank" class="text-xs text-blue-600 hover:underline truncate">{{ file.name }}</a>
                  </div>
                  <button type="button" class="text-gray-300 hover:text-red-500 transition ml-2 shrink-0" @click="removeExistingFile(file.url)">
                    <UIcon name="i-lucide-x" class="w-4 h-4" />
                  </button>
                </div>
              </div>

              <!-- New file drop zone -->
              <div
                class="rounded-xl border-2 border-dashed border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800/50 py-6 px-4 flex flex-col items-center gap-2 cursor-pointer hover:border-blue-400 transition-colors"
                @click="responseFileInput?.click()"
                @dragover.prevent
                @drop.prevent="handleResponseDrop"
              >
                <UIcon name="i-lucide-upload-cloud" class="w-6 h-6 text-gray-300" />
                <p class="text-xs text-gray-400 text-center">Перетащите или <span class="text-blue-500 font-semibold">выберите файлы</span></p>
                <p class="text-[10px] text-gray-300">JPG, PNG, PDF, DOC · до 10 МБ</p>
                <input
                  ref="responseFileInput"
                  type="file"
                  class="hidden"
                  multiple
                  accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp"
                  @change="handleResponseFileChange"
                />
              </div>

              <!-- Newly selected files (not yet uploaded) -->
              <div v-if="newResponseFiles.length" class="mt-2 space-y-1.5">
                <div
                  v-for="(file, i) in newResponseFiles"
                  :key="i"
                  class="flex items-center justify-between rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2"
                >
                  <div class="flex items-center gap-2 min-w-0">
                    <UIcon name="i-lucide-file" class="w-4 h-4 text-gray-400 shrink-0" />
                    <span class="text-xs text-gray-700 dark:text-gray-300 truncate">{{ file.name }}</span>
                    <span class="text-[10px] text-gray-400 shrink-0">{{ (file.size / 1024).toFixed(0) }} KB</span>
                  </div>
                  <button type="button" class="text-gray-300 hover:text-red-500 transition ml-2 shrink-0" @click="newResponseFiles.splice(i, 1)">
                    <UIcon name="i-lucide-x" class="w-4 h-4" />
                  </button>
                </div>
              </div>
            </div>
          </div>
        </Transition>

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
const responseMessageError = ref('')
const activeStatus = ref('all')
const responseFileInput = ref<HTMLInputElement | null>(null)
const newResponseFiles = ref<File[]>([])

const statuses = [
  { value: 'new',               label: 'Жалоба принята',          dot: 'bg-blue-500',   activeBg: 'bg-blue-50 dark:bg-blue-950',    activeText: 'text-blue-700 dark:text-blue-300' },
  { value: 'analyzing',         label: 'Анализ документов',        dot: 'bg-indigo-500', activeBg: 'bg-indigo-50 dark:bg-indigo-950', activeText: 'text-indigo-700 dark:text-indigo-300' },
  { value: 'investigating',     label: 'Изучение обстоятельств',   dot: 'bg-violet-500', activeBg: 'bg-violet-50 dark:bg-violet-950', activeText: 'text-violet-700 dark:text-violet-300' },
  { value: 'forming_response',  label: 'Формирование позиции',     dot: 'bg-yellow-500', activeBg: 'bg-yellow-50 dark:bg-yellow-950', activeText: 'text-yellow-700 dark:text-yellow-300' },
  { value: 'official_response', label: 'Официальный ответ',        dot: 'bg-orange-500', activeBg: 'bg-orange-50 dark:bg-orange-950', activeText: 'text-orange-700 dark:text-orange-300' },
  { value: 'closed',            label: 'Закрыта',                  dot: 'bg-green-500',  activeBg: 'bg-green-50 dark:bg-green-950',  activeText: 'text-green-700 dark:text-green-300' },
]

const tabs = [{ value: 'all', label: 'Все' }, ...statuses]

function badgeClass(status: string): string {
  const map: Record<string, string> = {
    new:               'bg-blue-50 text-blue-700 dark:bg-blue-950 dark:text-blue-300',
    analyzing:         'bg-indigo-50 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300',
    investigating:     'bg-violet-50 text-violet-700 dark:bg-violet-950 dark:text-violet-300',
    forming_response:  'bg-yellow-50 text-yellow-700 dark:bg-yellow-950 dark:text-yellow-300',
    official_response: 'bg-orange-50 text-orange-700 dark:bg-orange-950 dark:text-orange-300',
    closed:            'bg-green-50 text-green-700 dark:bg-green-950 dark:text-green-300',
  }
  return map[status] ?? 'bg-gray-100 text-gray-600'
}

function dotClass(status: string): string {
  const map: Record<string, string> = {
    new: 'bg-blue-500', analyzing: 'bg-indigo-500', investigating: 'bg-violet-500',
    forming_response: 'bg-yellow-500', official_response: 'bg-orange-500', closed: 'bg-green-500',
  }
  return map[status] ?? 'bg-gray-400'
}

function statusLabel(status: string) {
  return statuses.find(s => s.value === status)?.label ?? status
}

function formatDate(iso: string) {
  return new Date(iso).toLocaleDateString('ru-RU', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' })
}

interface FormState { status: string; admin_note: string; response_message: string }
const form = reactive<FormState>({ status: 'new', admin_note: '', response_message: '' })

const { data, pending, refresh } = await useAsyncData(
  'admin-complaints',
  () => apiFetch<{ data: any[] }>('/admin/complaints'),
)

const items   = computed(() => data.value?.data ?? [])
const total   = computed(() => items.value.length)

const filtered = computed(() =>
  activeStatus.value === 'all'
    ? items.value
    : items.value.filter(i => i.status === activeStatus.value),
)

const counts = computed(() => {
  const c: Record<string, number> = {}
  for (const s of statuses) {
    const n = items.value.filter(i => i.status === s.value).length
    if (n) c[s.value] = n
  }
  return c
})

function openEdit(item: any) {
  editItem.value          = item
  form.status             = item.status
  form.admin_note         = item.admin_note ?? ''
  form.response_message   = item.response_message ?? ''
  saveError.value         = ''
  responseMessageError.value = ''
  newResponseFiles.value  = []
  slideOpen.value         = true
}

function removeExistingFile(url: string) {
  if (!editItem.value) return
  editItem.value.response_files = editItem.value.response_files.filter((f: any) => f.url !== url)
}

function handleResponseFileChange(e: Event) {
  const input = e.target as HTMLInputElement
  if (!input.files) return
  newResponseFiles.value.push(...Array.from(input.files))
  input.value = ''
}

function handleResponseDrop(e: DragEvent) {
  if (!e.dataTransfer?.files) return
  newResponseFiles.value.push(...Array.from(e.dataTransfer.files))
}

async function save() {
  responseMessageError.value = ''
  saveError.value = ''

  if (form.status === 'official_response' && !form.response_message.trim()) {
    responseMessageError.value = 'Для официального ответа необходимо заполнить текст'
    return
  }

  saving.value = true
  try {
    const body = new FormData()
    body.append('status', form.status)
    body.append('admin_note', form.admin_note)
    body.append('response_message', form.response_message)

    // Removed existing files (send remaining URLs so backend can diff)
    const remaining = (editItem.value.response_files ?? []).map((f: any) => f.url)
    body.append('kept_files', JSON.stringify(remaining))

    for (const file of newResponseFiles.value) {
      body.append('response_files[]', file)
    }

    const updated = await apiFetch<{ data: any }>(`/admin/complaints/${editItem.value.id}`, {
      method: 'PUT',
      body,
    })

    // Sync local item with server response
    const idx = items.value.findIndex(i => i.id === editItem.value.id)
    if (idx !== -1 && updated?.data) {
      Object.assign(items.value[idx], updated.data)
      editItem.value = items.value[idx]
    }

    newResponseFiles.value = []
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
    await apiFetch(`/admin/complaints/${id}`, { method: 'DELETE' })
    await refresh()
  } finally {
    deleting.value = null
  }
}
</script>

<style scoped>
.slide-enter-active, .slide-leave-active {
  transition: all 0.2s ease;
  overflow: hidden;
}
.slide-enter-from, .slide-leave-to {
  opacity: 0;
  max-height: 0;
}
.slide-enter-to, .slide-leave-from {
  opacity: 1;
  max-height: 600px;
}
</style>
