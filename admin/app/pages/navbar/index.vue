<template>
  <div class="p-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Навигация</h1>
        <p class="text-sm text-gray-400 mt-0.5">Ссылки в главном меню сайта</p>
      </div>
      <UButton icon="i-lucide-plus" @click="openCreateLink">Добавить ссылку</UButton>
    </div>

    <div v-if="pending" class="flex items-center justify-center py-20">
      <UIcon name="i-lucide-loader-2" class="w-6 h-6 animate-spin text-gray-300" />
    </div>

    <div v-else class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">
      <table class="w-full text-sm">
        <thead class="border-b border-gray-100 dark:border-gray-800">
          <tr class="text-left text-gray-400 text-xs uppercase tracking-wide">
            <th class="px-5 py-3 font-medium">Текст (RU)</th>
            <th class="px-5 py-3 font-medium">URL / href</th>
            <th class="px-5 py-3 font-medium w-20 text-center">Поз.</th>
            <th class="px-5 py-3 font-medium text-right">Действия</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
          <tr v-for="link in links" :key="link.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
            <td class="px-5 py-4 font-medium text-gray-900 dark:text-white">
              {{ link.label.ru }}
            </td>
            <td class="px-5 py-4 text-gray-500">
              {{ link.href }}
            </td>
            <td class="px-5 py-4 text-center text-gray-400">
              {{ link.position }}
            </td>
            <td class="px-5 py-4">
              <div class="flex items-center justify-end gap-1">
                <UButton size="xs" variant="ghost" icon="i-lucide-pencil" @click="openEditLink(link)" />
                <UButton
                  size="xs" variant="ghost" color="error" icon="i-lucide-trash-2"
                  :loading="deleting === link.id"
                  @click="deleteLink(link)"
                />
              </div>
            </td>
          </tr>
          <tr v-if="!links.length">
            <td colspan="4" class="px-5 py-12 text-center text-gray-400">
              Нет ссылок. Нажмите «Добавить ссылку».
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- ── Link Slideover ────────────────────────────────────────── -->
  <USlideover
    v-model:open="slideOpen"
    :title="editItem ? 'Редактировать ссылку' : 'Новая ссылка'"
    side="right"
    class="w-full max-w-lg"
  >
    <template #body>
      <form class="flex flex-col gap-5 p-6" @submit.prevent="save">
        <LangTabs v-model="activeLang" />

        <template v-if="activeLang === 'ru'">
          <UFormField label="Текст ссылки (RU)" required>
            <UInput v-model="form.ru" class="w-full" placeholder="Главная" />
          </UFormField>
        </template>
        <template v-else-if="activeLang === 'uz'">
          <UFormField label="Текст ссылки (UZ)">
            <UInput v-model="form.uz" class="w-full" placeholder="Bosh sahifa" />
          </UFormField>
        </template>
        <template v-else>
          <UFormField label="Текст ссылки (EN)">
            <UInput v-model="form.en" class="w-full" placeholder="Home" />
          </UFormField>
        </template>

        <UFormField label="URL / href" required>
          <UInput v-model="form.href" class="w-full" placeholder="/about или https://..." />
        </UFormField>

        <UFormField label="Позиция">
          <UInput v-model.number="form.position" type="number" min="0" class="w-full" />
        </UFormField>

        <p v-if="error" class="text-sm text-red-500">{{ error }}</p>

        <div class="flex justify-end gap-3 pt-2">
          <UButton type="button" variant="ghost" @click="slideOpen = false">Отмена</UButton>
          <UButton type="submit" :loading="saving">{{ editItem ? 'Сохранить' : 'Создать' }}</UButton>
        </div>
      </form>
    </template>
  </USlideover>
</template>

<script setup lang="ts">
definePageMeta({ middleware: 'auth' })

interface NavbarLink {
  id: number
  label: { ru: string; uz: string; en: string }
  href: string
  position: number
}

const { apiFetch } = useApi()

// ── Data ──────────────────────────────────────────────────────────────────────
const links = ref<NavbarLink[]>([])
const pending = ref(true)

async function loadLinks() {
  pending.value = true
  try {
    const res = await apiFetch<{ data: NavbarLink[] }>('/admin/navbar')
    links.value = res.data
  } finally {
    pending.value = false
  }
}

onMounted(loadLinks)

// ── Delete ────────────────────────────────────────────────────────────────────
const deleting = ref<number | null>(null)

async function deleteLink(link: NavbarLink) {
  if (!confirm(`Удалить ссылку «${link.label.ru}»?`)) return
  deleting.value = link.id
  try {
    await apiFetch(`/admin/navbar/${link.id}`, { method: 'DELETE' })
    links.value = links.value.filter(l => l.id !== link.id)
  } finally {
    deleting.value = null
  }
}

// ── Form ──────────────────────────────────────────────────────────────────────
const slideOpen = ref(false)
const editItem = ref<NavbarLink | null>(null)
const activeLang = ref<'ru' | 'uz' | 'en'>('ru')
const saving = ref(false)
const error = ref('')

const form = reactive({ ru: '', uz: '', en: '', href: '', position: 1 })

function openCreateLink() {
  editItem.value = null
  activeLang.value = 'ru'
  error.value = ''
  Object.assign(form, {
    ru: '', uz: '', en: '', href: '',
    position: (links.value.length + 1),
  })
  slideOpen.value = true
}

function openEditLink(link: NavbarLink) {
  editItem.value = link
  activeLang.value = 'ru'
  error.value = ''
  Object.assign(form, {
    ru: link.label.ru,
    uz: link.label.uz ?? '',
    en: link.label.en ?? '',
    href: link.href,
    position: link.position,
  })
  slideOpen.value = true
}

async function save() {
  if (!form.ru.trim()) { error.value = 'Текст (RU) обязателен'; return }
  if (!form.href.trim()) { error.value = 'URL обязателен'; return }
  error.value = ''
  saving.value = true
  try {
    const payload = {
      label: { ru: form.ru, uz: form.uz, en: form.en },
      href: form.href,
      position: form.position,
    }
    if (editItem.value) {
      const res = await apiFetch<{ data: NavbarLink }>(`/admin/navbar/${editItem.value.id}`, {
        method: 'PUT',
        body: payload,
      })
      const idx = links.value.findIndex(l => l.id === editItem.value!.id)
      if (idx !== -1) links.value[idx] = res.data
    } else {
      const res = await apiFetch<{ data: NavbarLink }>('/admin/navbar', {
        method: 'POST',
        body: payload,
      })
      links.value.push(res.data)
      links.value.sort((a, b) => a.position - b.position)
    }
    slideOpen.value = false
  } catch (e: any) {
    error.value = e?.data?.message ?? 'Ошибка сохранения'
  } finally {
    saving.value = false
  }
}
</script>
