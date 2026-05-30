<template>
  <section id="contacts" class="section bg-gray-50">
    <div class="container mx-auto px-4">

      <div class="text-center mb-12">
        <span class="text-sm font-semibold text-(--theme-color) uppercase tracking-widest">{{ lt(contacts?.label) }}</span>
        <h2 class="mt-3 text-3xl md:text-4xl font-bold">{{ lt(contacts?.heading) }}</h2>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16">

        <div class="flex flex-col gap-y-6">
          <div v-for="info in contactItems" :key="info.type" class="flex items-start gap-x-4">
            <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center shrink-0">
              <Icon :name="info.icon" class="w-4 h-4 text-(--theme-color)" />
            </div>
            <div>
              <div class="text-sm text-gray-500 mb-0.5">{{ info.label }}</div>
              <a v-if="info.type === 'phone'" :href="`tel:${info.value.replace(/\s/g,'')}`" class="font-medium text-(--theme-color) hover:underline">{{ info.value }}</a>
              <a v-else-if="info.type === 'email'" :href="`mailto:${info.value}`" class="font-medium text-(--theme-color) hover:underline">{{ info.value }}</a>
              <div v-else class="font-medium">{{ info.value }}</div>
            </div>
          </div>

          <div ref="mapContainer" class="mt-2 w-full aspect-video rounded-2xl overflow-hidden bg-gray-200">
            <div v-if="mapError" class="w-full h-full flex items-center justify-center text-gray-400 text-sm">
              {{ t('contacts.map_error') }}
            </div>
          </div>
        </div>

        <form class="bg-white rounded-2xl p-6 md:p-8 flex flex-col gap-y-4 shadow-sm lg:h-full" @submit.prevent="handleSubmit">
          <h3 class="text-xl font-semibold mb-1">{{ t('contacts.form_title') }}</h3>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="flex flex-col gap-y-1.5">
              <label class="text-sm font-medium text-gray-700">{{ t('contacts.name') }}</label>
              <input v-model="form.name" type="text" :placeholder="t('contacts.name_placeholder')"
                     class="px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-(--theme-color) transition" />
            </div>
            <div class="flex flex-col gap-y-1.5">
              <label class="text-sm font-medium text-gray-700">{{ t('contacts.phone') }}</label>
              <input v-model="form.phone" type="tel" placeholder="+998 __ ___ __ __"
                     class="px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-(--theme-color) transition" />
            </div>
          </div>

          <div class="flex flex-col gap-y-1.5">
            <label class="text-sm font-medium text-gray-700">{{ t('contacts.email') }}</label>
            <input v-model="form.email" type="email" placeholder="example@mail.com"
                   class="px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-(--theme-color) transition" />
          </div>

          <div class="flex flex-col gap-y-1.5 flex-1">
            <label class="text-sm font-medium text-gray-700">{{ t('contacts.message') }}</label>
            <textarea v-model="form.message" :placeholder="t('contacts.message_placeholder')"
                      class="flex-1 min-h-28 px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-(--theme-color) transition resize-none" />
          </div>

          <UiButton type="submit" :disabled="submitting" class="w-full mt-2">
            {{ submitting ? t('contacts.sending') : t('contacts.send') }}
          </UiButton>
        </form>

      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
const { t } = useI18n()
const pageContent = usePageContent()
const settings    = useSettings()
const lt          = useLocaleText()
const config      = useRuntimeConfig()

const contacts = computed(() => pageContent.value?.contacts)

const contactItems = computed(() => [
  { type: 'address', icon: 'mdi:map-marker', label: t('contacts.address_label'), value: settings.value.address.text },
  { type: 'phone',   icon: 'mdi:phone',      label: t('contacts.phone_label'),   value: settings.value.contacts.phone },
  { type: 'email',   icon: 'mdi:email',      label: t('contacts.email_label'),   value: settings.value.contacts.email },
])

const mapContainer = ref<HTMLElement | null>(null)
const mapError     = ref(false)
const submitting   = ref(false)
const form         = reactive({ name: '', phone: '', email: '', message: '' })

function handleSubmit() {
  // TODO: wire up to backend API
}

function initYandexMap(ymaps: any) {
  if (!mapContainer.value) return
  const lat  = settings.value.address.lat
  const lng  = settings.value.address.lng
  const text = settings.value.address.text
  const map  = new ymaps.Map(mapContainer.value, { center: [lat, lng], zoom: 16, controls: ['zoomControl', 'fullscreenControl'] }, { suppressMapOpenBlock: true })
  const mark = new ymaps.Placemark([lat, lng], { balloonContentHeader: 'AUGZ', balloonContentBody: text }, { preset: 'islands#orangeIcon' })
  map.geoObjects.add(mark)
}

onMounted(() => {
  const apiKey = config.public.yandexMapsApiKey as string
  if (!apiKey) { mapError.value = true; return }
  const w = window as any
  if (w.ymaps) { w.ymaps.ready(() => initYandexMap(w.ymaps)); return }
  const script = document.createElement('script')
  script.src = `https://api-maps.yandex.ru/2.1/?apikey=${apiKey}&lang=ru_RU`
  script.async = true
  script.onerror = () => { mapError.value = true }
  script.onload  = () => { w.ymaps.ready(() => initYandexMap(w.ymaps)) }
  document.head.appendChild(script)
})
</script>
