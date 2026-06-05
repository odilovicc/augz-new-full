<template>
    <NuxtLink :to="localePath('/')">
        <div class="flex items-center gap-x-2">
            <img :src="`/logos/main/${locale}.png`" :class="{
                'w-14': locale === 'ru' || locale === 'uz',
                'w-12': props.variant === 'sm' || locale === 'en',
                'md:-mr-2': locale === 'uz',
            }" alt="Logo" class="object-contain"/>
            <div :class="variant === 'sm' ? 'h-8' : 'h-6'" class="w-[1px] bg-black"></div>
            <span class="w-36 sm:w-52 md:w-64 text-xs">{{ logoDesc }}</span>
        </div>
    </NuxtLink>
</template>
<script setup lang="ts">
import { useI18n } from '#imports';

const { t, locale } = useI18n()
const localePath = useLocalePath()
const settings = useSettings()
const props = defineProps<{
    variant?: 'default' | 'sm'
}>()

const logoDesc = computed(() => {
    const ld = settings.value?.logo_desc
    if (!ld) return t('logo_desc')
    return ld[locale.value as 'ru' | 'uz' | 'en'] ?? ld.ru ?? t('logo_desc')
})
</script>