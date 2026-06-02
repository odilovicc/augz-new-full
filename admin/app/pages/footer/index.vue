<template>
  <div class="p-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Футер</h1>
        <p class="text-sm text-gray-400 mt-0.5">Колонки и ссылки в подвале сайта</p>
      </div>
      <UButton icon="i-lucide-plus" @click="openCreateColumn">Добавить колонку</UButton>
    </div>

    <div v-if="pending" class="flex items-center justify-center py-20">
      <UIcon name="i-lucide-loader-2" class="w-6 h-6 animate-spin text-gray-300" />
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
      <div
        v-for="col in columns"
        :key="col.id"
        class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 flex flex-col"
      >
        <!-- Column header -->
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-800">
          <div>
            <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ col.title.ru }}</p>
            <p class="text-xs text-gray-400 mt-0.5">{{ col.links.length }} ссылок · поз. {{ col.position }}</p>
          </div>
          <div class="flex items-center gap-1">
            <UButton size="xs" variant="ghost" icon="i-lucide-pencil" @click="openEditColumn(col)" />
            <UButton
              size="xs" variant="ghost" color="error" icon="i-lucide-trash-2"
              :loading="deletingColumn === col.id"
              @click="deleteColumn(col)"
            />
          </div>
        </div>

        <!-- Links list -->
        <ul class="flex flex-col divide-y divide-gray-50 dark:divide-gray-800 flex-1">
          <li
            v-for="link in col.links"
            :key="link.id"
            class="flex items-center gap-3 px-5 py-3 group"
          >
            <div class="flex-1 min-w-0">
              <p class="text-sm text-gray-800 dark:text-gray-200 truncate">{{ link.label.ru }}</p>
              <p class="text-xs text-gray-400 truncate">{{ link.href }}</p>
            </div>
            <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
              <UButton size="xs" variant="ghost" icon="i-lucide-pencil" @click="openEditLink(col, link)" />
              <UButton
                size="xs" variant="ghost" color="error" icon="i-lucide-trash-2"
                :loading="deletingLink === link.id"
                @click="deleteLink(col, link)"
              />
            </div>
          </li>
          <li v-if="!col.links.length" class="px-5 py-4 text-xs text-gray-400 italic">Нет ссылок</li>
        </ul>

        <!-- Add link -->
        <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-800">
          <UButton size="xs" variant="ghost" icon="i-lucide-plus" class="w-full justify-center" @click="openCreateLink(col)">
            Добавить ссылку
          </UButton>
        </div>
      </div>

      <div v-if="!columns.length" class="col-span-full text-center py-16 text-gray-400">
        Нет колонок. Нажмите «Добавить колонку».
      </div>
    </div>
  </div>

  <!-- ── Column Slideover ───────────────────────────────────────── -->
  <USlideover
    v-model:open="columnSlideOpen"
    :title="editColumn ? 'Редактировать колонку' : 'Новая колонка'"
    side="right"
    class="w-full max-w-lg"
  >
    <template #body>
      <form class="flex flex-col gap-5 p-6" @submit.prevent="saveColumn">
        <!-- Lang tabs -->
        <LangTabs v-model="activeLangCol" />

        <template v-if="activeLangCol === 'ru'">
          <UFormField label="Заголовок (RU)" required>
            <UInput v-model="colForm.ru" class="w-full" placeholder="О нас" />
          </UFormField>
        </template>
        <template v-else-if="activeLangCol === 'uz'">
          <UFormField label="Заголовок (UZ)">
            <UInput v-model="colForm.uz" class="w-full" placeholder="Biz haqimizda" />
          </UFormField>
        </template>
        <template v-else>
          <UFormField label="Заголовок (EN)">
            <UInput v-model="colForm.en" class="w-full" placeholder="About us" />
          </UFormField>
        </template>

        <UFormField label="Позиция">
          <UInput v-model.number="colForm.position" type="number" min="0" class="w-full" />
        </UFormField>

        <p v-if="colError" class="text-sm text-red-500">{{ colError }}</p>

        <div class="flex justify-end gap-3 pt-2">
          <UButton type="button" variant="ghost" @click="columnSlideOpen = false">Отмена</UButton>
          <UButton type="submit" :loading="colSaving">{{ editColumn ? 'Сохранить' : 'Создать' }}</UButton>
        </div>
      </form>
    </template>
  </USlideover>

  <!-- ── Link Slideover ────────────────────────────────────────── -->
  <USlideover
    v-model:open="linkSlideOpen"
    :title="editLink ? 'Редактировать ссылку' : 'Новая ссылка'"
    side="right"
    class="w-full max-w-lg"
  >
    <template #body>
      <form class="flex flex-col gap-5 p-6" @submit.prevent="saveLink">
        <LangTabs v-model="activeLangLink" />

        <template v-if="activeLangLink === 'ru'">
          <UFormField label="Текст ссылки (RU)" required>
            <UInput v-model="linkForm.ru" class="w-full" placeholder="Об ассоциации" />
          </UFormField>
        </template>
        <template v-else-if="activeLangLink === 'uz'">
          <UFormField label="Текст ссылки (UZ)">
            <UInput v-model="linkForm.uz" class="w-full" placeholder="Assotsiatsiya haqida" />
          </UFormField>
        </template>
        <template v-else>
          <UFormField label="Текст ссылки (EN)">
            <UInput v-model="linkForm.en" class="w-full" placeholder="About the association" />
          </UFormField>
        </template>

        <UFormField label="URL / href" required>
          <UInput v-model="linkForm.href" class="w-full" placeholder="/about или https://..." />
        </UFormField>

        <UFormField label="Позиция">
          <UInput v-model.number="linkForm.position" type="number" min="0" class="w-full" />
        </UFormField>

        <p v-if="linkError" class="text-sm text-red-500">{{ linkError }}</p>

        <div class="flex justify-end gap-3 pt-2">
          <UButton type="button" variant="ghost" @click="linkSlideOpen = false">Отмена</UButton>
          <UButton type="submit" :loading="linkSaving">{{ editLink ? 'Сохранить' : 'Создать' }}</UButton>
        </div>
      </form>
    </template>
  </USlideover>
</template>

<script setup lang="ts">
interface FooterLink {
  id: number
  footer_column_id: number
  label: { ru: string; uz: string; en: string }
  href: string
  position: number
}

interface FooterColumn {
  id: number
  title: { ru: string; uz: string; en: string }
  position: number
  links: FooterLink[]
}

const { apiFetch } = useApi()

// ── Data ──────────────────────────────────────────────────────────────────────
const columns = ref<FooterColumn[]>([])
const pending = ref(true)

async function loadColumns() {
  pending.value = true
  try {
    const res = await apiFetch<{ data: FooterColumn[] }>('/admin/footer/columns')
    columns.value = res.data
  } finally {
    pending.value = false
  }
}

onMounted(loadColumns)

// ── Delete column ──────────────────────────────────────────────────────────────
const deletingColumn = ref<number | null>(null)

async function deleteColumn(col: FooterColumn) {
  if (!confirm(`Удалить колонку «${col.title.ru}» со всеми ссылками?`)) return
  deletingColumn.value = col.id
  try {
    await apiFetch(`/admin/footer/columns/${col.id}`, { method: 'DELETE' })
    columns.value = columns.value.filter(c => c.id !== col.id)
  } finally {
    deletingColumn.value = null
  }
}

// ── Delete link ────────────────────────────────────────────────────────────────
const deletingLink = ref<number | null>(null)

async function deleteLink(col: FooterColumn, link: FooterLink) {
  if (!confirm(`Удалить ссылку «${link.label.ru}»?`)) return
  deletingLink.value = link.id
  try {
    await apiFetch(`/admin/footer/columns/${col.id}/links/${link.id}`, { method: 'DELETE' })
    col.links = col.links.filter(l => l.id !== link.id)
  } finally {
    deletingLink.value = null
  }
}

// ── Column form ────────────────────────────────────────────────────────────────
const columnSlideOpen = ref(false)
const editColumn = ref<FooterColumn | null>(null)
const activeLangCol = ref<'ru' | 'uz' | 'en'>('ru')
const colSaving = ref(false)
const colError = ref('')

const colForm = reactive({ ru: '', uz: '', en: '', position: 1 })

function openCreateColumn() {
  editColumn.value = null
  activeLangCol.value = 'ru'
  colError.value = ''
  Object.assign(colForm, { ru: '', uz: '', en: '', position: (columns.value.length + 1) })
  columnSlideOpen.value = true
}

function openEditColumn(col: FooterColumn) {
  editColumn.value = col
  activeLangCol.value = 'ru'
  colError.value = ''
  Object.assign(colForm, {
    ru: col.title.ru,
    uz: col.title.uz ?? '',
    en: col.title.en ?? '',
    position: col.position,
  })
  columnSlideOpen.value = true
}

async function saveColumn() {
  if (!colForm.ru.trim()) { colError.value = 'Заголовок (RU) обязателен'; return }
  colError.value = ''
  colSaving.value = true
  try {
    const payload = {
      title: { ru: colForm.ru, uz: colForm.uz, en: colForm.en },
      position: colForm.position,
    }
    if (editColumn.value) {
      const res = await apiFetch<{ data: FooterColumn }>(`/admin/footer/columns/${editColumn.value.id}`, {
        method: 'PUT',
        body: payload,
      })
      const idx = columns.value.findIndex(c => c.id === editColumn.value!.id)
      if (idx !== -1) columns.value[idx] = res.data
    } else {
      const res = await apiFetch<{ data: FooterColumn }>('/admin/footer/columns', {
        method: 'POST',
        body: payload,
      })
      columns.value.push(res.data)
    }
    columnSlideOpen.value = false
  } catch (e: any) {
    colError.value = e?.data?.message ?? 'Ошибка сохранения'
  } finally {
    colSaving.value = false
  }
}

// ── Link form ──────────────────────────────────────────────────────────────────
const linkSlideOpen = ref(false)
const editLink = ref<FooterLink | null>(null)
const activeColumn = ref<FooterColumn | null>(null)
const activeLangLink = ref<'ru' | 'uz' | 'en'>('ru')
const linkSaving = ref(false)
const linkError = ref('')

const linkForm = reactive({ ru: '', uz: '', en: '', href: '', position: 1 })

function openCreateLink(col: FooterColumn) {
  activeColumn.value = col
  editLink.value = null
  activeLangLink.value = 'ru'
  linkError.value = ''
  Object.assign(linkForm, {
    ru: '', uz: '', en: '', href: '',
    position: (col.links.length + 1),
  })
  linkSlideOpen.value = true
}

function openEditLink(col: FooterColumn, link: FooterLink) {
  activeColumn.value = col
  editLink.value = link
  activeLangLink.value = 'ru'
  linkError.value = ''
  Object.assign(linkForm, {
    ru: link.label.ru,
    uz: link.label.uz ?? '',
    en: link.label.en ?? '',
    href: link.href,
    position: link.position,
  })
  linkSlideOpen.value = true
}

async function saveLink() {
  if (!linkForm.ru.trim()) { linkError.value = 'Текст (RU) обязателен'; return }
  if (!linkForm.href.trim()) { linkError.value = 'URL обязателен'; return }
  linkError.value = ''
  linkSaving.value = true
  const col = activeColumn.value!
  try {
    const payload = {
      label: { ru: linkForm.ru, uz: linkForm.uz, en: linkForm.en },
      href: linkForm.href,
      position: linkForm.position,
    }
    if (editLink.value) {
      const res = await apiFetch<{ data: FooterLink }>(
        `/admin/footer/columns/${col.id}/links/${editLink.value.id}`,
        { method: 'PUT', body: payload }
      )
      const idx = col.links.findIndex(l => l.id === editLink.value!.id)
      if (idx !== -1) col.links[idx] = res.data
    } else {
      const res = await apiFetch<{ data: FooterLink }>(
        `/admin/footer/columns/${col.id}/links`,
        { method: 'POST', body: payload }
      )
      col.links.push(res.data)
    }
    linkSlideOpen.value = false
  } catch (e: any) {
    linkError.value = e?.data?.message ?? 'Ошибка сохранения'
  } finally {
    linkSaving.value = false
  }
}
</script>
