<template>
  <div>
    <!-- ─── HERO ─── -->
    <div
      class="relative overflow-hidden min-h-[60vh] md:min-h-[72vh] flex items-center bg-gray-100"
      style="background: url('/img/Hero.png') center/cover no-repeat;"
    >
      <div class="absolute inset-0 bg-linear-to-r from-white/95 via-white/70 to-white/10" />

      <div class="relative z-10 container mx-auto px-4 pb-16 pt-32">
        <nav class="flex items-center gap-1.5 text-xs text-gray-400 mb-8">
          <NuxtLink :to="localePath('/')" class="hover:text-(--theme-color) transition-colors">{{ t('nav.home') }}</NuxtLink>
          <span>/</span>
          <span class="text-gray-700">{{ t('nav.contacts') }}</span>
        </nav>

        <div class="flex items-center gap-2 mb-5">
          <span class="w-8 h-0.5 bg-(--theme-color)" />
          <span class="text-xs font-bold uppercase tracking-[0.2em] text-gray-600">{{ hero('badge') }}</span>
        </div>

        <h1 class="text-4xl sm:text-5xl md:text-6xl font-black uppercase leading-none">
          {{ hero('title') || t('nav.contacts') }}
        </h1>
      </div>
    </div>

    <!-- ─── MAIN CONTENT ─── -->
    <section class="section bg-[#f5f5f0]">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-10 items-start">

          <!-- ── LEFT COLUMN ── -->
          <div class="flex flex-col gap-12">

            <!-- КАК НАС НАЙТИ -->
            <div>
              <div class="flex items-center gap-2 mb-6">
                <span class="w-6 h-0.5 bg-(--theme-color)" />
                <span class="text-xs font-bold uppercase tracking-[0.18em] text-(--theme-color)">{{ ui('section_find_us') }}</span>
              </div>

              <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
                <div ref="mapContainer" class="w-full h-72 bg-gray-200">
                  <div v-if="mapError" class="w-full h-full flex items-center justify-center text-gray-400 text-sm">
                    {{ ui('map_error') }}
                  </div>
                </div>

                <div class="flex items-center justify-between px-5 py-4 border-t border-gray-100">
                  <span class="text-sm text-gray-700 font-medium">{{ settings.address.text }}</span>
                  <a
                    :href="settings.address.maps_url || '#'"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="text-sm font-semibold text-(--theme-color) hover:underline flex items-center gap-1 shrink-0 ml-4"
                  >
                    {{ ui('open_in_maps') }} <span>→</span>
                  </a>
                </div>
              </div>
            </div>

            <!-- ОТДЕЛЫ АУГЗ -->
            <div v-if="departments.length">
              <div class="flex items-center gap-2 mb-6">
                <span class="w-6 h-0.5 bg-(--theme-color)" />
                <span class="text-xs font-bold uppercase tracking-[0.18em] text-(--theme-color)">{{ ui('section_departments') }}</span>
              </div>

              <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
                <table class="w-full text-sm">
                  <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                      <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-400">{{ ui('col_dept') }}</th>
                      <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-400 hidden sm:table-cell">{{ ui('col_responsible') }}</th>
                      <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-400">{{ ui('col_contact') }}</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-50">
                    <tr v-for="dept in departments" :key="dept.name" class="hover:bg-gray-50 transition-colors">
                      <td class="px-5 py-4">
                        <div class="font-semibold text-gray-900">{{ dept.name }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ dept.desc }}</div>
                      </td>
                      <td class="px-5 py-4 text-gray-600 hidden sm:table-cell">{{ dept.responsible }}</td>
                      <td class="px-5 py-4">
                        <a :href="phoneHref(dept.phone)" class="block font-semibold text-(--theme-color) hover:underline text-sm">{{ dept.phone }}</a>
                        <a :href="`mailto:${dept.email}`" class="block text-xs text-gray-400 hover:text-(--theme-color) transition-colors mt-0.5">{{ dept.email }}</a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- МЫ В СОЦСЕТЯХ -->
            <div v-if="socials.length">
              <div class="flex items-center gap-2 mb-6">
                <span class="w-6 h-0.5 bg-(--theme-color)" />
                <span class="text-xs font-bold uppercase tracking-[0.18em] text-(--theme-color)">{{ ui('section_socials') }}</span>
              </div>

              <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                <a
                  v-for="social in socials"
                  :key="social.id ?? social.name"
                  :href="social.url"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col items-center gap-2 hover:border-(--theme-color)/40 hover:shadow-md transition-all group"
                >
                  <Icon :name="social.icon" class="w-7 h-7 text-gray-500 group-hover:text-(--theme-color) transition-colors" />
                  <span class="text-sm font-semibold text-gray-900">{{ social.name }}</span>
                  <span class="text-xs text-gray-400">{{ social.handle }}</span>
                </a>
              </div>
            </div>

          </div>

          <!-- ── RIGHT SIDEBAR ── -->
          <div class="flex flex-col gap-4 lg:sticky lg:top-20">

            <!-- Contact form -->
            <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
              <div class="bg-(--theme-color) px-5 py-4">
                <h3 class="text-base font-bold text-white">{{ ui('form_title') }}</h3>
                <p class="text-xs text-white/70 mt-0.5">{{ ui('form_subtitle') }}</p>
              </div>

              <!-- Success state -->
              <div v-if="submitted" class="flex flex-col items-center gap-4 p-6 text-center">
                <div class="w-14 h-14 rounded-full bg-green-50 flex items-center justify-center">
                  <Icon name="heroicons:check-circle" class="w-8 h-8 text-green-500" />
                </div>
                <div>
                  <p class="font-bold text-gray-900">{{ ui('btn_sent') }}</p>
                  <p class="text-sm text-gray-400 mt-1">{{ ui('form_subtitle') }}</p>
                </div>
                <button
                  type="button"
                  class="text-sm font-semibold text-(--theme-color) hover:underline"
                  @click="submitted = false; serverError = ''"
                >
                  {{ t('contacts_page.btn_send') }}
                </button>
              </div>

              <form v-else class="flex flex-col gap-3.5 p-5" @submit.prevent="submitForm">
                <!-- Name -->
                <div class="flex flex-col gap-1">
                  <label class="text-[11px] font-bold uppercase tracking-wider text-gray-400">
                    {{ ui('field_name') }} <span class="text-red-400">*</span>
                  </label>
                  <input
                    v-model="contactForm.name"
                    type="text"
                    :placeholder="ui('field_name_ph')"
                    class="px-3.5 py-2.5 text-sm border rounded-lg focus:outline-none transition-colors"
                    :class="formErrors.name ? 'border-red-400 focus:border-red-400' : 'border-gray-200 focus:border-(--theme-color)'"
                    @blur="validateField('name')"
                  />
                  <p v-if="formErrors.name" class="text-xs text-red-500">{{ formErrors.name }}</p>
                </div>

                <!-- Phone + Email -->
                <div class="grid grid-cols-2 gap-3">
                  <div class="flex flex-col gap-1">
                    <label class="text-[11px] font-bold uppercase tracking-wider text-gray-400">
                      {{ ui('field_phone') }} <span class="text-red-400">*</span>
                    </label>
                    <UiPhoneInput
                      v-model="contactForm.phone"
                      class="px-3.5 py-2.5 text-sm border rounded-lg focus:outline-none transition-colors w-full"
                      :class="formErrors.phone ? 'border-red-400 focus:border-red-400' : 'border-gray-200 focus:border-(--theme-color)'"
                      @blur="validateField('phone')"
                    />
                    <p v-if="formErrors.phone" class="text-xs text-red-500">{{ formErrors.phone }}</p>
                  </div>
                  <div class="flex flex-col gap-1">
                    <label class="text-[11px] font-bold uppercase tracking-wider text-gray-400">{{ ui('field_email') }}</label>
                    <input
                      v-model="contactForm.email"
                      type="email"
                      :placeholder="ui('field_email_ph')"
                      class="px-3.5 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-(--theme-color) transition-colors"
                    />
                  </div>
                </div>

                <!-- Subject -->
                <div class="flex flex-col gap-1">
                  <label class="text-[11px] font-bold uppercase tracking-wider text-gray-400">{{ ui('field_subject') }}</label>
                  <input
                    v-model="contactForm.subject"
                    type="text"
                    :placeholder="ui('field_subject_ph')"
                    class="px-3.5 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-(--theme-color) transition-colors"
                  />
                </div>

                <!-- Message -->
                <div class="flex flex-col gap-1">
                  <label class="text-[11px] font-bold uppercase tracking-wider text-gray-400">
                    {{ ui('field_message') }} <span class="text-red-400">*</span>
                  </label>
                  <textarea
                    v-model="contactForm.message"
                    rows="4"
                    :placeholder="ui('field_message_ph')"
                    class="px-3.5 py-2.5 text-sm border rounded-lg focus:outline-none transition-colors resize-none"
                    :class="formErrors.message ? 'border-red-400 focus:border-red-400' : 'border-gray-200 focus:border-(--theme-color)'"
                    @blur="validateField('message')"
                  />
                  <p v-if="formErrors.message" class="text-xs text-red-500">{{ formErrors.message }}</p>
                </div>

                <!-- Server error -->
                <p v-if="serverError" class="text-xs text-red-500 bg-red-50 rounded-lg px-3 py-2">{{ serverError }}</p>

                <button
                  type="submit"
                  :disabled="submitting"
                  class="w-full py-3 rounded-xl bg-(--theme-color) text-white text-sm font-bold flex items-center justify-center gap-2 hover:opacity-90 transition-opacity disabled:opacity-60"
                >
                  <Icon v-if="submitting" name="heroicons:arrow-path" class="w-4 h-4 animate-spin" />
                  <span>{{ submitting ? ui('btn_sending') : ui('btn_send') }}</span>
                </button>

                <p class="text-xs text-gray-400 text-center">
                  {{ ui('privacy_pre') }}
                  <NuxtLink :to="localePath('/privacy')" class="text-(--theme-color) hover:underline">{{ ui('privacy_link') }}</NuxtLink>
                  {{ ui('privacy_post') }}
                </p>
              </form>
            </div>

            <!-- Quick contacts -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden divide-y divide-gray-50">
              <div class="flex items-start gap-3.5 px-5 py-4">
                <div class="w-9 h-9 rounded-xl bg-orange-50 flex items-center justify-center shrink-0 mt-0.5">
                  <Icon name="heroicons:phone" class="w-4 h-4 text-(--theme-color)" />
                </div>
                <div>
                  <div class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-0.5">{{ ui('hotline') }}</div>
                  <a :href="phoneHref(settings.contacts.phone)" class="text-sm font-bold text-gray-900 hover:text-(--theme-color) transition-colors">
                    {{ settings.contacts.phone }}
                  </a>
                  <div class="text-xs text-gray-400 mt-0.5">{{ hoursLabel }}</div>
                </div>
              </div>

              <div class="flex items-start gap-3.5 px-5 py-4">
                <div class="w-9 h-9 rounded-xl bg-orange-50 flex items-center justify-center shrink-0 mt-0.5">
                  <Icon name="mdi:send" class="w-4 h-4 text-(--theme-color)" />
                </div>
                <div>
                  <div class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-0.5">{{ ui('telegram_label') }}</div>
                  <a :href="settings.contacts.telegram_url" target="_blank"
                    class="text-sm font-bold text-gray-900 hover:text-(--theme-color) transition-colors">
                    {{ settings.contacts.telegram }}
                  </a>
                  <div class="text-xs text-gray-400 mt-0.5">{{ ui('telegram_hint') }}</div>
                </div>
              </div>

              <div class="flex items-start gap-3.5 px-5 py-4">
                <div class="w-9 h-9 rounded-xl bg-orange-50 flex items-center justify-center shrink-0 mt-0.5">
                  <Icon name="heroicons:envelope" class="w-4 h-4 text-(--theme-color)" />
                </div>
                <div>
                  <div class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-0.5">{{ ui('email_label') }}</div>
                  <a :href="`mailto:${settings.contacts.email}`"
                    class="text-sm font-bold text-gray-900 hover:text-(--theme-color) transition-colors">
                    {{ settings.contacts.email }}
                  </a>
                  <div class="text-xs text-gray-400 mt-0.5">{{ ui('email_hint') }}</div>
                </div>
              </div>

              <div class="flex items-start gap-3.5 px-5 py-4">
                <div class="w-9 h-9 rounded-xl bg-orange-50 flex items-center justify-center shrink-0 mt-0.5">
                  <Icon name="heroicons:map-pin" class="w-4 h-4 text-(--theme-color)" />
                </div>
                <div>
                  <div class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-0.5">{{ ui('address_label') }}</div>
                  <div class="text-sm font-medium text-gray-900 leading-snug">{{ settings.address.text }}</div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
const { t, locale } = useI18n()
const config     = useRuntimeConfig()
const settings   = useSettings()
const hoursLabel = useHoursLabel()
const localePath  = useLocalePath()

useSeoMeta({
  title: 'Контакты — АУГЗ',
  description: 'Свяжитесь с АУГЗ: телефон +998 55 503 12 21, email info@augz.uz. Офис: г. Ташкент, Мирабадский район, ул. Нукуса, 89. Пн–Пт с 9:00 до 18:00.',
  ogTitle: 'Контакты — АУГЗ',
  ogDescription: 'Телефон: +998 55 503 12 21 · Email: info@augz.uz · Ташкент, ул. Нукуса, 89',
  ogImage: '/og-default.jpg',
  ogUrl: 'https://augz.uz/contacts',
  ogType: 'website',
  twitterCard: 'summary_large_image',
  twitterTitle: 'Контакты — АУГЗ',
  twitterDescription: 'Телефон: +998 55 503 12 21 · Email: info@augz.uz · Ташкент, ул. Нукуса, 89',
})

// CMS content for translatable UI strings
const { data: pageData } = await useAsyncData(
  'contacts-page',
  () => $fetch<{ slug: string; content: any }>(`${config.public.apiBase}/page/contacts`),
)
const cmsUi   = computed(() => pageData.value?.content?.ui ?? {})
const cmsHero = computed(() => pageData.value?.content?.hero ?? {})

// Helper: pick locale from CMS object, fall back to $t()
function cms(section: Record<string, any>, key: string, fallback: string): string {
  const val = section[key]
  if (val && typeof val === 'object') {
    const lang = locale.value as string
    return val[lang] ?? val.ru ?? val.uz ?? val.en ?? fallback
  }
  return fallback
}
function ui(key: string): string  { return cms(cmsUi.value, key, t(`contacts_page.${key}`)) }
function hero(key: string): string { return cms(cmsHero.value, key, t(`contacts_page.${key}`)) }

const lt = useLocaleText()

function deptText(val: string | { ru: string; uz: string; en: string } | undefined): string {
  if (!val) return ''
  if (typeof val === 'string') return val
  return lt(val)
}

const departments = computed(() =>
  (settings.value?.departments ?? []).map(d => ({
    ...d,
    name:        deptText(d.name),
    desc:        deptText(d.desc),
    responsible: deptText(d.responsible),
  }))
)
const socials     = computed(() => settings.value?.socials ?? [])

function phoneHref(phone: string | undefined) {
  if (!phone) return '#'
  return `tel:${phone.replace(/\s/g, '')}`
}

const contactForm  = reactive({ name: '', phone: '', email: '', subject: '', message: '' })
const formErrors   = reactive({ name: '', phone: '', message: '' })
const submitting   = ref(false)
const submitted    = ref(false)
const serverError  = ref('')

function validateField(field: 'name' | 'phone' | 'message') {
  if (field === 'name')    formErrors.name    = contactForm.name.trim().length < 2 ? 'Введите имя' : ''
  if (field === 'phone')   formErrors.phone   = !contactForm.phone.trim() ? 'Введите телефон' : ''
  if (field === 'message') formErrors.message = contactForm.message.trim().length < 5 ? 'Сообщение слишком короткое' : ''
}

function validateAll(): boolean {
  validateField('name')
  validateField('phone')
  validateField('message')
  return !formErrors.name && !formErrors.phone && !formErrors.message
}

async function submitForm() {
  if (!validateAll()) return
  submitting.value = true
  serverError.value = ''
  try {
    await $fetch(`${config.public.apiBase}/questions`, {
      method: 'POST',
      body: {
        name:     contactForm.name,
        phone:    contactForm.phone,
        email:    contactForm.email || undefined,
        category: contactForm.subject || 'Контакты',
        question: contactForm.message,
      },
    })
    submitted.value = true
    Object.assign(contactForm, { name: '', phone: '', email: '', subject: '', message: '' })
    Object.assign(formErrors, { name: '', phone: '', message: '' })
  } catch (e: any) {
    const errs = e?.data?.errors
    serverError.value = errs
      ? Object.values(errs).flat().join(' ')
      : e?.data?.message ?? 'Ошибка отправки. Попробуйте ещё раз.'
  } finally {
    submitting.value = false
  }
}

const mapContainer = ref<HTMLElement | null>(null)
const mapError     = ref(false)

function initMap(ymaps: any) {
  if (!mapContainer.value) return
  const lat  = settings.value.address.lat
  const lng  = settings.value.address.lng
  const text = settings.value.address.text
  const map  = new ymaps.Map(mapContainer.value, { center: [lat, lng], zoom: 16, controls: ['zoomControl'] }, { suppressMapOpenBlock: true })
  const mark = new ymaps.Placemark([lat, lng], { balloonContent: text }, { preset: 'islands#orangeIcon' })
  map.geoObjects.add(mark)
}

onMounted(() => {
  const apiKey = config.public.yandexMapsApiKey as string
  if (!apiKey) { mapError.value = true; return }
  const w = window as any
  if (w.ymaps) { w.ymaps.ready(() => initMap(w.ymaps)); return }
  const s = document.createElement('script')
  s.src = `https://api-maps.yandex.ru/2.1/?apikey=${apiKey}&lang=ru_RU`
  s.async = true
  s.onerror = () => { mapError.value = true }
  s.onload  = () => { w.ymaps.ready(() => initMap(w.ymaps)) }
  document.head.appendChild(s)
})
</script>
