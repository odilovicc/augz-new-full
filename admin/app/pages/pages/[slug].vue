<template>
  <div class="p-8">
    <div class="flex items-center gap-3 mb-6">
      <NuxtLink to="/" class="text-gray-400 hover:text-gray-600 transition-colors">
        <UIcon name="i-lucide-chevron-left" class="w-5 h-5" />
      </NuxtLink>
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ pageTitle }}</h1>
        <p class="text-sm text-gray-400 mt-0.5">Статический контент страницы</p>
      </div>
    </div>

    <div v-if="pending" class="flex items-center justify-center py-20">
      <UIcon name="i-lucide-loader-2" class="w-6 h-6 animate-spin text-gray-300" />
    </div>

    <div v-else-if="content" class="space-y-4">
      <!-- Section tabs -->
      <div class="flex gap-1 p-1 bg-gray-100 dark:bg-gray-800 rounded-xl w-fit">
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

      <!-- hero section — contacts -->
      <div v-if="activeSection === 'hero' && slug === 'contacts'" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Hero</h2>
        <template v-if="content.hero">
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Badge (подпись над заголовком)</p>
            <I18nField v-model="content.hero.badge" />
          </div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок страницы</p>
            <I18nField v-model="content.hero.title" />
          </div>
        </template>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ui translations — contacts -->
      <div v-if="activeSection === 'ui' && slug === 'contacts'" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Переводы интерфейса</h2>
        <template v-if="content.ui">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Секция «Как нас найти»</p>
              <I18nField v-model="content.ui.section_find_us" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Кнопка «Открыть в картах»</p>
              <I18nField v-model="content.ui.open_in_maps" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Секция «Отделы»</p>
              <I18nField v-model="content.ui.section_departments" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Столбец «Отдел»</p>
              <I18nField v-model="content.ui.col_dept" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Столбец «Ответственный»</p>
              <I18nField v-model="content.ui.col_responsible" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Столбец «Контакт»</p>
              <I18nField v-model="content.ui.col_contact" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Секция «Соцсети»</p>
              <I18nField v-model="content.ui.section_socials" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок формы</p>
              <I18nField v-model="content.ui.form_title" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подзаголовок формы</p>
              <I18nField v-model="content.ui.form_subtitle" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Поле «Имя» — лейбл</p>
              <I18nField v-model="content.ui.field_name" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Поле «Имя» — плейсхолдер</p>
              <I18nField v-model="content.ui.field_name_ph" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Поле «Тема» — лейбл</p>
              <I18nField v-model="content.ui.field_subject" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Поле «Сообщение» — лейбл</p>
              <I18nField v-model="content.ui.field_message" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Кнопка «Отправить»</p>
              <I18nField v-model="content.ui.btn_send" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Лейбл «Горячая линия»</p>
              <I18nField v-model="content.ui.hotline" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подсказка Telegram</p>
              <I18nField v-model="content.ui.telegram_hint" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Лейбл Email</p>
              <I18nField v-model="content.ui.email_label" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подсказка Email</p>
              <I18nField v-model="content.ui.email_hint" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Лейбл «Адрес офиса»</p>
              <I18nField v-model="content.ui.address_label" />
            </div>
          </div>
        </template>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- hero section — markets -->
      <div v-if="activeSection === 'hero' && slug === 'markets'" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Hero</h2>
        <template v-if="content.hero">
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Badge</p>
            <I18nField v-model="content.hero.badge" />
          </div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок строка 1</p>
            <I18nField v-model="content.hero.title_1" />
          </div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок строка 2 (оранжевый)</p>
            <I18nField v-model="content.hero.title_2" />
          </div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подзаголовок</p>
            <I18nField v-model="content.hero.subtitle" textarea />
          </div>
        </template>
      </div>

      <!-- hero section (home / news) -->
      <div v-if="activeSection === 'hero' && slug !== 'about' && slug !== 'membership' && slug !== 'services' && slug !== 'markets' && slug !== 'contacts'" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Hero</h2>

        <template v-if="content.hero">
          <!-- hero background image -->
          <div v-if="'image' in content.hero">
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Фоновое изображение</p>
            <ImageUpload v-model="content.hero.image" />
          </div>

          <!-- title_1/2/3 — только на главной -->
          <template v-if="'title_1' in content.hero">
            <div v-for="(key, i) in ['title_1','title_2','title_3']" :key="key">
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок строка {{ i + 1 }}</p>
              <I18nField v-model="content.hero[key as keyof typeof content.hero]" />
            </div>
          </template>

          <!-- title — на остальных страницах -->
          <template v-else-if="'title' in content.hero">
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок</p>
              <I18nField v-model="content.hero.title" />
            </div>
          </template>

          <div v-if="'subtitle' in content.hero">
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подзаголовок</p>
            <I18nField v-model="content.hero.subtitle" textarea />
          </div>

          <template v-if="'btn_primary' in content.hero">
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Кнопка «Основная» — текст</p>
              <I18nField v-model="content.hero.btn_primary.label" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Кнопка «Основная» — ссылка</p>
              <UInput v-model="content.hero.btn_primary.href" class="max-w-sm" placeholder="#about" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Кнопка «Вторичная» — текст</p>
              <I18nField v-model="content.hero.btn_secondary.label" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Кнопка «Вторичная» — ссылка</p>
              <UInput v-model="content.hero.btn_secondary.href" class="max-w-sm" placeholder="#services" />
            </div>
          </template>
        </template>

        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- about section -->
      <div v-if="activeSection === 'about' && content.about" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">О нас</h2>

        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок раздела</p>
          <I18nField v-model="content.about.heading" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ссылка «Все услуги»</p>
          <I18nField v-model="content.about.all_services_label" />
        </div>

        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Карточки (4 шт.)</p>
          <div class="space-y-4">
            <div v-for="(f, i) in content.about.features" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-3">
              <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Карточка {{ i + 1 }}</p>
              <div>
                <p class="text-sm text-gray-500 mb-1">Иконка (heroicons)</p>
                <UInput v-model="f.icon" class="max-w-sm" placeholder="heroicons:shield-check" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Заголовок</p>
                <I18nField v-model="f.title" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Описание</p>
                <I18nField v-model="f.desc" textarea />
              </div>
            </div>
          </div>
        </div>

        <div class="rounded-xl border border-amber-100 bg-amber-50 dark:bg-amber-950/20 dark:border-amber-900/40 px-4 py-3 text-sm text-amber-700 dark:text-amber-400">
          Карточки услуг управляются в разделе <strong>«Услуги»</strong> — там можно добавлять, редактировать и удалять услуги динамически.
        </div>

        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- stats section -->
      <div v-if="activeSection === 'stats' && content.stats" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Статистика</h2>

        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подпись</p>
          <I18nField v-model="content.stats.label" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок</p>
          <I18nField v-model="content.stats.heading" />
        </div>

        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Показатели (4 шт.)</p>
          <div class="space-y-4">
            <div v-for="(item, i) in content.stats.items" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-3">
              <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Показатель {{ i + 1 }}</p>
              <div>
                <p class="text-sm text-gray-500 mb-1">Иконка (heroicons)</p>
                <UInput v-model="item.icon" class="max-w-sm" placeholder="heroicons:user-group" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Значение (200+, 15+ ...)</p>
                <I18nField v-model="item.value" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Подпись</p>
                <I18nField v-model="item.label" />
              </div>
            </div>
          </div>
        </div>

        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- partners section -->
      <div v-if="activeSection === 'partners' && content.partners" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Партнёры</h2>

        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок</p>
          <I18nField v-model="content.partners.heading" />
        </div>

        <div>
          <div class="flex items-center justify-between mb-3">
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Логотипы партнёров</p>
            <UButton size="xs" variant="outline" icon="i-lucide-plus" @click="addLogo">Добавить</UButton>
          </div>
          <div class="space-y-3">
            <div v-for="(logo, i) in content.partners.logos" :key="i" class="flex items-center gap-3 border border-gray-100 dark:border-gray-800 rounded-xl p-3">
              <img v-if="logo.src" :src="logo.src" :alt="logo.alt" class="h-8 w-auto object-contain shrink-0" />
              <div class="flex-1 flex gap-2 min-w-0">
                <ImageUpload v-model="logo.src" compact />
                <UInput v-model="logo.alt" placeholder="Название партнёра" />
              </div>
              <UButton size="xs" color="error" variant="ghost" icon="i-lucide-trash-2" @click="removeLogo(i)" />
            </div>
          </div>
        </div>

        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- contacts section -->
      <div v-if="activeSection === 'contacts' && content.contacts" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Контакты</h2>

        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подпись</p>
          <I18nField v-model="content.contacts.label" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок</p>
          <I18nField v-model="content.contacts.heading" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Адрес</p>
          <I18nField v-model="content.contacts.address_value" textarea />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Телефон</p>
          <UInput v-model="content.contacts.phone" class="max-w-sm" placeholder="+998 ..." />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</p>
          <UInput v-model="content.contacts.email" class="max-w-sm" type="email" placeholder="info@..." />
        </div>

        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── MEMBERSHIP: hero ── -->
      <div v-if="activeSection === 'hero' && slug === 'membership' && content.hero" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Hero — Членство</h2>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подпись (мелкая, оранжевая)</p>
          <I18nField v-model="content.hero.label" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок — строка 1</p>
          <I18nField v-model="content.hero.heading_1" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок — строка 2</p>
          <I18nField v-model="content.hero.heading_2" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок — строка 3 (оранжевая)</p>
          <I18nField v-model="content.hero.heading_3" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Описание</p>
          <I18nField v-model="content.hero.desc" textarea />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Кнопка «Основная» — текст</p>
          <I18nField v-model="content.hero.btn_primary.label" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Кнопка «Основная» — ссылка</p>
          <UInput v-model="content.hero.btn_primary.href" class="max-w-sm" placeholder="#form" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Кнопка «Вторичная» — текст</p>
          <I18nField v-model="content.hero.btn_secondary.label" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Кнопка «Вторичная» — ссылка</p>
          <UInput v-model="content.hero.btn_secondary.href" class="max-w-sm" placeholder="#benefits" />
        </div>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── MEMBERSHIP: benefits ── -->
      <div v-if="activeSection === 'benefits' && content.benefits" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Преимущества членства</h2>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок раздела</p>
          <I18nField v-model="content.benefits.heading" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Карточки (6 шт.)</p>
          <div class="space-y-4">
            <div v-for="(item, i) in content.benefits.items" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-3">
              <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Карточка {{ i + 1 }}</p>
              <div>
                <p class="text-sm text-gray-500 mb-1">Иконка (heroicons:*)</p>
                <UInput v-model="item.icon" class="max-w-sm" placeholder="heroicons:document-check" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Цвет фона иконки (Tailwind-класс)</p>
                <UInput v-model="item.icon_bg" class="max-w-sm" placeholder="bg-amber-900/60" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Заголовок</p>
                <I18nField v-model="item.title" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Описание</p>
                <I18nField v-model="item.description" textarea />
              </div>
            </div>
          </div>
        </div>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── MEMBERSHIP: member_types ── -->
      <div v-if="activeSection === 'member_types' && content.member_types" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Кто может вступить</h2>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок раздела</p>
          <I18nField v-model="content.member_types.heading" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Карточки (4 шт.)</p>
          <div class="space-y-4">
            <div v-for="(item, i) in content.member_types.items" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-3">
              <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Карточка {{ i + 1 }}</p>
              <div>
                <p class="text-sm text-gray-500 mb-1">Иконка (heroicons:*)</p>
                <UInput v-model="item.icon" class="max-w-sm" placeholder="heroicons:building-office-2" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Заголовок</p>
                <I18nField v-model="item.title" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Описание</p>
                <I18nField v-model="item.description" textarea />
              </div>
            </div>
          </div>
        </div>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── MEMBERSHIP: form ── -->
      <div v-if="activeSection === 'form' && content.form" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Раздел «Подать заявку»</h2>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подпись (маленькая, оранжевая)</p>
          <I18nField v-model="content.form.label" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок (строка 1)</p>
          <I18nField v-model="content.form.heading" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок — акцент (строка 2, оранжевая)</p>
          <I18nField v-model="content.form.heading_accent" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Описание</p>
          <I18nField v-model="content.form.desc" textarea />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Число статистики (напр. 1000+)</p>
          <UInput v-model="content.form.stat_value" class="max-w-xs" placeholder="1000+" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подпись к числу</p>
          <I18nField v-model="content.form.stat_label" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Знаки доверия (3 шт.)</p>
          <div class="space-y-4">
            <div v-for="(signal, i) in content.form.trust_signals" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-3">
              <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Знак доверия {{ i + 1 }}</p>
              <div>
                <p class="text-sm text-gray-500 mb-1">Иконка (heroicons:*)</p>
                <UInput v-model="signal.icon" class="max-w-sm" placeholder="heroicons:clock" />
              </div>
              <div class="grid grid-cols-2 gap-3">
                <div>
                  <p class="text-sm text-gray-500 mb-1">Фон (bg-*)</p>
                  <UInput v-model="signal.bg" placeholder="bg-orange-500/10" />
                </div>
                <div>
                  <p class="text-sm text-gray-500 mb-1">Цвет иконки (text-*)</p>
                  <UInput v-model="signal.color" placeholder="text-orange-400" />
                </div>
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Заголовок</p>
                <I18nField v-model="signal.title" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Подзаголовок</p>
                <I18nField v-model="signal.subtitle" />
              </div>
            </div>
          </div>
        </div>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── MEMBERSHIP: cta ── -->
      <div v-if="activeSection === 'cta' && content.cta" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Финальный CTA</h2>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Бейдж (верхняя строка)</p>
          <I18nField v-model="content.cta.badge" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок (белый, можно \n для переноса)</p>
          <I18nField v-model="content.cta.heading" textarea />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Акцент заголовка (оранжевый)</p>
          <I18nField v-model="content.cta.accent" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Описание</p>
          <I18nField v-model="content.cta.desc" textarea />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Кнопка «Основная» — текст</p>
          <I18nField v-model="content.cta.btn_primary.label" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Кнопка «Основная» — ссылка</p>
          <UInput v-model="content.cta.btn_primary.href" class="max-w-sm" placeholder="#form" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Кнопка «Вторичная» — текст</p>
          <I18nField v-model="content.cta.btn_secondary.label" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Кнопка «Вторичная» — ссылка</p>
          <UInput v-model="content.cta.btn_secondary.href" class="max-w-sm" placeholder="#form" />
        </div>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── ABOUT: hero ── -->
      <div v-if="activeSection === 'hero' && slug === 'about' && content.hero" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Hero — О нас</h2>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Фоновое изображение</p>
          <ImageUpload v-model="content.hero.image" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок</p>
          <I18nField v-model="content.hero.heading" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подзаголовок</p>
          <I18nField v-model="content.hero.subtitle" textarea />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Кнопка — текст</p>
          <I18nField v-model="content.hero.btn_label" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Кнопка — ссылка</p>
          <UInput v-model="content.hero.btn_href" class="max-w-sm" placeholder="#contacts" />
        </div>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── ABOUT: intro ── -->
      <div v-if="activeSection === 'intro' && content.intro" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Блок «Ассоциация» (левая колонка + статистика)</h2>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Бейдж (напр. «С 2013 года»)</p>
          <I18nField v-model="content.intro.badge" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок</p>
          <I18nField v-model="content.intro.heading" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Описание</p>
          <I18nField v-model="content.intro.desc" textarea />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Текст кнопки</p>
          <I18nField v-model="content.intro.btn_label" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ссылка кнопки</p>
          <UInput v-model="content.intro.btn_href" class="max-w-sm" placeholder="/membership" />
        </div>

        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Карточки статистики</p>
          <div class="space-y-4">
            <div
              v-for="(stat, i) in content.intro.stats"
              :key="i"
              class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-3"
            >
              <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Карточка {{ i + 1 }}</p>
              <div>
                <p class="text-sm text-gray-500 mb-1">Иконка (heroicons:*)</p>
                <UInput v-model="stat.icon" class="max-w-sm" placeholder="heroicons:users" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Значение (200+, 3000+ ...)</p>
                <UInput v-model="stat.value" class="max-w-xs" placeholder="200+" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Подпись</p>
                <I18nField v-model="stat.label" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Цвет акцента (hex)</p>
                <div class="flex items-center gap-3">
                  <UInput v-model="stat.accent_color" class="max-w-xs font-mono" placeholder="#1e40af" />
                  <div class="w-8 h-8 rounded-lg border border-gray-200 shrink-0" :style="{ background: stat.accent_color }" />
                </div>
              </div>
            </div>
          </div>
          <UButton
            size="sm" variant="outline" icon="i-lucide-plus" class="mt-3"
            @click="content.intro.stats.push({ icon: 'heroicons:users', value: '0', label: { ru: '', uz: '', en: '' }, accent_color: '#D1832C' })"
          >
            Добавить карточку
          </UButton>
        </div>

        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── ABOUT: mission ── -->
      <div v-if="activeSection === 'mission' && content.mission" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Миссия</h2>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подпись</p>
          <I18nField v-model="content.mission.label" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок</p>
          <I18nField v-model="content.mission.heading" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Текст</p>
          <I18nField v-model="content.mission.text" textarea />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Геолокация / дата</p>
          <I18nField v-model="content.mission.location" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Показатели (4 шт.)</p>
          <div class="space-y-4">
            <div v-for="(stat, i) in content.mission.stats" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-3">
              <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Показатель {{ i + 1 }}</p>
              <div>
                <p class="text-sm text-gray-500 mb-1">Иконка (i-lucide-*)</p>
                <UInput v-model="stat.icon" class="max-w-sm" placeholder="i-lucide-users" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Значение</p>
                <UInput v-model="stat.value" class="max-w-xs" placeholder="1000+" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Подпись</p>
                <I18nField v-model="stat.label" />
              </div>
            </div>
          </div>
        </div>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── ABOUT: values ── -->
      <div v-if="activeSection === 'values' && content.values" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Ценности</h2>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок раздела</p>
          <I18nField v-model="content.values.heading" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Карточки (4 шт.)</p>
          <div class="space-y-4">
            <div v-for="(val, i) in content.values.items" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-3">
              <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Карточка {{ i + 1 }}</p>
              <div>
                <p class="text-sm text-gray-500 mb-1">Иконка (i-lucide-*)</p>
                <UInput v-model="val.icon" class="max-w-sm" placeholder="i-lucide-shield-check" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Название</p>
                <I18nField v-model="val.title" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Описание</p>
                <I18nField v-model="val.desc" textarea />
              </div>
            </div>
          </div>
        </div>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── ABOUT: leaders ── -->
      <div v-if="activeSection === 'leaders' && content.leaders" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Руководство</h2>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подпись</p>
          <I18nField v-model="content.leaders.label" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок (можно использовать \n для переноса строки)</p>
          <I18nField v-model="content.leaders.heading" textarea />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Описание</p>
          <I18nField v-model="content.leaders.subtitle" textarea />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Участники</p>
          <div class="space-y-4">
            <div v-for="(leader, i) in content.leaders.items" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-3">
              <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ leader.name?.split('\n')[0] ?? `Участник ${i + 1}` }}</p>
              <div>
                <p class="text-sm text-gray-500 mb-1">Фото</p>
                <ImageUpload v-model="leader.photo" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Имя (можно использовать \n для переноса)</p>
                <UInput v-model="leader.name" class="w-full" placeholder="Фамилия\nИмя Отчество" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Должность</p>
                <I18nField v-model="leader.role" />
              </div>
            </div>
          </div>
        </div>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── ABOUT: timeline ── -->
      <div v-if="activeSection === 'timeline' && content.timeline" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">История</h2>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подпись</p>
          <I18nField v-model="content.timeline.label" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок</p>
          <I18nField v-model="content.timeline.heading" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">События</p>
          <div class="space-y-4">
            <div v-for="(event, i) in content.timeline.items" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-3">
              <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ event.year }}</p>
              <div>
                <p class="text-sm text-gray-500 mb-1">Год</p>
                <UInput v-model="event.year" class="max-w-xs" placeholder="2013" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Заголовок события</p>
                <I18nField v-model="event.title" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Описание</p>
                <I18nField v-model="event.desc" textarea />
              </div>
            </div>
          </div>
        </div>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── MEMBERSHIP: ask_modal ── -->
      <div v-if="activeSection === 'ask_modal' && content.ask_modal" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Модалка «Задать вопрос»</h2>

        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подпись (оранжевая, маленькая)</p>
          <I18nField v-model="content.ask_modal.support_label" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок модалки</p>
          <I18nField v-model="content.ask_modal.title" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подзаголовок</p>
          <I18nField v-model="content.ask_modal.subtitle" />
        </div>

        <UDivider label="Бейджи доверия" />
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Бейдж «Ответ за N часов»</p>
          <I18nField v-model="content.ask_modal.badge_time" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Бейдж «Бесплатно»</p>
          <I18nField v-model="content.ask_modal.badge_free" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Бейдж «Эксперты»</p>
          <I18nField v-model="content.ask_modal.badge_experts" />
        </div>

        <UDivider label="Категории чипов" />
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подпись над чипами</p>
          <I18nField v-model="content.ask_modal.category_label" />
        </div>
        <div>
          <div class="flex items-center justify-between mb-3">
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Категории</p>
            <UButton size="xs" variant="outline" icon="i-lucide-plus" @click="content.ask_modal.categories.push({ ru: '', uz: '', en: '' })">Добавить</UButton>
          </div>
          <div class="space-y-3">
            <div v-for="(cat, i) in content.ask_modal.categories" :key="i" class="flex items-start gap-2 border border-gray-100 dark:border-gray-800 rounded-xl p-3">
              <div class="flex-1">
                <I18nField v-model="content.ask_modal.categories[i]" />
              </div>
              <UButton size="xs" color="error" variant="ghost" icon="i-lucide-trash-2" class="mt-1 shrink-0" @click="content.ask_modal.categories.splice(i, 1)" />
            </div>
          </div>
        </div>

        <UDivider label="Лейблы полей" />
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Поле «Имя»</p>
          <I18nField v-model="content.ask_modal.label_name" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Поле «Телефон»</p>
          <I18nField v-model="content.ask_modal.label_phone" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Поле «Email»</p>
          <I18nField v-model="content.ask_modal.label_email" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Поле «Вопрос»</p>
          <I18nField v-model="content.ask_modal.label_question" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Кнопка отправки</p>
          <I18nField v-model="content.ask_modal.btn_submit" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Дисклеймер (под кнопкой)</p>
          <I18nField v-model="content.ask_modal.disclaimer" textarea />
        </div>

        <UDivider label="Экран успеха" />
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок</p>
          <I18nField v-model="content.ask_modal.success_title" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подзаголовок</p>
          <I18nField v-model="content.ask_modal.success_subtitle" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подпись блока контактов</p>
          <I18nField v-model="content.ask_modal.contacts_label" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email для связи</p>
          <UInput v-model="content.ask_modal.contact_email" class="max-w-sm" placeholder="info@augz.uz" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Telegram</p>
          <UInput v-model="content.ask_modal.contact_telegram" class="max-w-sm" placeholder="@augz_uz" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Рабочие часы</p>
          <I18nField v-model="content.ask_modal.working_hours" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Кнопка «Вступить»</p>
          <I18nField v-model="content.ask_modal.btn_join" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ссылка кнопки «Вступить»</p>
          <UInput v-model="content.ask_modal.btn_join_href" class="max-w-sm" placeholder="/membership" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Кнопка «Закрыть»</p>
          <I18nField v-model="content.ask_modal.btn_close" />
        </div>

        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── SERVICES: hero ── -->
      <div v-if="activeSection === 'hero' && slug === 'services' && content.hero" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Hero — Услуги</h2>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Фоновое изображение</p>
          <ImageUpload v-model="content.hero.image" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Бейдж (верхняя строка)</p>
          <I18nField v-model="content.hero.badge" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок — часть 1 (чёрная)</p>
          <I18nField v-model="content.hero.title_1" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок — часть 2 (оранжевая)</p>
          <I18nField v-model="content.hero.title_2" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подзаголовок</p>
          <I18nField v-model="content.hero.subtitle" textarea />
        </div>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── SERVICES: consulting ── -->
      <div v-if="activeSection === 'svc_consulting' && slug === 'services'" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">01 — Консалтинг</h2>
        <template v-if="svc_consulting">
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Бейдж</p>
            <I18nField v-model="svc_consulting.badge" />
          </div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок</p>
            <I18nField v-model="svc_consulting.heading" />
          </div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подзаголовок</p>
            <I18nField v-model="svc_consulting.subtitle" textarea />
          </div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Пункты услуги</p>
            <div class="space-y-4">
              <div v-for="(item, i) in svc_consulting.items" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-3">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Пункт {{ item.number }}</p>
                <div>
                  <p class="text-sm text-gray-500 mb-1">Заголовок</p>
                  <I18nField v-model="item.title" />
                </div>
                <div>
                  <p class="text-sm text-gray-500 mb-1">Описание</p>
                  <I18nField v-model="item.desc" textarea />
                </div>
                <div>
                  <p class="text-sm text-gray-500 mb-1">Теги (через запятую)</p>
                  <UInput :model-value="item.tags.join(', ')" @update:model-value="item.tags = $event.split(',').map((t: string) => t.trim()).filter(Boolean)" class="w-full" placeholder="СТРАТЕГИЯ, АНАЛИЗ" />
                </div>
              </div>
            </div>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Статистика</p>
            <div class="space-y-3">
              <div v-for="(stat, i) in svc_consulting.stats" :key="i" class="flex gap-3 items-start border border-gray-100 dark:border-gray-800 rounded-xl p-3">
                <UInput v-model="stat.value" class="w-24 shrink-0" placeholder="73%" />
                <I18nField v-model="stat.label" class="flex-1" />
              </div>
            </div>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок панели статистики</p>
            <I18nField v-model="svc_consulting.stats_label" />
          </div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Описание под статистикой</p>
            <I18nField v-model="svc_consulting.stats_desc" textarea />
          </div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Кнопка CTA — текст</p>
            <I18nField v-model="svc_consulting.cta_label" />
          </div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Кнопка CTA — ссылка</p>
            <UInput v-model="svc_consulting.cta_href" class="max-w-sm" placeholder="#contacts" />
          </div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Экспресс-консультация — заголовок</p>
            <I18nField v-model="svc_consulting.express_title" />
          </div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Экспресс-консультация — описание</p>
            <I18nField v-model="svc_consulting.express_desc" textarea />
          </div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Экспресс-консультация — кнопка</p>
            <I18nField v-model="svc_consulting.express_btn" />
          </div>
        </template>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── SERVICES: digital products ── -->
      <div v-if="activeSection === 'svc_products' && slug === 'services'" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">02 — Цифровые продукты</h2>
        <template v-if="svc_products">
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Бейдж</p>
            <I18nField v-model="svc_products.badge" />
          </div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок</p>
            <I18nField v-model="svc_products.heading" />
          </div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подзаголовок</p>
            <I18nField v-model="svc_products.subtitle" textarea />
          </div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Продукты (4 шт.)</p>
            <div class="space-y-4">
              <div v-for="(product, i) in svc_products.products" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-3">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Продукт {{ i + 1 }}</p>
                <div class="grid grid-cols-2 gap-3">
                  <div>
                    <p class="text-sm text-gray-500 mb-1">Иконка (heroicons:*)</p>
                    <UInput v-model="product.icon" placeholder="heroicons:bolt" />
                  </div>
                  <div>
                    <p class="text-sm text-gray-500 mb-1">Цвет акцента (hex)</p>
                    <div class="flex items-center gap-2">
                      <UInput v-model="product.accent" class="font-mono" placeholder="#D1832C" />
                      <div class="w-7 h-7 rounded-lg border border-gray-200 shrink-0" :style="{ background: product.accent }" />
                    </div>
                  </div>
                </div>
                <div>
                  <p class="text-sm text-gray-500 mb-1">Название</p>
                  <I18nField v-model="product.name" />
                </div>
                <div>
                  <p class="text-sm text-gray-500 mb-1">Подпись (tagline)</p>
                  <I18nField v-model="product.tagline" />
                </div>
                <div>
                  <p class="text-sm text-gray-500 mb-1">Описание</p>
                  <I18nField v-model="product.desc" textarea />
                </div>
                <div>
                  <p class="text-sm text-gray-500 mb-1">Фичи (одна на строку)</p>
                  <UTextarea :model-value="product.features.join('\n')" :rows="4" @update:model-value="product.features = $event.split('\n').map((f: string) => f.trim()).filter(Boolean)" class="w-full font-mono text-xs" />
                </div>
                <div class="grid grid-cols-2 gap-3">
                  <div>
                    <p class="text-sm text-gray-500 mb-1">Статус-бейдж</p>
                    <UInput v-model="product.status" placeholder="В РАЗРАБОТКЕ · BETA Q3 2026" />
                  </div>
                  <div>
                    <p class="text-sm text-gray-500 mb-1">Цвет статуса (hex)</p>
                    <UInput v-model="product.status_color" class="font-mono" placeholder="#3B82F6" />
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                  <div>
                    <p class="text-sm text-gray-500 mb-1">Ссылка</p>
                    <UInput v-model="product.link" placeholder="https://..." />
                  </div>
                  <div>
                    <p class="text-sm text-gray-500 mb-1">Текст ссылки</p>
                    <I18nField v-model="product.link_label" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </template>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── SERVICES: flagship ── -->
      <div v-if="activeSection === 'svc_flagship' && slug === 'services'" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">03 — Флагманский продукт (TenderZone)</h2>
        <template v-if="svc_flagship">
          <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Бейдж</p><I18nField v-model="svc_flagship.badge" /></div>
          <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок страницы</p><I18nField v-model="svc_flagship.heading" /></div>
          <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подпись продукта</p><I18nField v-model="svc_flagship.product_label" /></div>
          <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Большой заголовок — строка 1</p><I18nField v-model="svc_flagship.product_title_1" /></div>
          <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Большой заголовок — строка 2</p><I18nField v-model="svc_flagship.product_title_2" /></div>
          <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Большой заголовок — строка 3 (оранжевая)</p><I18nField v-model="svc_flagship.product_title_3" /></div>
          <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Описание</p><I18nField v-model="svc_flagship.product_desc" textarea /></div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Мини-фичи (4 шт.)</p>
            <div class="space-y-3">
              <div v-for="(feat, i) in svc_flagship.product_features" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-3 space-y-2">
                <UInput v-model="feat.icon" placeholder="heroicons:bell" class="max-w-xs" />
                <I18nField v-model="feat.title" />
                <I18nField v-model="feat.desc" />
              </div>
            </div>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Статистика справа (4 шт.)</p>
            <div class="space-y-3">
              <div v-for="(stat, i) in svc_flagship.product_stats" :key="i" class="flex gap-3 items-start border border-gray-100 dark:border-gray-800 rounded-xl p-3">
                <UInput v-model="stat.icon" class="w-40 shrink-0" placeholder="heroicons:document-text" />
                <UInput v-model="stat.value" class="w-28 shrink-0" placeholder="150 000+" />
                <I18nField v-model="stat.label" class="flex-1" />
              </div>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div><p class="text-sm text-gray-500 mb-1">CTA кнопка 1 — текст</p><I18nField v-model="svc_flagship.cta_primary_label" /></div>
            <div><p class="text-sm text-gray-500 mb-1">CTA кнопка 1 — ссылка</p><UInput v-model="svc_flagship.cta_primary_href" placeholder="https://tzone.uz" /></div>
            <div><p class="text-sm text-gray-500 mb-1">CTA кнопка 2 — текст</p><I18nField v-model="svc_flagship.cta_secondary_label" /></div>
            <div><p class="text-sm text-gray-500 mb-1">CTA кнопка 2 — ссылка</p><UInput v-model="svc_flagship.cta_secondary_href" placeholder="https://tzone.uz" /></div>
          </div>
        </template>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── SERVICES: analytics ── -->
      <div v-if="activeSection === 'svc_analytics' && slug === 'services'" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">04 — Аналитика</h2>
        <template v-if="svc_analytics">
          <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Бейдж</p><I18nField v-model="svc_analytics.badge" /></div>
          <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок</p><I18nField v-model="svc_analytics.heading" /></div>
          <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подзаголовок</p><I18nField v-model="svc_analytics.subtitle" textarea /></div>
          <div>
            <div class="flex items-center justify-between mb-3">
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Направления</p>
              <UButton size="xs" variant="outline" icon="i-lucide-plus" @click="svc_analytics.directions.push({ icon: 'heroicons:chart-bar', title: { ru: '', uz: '', en: '' }, desc: { ru: '', uz: '', en: '' }, tags: [] })">Добавить</UButton>
            </div>
            <div class="space-y-4">
              <div v-for="(dir, i) in svc_analytics.directions" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-3">
                <div class="flex items-center justify-between">
                  <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Направление {{ i + 1 }}</p>
                  <UButton size="xs" color="error" variant="ghost" icon="i-lucide-trash-2" @click="svc_analytics.directions.splice(i, 1)" />
                </div>
                <UInput v-model="dir.icon" class="max-w-sm" placeholder="heroicons:chart-bar" />
                <I18nField v-model="dir.title" />
                <I18nField v-model="dir.desc" textarea />
                <div>
                  <p class="text-sm text-gray-500 mb-1">Теги (через запятую)</p>
                  <UInput :model-value="dir.tags.join(', ')" @update:model-value="dir.tags = $event.split(',').map((t: string) => t.trim()).filter(Boolean)" placeholder="ОБНОВЛЯЕТСЯ, ЧЛЕНЫ АУГЗ" />
                </div>
              </div>
            </div>
          </div>
          <div>
            <div class="flex items-center justify-between mb-3">
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Отчёты</p>
              <UButton size="xs" variant="outline" icon="i-lucide-plus" @click="svc_analytics.reports.push({ title: { ru: '', uz: '', en: '' }, meta: 'PDF · 0 СТР.', desc: { ru: '', uz: '', en: '' }, date: '', downloads: '', btn: { ru: 'Скачать PDF', uz: 'PDF yuklab olish', en: 'Download PDF' }, href: '#' })">Добавить</UButton>
            </div>
            <div class="space-y-4">
              <div v-for="(rep, i) in svc_analytics.reports" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-3">
                <div class="flex items-center justify-between">
                  <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Отчёт {{ i + 1 }}</p>
                  <UButton size="xs" color="error" variant="ghost" icon="i-lucide-trash-2" @click="svc_analytics.reports.splice(i, 1)" />
                </div>
                <I18nField v-model="rep.title" />
                <div class="grid grid-cols-3 gap-2">
                  <UInput v-model="rep.meta" placeholder="PDF · 48 СТР." />
                  <UInput v-model="rep.date" placeholder="Март 2026" />
                  <UInput v-model="rep.downloads" placeholder="5 440 скачиваний" />
                </div>
                <I18nField v-model="rep.desc" textarea />
                <div class="grid grid-cols-2 gap-2">
                  <div><p class="text-sm text-gray-500 mb-1">Текст кнопки</p><I18nField v-model="rep.btn" /></div>
                  <div><p class="text-sm text-gray-500 mb-1">Ссылка</p><UInput v-model="rep.href" placeholder="https://..." /></div>
                </div>
              </div>
            </div>
          </div>
        </template>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── SERVICES: support ── -->
      <div v-if="activeSection === 'svc_support' && slug === 'services'" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">05 — Сопровождение</h2>
        <template v-if="svc_support">
          <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Бейдж</p><I18nField v-model="svc_support.badge" /></div>
          <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок</p><I18nField v-model="svc_support.heading" /></div>
          <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подзаголовок</p><I18nField v-model="svc_support.subtitle" textarea /></div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Тарифы (3 шт.)</p>
            <div class="space-y-4">
              <div v-for="(plan, i) in svc_support.plans" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-3">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Тариф {{ i + 1 }}</p>
                <div class="grid grid-cols-2 gap-3">
                  <div><p class="text-sm text-gray-500 mb-1">Иконка</p><UInput v-model="plan.icon" placeholder="heroicons:document-text" /></div>
                  <div>
                    <p class="text-sm text-gray-500 mb-1">Цвет (hex)</p>
                    <div class="flex items-center gap-2">
                      <UInput v-model="plan.accent" class="font-mono" placeholder="#D1832C" />
                      <div class="w-7 h-7 rounded-lg border border-gray-200 shrink-0" :style="{ background: plan.accent }" />
                    </div>
                  </div>
                </div>
                <div><p class="text-sm text-gray-500 mb-1">Название</p><I18nField v-model="plan.name" /></div>
                <div><p class="text-sm text-gray-500 mb-1">Описание</p><I18nField v-model="plan.desc" textarea /></div>
                <div>
                  <p class="text-sm text-gray-500 mb-1">Фичи (одна на строку)</p>
                  <UTextarea :model-value="plan.features.join('\n')" :rows="4" @update:model-value="plan.features = $event.split('\n').map((f: string) => f.trim()).filter(Boolean)" class="w-full font-mono text-xs" />
                </div>
                <div><p class="text-sm text-gray-500 mb-1">Цена</p><I18nField v-model="plan.price" /></div>
              </div>
            </div>
          </div>
        </template>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── SERVICES: extra services ── -->
      <div v-if="activeSection === 'svc_extra' && slug === 'services'" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">06 — Дополнительные сервисы</h2>
        <template v-if="svc_extra">
          <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Бейдж</p><I18nField v-model="svc_extra.badge" /></div>
          <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок</p><I18nField v-model="svc_extra.heading" /></div>
          <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подзаголовок</p><I18nField v-model="svc_extra.subtitle" textarea /></div>
          <div>
            <div class="flex items-center justify-between mb-3">
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Сервисы</p>
              <UButton size="xs" variant="outline" icon="i-lucide-plus" @click="svc_extra.services.push({ emoji: '📌', name: { ru: '', uz: '', en: '' }, desc: { ru: '', uz: '', en: '' }, link_label: { ru: 'Подробнее', uz: 'Batafsil', en: 'Learn more' }, href: '#' })">Добавить</UButton>
            </div>
            <div class="space-y-4">
              <div v-for="(svc, i) in svc_extra.services" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-3">
                <div class="flex items-center justify-between">
                  <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Сервис {{ i + 1 }}</p>
                  <UButton size="xs" color="error" variant="ghost" icon="i-lucide-trash-2" @click="svc_extra.services.splice(i, 1)" />
                </div>
                <div class="grid grid-cols-2 gap-3">
                  <div><p class="text-sm text-gray-500 mb-1">Эмодзи</p><UInput v-model="svc.emoji" class="max-w-xs" placeholder="📄" /></div>
                  <div><p class="text-sm text-gray-500 mb-1">Ссылка</p><UInput v-model="svc.href" placeholder="#" /></div>
                </div>
                <div><p class="text-sm text-gray-500 mb-1">Название</p><I18nField v-model="svc.name" /></div>
                <div><p class="text-sm text-gray-500 mb-1">Описание</p><I18nField v-model="svc.desc" textarea /></div>
                <div><p class="text-sm text-gray-500 mb-1">Текст ссылки</p><I18nField v-model="svc.link_label" /></div>
              </div>
            </div>
          </div>
        </template>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── SERVICES: CTA form ── -->
      <div v-if="activeSection === 'svc_cta' && slug === 'services'" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">CTA — Форма заявки</h2>
        <template v-if="svc_cta">
          <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Бейдж</p><I18nField v-model="svc_cta.badge" /></div>
          <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок — строка 1</p><I18nField v-model="svc_cta.heading_1" /></div>
          <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок — строка 2</p><I18nField v-model="svc_cta.heading_2" /></div>
          <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок — строка 3 (оранжевая)</p><I18nField v-model="svc_cta.heading_3" /></div>
          <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Описание</p><I18nField v-model="svc_cta.desc" textarea /></div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Контакты (4 шт.)</p>
            <div class="space-y-3">
              <div v-for="(contact, i) in svc_cta.contacts" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-3 space-y-2">
                <div class="grid grid-cols-2 gap-2">
                  <div><p class="text-xs text-gray-400 mb-1">Иконка</p><UInput v-model="contact.icon" placeholder="heroicons:phone" /></div>
                  <div><p class="text-xs text-gray-400 mb-1">Значение</p><UInput v-model="contact.value" placeholder="+998 ..." /></div>
                </div>
                <div><p class="text-xs text-gray-400 mb-1">Подпись</p><I18nField v-model="contact.label" /></div>
              </div>
            </div>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Варианты услуг в форме</p>
            <div class="space-y-2">
              <div v-for="(opt, i) in svc_cta.form_service_options" :key="i" class="flex gap-2">
                <UInput :model-value="opt" @update:model-value="svc_cta.form_service_options[i] = $event" class="flex-1" />
                <UButton size="sm" color="error" variant="ghost" icon="i-lucide-trash-2" @click="svc_cta.form_service_options.splice(i, 1)" />
              </div>
              <UButton size="xs" variant="outline" icon="i-lucide-plus" @click="svc_cta.form_service_options.push('')">Добавить вариант</UButton>
            </div>
          </div>
          <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Кнопка отправки</p><I18nField v-model="svc_cta.form_btn" /></div>
        </template>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── TENDERZONE: hero ── -->
      <div v-if="activeSection === 'hero' && slug === 'tenderzone' && content.hero" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Hero</h2>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Бейдж</p>
          <I18nField v-model="content.hero.badge" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок — строка 1</p>
          <I18nField v-model="content.hero.title_1" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок — строка 2 (оранжевая)</p>
          <I18nField v-model="content.hero.title_2" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок — строка 3</p>
          <I18nField v-model="content.hero.title_3" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок — строка 4 (акцент, оранжевая)</p>
          <I18nField v-model="content.hero.title_accent" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подзаголовок</p>
          <I18nField v-model="content.hero.subtitle" textarea />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Кнопка «Основная» — текст</p>
          <I18nField v-model="content.hero.btn_primary.label" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Кнопка «Основная» — ссылка</p>
          <UInput v-model="content.hero.btn_primary.href" class="max-w-sm" placeholder="https://tzone.uz" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Кнопка «Вторичная» — текст</p>
          <I18nField v-model="content.hero.btn_secondary.label" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Кнопка «Вторичная» — ссылка</p>
          <UInput v-model="content.hero.btn_secondary.href" class="max-w-sm" placeholder="https://tzone.uz" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Мини-статистика (3 шт.)</p>
          <div class="space-y-3">
            <div v-for="(stat, i) in content.hero.stats" :key="i" class="flex gap-3 items-center border border-gray-100 dark:border-gray-800 rounded-xl p-3">
              <UInput v-model="stat.value" class="w-28 shrink-0" placeholder="12 000+" />
              <I18nField v-model="stat.label" class="flex-1" />
            </div>
          </div>
        </div>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── TENDERZONE: features ── -->
      <div v-if="activeSection === 'features' && slug === 'tenderzone' && content.features" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Раздел «Возможности»</h2>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Бейдж</p>
          <I18nField v-model="content.features.badge" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок</p>
          <I18nField v-model="content.features.heading" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Подзаголовок</p>
          <I18nField v-model="content.features.subtitle" textarea />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Карточки (6 шт.)</p>
          <div class="space-y-4">
            <div v-for="(f, i) in content.features.items" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-3">
              <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Карточка {{ i + 1 }}</p>
              <div class="grid grid-cols-2 gap-3">
                <div>
                  <p class="text-sm text-gray-500 mb-1">Иконка (ph:*)</p>
                  <UInput v-model="f.icon" placeholder="ph:magnifying-glass" />
                </div>
                <div>
                  <p class="text-sm text-gray-500 mb-1">Цвет иконки (text-*)</p>
                  <UInput v-model="f.icon_color" placeholder="text-orange-500" />
                </div>
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Цвет верхней границы (border-t-*)</p>
                <UInput v-model="f.border_color" placeholder="border-t-orange-400" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Заголовок</p>
                <I18nField v-model="f.title" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Описание</p>
                <I18nField v-model="f.desc" textarea />
              </div>
              <div class="grid grid-cols-2 gap-3">
                <div>
                  <p class="text-sm text-gray-500 mb-1">Бейдж</p>
                  <I18nField v-model="f.badge" />
                </div>
                <div>
                  <p class="text-sm text-gray-500 mb-1">Цвет бейджа (Tailwind-классы)</p>
                  <UInput v-model="f.badge_color" placeholder="text-orange-600 bg-orange-50 border-orange-200" />
                </div>
              </div>
            </div>
          </div>
        </div>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── TENDERZONE: how it works ── -->
      <div v-if="activeSection === 'how' && slug === 'tenderzone' && content.how" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Раздел «Как работает»</h2>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Бейдж</p>
          <I18nField v-model="content.how.badge" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок</p>
          <I18nField v-model="content.how.heading" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">CTA подсказка (под кнопками)</p>
          <I18nField v-model="content.how.cta_hint" textarea />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Кнопка «Основная» — текст</p>
          <I18nField v-model="content.how.btn_primary.label" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Кнопка «Основная» — ссылка</p>
          <UInput v-model="content.how.btn_primary.href" class="max-w-sm" placeholder="https://tzone.uz" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Кнопка «Вторичная» — текст</p>
          <I18nField v-model="content.how.btn_secondary.label" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Кнопка «Вторичная» — ссылка</p>
          <UInput v-model="content.how.btn_secondary.href" class="max-w-sm" placeholder="#" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Шаги (5 шт.)</p>
          <div class="space-y-4">
            <div v-for="(step, i) in content.how.steps" :key="i" class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 space-y-3">
              <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Шаг {{ i + 1 }}</p>
              <div>
                <p class="text-sm text-gray-500 mb-1">Название</p>
                <I18nField v-model="step.title" />
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Описание</p>
                <I18nField v-model="step.desc" textarea />
              </div>
            </div>
          </div>
        </div>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- ── TENDERZONE: modal ── -->
      <div v-if="activeSection === 'modal' && slug === 'tenderzone' && content.modal" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Модалка заявки</h2>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок «Начать бесплатно»</p>
          <I18nField v-model="content.modal.free_title" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Описание «Начать бесплатно»</p>
          <I18nField v-model="content.modal.free_desc" textarea />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Заголовок «Запросить демо»</p>
          <I18nField v-model="content.modal.demo_title" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Описание «Запросить демо»</p>
          <I18nField v-model="content.modal.demo_desc" textarea />
        </div>
        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>

      <!-- footer section -->
      <div v-if="activeSection === 'footer' && content.footer" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-6 space-y-6">
        <h2 class="font-semibold text-gray-900 dark:text-white">Подвал сайта</h2>

        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Слоган</p>
          <I18nField v-model="content.footer.tagline" />
        </div>
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Описание</p>
          <I18nField v-model="content.footer.description" textarea />
        </div>

        <SaveBar :saving="saving" :error="saveError" @save="save" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ middleware: 'auth' })

const route = useRoute()
const slug = computed(() => route.params.slug as string)
const { apiFetch } = useApi()

const pageTitles: Record<string, string> = {
  home:       'Главная страница',
  about:      'Страница «О нас»',
  news:       'Страница новостей',
  services:   'Страница услуг',
  membership: 'Страница членства',
  markets:    'Торговые площадки',
  contacts:    'Страница контактов',
  tenderzone:  'TenderZone',
}
const pageTitle = computed(() => pageTitles[slug.value] ?? slug.value)

const sectionsBySlug: Record<string, { key: string; label: string }[]> = {
  home: [
    { key: 'hero',     label: 'Hero' },
    { key: 'about',    label: 'О нас' },
    { key: 'stats',    label: 'Статистика' },
    { key: 'partners', label: 'Партнёры' },
    { key: 'contacts', label: 'Контакты' },
  ],
  about: [
    { key: 'hero',     label: 'Hero' },
    { key: 'intro',    label: 'Ассоциация' },
    { key: 'mission',  label: 'Миссия' },
    { key: 'values',   label: 'Ценности' },
    { key: 'timeline', label: 'История' },
  ],
  news:       [{ key: 'hero', label: 'Hero' }],
  markets:    [{ key: 'hero', label: 'Hero' }],
  services: [
    { key: 'hero',           label: 'Hero' },
    { key: 'svc_consulting', label: 'Консалтинг' },
    { key: 'svc_products',   label: 'Цифр. продукты' },
    { key: 'svc_flagship',   label: 'Флагман' },
    { key: 'svc_analytics',  label: 'Аналитика' },
    { key: 'svc_support',    label: 'Сопровождение' },
    { key: 'svc_extra',      label: 'Сервисы' },
    { key: 'svc_cta',        label: 'CTA' },
  ],
  membership: [
    { key: 'hero',         label: 'Hero' },
    { key: 'benefits',     label: 'Преимущества' },
    { key: 'member_types', label: 'Кто может вступить' },
    { key: 'form',         label: 'Форма заявки' },
    { key: 'cta',          label: 'CTA' },
    { key: 'ask_modal',    label: 'Задать вопрос' },
  ],
  contacts: [
    { key: 'hero', label: 'Hero' },
    { key: 'ui',   label: 'Переводы UI' },
  ],
  tenderzone: [
    { key: 'hero',     label: 'Hero' },
    { key: 'features', label: 'Возможности' },
    { key: 'how',      label: 'Как работает' },
    { key: 'modal',    label: 'Модалка' },
  ],
}
const sections = computed(() => sectionsBySlug[slug.value] ?? [{ key: 'hero', label: 'Hero' }])
const activeSection = ref('hero')

const content = ref<Record<string, any> | null>(null)
const pending = ref(true)
const saving = ref(false)
const saveError = ref('')

onMounted(async () => {
  try {
    const res = await apiFetch<{ slug: string; content: any }>(`/admin/page/${slug.value}`)
    content.value = res.content

    // Initialize missing tenderzone fields to avoid v-model errors and validation failures
    if (slug.value === 'tenderzone') {
      const emptyI18n = () => ({ ru: '', uz: '', en: '' })
      
      if (!content.value.hero) content.value.hero = {}
      if (!content.value.hero.badge) content.value.hero.badge = emptyI18n()
      if (!content.value.hero.title_1) content.value.hero.title_1 = emptyI18n()
      if (!content.value.hero.title_2) content.value.hero.title_2 = emptyI18n()
      if (!content.value.hero.title_3) content.value.hero.title_3 = emptyI18n()
      if (!content.value.hero.title_accent) content.value.hero.title_accent = emptyI18n()
      if (!content.value.hero.subtitle) content.value.hero.subtitle = emptyI18n()
      if (!content.value.hero.btn_primary) content.value.hero.btn_primary = { label: emptyI18n(), href: '' }
      if (!content.value.hero.btn_secondary) content.value.hero.btn_secondary = { label: emptyI18n(), href: '' }

      if (!content.value.hero.stats || content.value.hero.stats.length === 0) {
        content.value.hero.stats = Array(3).fill(null).map(() => ({ value: '', label: emptyI18n() }))
      }
      
      if (!content.value.features) content.value.features = {}
      if (!content.value.features.badge) content.value.features.badge = emptyI18n()
      if (!content.value.features.heading) content.value.features.heading = emptyI18n()
      if (!content.value.features.subtitle) content.value.features.subtitle = emptyI18n()
      if (!content.value.features.items || content.value.features.items.length === 0) {
        content.value.features.items = Array(6).fill(null).map(() => ({
          icon: '', icon_color: '', border_color: '',
          title: emptyI18n(), desc: emptyI18n(),
          badge: emptyI18n(), badge_color: ''
        }))
      }
      
      if (!content.value.how) content.value.how = {}
      if (!content.value.how.badge) content.value.how.badge = emptyI18n()
      if (!content.value.how.heading) content.value.how.heading = emptyI18n()
      if (!content.value.how.cta_hint) content.value.how.cta_hint = emptyI18n()
      if (!content.value.how.btn_primary) content.value.how.btn_primary = { label: emptyI18n(), href: '' }
      if (!content.value.how.btn_secondary) content.value.how.btn_secondary = { label: emptyI18n(), href: '' }
      if (!content.value.how.steps || content.value.how.steps.length === 0) {
        content.value.how.steps = Array(5).fill(null).map(() => ({
          title: emptyI18n(), desc: emptyI18n()
        }))
      }
      
      if (!content.value.modal) content.value.modal = {}
      if (!content.value.modal.free_title) content.value.modal.free_title = emptyI18n()
      if (!content.value.modal.free_desc) content.value.modal.free_desc = emptyI18n()
      if (!content.value.modal.demo_title) content.value.modal.demo_title = emptyI18n()
      if (!content.value.modal.demo_desc) content.value.modal.demo_desc = emptyI18n()
    }
  }
  catch (e) {
    console.error('Failed to load page content:', e)
    content.value = {}
  }
  finally {
    pending.value = false
  }
})

async function save() {
  if (!content.value) return
  saving.value = true
  saveError.value = ''
  try {
    await apiFetch(`/admin/page/${slug.value}`, { method: 'PUT', body: { content: content.value } })
  }
  catch (e: any) {
    saveError.value = e?.data?.message ?? 'Ошибка сохранения'
  }
  finally {
    saving.value = false
  }
}

function servicesSection(id: string) {
  return content.value?.sections?.find((s: any) => s.id === id) ?? null
}

const svc_consulting    = computed(() => servicesSection('consulting'))
const svc_products      = computed(() => servicesSection('digital-products'))
const svc_flagship      = computed(() => servicesSection('flagship'))
const svc_analytics     = computed(() => servicesSection('analytics'))
const svc_support       = computed(() => servicesSection('support'))
const svc_extra         = computed(() => servicesSection('extra-services'))
const svc_cta           = computed(() => servicesSection('cta'))

function addLogo() {
  content.value?.partners?.logos?.push({ src: '', alt: '' })
}

function removeLogo(i: number) {
  content.value?.partners?.logos?.splice(i, 1)
}
</script>
