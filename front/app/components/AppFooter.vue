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

        <div v-for="col in footerColumns" :key="col.id" class="flex flex-col gap-3">
          <h4 class="text-sm font-bold text-gray-900">{{ lt(col.title) }}</h4>
          <ul class="flex flex-col gap-2">
            <li v-for="link in col.links" :key="link.id">
              <NuxtLink
                :to="localePath(link.href)"
                class="text-sm text-gray-500 hover:text-gray-900 transition-colors"
              >
                {{ lt(link.label) }}
              </NuxtLink>
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
interface FooterLink {
  id: number
  label: { ru: string; uz: string; en: string }
  href: string
  position: number
}

interface FooterColumn {
  id: number
  title: { ru: string; uz: string; en: string }
  position: number
  links: FooterLink[]
}

const { t } = useI18n()
const localePath = useLocalePath()
const pageContent = usePageContent()
const lt = useLocaleText()

const footer = computed(() => pageContent.value?.footer)

const config = useRuntimeConfig()

const { data: footerColumns } = await useAsyncData<FooterColumn[]>(
  'footer-columns',
  () => $fetch<{ data: FooterColumn[] }>(`${config.public.apiBase}/footer`)
    .then(res => res.data),
  { default: () => [] }
)
</script>
