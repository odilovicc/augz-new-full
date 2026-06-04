<template>
  <div class="min-h-screen bg-gray-50 dark:bg-gray-950 flex">
    <aside class="w-60 shrink-0 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 flex flex-col">
      <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-primary-500 flex items-center justify-center text-white font-black text-sm">А</div>
        <span class="font-bold text-sm text-gray-900 dark:text-white">АУГЗ Админ</span>
      </div>

      <nav class="flex-1 p-3 flex flex-col gap-1 overflow-y-auto">
        <p class="px-3 pt-1 pb-0.5 text-[10px] font-bold uppercase tracking-widest text-gray-300 dark:text-gray-600">Контент страниц</p>
        <NuxtLink
          v-for="link in navLinks"
          :key="link.to"
          :to="link.to"
          class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium transition-colors"
          :class="$route.path === link.to
            ? 'bg-primary-50 dark:bg-primary-950 text-primary-600 dark:text-primary-400'
            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white'"
        >
          <UIcon :name="link.icon" class="w-4 h-4 shrink-0" />
          {{ link.label }}
        </NuxtLink>

        <div class="my-1 border-t border-gray-100 dark:border-gray-800" />
        <p class="px-3 pt-1 pb-0.5 text-[10px] font-bold uppercase tracking-widest text-gray-300 dark:text-gray-600">Динамика</p>
        <NuxtLink
          v-for="link in dynamicLinks"
          :key="link.to"
          :to="link.to"
          class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium transition-colors"
          :class="$route.path.startsWith(link.to)
            ? 'bg-primary-50 dark:bg-primary-950 text-primary-600 dark:text-primary-400'
            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white'"
        >
          <UIcon :name="link.icon" class="w-4 h-4 shrink-0" />
          {{ link.label }}
        </NuxtLink>

        <div class="my-1 border-t border-gray-100 dark:border-gray-800" />
        <p class="px-3 pt-1 pb-0.5 text-[10px] font-bold uppercase tracking-widest text-gray-300 dark:text-gray-600">Система</p>
        <NuxtLink
          to="/settings"
          class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium transition-colors"
          :class="$route.path.startsWith('/settings')
            ? 'bg-primary-50 dark:bg-primary-950 text-primary-600 dark:text-primary-400'
            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white'"
        >
          <UIcon name="i-lucide-settings" class="w-4 h-4 shrink-0" />
          Настройки
        </NuxtLink>
      </nav>

      <div class="p-3 border-t border-gray-100 dark:border-gray-800">
        <div class="px-3 py-2 text-xs text-gray-400 truncate mb-1">{{ user?.email }}</div>
        <button
          class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-red-50 dark:hover:bg-red-950 hover:text-red-600 dark:hover:text-red-400 transition-colors"
          @click="logout"
        >
          <UIcon name="i-lucide-log-out" class="w-4 h-4 shrink-0" />
          Выйти
        </button>
      </div>
    </aside>

    <main class="flex-1 min-w-0">
      <slot />
    </main>
  </div>
</template>

<script setup lang="ts">
defineOptions({ name: 'DefaultLayout' })

const { user, logout } = useAuth()

const navLinks = [
  { to: '/pages/home',       icon: 'i-lucide-layout',      label: 'Главная' },
  { to: '/pages/about',      icon: 'i-lucide-info',        label: 'Стр. о нас' },
  { to: '/pages/news',       icon: 'i-lucide-file-text',   label: 'Стр. новостей' },
  { to: '/pages/services',   icon: 'i-lucide-briefcase',   label: 'Стр. услуг' },
  { to: '/pages/membership', icon: 'i-lucide-users',       label: 'Стр. членства' },
  { to: '/pages/markets',    icon: 'i-lucide-store',       label: 'Стр. площадок' },
  { to: '/pages/contacts',   icon: 'i-lucide-phone',       label: 'Стр. контактов' },
  { to: '/pages/report',      icon: 'i-lucide-alert-triangle', label: 'Портал жалоб' },
  { to: '/pages/tenderzone',  icon: 'i-lucide-search',         label: 'TenderZone' },
]

const dynamicLinks = [
  { to: '/complaints',   icon: 'i-lucide-alert-triangle',  label: 'Жалобы' },
  { to: '/leaders',     icon: 'i-lucide-user-circle',    label: 'Руководство' },
  { to: '/markets',     icon: 'i-lucide-building-2',     label: 'Торг. площадки' },
  { to: '/services',    icon: 'i-lucide-layers',         label: 'Услуги' },
  { to: '/news',        icon: 'i-lucide-newspaper',      label: 'Новости' },
  { to: '/videos',      icon: 'i-lucide-play-circle',    label: 'Видео' },
  { to: '/applications',icon: 'i-lucide-inbox',          label: 'Заявки' },
  { to: '/questions',   icon: 'i-lucide-message-circle', label: 'Вопросы' },
  { to: '/leads',       icon: 'i-lucide-zap',            label: 'Лиды' },
  { to: '/navbar',      icon: 'i-lucide-menu',           label: 'Навигация' },
  { to: '/footer',      icon: 'i-lucide-layout-panel-top', label: 'Футер' },
]
</script>
