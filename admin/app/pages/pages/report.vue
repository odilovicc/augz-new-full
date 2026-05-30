<template>
  <div class="p-8">
    <div class="flex items-center gap-3 mb-6">
      <NuxtLink to="/" class="text-gray-400 hover:text-gray-600 transition-colors">
        <UIcon name="i-lucide-chevron-left" class="w-5 h-5" />
      </NuxtLink>
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Портал жалоб</h1>
        <p class="text-sm text-gray-400 mt-0.5">Статический контент страницы /report</p>
      </div>
    </div>

    <div v-if="pending" class="flex items-center justify-center py-20">
      <UIcon name="i-lucide-loader-2" class="w-6 h-6 animate-spin text-gray-300" />
    </div>

    <div v-else-if="content" class="space-y-4">
      <!-- Section tabs -->
      <div class="flex flex-wrap gap-1 p-1 bg-gray-100 dark:bg-gray-800 rounded-xl w-fit">
        <button
          v-for="section in sections"
          :key="section.key"
          type="button"
          class="px-4 py-2 rounded-lg text-sm font-medium transition-all"
          :class="activeSection === section.key
            ? 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm'
            : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'"
          @click="activeSection = section.key"
        >
          {{ section.label }}
        </button>
      </div>

      <!-- ── HERO ── -->
      <div v-if="activeSection === 'hero'" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Шапка страницы</h2>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Бейдж (оранжевая строка над заголовком)</p>
          <I18nField v-model="content.hero.badge" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок</p>
          <I18nField v-model="content.hero.title" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подзаголовок</p>
          <I18nField v-model="content.hero.subtitle" />
        </div>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── INFO BANNER ── -->
      <div v-if="activeSection === 'banner'" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Информационный баннер</h2>
        <p class="text-sm text-gray-400">Баннер под шагами формы: «Все обращения рассматриваются в течение 10 рабочих дней...»</p>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Текст до выделения</p>
          <I18nField v-model="content.info_banner.text" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Выделенный текст (жирный — срок)</p>
          <I18nField v-model="content.info_banner.days" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Текст после выделения</p>
          <I18nField v-model="content.info_banner.after_text" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Слово «трек-код» (жирное)</p>
          <I18nField v-model="content.info_banner.track_word" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Завершение строки</p>
          <I18nField v-model="content.info_banner.suffix" />
        </div>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── SIDEBAR ── -->
      <div v-if="activeSection === 'sidebar'" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Боковая панель (десктоп)</h2>

        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок инфо-блока</p>
          <I18nField v-model="content.sidebar.info_title" />
        </div>

        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Пункты инфо-блока (3 строки)</p>
          <div class="space-y-4">
            <div v-for="(_, i) in content.sidebar.info_items" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4">
              <p class="text-xs text-gray-400 mb-2">Пункт {{ i + 1 }}</p>
              <I18nField v-model="content.sidebar.info_items[i]" />
            </div>
          </div>
        </div>

        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Статистика (3 карточки)</p>
          <div class="space-y-3">
            <div v-for="(stat, i) in content.sidebar.stats" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-3">
              <div class="grid grid-cols-2 gap-3">
                <div>
                  <p class="text-xs text-gray-400 mb-1">Иконка (ph:*)</p>
                  <UInput v-model="stat.icon" placeholder="ph:files" />
                </div>
                <div>
                  <p class="text-xs text-gray-400 mb-1">Значение</p>
                  <UInput v-model="stat.value" placeholder="1 240+" />
                </div>
              </div>
              <div>
                <p class="text-xs text-gray-400 mb-1">Подпись</p>
                <I18nField v-model="stat.label" />
              </div>
            </div>
          </div>
        </div>

        <p class="text-xs text-gray-400 bg-gray-50 dark:bg-gray-800 rounded-lg px-3 py-2">
          Телефон и часы работы берутся из глобальных настроек (<NuxtLink to="/settings" class="underline hover:no-underline">Настройки</NuxtLink>).
        </p>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── FORM ── -->
      <div v-if="activeSection === 'form'" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Форма подачи жалобы</h2>

        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Названия вкладок</p>
          <div class="space-y-4">
            <div>
              <p class="text-sm text-gray-500 mb-1">«Подать жалобу»</p>
              <I18nField v-model="content.form.tabs.submit" />
            </div>
            <div>
              <p class="text-sm text-gray-500 mb-1">«Отследить»</p>
              <I18nField v-model="content.form.tabs.track" />
            </div>
          </div>
        </div>

        <UDivider label="Шаги прогресса" />
        <div class="space-y-3">
          <div v-for="(step, i) in content.form.steps" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4">
            <p class="text-xs text-gray-400 mb-2">Шаг {{ i + 1 }}</p>
            <I18nField v-model="step.label" />
          </div>
        </div>

        <UDivider label="Секция 1 — Детали нарушения" />
        <div>
          <p class="text-sm text-gray-500 mb-1">Заголовок секции</p>
          <I18nField v-model="content.form.section1_title" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Лейбл «Организация-нарушитель»</p>
          <I18nField v-model="content.form.label_org" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Плейсхолдер организации</p>
          <I18nField v-model="content.form.placeholder_org" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Лейбл «Номер тендера»</p>
          <I18nField v-model="content.form.label_tender" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Плейсхолдер тендера</p>
          <I18nField v-model="content.form.placeholder_tender" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Лейбл «Дата нарушения»</p>
          <I18nField v-model="content.form.label_date" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Лейбл «Суть обращения»</p>
          <I18nField v-model="content.form.label_desc" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Плейсхолдер описания</p>
          <I18nField v-model="content.form.placeholder_desc" :textarea="true" />
        </div>

        <UDivider label="Секция 2 — Документы" />
        <div>
          <p class="text-sm text-gray-500 mb-1">Заголовок секции</p>
          <I18nField v-model="content.form.section2_title" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Метка «необязательно»</p>
          <I18nField v-model="content.form.section2_optional" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Заголовок дроп-зоны</p>
          <I18nField v-model="content.form.upload_title" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Подсказка дроп-зоны</p>
          <I18nField v-model="content.form.upload_hint" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Строка форматов файлов</p>
          <I18nField v-model="content.form.upload_formats" />
        </div>

        <UDivider label="Секция 3 — Ваши данные" />
        <div>
          <p class="text-sm text-gray-500 mb-1">Заголовок секции</p>
          <I18nField v-model="content.form.section3_title" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Лейбл тоггла «Анонимно»</p>
          <I18nField v-model="content.form.anon_label" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Подсказка анонимности</p>
          <I18nField v-model="content.form.anon_hint" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Лейбл «Имя и Фамилия»</p>
          <I18nField v-model="content.form.label_name" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Плейсхолдер имени</p>
          <I18nField v-model="content.form.placeholder_name" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Лейбл «Организация» (отправитель)</p>
          <I18nField v-model="content.form.label_sender_org" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Плейсхолдер организации отправителя</p>
          <I18nField v-model="content.form.placeholder_sender_org" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Лейбл «Телефон»</p>
          <I18nField v-model="content.form.label_phone" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Лейбл «Email»</p>
          <I18nField v-model="content.form.label_email" />
        </div>

        <UDivider label="Согласие и кнопки" />
        <div>
          <p class="text-sm text-gray-500 mb-1">Текст согласия (до ссылок)</p>
          <I18nField v-model="content.form.agree_text" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Ссылка 1 — «политика конфиденциальности»</p>
          <I18nField v-model="content.form.agree_privacy" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Союз между ссылками</p>
          <I18nField v-model="content.form.agree_and" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Ссылка 2 — «правила обработки»</p>
          <I18nField v-model="content.form.agree_rules" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Кнопка «Подать жалобу»</p>
          <I18nField v-model="content.form.btn_submit" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Кнопка «Позвонить»</p>
          <I18nField v-model="content.form.btn_call" />
        </div>
        <p class="text-xs text-gray-400 bg-gray-50 dark:bg-gray-800 rounded-lg px-3 py-2">
          Номер телефона берётся из глобальных настроек (<NuxtLink to="/settings" class="underline hover:no-underline">Настройки</NuxtLink>).
        </p>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── TRACK ── -->
      <div v-if="activeSection === 'track'" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Вкладка «Отследить статус»</h2>

        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок боковой панели</p>
          <I18nField v-model="content.track.sidebar_title" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Пункты боковой панели (3 шт.)</p>
          <div class="space-y-3">
            <div v-for="(_, i) in content.track.sidebar_items" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4">
              <p class="text-xs text-gray-400 mb-2">Пункт {{ i + 1 }}</p>
              <I18nField v-model="content.track.sidebar_items[i]" />
            </div>
          </div>
        </div>

        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Легенда статусов</p>
          <div class="space-y-3">
            <div v-for="(s, i) in content.track.status_legend" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-3">
              <div>
                <p class="text-xs text-gray-400 mb-1">Цвет (Tailwind-класс)</p>
                <UInput v-model="s.color" placeholder="bg-blue-400" class="max-w-xs" />
              </div>
              <div>
                <p class="text-xs text-gray-400 mb-1">Название статуса</p>
                <I18nField v-model="s.label" />
              </div>
              <div>
                <p class="text-xs text-gray-400 mb-1">Описание</p>
                <I18nField v-model="s.desc" />
              </div>
            </div>
          </div>
        </div>

        <UDivider label="Блок поиска" />
        <div>
          <p class="text-sm text-gray-500 mb-1">Заголовок поиска</p>
          <I18nField v-model="content.track.search_title" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Подсказка под заголовком</p>
          <I18nField v-model="content.track.search_hint" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Плейсхолдер поля ввода (не переводится — формат кода)</p>
          <UInput v-model="content.track.search_placeholder" class="max-w-xs" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Кнопка «Найти»</p>
          <I18nField v-model="content.track.btn_find" />
        </div>

        <UDivider label="Состояния результата" />
        <div>
          <p class="text-sm text-gray-500 mb-1">Пустое состояние — заголовок</p>
          <I18nField v-model="content.track.empty_title" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Пустое состояние — подсказка</p>
          <I18nField v-model="content.track.empty_hint" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">«Не найдено» — заголовок</p>
          <I18nField v-model="content.track.not_found_title" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">«Не найдено» — текст</p>
          <I18nField v-model="content.track.not_found_text" :textarea="true" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Заголовок блока этапов</p>
          <I18nField v-model="content.track.stages_title" />
        </div>

        <UDivider label="Кнопки" />
        <div>
          <p class="text-sm text-gray-500 mb-1">Кнопка «Подать ещё»</p>
          <I18nField v-model="content.track.btn_new" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Кнопка «Позвонить»</p>
          <I18nField v-model="content.track.btn_call" />
        </div>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── SUCCESS MODAL ── -->
      <div v-if="activeSection === 'success'" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Модальное окно «Жалоба принята»</h2>

        <div>
          <p class="text-sm text-gray-500 mb-1">Заголовок модала</p>
          <I18nField v-model="content.success_modal.title" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Подзаголовок</p>
          <I18nField v-model="content.success_modal.subtitle" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Лейбл трек-кода</p>
          <I18nField v-model="content.success_modal.track_label" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Кнопка «Скопировать»</p>
          <I18nField v-model="content.success_modal.btn_copy" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Кнопка «Скопировано»</p>
          <I18nField v-model="content.success_modal.btn_copied" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Текст перед email</p>
          <I18nField v-model="content.success_modal.email_prefix" />
        </div>

        <UDivider label="Мета-данные" />
        <div>
          <p class="text-sm text-gray-500 mb-1">Лейбл «Категория»</p>
          <I18nField v-model="content.success_modal.meta_category" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Значение категории</p>
          <I18nField v-model="content.success_modal.category_name" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Лейбл «Дата подачи»</p>
          <I18nField v-model="content.success_modal.meta_date" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Лейбл «Эксперт»</p>
          <I18nField v-model="content.success_modal.meta_expert" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Имя эксперта</p>
          <I18nField v-model="content.success_modal.expert_name" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Лейбл «Срок ответа»</p>
          <I18nField v-model="content.success_modal.meta_deadline" />
        </div>

        <UDivider label="Шаги прогресса в модале" />
        <div class="space-y-3">
          <div v-for="(step, i) in content.success_modal.progress_steps" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-3">
            <p class="text-xs text-gray-400">Шаг {{ i + 1 }}</p>
            <div>
              <p class="text-xs text-gray-400 mb-1">Название</p>
              <I18nField v-model="step.label" />
            </div>
            <div>
              <p class="text-xs text-gray-400 mb-1">Время</p>
              <I18nField v-model="step.time" />
            </div>
          </div>
        </div>

        <UDivider label="Кнопки" />
        <div>
          <p class="text-sm text-gray-500 mb-1">Кнопка «Отследить»</p>
          <I18nField v-model="content.success_modal.btn_track" />
        </div>
        <div>
          <p class="text-sm text-gray-500 mb-1">Кнопка «Закрыть»</p>
          <I18nField v-model="content.success_modal.btn_close" />
        </div>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ middleware: 'auth' })

const { apiFetch } = useApi()

const sections = [
  { key: 'hero',    label: 'Шапка' },
  { key: 'banner',  label: 'Баннер' },
  { key: 'sidebar', label: 'Боковая панель' },
  { key: 'form',    label: 'Форма' },
  { key: 'track',   label: 'Отслеживание' },
  { key: 'success', label: 'Модал успеха' },
]

const activeSection = ref('hero')
const saving = ref(false)
const saveError = ref<string | null>(null)

const { data: pageData, pending } = await useLazyAsyncData('page-report', () =>
  apiFetch<{ slug: string; content: any }>('/admin/page/report')
)

const content = ref<any>(null)
watch(pageData, (val) => {
  if (val?.content) content.value = val.content
}, { immediate: true })

async function save() {
  if (!content.value) return
  saving.value = true
  saveError.value = null
  try {
    await apiFetch('/admin/page/report', {
      method: 'PUT',
      body: { content: content.value },
    })
  } catch (e: any) {
    saveError.value = e?.data?.message ?? 'Ошибка сохранения'
  } finally {
    saving.value = false
  }
}
</script>
