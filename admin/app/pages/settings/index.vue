<template>
  <div class="p-8 max-w-4xl">
    <div class="flex items-center justify-between mb-8">
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Настройки</h1>
        <p class="text-sm text-gray-400 mt-0.5">Глобальные контакты, адрес, часы работы, соцсети и отделы</p>
      </div>
      <UButton :loading="saving" @click="save">Сохранить</UButton>
    </div>

    <p v-if="saveError" class="mb-4 text-sm text-red-500 bg-red-50 rounded-xl px-4 py-2">{{ saveError }}</p>
    <p v-if="saved" class="mb-4 text-sm text-green-600 bg-green-50 rounded-xl px-4 py-2">Сохранено успешно</p>

    <div v-if="pending" class="flex items-center justify-center py-20">
      <UIcon name="i-lucide-loader-2" class="w-6 h-6 animate-spin text-gray-300" />
    </div>

    <template v-else>

      <!-- ── CONTACTS ── -->
      <section class="mb-8">
        <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4 flex items-center gap-2">
          <UIcon name="i-lucide-phone" class="w-3.5 h-3.5" /> Основные контакты
        </h2>
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
          <UFormField label="Телефон (горячая линия)">
            <UInput v-model="form.contacts.phone" class="w-full" placeholder="+998 55 503 12 21" />
          </UFormField>
          <UFormField label="Email">
            <UInput v-model="form.contacts.email" class="w-full" placeholder="info@augz.uz" />
          </UFormField>
          <UFormField label="Telegram (handle)">
            <UInput v-model="form.contacts.telegram" class="w-full" placeholder="@augz_uz" />
          </UFormField>
          <UFormField label="Telegram URL">
            <UInput v-model="form.contacts.telegram_url" class="w-full" placeholder="https://t.me/augz_uz" />
          </UFormField>
        </div>
      </section>

      <!-- ── ADDRESS ── -->
      <section class="mb-8">
        <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4 flex items-center gap-2">
          <UIcon name="i-lucide-map-pin" class="w-3.5 h-3.5" /> Адрес офиса
        </h2>
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
          <UFormField label="Полный адрес" class="sm:col-span-2">
            <UInput v-model="form.address.text" class="w-full" placeholder="г. Ташкент, Мирабадский район, ул. Нукуса, 89" />
          </UFormField>
          <UFormField label="Почтовый индекс">
            <UInput v-model="form.address.zip" class="w-full" placeholder="100000" />
          </UFormField>
          <UFormField label="Ссылка на Яндекс карты">
            <UInput v-model="form.address.maps_url" class="w-full" placeholder="https://yandex.uz/maps/..." />
          </UFormField>
          <UFormField label="Координаты офиса" class="sm:col-span-2">
            <UInput
              v-model="coordsInput"
              class="w-full"
              placeholder="41.298600, 69.275700  —  вставьте из Google / Яндекс карт"
              @blur="parseCoords"
            />
            <template #hint>
              <span v-if="coordsError" class="text-red-500 text-xs">{{ coordsError }}</span>
              <span v-else-if="form.address.lat" class="text-gray-400 text-xs">
                lat {{ form.address.lat }}, lng {{ form.address.lng }}
              </span>
              <span v-else class="text-gray-400 text-xs">Скопируйте координаты из Google Maps («Копировать координаты») или Яндекс Карт</span>
            </template>
          </UFormField>
        </div>
      </section>

      <!-- ── HOURS ── -->
      <section class="mb-8">
        <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4 flex items-center gap-2">
          <UIcon name="i-lucide-clock" class="w-3.5 h-3.5" /> Часы работы
        </h2>
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 grid grid-cols-1 sm:grid-cols-3 gap-5">
          <UFormField label="Рабочие дни">
            <UInput v-model="form.hours.days" class="w-full" placeholder="Пн–Пт" />
          </UFormField>
          <UFormField label="Начало">
            <UInput v-model="form.hours.from" class="w-full" placeholder="09:00" />
          </UFormField>
          <UFormField label="Конец">
            <UInput v-model="form.hours.to" class="w-full" placeholder="18:00" />
          </UFormField>
        </div>
      </section>

      <!-- ── SOCIALS ── -->
      <section class="mb-8">
        <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4 flex items-center gap-2">
          <UIcon name="i-lucide-share-2" class="w-3.5 h-3.5" /> Социальные сети
        </h2>
        <div class="flex flex-col gap-3">
          <div
            v-for="(social, i) in form.socials"
            :key="social.id"
            class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-5 grid grid-cols-1 sm:grid-cols-[1fr_1fr_1fr_auto] gap-4 items-end"
          >
            <UFormField :label="`${social.name} — Название`">
              <UInput v-model="form.socials[i].name" class="w-full" />
            </UFormField>
            <UFormField label="Handle / подпись">
              <UInput v-model="form.socials[i].handle" class="w-full" placeholder="@augz_uz" />
            </UFormField>
            <UFormField label="URL">
              <UInput v-model="form.socials[i].url" class="w-full" placeholder="https://..." />
            </UFormField>
            <UButton
              color="error"
              variant="ghost"
              icon="i-lucide-trash-2"
              size="sm"
              @click="removeSocial(i)"
            />
          </div>

          <button
            type="button"
            class="flex items-center gap-2 text-sm font-semibold text-gray-400 hover:text-gray-700 dark:hover:text-white transition-colors px-1 py-2"
            @click="addSocial"
          >
            <UIcon name="i-lucide-plus-circle" class="w-4 h-4" />
            Добавить соцсеть
          </button>
        </div>
      </section>

      <!-- ── DEPARTMENTS ── -->
      <section class="mb-8">
        <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4 flex items-center gap-2">
          <UIcon name="i-lucide-building-2" class="w-3.5 h-3.5" /> Отделы АУГЗ
        </h2>

        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">
          <table class="w-full text-sm">
            <thead class="border-b border-gray-100 dark:border-gray-800">
              <tr class="text-left text-gray-400 text-xs uppercase tracking-wide">
                <th class="px-5 py-3 font-medium">Отдел</th>
                <th class="px-5 py-3 font-medium">Описание</th>
                <th class="px-5 py-3 font-medium">Ответственный</th>
                <th class="px-5 py-3 font-medium">Телефон</th>
                <th class="px-5 py-3 font-medium">Email</th>
                <th class="px-5 py-3 font-medium w-10" />
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
              <tr v-for="(dept, i) in form.departments" :key="i" class="group">
                <td class="px-3 py-2">
                  <UInput v-model="form.departments[i].name" size="sm" class="w-full" placeholder="Членство" />
                </td>
                <td class="px-3 py-2">
                  <UInput v-model="form.departments[i].desc" size="sm" class="w-full" placeholder="Вступление, тарифы" />
                </td>
                <td class="px-3 py-2">
                  <UInput v-model="form.departments[i].responsible" size="sm" class="w-full" placeholder="Абидов Марат" />
                </td>
                <td class="px-3 py-2">
                  <UInput v-model="form.departments[i].phone" size="sm" class="w-full" placeholder="+998 55 503 12 21" />
                </td>
                <td class="px-3 py-2">
                  <UInput v-model="form.departments[i].email" size="sm" class="w-full" placeholder="info@augz.uz" />
                </td>
                <td class="px-3 py-2">
                  <UButton
                    color="error"
                    variant="ghost"
                    icon="i-lucide-trash-2"
                    size="xs"
                    @click="removeDept(i)"
                  />
                </td>
              </tr>
              <tr v-if="!form.departments.length">
                <td colspan="6" class="px-5 py-8 text-center text-gray-400 text-sm">Нет отделов</td>
              </tr>
            </tbody>
          </table>

          <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-800">
            <button
              type="button"
              class="flex items-center gap-2 text-sm font-semibold text-gray-400 hover:text-gray-700 dark:hover:text-white transition-colors"
              @click="addDept"
            >
              <UIcon name="i-lucide-plus-circle" class="w-4 h-4" />
              Добавить отдел
            </button>
          </div>
        </div>
      </section>

      <!-- bottom save -->
      <div class="flex justify-end">
        <UButton :loading="saving" size="lg" @click="save">Сохранить настройки</UButton>
      </div>

    </template>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ middleware: 'auth' })

const { apiFetch } = useApi()

const pending     = ref(true)
const saving      = ref(false)
const saveError   = ref('')
const saved       = ref(false)
const coordsInput = ref('')
const coordsError = ref('')

interface Social {
  id: string; name: string; handle: string; url: string; icon: string
}
interface Department {
  name: string; desc: string; responsible: string; phone: string; email: string
}

const form = reactive({
  contacts: { phone: '', email: '', telegram: '', telegram_url: '' },
  address:  { text: '', zip: '', maps_url: '', lat: 0, lng: 0 },
  hours:    { days: '', from: '', to: '' },
  socials:  [] as Social[],
  departments: [] as Department[],
})

// Parses "lat, lng" from Google Maps / Yandex / plain coordinates
function parseCoords() {
  coordsError.value = ''
  const raw = coordsInput.value.trim()
  if (!raw) return

  // Match two decimal numbers separated by comma or whitespace
  const match = raw.match(/(-?\d{1,3}[.,]\d+)[,\s]+(-?\d{1,3}[.,]\d+)/)
  if (!match) {
    coordsError.value = 'Не удалось распознать координаты. Пример: 41.298600, 69.275700'
    return
  }
  const lat = parseFloat(match[1].replace(',', '.'))
  const lng = parseFloat(match[2].replace(',', '.'))
  if (isNaN(lat) || isNaN(lng) || lat < -90 || lat > 90 || lng < -180 || lng > 180) {
    coordsError.value = 'Координаты вне допустимого диапазона'
    return
  }
  form.address.lat = lat
  form.address.lng = lng
  coordsInput.value = `${lat}, ${lng}`
}

onMounted(async () => {
  try {
    const data = await apiFetch<any>('/admin/settings')
    if (data?.contacts)    Object.assign(form.contacts, data.contacts)
    if (data?.address)     Object.assign(form.address, data.address)
    if (data?.hours)       Object.assign(form.hours, data.hours)
    if (data?.socials)     form.socials = data.socials
    if (data?.departments) form.departments = data.departments
    // Populate coords display
    if (data?.address?.lat) coordsInput.value = `${data.address.lat}, ${data.address.lng}`
  } finally {
    pending.value = false
  }
})

function addSocial() {
  form.socials.push({ id: `social_${Date.now()}`, name: '', handle: '', url: '', icon: 'mdi:link' })
}
function removeSocial(i: number) { form.socials.splice(i, 1) }

function addDept() {
  form.departments.push({ name: '', desc: '', responsible: '', phone: '', email: '' })
}
function removeDept(i: number) { form.departments.splice(i, 1) }

async function save() {
  parseCoords()
  if (coordsError.value) return
  saving.value = true
  saveError.value = ''
  saved.value = false
  try {
    await apiFetch('/admin/settings', { method: 'PUT', body: { content: { ...form } } })
    saved.value = true
    setTimeout(() => { saved.value = false }, 3000)
  } catch (e: any) {
    saveError.value = e?.data?.message ?? 'Ошибка сохранения'
  } finally {
    saving.value = false
  }
}
</script>
