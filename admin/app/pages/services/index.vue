<template>
  <div class="p-8">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Услуги</h1>
        <p class="text-sm text-gray-400 mt-0.5">{{ services.length }} услуг</p>
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
            <th class="px-5 py-3 font-medium">Название</th>
            <th class="px-5 py-3 font-medium">Тег</th>
            <th class="px-5 py-3 font-medium w-16 text-center">№</th>
            <th class="px-5 py-3 font-medium text-right">Действия</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
          <tr v-for="item in services" :key="item.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
            <td class="px-5 py-3">
              <div class="w-12 h-9 rounded-lg bg-gray-100 dark:bg-gray-800 overflow-hidden shrink-0">
                <img v-if="item.image" :src="item.image" :alt="item.title.ru" class="w-full h-full object-cover" />
              </div>
            </td>
            <td class="px-5 py-3 max-w-xs">
              <p class="font-medium text-gray-900 dark:text-white line-clamp-1">{{ item.title.ru }}</p>
              <p class="text-gray-400 text-xs line-clamp-1 mt-0.5">{{ item.desc.ru }}</p>
            </td>
            <td class="px-5 py-3">
              <UBadge v-if="item.tag.ru" variant="soft" color="neutral" size="xs">{{ item.tag.ru }}</UBadge>
            </td>
            <td class="px-5 py-3 text-center text-gray-400">{{ item.sort_order }}</td>
            <td class="px-5 py-3">
              <div class="flex items-center justify-end gap-1">
                <UButton size="xs" variant="ghost" icon="i-lucide-pencil" @click="openEdit(item)" />
                <UButton size="xs" variant="ghost" color="error" icon="i-lucide-trash-2" :loading="deleting === item.id" @click="deleteItem(item.id)" />
              </div>
            </td>
          </tr>
          <tr v-if="!services.length">
            <td colspan="5" class="px-5 py-12 text-center text-gray-400">Нет услуг</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <USlideover v-model:open="slideOpen" :title="editItem ? 'Редактировать услугу' : 'Новая услуга'" side="right" class="w-full max-w-2xl">
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
          <UFormField label="Название (RU)" required>
            <UInput v-model="form.ru.title" class="w-full" placeholder="Консультационные услуги" />
          </UFormField>
          <UFormField label="Тег (RU)">
            <UInput v-model="form.ru.tag" class="w-full" placeholder="Консультации" />
          </UFormField>
          <UFormField label="Описание (RU)">
            <UTextarea v-model="form.ru.desc" :rows="3" class="w-full" placeholder="Краткое описание услуги" />
          </UFormField>
        </template>

        <!-- UZ -->
        <template v-if="activeLang === 'uz'">
          <UFormField label="Nomi (UZ)" required>
            <UInput v-model="form.uz.title" class="w-full" placeholder="Maslahat xizmatlari" />
          </UFormField>
          <UFormField label="Teg (UZ)">
            <UInput v-model="form.uz.tag" class="w-full" placeholder="Maslahat" />
          </UFormField>
          <UFormField label="Tavsif (UZ)">
            <UTextarea v-model="form.uz.desc" :rows="3" class="w-full" placeholder="Xizmatning qisqacha tavsifi" />
          </UFormField>
        </template>

        <!-- EN -->
        <template v-if="activeLang === 'en'">
          <UFormField label="Title (EN)" required>
            <UInput v-model="form.en.title" class="w-full" placeholder="Consulting services" />
          </UFormField>
          <UFormField label="Tag (EN)">
            <UInput v-model="form.en.tag" class="w-full" placeholder="Consulting" />
          </UFormField>
          <UFormField label="Description (EN)">
            <UTextarea v-model="form.en.desc" :rows="3" class="w-full" placeholder="Short service description" />
          </UFormField>
        </template>

        <UDivider />

        <UFormField label="Изображение">
          <ImageUpload v-model="form.image" />
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
  { code: 'ru' as const, label: 'Русский',  flag: '🇷🇺' },
  { code: 'uz' as const, label: 'Ўзбекча', flag: '🇺🇿' },
  { code: 'en' as const, label: 'English',  flag: '🇬🇧' },
]

interface LangFields { title: string; tag: string; desc: string }
interface FormState {
  ru: LangFields; uz: LangFields; en: LangFields
  image: string
  sort_order: number
}

const emptyLang = (): LangFields => ({ title: '', tag: '', desc: '' })
const emptyForm = (): FormState => ({ ru: emptyLang(), uz: emptyLang(), en: emptyLang(), image: '', sort_order: 0 })
const form = reactive<FormState>(emptyForm())

function isLangFilled(code: 'ru' | 'uz' | 'en') {
  return !!form[code].title
}

const { data, pending, refresh } = await useAsyncData(
  'admin-services',
  () => apiFetch<{ data: any[] }>('/admin/services'),
)

const services = computed(() => data.value?.data ?? [])

function openCreate() {
  editItem.value = null
  Object.assign(form, emptyForm())
  saveError.value = ''
  activeLang.value = 'ru'
  slideOpen.value = true
}

function openEdit(item: any) {
  editItem.value = item
  form.ru.title = item.title?.ru ?? ''
  form.ru.tag   = item.tag?.ru   ?? ''
  form.ru.desc  = item.desc?.ru  ?? ''
  form.uz.title = item.translations?.uz?.title ?? ''
  form.uz.tag   = item.translations?.uz?.tag   ?? ''
  form.uz.desc  = item.translations?.uz?.desc  ?? ''
  form.en.title = item.translations?.en?.title ?? ''
  form.en.tag   = item.translations?.en?.tag   ?? ''
  form.en.desc  = item.translations?.en?.desc  ?? ''
  form.image      = item.image      ?? ''
  form.sort_order = item.sort_order ?? 0
  saveError.value = ''
  activeLang.value = 'ru'
  slideOpen.value = true
}

async function save() {
  saving.value = true
  saveError.value = ''
  try {
    const body = {
      title: form.ru.title,
      tag:   form.ru.tag,
      desc:  form.ru.desc,
      image: form.image,
      sort_order: form.sort_order,
      translations: {
        uz: { title: form.uz.title, tag: form.uz.tag, desc: form.uz.desc },
        en: { title: form.en.title, tag: form.en.tag, desc: form.en.desc },
      },
    }
    if (editItem.value) {
      await apiFetch(`/admin/services/${editItem.value.id}`, { method: 'PUT', body })
    } else {
      await apiFetch('/admin/services', { method: 'POST', body })
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
    await apiFetch(`/admin/services/${id}`, { method: 'DELETE' })
    await refresh()
  } finally {
    deleting.value = null
  }
}
</script>
