<template>
  <div class="p-8">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Добро пожаловать</h1>
    <p class="text-gray-500 mb-8">Выберите раздел в боковом меню для управления контентом.</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-lg">
      <NuxtLink to="/news" class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5 flex items-center gap-4 hover:border-primary-300 transition-colors group">
        <div class="w-10 h-10 rounded-lg bg-primary-50 dark:bg-primary-950 flex items-center justify-center text-primary-500">
          <UIcon name="i-lucide-newspaper" class="w-5 h-5" />
        </div>
        <div>
          <p class="font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 transition-colors">Новости</p>
          <p class="text-xs text-gray-400">Управление статьями</p>
        </div>
      </NuxtLink>

      <NuxtLink to="/videos" class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5 flex items-center gap-4 hover:border-primary-300 transition-colors group">
        <div class="w-10 h-10 rounded-lg bg-primary-50 dark:bg-primary-950 flex items-center justify-center text-primary-500">
          <UIcon name="i-lucide-play-circle" class="w-5 h-5" />
        </div>
        <div>
          <p class="font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 transition-colors">Видео</p>
          <p class="text-xs text-gray-400">Управление видеозаписями</p>
        </div>
      </NuxtLink>

      <NuxtLink to="/applications" class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5 flex items-center gap-4 hover:border-primary-300 transition-colors group">
        <div class="w-10 h-10 rounded-lg bg-primary-50 dark:bg-primary-950 flex items-center justify-center text-primary-500">
          <UIcon name="i-lucide-inbox" class="w-5 h-5" />
        </div>
        <div>
          <p class="font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 transition-colors">Заявки</p>
          <p class="text-xs text-gray-400">Заявки на членство</p>
        </div>
      </NuxtLink>

      <NuxtLink to="/testimonials" class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5 flex items-center gap-4 hover:border-primary-300 transition-colors group">
        <div class="w-10 h-10 rounded-lg bg-primary-50 dark:bg-primary-950 flex items-center justify-center text-primary-500">
          <UIcon name="i-lucide-message-square" class="w-5 h-5" />
        </div>
        <div>
          <p class="font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 transition-colors">Отзывы</p>
          <p class="text-xs text-gray-400">Управление отзывами</p>
        </div>
      </NuxtLink>

      <NuxtLink to="/membership" class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5 flex items-center gap-4 hover:border-primary-300 transition-colors group">
        <div class="w-10 h-10 rounded-lg bg-primary-50 dark:bg-primary-950 flex items-center justify-center text-primary-500">
          <UIcon name="i-lucide-badge-check" class="w-5 h-5" />
        </div>
        <div>
          <p class="font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 transition-colors">Тарифы членства</p>
          <p class="text-xs text-gray-400">Цены и возможности планов</p>
        </div>
      </NuxtLink>

      <NuxtLink to="/pages/report" class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5 flex items-center gap-4 hover:border-primary-300 transition-colors group">
        <div class="w-10 h-10 rounded-lg bg-primary-50 dark:bg-primary-950 flex items-center justify-center text-primary-500">
          <UIcon name="i-lucide-alert-triangle" class="w-5 h-5" />
        </div>
        <div>
          <p class="font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 transition-colors">Портал жалоб</p>
          <p class="text-xs text-gray-400">Контент страницы /report</p>
        </div>
      </NuxtLink>

      <NuxtLink to="/pages/tenderzone" class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5 flex items-center gap-4 hover:border-primary-300 transition-colors group">
        <div class="w-10 h-10 rounded-lg bg-primary-50 dark:bg-primary-950 flex items-center justify-center text-primary-500">
          <UIcon name="i-lucide-search" class="w-5 h-5" />
        </div>
        <div>
          <p class="font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 transition-colors">TenderZone</p>
          <p class="text-xs text-gray-400">Контент страницы /tenderzone</p>
        </div>
      </NuxtLink>

      <NuxtLink to="/footer" class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5 flex items-center gap-4 hover:border-primary-300 transition-colors group">
        <div class="w-10 h-10 rounded-lg bg-primary-50 dark:bg-primary-950 flex items-center justify-center text-primary-500">
          <UIcon name="i-lucide-layout-panel-top" class="w-5 h-5" />
        </div>
        <div>
          <p class="font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 transition-colors">Футер</p>
          <p class="text-xs text-gray-400">Колонки и ссылки в подвале сайта</p>
        </div>
      </NuxtLink>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ middleware: 'auth' })
</script>
