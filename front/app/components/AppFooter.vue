<template>
  <footer class="bg-gray-100 border-t border-gray-200">
    <div class="container mx-auto px-4 py-14">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-10 lg:gap-8">

        <div class="lg:col-span-2 flex flex-col gap-5">
          <div class="flex items-center gap-3">
            <Logo variant="sm"/>
          </div>
          <p class="text-sm text-gray-500 leading-relaxed max-w-xs">{{ lt(footer?.description) }}</p>
        </div>

        <div v-for="(col, i) in navColumns" :key="i" class="flex flex-col gap-3">
          <h4 class="text-sm font-bold text-gray-900">{{ t(col.titleKey) }}</h4>
          <ul class="flex flex-col gap-2">
            <li v-for="(linkKey, j) in col.linkKeys" :key="j">
              <a href="#" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">
                {{ t(linkKey) }}
              </a>
            </li>
          </ul>
        </div>

      </div>
    </div>

    <div class="border-t border-gray-200">
      <div class="container mx-auto px-4 py-5 flex flex-col sm:flex-row items-center justify-between gap-3">
        <span class="text-xs text-gray-400">{{ t('footer.copyright') }}</span>
        <div class="flex gap-6">
          <NuxtLink :to="localePath('/privacy')" class="text-xs text-gray-400 hover:text-gray-700 transition-colors">{{ t('footer.privacy') }}</NuxtLink>
          <NuxtLink :to="localePath('/appeals-rules')" class="text-xs text-gray-400 hover:text-gray-700 transition-colors">{{ t('footer.appeals_rules') }}</NuxtLink>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup lang="ts">
const { t } = useI18n()
const localePath = useLocalePath()
const pageContent = usePageContent()
const lt = useLocaleText()

const footer = computed(() => pageContent.value?.footer)

const navColumns = [
  {
    titleKey: 'footer.col_about',
    linkKeys: ['footer.col_about_links[0]', 'footer.col_about_links[1]', 'footer.col_about_links[2]', 'footer.col_about_links[3]'],
  },
  {
    titleKey: 'footer.col_services',
    linkKeys: ['footer.col_services_links[0]', 'footer.col_services_links[1]', 'footer.col_services_links[2]', 'footer.col_services_links[3]'],
  },
  {
    titleKey: 'footer.col_membership',
    linkKeys: ['footer.col_membership_links[0]', 'footer.col_membership_links[1]'],
  },
  {
    titleKey: 'footer.col_info',
    linkKeys: ['footer.col_info_links[0]', 'footer.col_info_links[1]', 'footer.col_info_links[2]', 'footer.col_info_links[3]'],
  },
]
</script>
