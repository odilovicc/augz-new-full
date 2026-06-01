<template>
  <div class="p-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Новости и аналитика</h1>
        <p class="text-sm text-gray-400 mt-0.5">{{ total }} материалов</p>
      </div>
      <UButton icon="i-lucide-plus" @click="openCreate">Добавить</UButton>
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap items-center gap-2 mb-5">
      <div class="flex items-center gap-1 p-1 bg-gray-100 dark:bg-gray-800 rounded-xl">
        <button
          v-for="cat in categoryOptions"
          :key="cat.value"
          class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all cursor-pointer"
          :class="filterCategory === cat.value
            ? 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm'
            : 'text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
          @click="filterCategory = cat.value; page = 1"
        >
          <span v-if="cat.color" class="w-2 h-2 rounded-full shrink-0" :style="{ background: cat.color }" />
          {{ cat.label }}
        </button>
      </div>

      <div class="ml-auto flex items-center gap-2">
        <USelect
          v-model="filterSort"
          :items="sortOptions"
          size="sm"
          class="w-44"
          @change="page = 1"
        />
      </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">
      <div v-if="pending" class="flex items-center justify-center py-20">
        <UIcon name="i-lucide-loader-2" class="w-6 h-6 animate-spin text-gray-300" />
      </div>

      <table v-else class="w-full text-sm">
        <thead class="border-b border-gray-100 dark:border-gray-800">
          <tr class="text-left text-gray-400 text-xs uppercase tracking-wide">
            <th class="px-5 py-3 font-medium w-16">Фото</th>
            <th class="px-5 py-3 font-medium">Заголовок / краткое</th>
            <th class="px-5 py-3 font-medium">Категория</th>
            <th class="px-5 py-3 font-medium">Теги</th>
            <th class="px-5 py-3 font-medium">Просм.</th>
            <th class="px-5 py-3 font-medium">Дата</th>
            <th class="px-5 py-3 font-medium text-center">Featured</th>
            <th class="px-5 py-3 font-medium text-right">Действия</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
          <tr v-for="item in articles" :key="item.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
            <td class="px-5 py-3">
              <div class="w-12 h-9 rounded-lg bg-gray-100 dark:bg-gray-800 overflow-hidden shrink-0">
                <img v-if="item.image" :src="item.image" :alt="item.title" class="w-full h-full object-cover" />
              </div>
            </td>
            <td class="px-5 py-3 max-w-xs">
              <p class="font-medium text-gray-900 dark:text-white line-clamp-1">{{ item.title }}</p>
              <p class="text-gray-400 text-xs line-clamp-1 mt-0.5">{{ item.excerpt }}</p>
            </td>
            <td class="px-5 py-3">
              <span
                class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full"
                :style="categoryStyle(item.category)"
              >
                <span class="w-1.5 h-1.5 rounded-full shrink-0" :style="{ background: categoryColor(item.category) }" />
                {{ categoryLabel(item.category) }}
              </span>
            </td>
            <td class="px-5 py-3">
              <div class="flex flex-wrap gap-1 max-w-[140px]">
                <span
                  v-for="tag in (item.tags ?? []).slice(0, 2)"
                  :key="tag"
                  class="text-[10px] bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 px-1.5 py-0.5 rounded"
                >{{ tag }}</span>
                <span v-if="(item.tags ?? []).length > 2" class="text-[10px] text-gray-400">+{{ item.tags.length - 2 }}</span>
              </div>
            </td>
            <td class="px-5 py-3 text-gray-500 text-xs">{{ item.views ?? 0 }}</td>
            <td class="px-5 py-3 text-gray-500 whitespace-nowrap text-xs">
              {{ item.published_at ? formatDate(item.published_at) : '—' }}
            </td>
            <td class="px-5 py-3 text-center">
              <UBadge v-if="item.is_featured" color="primary" variant="soft" size="xs">Да</UBadge>
              <span v-else class="text-gray-300">—</span>
            </td>
            <td class="px-5 py-3">
              <div class="flex items-center justify-end gap-1">
                <UButton size="xs" variant="ghost" icon="i-lucide-pencil" @click="openEdit(item)" />
                <UButton size="xs" variant="ghost" color="error" icon="i-lucide-trash-2" :loading="deleting === item.id" @click="deleteItem(item.id)" />
              </div>
            </td>
          </tr>
          <tr v-if="!articles?.length">
            <td colspan="8" class="px-5 py-12 text-center text-gray-400">Нет материалов</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="(data?.meta?.last_page ?? 1) > 1" class="flex justify-center mt-6">
      <UPagination v-model:page="page" :total="total" :items-per-page="20" />
    </div>
  </div>

  <!-- Slideover -->
  <USlideover v-model:open="slideOpen" :title="editItem ? 'Редактировать материал' : 'Новый материал'" side="right" class="w-full max-w-2xl">
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

        <!-- RU fields -->
        <template v-if="activeLang === 'ru'">
          <UFormField label="Заголовок (RU)" required>
            <UInput v-model="form.ru.title" class="w-full" placeholder="Введите заголовок" />
          </UFormField>
          <UFormField label="Краткий анонс (RU)" required>
            <UTextarea v-model="form.ru.excerpt" :rows="3" class="w-full" placeholder="1–3 предложения для превью" />
          </UFormField>
          <UFormField label="Полный текст (RU)" required>
            <ClientOnly>
              <RichEditor v-model="form.ru.content" placeholder="Полный текст статьи..." />
              <template #fallback>
                <UTextarea v-model="form.ru.content" :rows="8" class="w-full" />
              </template>
            </ClientOnly>
          </UFormField>
        </template>

        <!-- UZ fields -->
        <template v-if="activeLang === 'uz'">
          <UFormField label="Sarlavha (UZ)" required>
            <UInput v-model="form.uz.title" class="w-full" placeholder="Sarlavhani kiriting" />
          </UFormField>
          <UFormField label="Qisqacha tavsif (UZ)" required>
            <UTextarea v-model="form.uz.excerpt" :rows="3" class="w-full" placeholder="1–3 ta jumla" />
          </UFormField>
          <UFormField label="To'liq matn (UZ)" required>
            <ClientOnly>
              <RichEditor v-model="form.uz.content" placeholder="Maqolaning to'liq matni..." />
              <template #fallback>
                <UTextarea v-model="form.uz.content" :rows="8" class="w-full" />
              </template>
            </ClientOnly>
          </UFormField>
        </template>

        <!-- EN fields -->
        <template v-if="activeLang === 'en'">
          <UFormField label="Title (EN)" required>
            <UInput v-model="form.en.title" class="w-full" placeholder="Enter title" />
          </UFormField>
          <UFormField label="Excerpt (EN)" required>
            <UTextarea v-model="form.en.excerpt" :rows="3" class="w-full" placeholder="1–3 sentences for preview" />
          </UFormField>
          <UFormField label="Full text (EN)" required>
            <ClientOnly>
              <RichEditor v-model="form.en.content" placeholder="Full article text..." />
              <template #fallback>
                <UTextarea v-model="form.en.content" :rows="8" class="w-full" />
              </template>
            </ClientOnly>
          </UFormField>
        </template>

        <UDivider />

        <!-- Category + Source -->
        <div class="grid grid-cols-2 gap-4">
          <UFormField label="Категория" required>
            <USelect
              v-model="form.category"
              :items="categoryOptions.filter(c => c.value !== '')"
              class="w-full"
            />
          </UFormField>
          <UFormField label="Источник">
            <UInput v-model="form.source" class="w-full" placeholder="mypc.uz" />
          </UFormField>
        </div>

        <UFormField label="Ссылка на источник">
          <UInput v-model="form.source_url" class="w-full" placeholder="https://gazeta.uz/ru/2026/..." />
        </UFormField>

        <!-- Tags -->
        <UFormField label="Теги">
          <div class="flex flex-col gap-2">
            <div class="flex flex-wrap gap-2 min-h-[32px]">
              <span
                v-for="tag in form.tags"
                :key="tag"
                class="flex items-center gap-1 text-xs bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 px-2 py-1 rounded-full"
              >
                {{ tag }}
                <button type="button" class="hover:text-red-500 transition-colors cursor-pointer" @click="removeTag(tag)">
                  <UIcon name="i-lucide-x" class="w-3 h-3" />
                </button>
              </span>
              <span v-if="form.tags.length === 0" class="text-xs text-gray-400 py-1">Нет тегов</span>
            </div>
            <div class="flex gap-2">
              <UInput
                v-model="tagInput"
                class="flex-1"
                placeholder="Новый тег..."
                @keydown.enter.prevent="addTag"
                @keydown.comma.prevent="addTag"
                @paste.prevent="addTagsFromPaste"
              />
              <UButton type="button" variant="outline" size="sm" icon="i-lucide-plus" @click="addTag" />
            </div>
            <p class="text-xs text-gray-400">Enter или запятая для добавления. Вставка через запятую — добавит сразу все теги</p>
          </div>
        </UFormField>

        <UDivider />

        <!-- Image upload -->
        <UFormField label="Изображение">
          <div class="flex flex-col gap-3">
            <div v-if="imagePreview || form.image" class="relative w-full h-40 rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800 group">
              <img :src="imagePreview || form.image" alt="preview" class="w-full h-full object-cover" />
              <button
                type="button"
                class="absolute top-2 right-2 w-7 h-7 rounded-full bg-black/50 hover:bg-black/70 flex items-center justify-center text-white transition-colors opacity-0 group-hover:opacity-100"
                @click="clearImage"
              >
                <UIcon name="i-lucide-x" class="w-3.5 h-3.5" />
              </button>
            </div>
            <label
              class="flex flex-col items-center justify-center gap-2 w-full h-28 border-2 border-dashed rounded-xl cursor-pointer transition-colors"
              :class="dragOver
                ? 'border-primary-400 bg-primary-50 dark:bg-primary-950'
                : 'border-gray-200 dark:border-gray-700 hover:border-primary-300 hover:bg-gray-50 dark:hover:bg-gray-800'"
              @dragover.prevent="dragOver = true"
              @dragleave="dragOver = false"
              @drop.prevent="onDrop"
            >
              <UIcon
                name="i-lucide-upload-cloud"
                class="w-6 h-6 transition-colors"
                :class="dragOver ? 'text-primary-500' : 'text-gray-300'"
              />
              <span class="text-xs text-gray-400">
                <span v-if="uploading">Загрузка...</span>
                <span v-else>Перетащите или <span class="text-primary-500 font-medium">выберите файл</span></span>
              </span>
              <span class="text-xs text-gray-300">PNG, JPG, WEBP до 5 МБ</span>
              <input ref="fileInput" type="file" accept="image/*" class="hidden" :disabled="uploading" @change="onFileChange" />
            </label>
          </div>
        </UFormField>

        <!-- Date + Featured -->
        <div class="grid grid-cols-2 gap-4 items-end">
          <UFormField label="Дата публикации">
            <UInput v-model="form.published_at" type="date" class="w-full" />
          </UFormField>
          <UCheckbox v-model="form.is_featured" label="Featured (слайдер)" class="pb-1" />
        </div>

        <p v-if="saveError" class="text-sm text-red-500">{{ saveError }}</p>

        <div class="flex gap-3 pt-2">
          <UButton type="submit" :loading="saving" :disabled="uploading" class="flex-1 justify-center">
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
const config = useRuntimeConfig()
const token = useCookie('admin_token')

// ── Constants ─────────────────────────────────────────────────────────────

const CATEGORIES = [
  { value: '',             label: 'Все',              color: '' },
  { value: 'news',         label: 'Новости',          color: '#6366f1' },
  { value: 'analytics',    label: 'Аналитика',        color: '#D1832C' },
  { value: 'event',        label: 'События',           color: '#10b981' },
  { value: 'legislation',  label: 'Законодательство', color: '#3b82f6' },
  { value: 'investigation',label: 'Расследования',    color: '#ef4444' },
]

const categoryOptions = CATEGORIES

const sortOptions = [
  { value: 'newest',  label: 'Сначала новые' },
  { value: 'oldest',  label: 'Сначала старые' },
  { value: 'popular', label: 'По просмотрам' },
]

const langs = [
  { code: 'ru' as const, label: 'Русский', flag: '🇷🇺' },
  { code: 'uz' as const, label: 'Ўзбекча', flag: '🇺🇿' },
  { code: 'en' as const, label: 'English',  flag: '🇬🇧' },
]

// ── Filters / pagination ──────────────────────────────────────────────────

const page = ref(1)
const filterCategory = ref('')
const filterSort = ref('newest')

// ── Data fetching ─────────────────────────────────────────────────────────

const { data, pending, refresh } = await useAsyncData(
  'admin-news',
  () => apiFetch<any>(
    `/admin/news?page=${page.value}&sort=${filterSort.value}` +
    (filterCategory.value ? `&category=${filterCategory.value}` : ''),
  ),
  { watch: [page, filterCategory, filterSort], server: false },
)

const articles = computed(() => data.value?.data ?? [])
const total    = computed(() => data.value?.meta?.total ?? 0)

// ── Helpers ───────────────────────────────────────────────────────────────

function categoryColor(cat: string): string {
  return CATEGORIES.find(c => c.value === cat)?.color ?? '#9ca3af'
}

function categoryLabel(cat: string): string {
  return CATEGORIES.find(c => c.value === cat)?.label ?? cat
}

function categoryStyle(cat: string): Record<string, string> {
  const color = categoryColor(cat)
  return {
    color,
    background: `${color}18`,
  }
}

function formatDate(d: string) {
  return new Date(d).toLocaleDateString('ru-RU', { day: '2-digit', month: '2-digit', year: 'numeric' })
}

// ── Form state ────────────────────────────────────────────────────────────

const slideOpen  = ref(false)
const editItem   = ref<any>(null)
const deleting   = ref<number | null>(null)
const saving     = ref(false)
const uploading  = ref(false)
const saveError  = ref('')
const dragOver   = ref(false)
const fileInput  = ref<HTMLInputElement | null>(null)
const imagePreview = ref<string | null>(null)
const activeLang = ref<'ru' | 'uz' | 'en'>('ru')
const tagInput   = ref('')

interface LangFields { title: string; excerpt: string; content: string }
interface FormState {
  ru: LangFields; uz: LangFields; en: LangFields
  image: string; published_at: string; is_featured: boolean
  category: string; source: string; source_url: string; tags: string[]
}

const emptyLang  = (): LangFields => ({ title: '', excerpt: '', content: '' })
const emptyForm  = (): FormState => ({
  ru: emptyLang(), uz: emptyLang(), en: emptyLang(),
  image: '', published_at: '', is_featured: false,
  category: 'news', source: '', source_url: '', tags: [],
})

const form = reactive<FormState>(emptyForm())

function isLangFilled(code: 'ru' | 'uz' | 'en'): boolean {
  const f = form[code]
  return !!(f.title && f.excerpt && f.content)
}

// ── Tags ──────────────────────────────────────────────────────────────────

function addTag() {
  const tag = tagInput.value.trim().replace(/,$/, '')
  if (tag && !form.tags.includes(tag)) form.tags.push(tag)
  tagInput.value = ''
}

function addTagsFromPaste(e: ClipboardEvent) {
  const text = e.clipboardData?.getData('text') ?? ''
  const parts = text.split(/[,;\n]+/).map(s => s.trim()).filter(Boolean)
  if (parts.length <= 1) {
    // single word — just let it land in the input normally
    tagInput.value += parts[0] ?? ''
    return
  }
  for (const part of parts) {
    if (!form.tags.includes(part)) form.tags.push(part)
  }
  tagInput.value = ''
}

function removeTag(tag: string) {
  form.tags = form.tags.filter(t => t !== tag)
}

// ── Slideover open/close ──────────────────────────────────────────────────

function openCreate() {
  editItem.value = null
  Object.assign(form, emptyForm())
  imagePreview.value = null
  saveError.value = ''
  activeLang.value = 'ru'
  slideOpen.value = true
}

function openEdit(item: any) {
  editItem.value = item
  const tr = item.translations ?? {}
  form.ru.title   = item.title   ?? ''
  form.ru.excerpt = item.excerpt ?? ''
  form.ru.content = item.content ?? ''
  form.uz.title   = tr.uz?.title   ?? ''
  form.uz.excerpt = tr.uz?.excerpt ?? ''
  form.uz.content = tr.uz?.content ?? ''
  form.en.title   = tr.en?.title   ?? ''
  form.en.excerpt = tr.en?.excerpt ?? ''
  form.en.content = tr.en?.content ?? ''
  form.image        = item.image ?? ''
  form.published_at = item.published_at ? item.published_at.slice(0, 10) : ''
  form.is_featured  = item.is_featured ?? false
  form.category     = item.category ?? 'news'
  form.source       = item.source ?? ''
  form.source_url   = item.source_url ?? ''
  form.tags         = item.tags ?? []
  imagePreview.value = null
  saveError.value = ''
  activeLang.value = 'ru'
  slideOpen.value = true
}

// ── Image upload ──────────────────────────────────────────────────────────

function clearImage() {
  form.image = ''
  imagePreview.value = null
  if (fileInput.value) fileInput.value.value = ''
}

async function uploadFile(file: File) {
  if (!file.type.startsWith('image/')) return
  uploading.value = true
  saveError.value = ''

  const reader = new FileReader()
  reader.onload = e => { imagePreview.value = e.target?.result as string }
  reader.readAsDataURL(file)

  try {
    const fd = new FormData()
    fd.append('image', file)
    const res = await $fetch<{ url: string }>(`${config.public.apiBase}/admin/upload/image`, {
      method: 'POST',
      body: fd,
      headers: { Authorization: `Bearer ${token.value}`, Accept: 'application/json' },
    })
    form.image = res.url
  }
  catch (e: any) {
    saveError.value = e?.data?.message ?? 'Ошибка загрузки изображения'
    imagePreview.value = null
  }
  finally {
    uploading.value = false
  }
}

function onFileChange(e: Event) {
  const file = (e.target as HTMLInputElement).files?.[0]
  if (file) uploadFile(file)
}

function onDrop(e: DragEvent) {
  dragOver.value = false
  const file = e.dataTransfer?.files?.[0]
  if (file) uploadFile(file)
}

// ── Save / delete ─────────────────────────────────────────────────────────

async function save() {
  saving.value = true
  saveError.value = ''
  try {
    const body: Record<string, any> = {
      title:        form.ru.title,
      excerpt:      form.ru.excerpt,
      content:      form.ru.content,
      image:        form.image || null,
      is_featured:  form.is_featured,
      category:     form.category,
      source:       form.source || null,
      source_url:   form.source_url || null,
      tags:         form.tags,
      translations: {
        uz: { title: form.uz.title, excerpt: form.uz.excerpt, content: form.uz.content },
        en: { title: form.en.title, excerpt: form.en.excerpt, content: form.en.content },
      },
    }
    if (form.published_at) body.published_at = form.published_at

    if (editItem.value) {
      await apiFetch(`/admin/news/${editItem.value.id}`, { method: 'PUT', body })
    }
    else {
      await apiFetch('/admin/news', { method: 'POST', body })
    }
    slideOpen.value = false
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
    await apiFetch(`/admin/news/${id}`, { method: 'DELETE' })
    await refresh()
  }
  finally {
    deleting.value = null
  }
}
</script>
