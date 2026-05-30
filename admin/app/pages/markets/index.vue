<template>
  <div class="p-8">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Торговые площадки</h1>
        <p class="text-sm text-gray-400 mt-0.5">{{ platforms.length }} площадок</p>
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
            <th class="px-5 py-3 font-medium">URL</th>
            <th class="px-5 py-3 font-medium">Категория</th>
            <th class="px-5 py-3 font-medium">Официальная</th>
            <th class="px-5 py-3 font-medium w-16 text-center">№</th>
            <th class="px-5 py-3 font-medium text-right">Действия</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
          <tr v-for="item in platforms" :key="item.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
            <td class="px-5 py-3 max-w-xs">
              <div class="flex items-center gap-3">
                <div
                  class="w-8 h-8 rounded-lg shrink-0 flex items-center justify-center text-white text-xs font-black"
                  :style="item.logo_color ? `background:${item.logo_color}` : 'background:#e5e7eb'"
                >
                  <span v-if="!item.logo" class="text-gray-400">{{ item.name.slice(0, 2).toUpperCase() }}</span>
                  <img v-else :src="item.logo" :alt="item.name" class="w-full h-full object-contain rounded-lg" />
                </div>
                <div>
                  <p class="font-medium text-gray-900 dark:text-white line-clamp-1">{{ item.name }}</p>
                  <p class="text-gray-400 text-xs line-clamp-1 mt-0.5">{{ item.subtitle }}</p>
                </div>
              </div>
            </td>
            <td class="px-5 py-3">
              <a :href="item.url" target="_blank" class="text-xs text-blue-500 hover:underline">{{ item.url.replace(/^https?:\/\//, '') }}</a>
            </td>
            <td class="px-5 py-3">
              <UBadge variant="soft" color="neutral" size="xs">{{ categoryLabel(item.category) }}</UBadge>
            </td>
            <td class="px-5 py-3 text-center">
              <UIcon v-if="item.is_official" name="i-lucide-check-circle" class="w-4 h-4 text-green-500" />
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
          <tr v-if="!platforms.length">
            <td colspan="6" class="px-5 py-12 text-center text-gray-400">Нет торговых площадок</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <USlideover v-model:open="slideOpen" :title="editItem ? 'Редактировать площадку' : 'Новая площадка'" side="right" class="w-full max-w-2xl">
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
            <UInput v-model="form.ru.name" class="w-full" placeholder="e-xarid.uz" />
          </UFormField>
          <UFormField label="Подзаголовок (RU)">
            <UInput v-model="form.ru.subtitle" class="w-full" placeholder="Единая электронная торговая площадка" />
          </UFormField>
          <UFormField label="Описание (RU)">
            <UTextarea v-model="form.ru.desc" :rows="3" class="w-full" />
          </UFormField>
        </template>

        <!-- UZ -->
        <template v-if="activeLang === 'uz'">
          <UFormField label="Nomi (UZ)">
            <UInput v-model="form.uz.name" class="w-full" />
          </UFormField>
          <UFormField label="Sarlavha (UZ)">
            <UInput v-model="form.uz.subtitle" class="w-full" />
          </UFormField>
          <UFormField label="Tavsif (UZ)">
            <UTextarea v-model="form.uz.desc" :rows="3" class="w-full" />
          </UFormField>
        </template>

        <!-- EN -->
        <template v-if="activeLang === 'en'">
          <UFormField label="Name (EN)">
            <UInput v-model="form.en.name" class="w-full" />
          </UFormField>
          <UFormField label="Subtitle (EN)">
            <UInput v-model="form.en.subtitle" class="w-full" />
          </UFormField>
          <UFormField label="Description (EN)">
            <UTextarea v-model="form.en.desc" :rows="3" class="w-full" />
          </UFormField>
        </template>

        <UDivider />

        <UFormField label="URL сайта" required>
          <UInput v-model="form.url" class="w-full" placeholder="https://e-xarid.uz" />
        </UFormField>

        <div class="grid grid-cols-2 gap-4">
          <UFormField label="Цвет логотипа">
            <div class="flex items-center gap-2">
              <input v-model="form.logo_color" type="color" class="w-10 h-9 rounded border border-gray-200 cursor-pointer p-0.5" />
              <UInput v-model="form.logo_color" class="w-full" placeholder="#1a56db" />
            </div>
          </UFormField>
          <UFormField label="Категория" required>
            <USelect v-model="form.category" :items="categoryOptions" class="w-full" />
          </UFormField>
        </div>

        <div class="flex items-center gap-3">
          <UCheckbox v-model="form.is_official" label="Официальная площадка" />
        </div>

        <UFormField label="Теги (через запятую)">
          <UInput v-model="tagsInput" class="w-full" placeholder="Госзакупки, ЭЦП, Тендеры" />
        </UFormField>

        <UFormField label="Логотип (URL)">
          <ImageUpload v-model="form.logo" />
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

const slideOpen  = ref(false)
const editItem   = ref<any>(null)
const deleting   = ref<number | null>(null)
const saving     = ref(false)
const saveError  = ref('')
const activeLang = ref<'ru' | 'uz' | 'en'>('ru')
const tagsInput  = ref('')

const langs = [
  { code: 'ru' as const, label: 'Русский', flag: '🇷🇺' },
  { code: 'uz' as const, label: 'Ўзбекча', flag: '🇺🇿' },
  { code: 'en' as const, label: 'English',  flag: '🇬🇧' },
]

const categoryOptions = [
  { label: 'Государственные',  value: 'government' },
  { label: 'Корпоративные',    value: 'corporate' },
  { label: 'Агрегаторы',       value: 'aggregator' },
  { label: 'Международные',    value: 'international' },
]

const categoryLabels: Record<string, string> = {
  government:    'Государственные',
  corporate:     'Корпоративные',
  aggregator:    'Агрегаторы',
  international: 'Международные',
}
function categoryLabel(cat: string) { return categoryLabels[cat] ?? cat }

interface LangFields { name: string; subtitle: string; desc: string }
interface FormState {
  ru: LangFields; uz: LangFields; en: LangFields
  url: string; logo: string; logo_color: string
  category: string; is_official: boolean; sort_order: number
}

const emptyLang = (): LangFields => ({ name: '', subtitle: '', desc: '' })
const emptyForm = (): FormState => ({
  ru: emptyLang(), uz: emptyLang(), en: emptyLang(),
  url: '', logo: '', logo_color: '#1a56db',
  category: 'government', is_official: false, sort_order: 0,
})
const form = reactive<FormState>(emptyForm())

function isLangFilled(code: 'ru' | 'uz' | 'en') { return !!form[code].name }

const { data, pending, refresh } = await useAsyncData(
  'admin-markets',
  () => apiFetch<{ data: any[] }>('/admin/trading-platforms'),
)

const platforms = computed(() => data.value?.data ?? [])

function openCreate() {
  editItem.value = null
  Object.assign(form, emptyForm())
  tagsInput.value = ''
  saveError.value = ''
  activeLang.value = 'ru'
  slideOpen.value = true
}

function openEdit(item: any) {
  editItem.value = item
  form.ru.name     = item.name     ?? ''
  form.ru.subtitle = item.subtitle ?? ''
  form.ru.desc     = item.desc     ?? ''
  form.uz.name     = item.translations?.uz?.name     ?? ''
  form.uz.subtitle = item.translations?.uz?.subtitle ?? ''
  form.uz.desc     = item.translations?.uz?.desc     ?? ''
  form.en.name     = item.translations?.en?.name     ?? ''
  form.en.subtitle = item.translations?.en?.subtitle ?? ''
  form.en.desc     = item.translations?.en?.desc     ?? ''
  form.url         = item.url        ?? ''
  form.logo        = item.logo       ?? ''
  form.logo_color  = item.logo_color ?? '#1a56db'
  form.category    = item.category   ?? 'government'
  form.is_official = item.is_official ?? false
  form.sort_order  = item.sort_order  ?? 0
  tagsInput.value  = (item.tags ?? []).join(', ')
  saveError.value  = ''
  activeLang.value = 'ru'
  slideOpen.value  = true
}

async function save() {
  saving.value = true
  saveError.value = ''
  try {
    const tags = tagsInput.value.split(',').map(t => t.trim()).filter(Boolean)
    const body = {
      name:        form.ru.name,
      subtitle:    form.ru.subtitle,
      desc:        form.ru.desc,
      url:         form.url,
      logo:        form.logo,
      logo_color:  form.logo_color,
      category:    form.category,
      is_official: form.is_official,
      tags,
      sort_order:  form.sort_order,
      translations: {
        uz: { name: form.uz.name, subtitle: form.uz.subtitle, desc: form.uz.desc },
        en: { name: form.en.name, subtitle: form.en.subtitle, desc: form.en.desc },
      },
    }
    if (editItem.value) {
      await apiFetch(`/admin/trading-platforms/${editItem.value.id}`, { method: 'PUT', body })
    } else {
      await apiFetch('/admin/trading-platforms', { method: 'POST', body })
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
    await apiFetch(`/admin/trading-platforms/${id}`, { method: 'DELETE' })
    await refresh()
  } finally {
    deleting.value = null
  }
}
</script>
