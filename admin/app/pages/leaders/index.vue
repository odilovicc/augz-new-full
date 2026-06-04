<template>
  <div class="p-8">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Руководство</h1>
        <p class="text-sm text-gray-400 mt-0.5">{{ leaders.length }} участников</p>
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
            <th class="px-5 py-3 font-medium w-16">Фото</th>
            <th class="px-5 py-3 font-medium">Имя / Должность</th>
            <th class="px-5 py-3 font-medium max-w-xs">Биография</th>
            <th class="px-5 py-3 font-medium">Соцсети</th>
            <th class="px-5 py-3 font-medium w-12 text-center">№</th>
            <th class="px-5 py-3 font-medium text-right">Действия</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
          <tr v-for="item in leaders" :key="item.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors align-top">
            <td class="px-5 py-3">
              <div class="w-10 h-12 rounded-lg bg-gray-100 dark:bg-gray-800 overflow-hidden shrink-0">
                <img v-if="item.photo" :src="`${item.photo}?t=${item.updated_at}`" :alt="item.name.ru" class="w-full h-full object-cover object-top" />
              </div>
            </td>
            <td class="px-5 py-3 min-w-40">
              <p class="font-medium text-gray-900 dark:text-white whitespace-pre-line leading-snug">{{ item.name.ru }}</p>
              <p class="text-gray-400 text-xs mt-0.5">{{ item.role.ru }}</p>
            </td>
            <td class="px-5 py-3 max-w-56">
              <p v-if="item.bio?.ru" class="text-xs text-gray-500 line-clamp-3 leading-relaxed">{{ item.bio.ru }}</p>
              <span v-else class="text-xs text-gray-300">—</span>
            </td>
            <td class="px-5 py-3 min-w-36">
              <div v-if="item.social_links?.length" class="flex flex-col gap-1">
                <a
                  v-for="link in item.social_links"
                  :key="link.url"
                  :href="link.url"
                  target="_blank"
                  class="text-xs text-blue-500 hover:underline truncate max-w-36 block"
                >{{ link.label }}</a>
              </div>
              <span v-else class="text-xs text-gray-300">—</span>
            </td>
            <td class="px-5 py-3 text-center text-gray-400">{{ item.sort_order }}</td>
            <td class="px-5 py-3">
              <div class="flex items-center justify-end gap-1">
                <UButton size="xs" variant="ghost" icon="i-lucide-pencil" @click="openEdit(item)" />
                <UButton size="xs" variant="ghost" color="error" icon="i-lucide-trash-2" :loading="deleting === item.id" @click="deleteItem(item.id)" />
              </div>
            </td>
          </tr>
          <tr v-if="!leaders.length">
            <td colspan="6" class="px-5 py-12 text-center text-gray-400">Нет участников</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <USlideover v-model:open="slideOpen" :title="editItem ? 'Редактировать участника' : 'Новый участник'" side="right" class="w-full max-w-2xl">
    <template #body>
      <form class="flex flex-col gap-5 p-6" @submit.prevent="save">

        <!-- Language tabs -->
        <div class="flex gap-1 p-1 bg-gray-100 dark:bg-gray-800 rounded-xl">
          <button
            v-for="lang in langs"
            :key="lang.code"
            type="button"
            class="flex-1 flex items-center justify-center gap-2 py-2 px-3 rounded-lg text-sm font-semibold transition-all"
            :class="activeLang === lang.code
              ? 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm'
              : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-300'"
            @click="activeLang = lang.code"
          >
            <span>{{ lang.flag }}</span>
            <span>{{ lang.label }}</span>
            <span v-if="!isLangFilled(lang.code)" class="w-1.5 h-1.5 rounded-full bg-amber-400 shrink-0" />
          </button>
        </div>

        <!-- RU -->
        <template v-if="activeLang === 'ru'">
          <UFormField label="Имя (RU)" required>
            <UTextarea v-model="form.ru.name" :rows="2" class="w-full" placeholder="Фамилия&#10;Имя Отчество" />
          </UFormField>
          <UFormField label="Должность (RU)" required>
            <UInput v-model="form.ru.role" class="w-full" placeholder="Председатель АУГЗ" />
          </UFormField>
          <UFormField label="Биография (RU)">
            <UTextarea v-model="form.ru.bio" :rows="4" class="w-full" placeholder="Краткое описание руководителя..." />
          </UFormField>
        </template>

        <!-- UZ -->
        <template v-if="activeLang === 'uz'">
          <UFormField label="Ismi (UZ)" required>
            <UTextarea v-model="form.uz.name" :rows="2" class="w-full" placeholder="Familiya&#10;Ism Otasining ismi" />
          </UFormField>
          <UFormField label="Lavozimi (UZ)" required>
            <UInput v-model="form.uz.role" class="w-full" placeholder="AUGZ raisi" />
          </UFormField>
          <UFormField label="Biografiya (UZ)">
            <UTextarea v-model="form.uz.bio" :rows="4" class="w-full" placeholder="Rahbar haqida qisqacha..." />
          </UFormField>
        </template>

        <!-- EN -->
        <template v-if="activeLang === 'en'">
          <UFormField label="Name (EN)" required>
            <UTextarea v-model="form.en.name" :rows="2" class="w-full" placeholder="First Name&#10;Last Name" />
          </UFormField>
          <UFormField label="Role (EN)" required>
            <UInput v-model="form.en.role" class="w-full" placeholder="Chairman of AUGZ" />
          </UFormField>
          <UFormField label="Bio (EN)">
            <UTextarea v-model="form.en.bio" :rows="4" class="w-full" placeholder="Brief description..." />
          </UFormField>
        </template>

        <UDivider label="Социальные сети" />

        <!-- Social links -->
        <div class="flex flex-col gap-3">
          <div
            v-for="(link, idx) in form.social_links"
            :key="idx"
            class="flex gap-2 items-start"
          >
            <UInput v-model="link.label" class="w-32 shrink-0" placeholder="Telegram" />
            <UInput v-model="link.url" class="flex-1" placeholder="https://t.me/..." />
            <UButton size="sm" variant="ghost" color="error" icon="i-lucide-trash-2" @click="removeSocialLink(idx)" />
          </div>
          <UButton size="sm" variant="outline" icon="i-lucide-plus" class="self-start" @click="addSocialLink">
            Добавить соцсеть
          </UButton>
        </div>

        <UDivider />

        <UFormField label="Фото">
          <ImageUpload v-model="form.photo" />
        </UFormField>

        <UFormField label="Порядок сортировки">
          <UInput v-model.number="form.sort_order" type="number" min="0" class="w-32" />
        </UFormField>

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
const activeLang = ref<'ru' | 'uz' | 'en'>('ru')

const langs = [
  { code: 'ru' as const, label: 'Русский', flag: '🇷🇺' },
  { code: 'uz' as const, label: 'Ўзбекча', flag: '🇺🇿' },
  { code: 'en' as const, label: 'English',  flag: '🇬🇧' },
]

interface SocialLink { label: string; url: string }

interface FormState {
  ru: { name: string; role: string; bio: string }
  uz: { name: string; role: string; bio: string }
  en: { name: string; role: string; bio: string }
  photo: string
  sort_order: number
  social_links: SocialLink[]
}

const emptyForm = (): FormState => ({
  ru: { name: '', role: '', bio: '' },
  uz: { name: '', role: '', bio: '' },
  en: { name: '', role: '', bio: '' },
  photo: '',
  sort_order: 0,
  social_links: [],
})
const form = reactive<FormState>(emptyForm())

function isLangFilled(code: 'ru' | 'uz' | 'en') {
  if (code === 'ru') return !!form.ru.name && !!form.ru.role
  if (code === 'uz') return !!form.uz.name && !!form.uz.role
  return !!form.en.name && !!form.en.role
}

function addSocialLink() {
  form.social_links.push({ label: '', url: '' })
}

function removeSocialLink(idx: number) {
  form.social_links.splice(idx, 1)
}

const { data, pending, refresh } = await useAsyncData(
  'admin-leaders',
  () => apiFetch<{ data: any[] }>('/admin/leaders'),
)

const leaders = computed(() => data.value?.data ?? [])

function openCreate() {
  editItem.value = null
  Object.assign(form, emptyForm())
  saveError.value = ''
  activeLang.value = 'ru'
  slideOpen.value = true
}

function openEdit(item: any) {
  editItem.value = item
  form.ru.name      = item.name?.ru ?? ''
  form.ru.role      = item.role?.ru ?? ''
  form.ru.bio       = item.bio?.ru ?? ''
  form.uz.name      = item.name?.uz ?? ''
  form.uz.role      = item.role?.uz ?? ''
  form.uz.bio       = item.bio?.uz ?? ''
  form.en.name      = item.name?.en ?? ''
  form.en.role      = item.role?.en ?? ''
  form.en.bio       = item.bio?.en ?? ''
  form.photo        = item.photo ?? ''
  form.sort_order   = item.sort_order ?? 0
  form.social_links = item.social_links ? JSON.parse(JSON.stringify(item.social_links)) : []
  saveError.value   = ''
  activeLang.value  = 'ru'
  slideOpen.value   = true
}

async function save() {
  saving.value = true
  saveError.value = ''
  try {
    const body = {
      name:       form.ru.name,
      role:       form.ru.role,
      photo:      form.photo,
      sort_order: form.sort_order,
      bio: {
        ru: form.ru.bio,
        uz: form.uz.bio,
        en: form.en.bio,
      },
      social_links: form.social_links.filter(l => l.label && l.url),
      translations: {
        uz: { role: form.uz.role, name: form.uz.name },
        en: { role: form.en.role, name: form.en.name },
      },
    }
    if (editItem.value) {
      await apiFetch(`/admin/leaders/${editItem.value.id}`, { method: 'PUT', body })
    } else {
      await apiFetch('/admin/leaders', { method: 'POST', body })
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
    await apiFetch(`/admin/leaders/${id}`, { method: 'DELETE' })
    await refresh()
  } finally {
    deleting.value = null
  }
}
</script>
