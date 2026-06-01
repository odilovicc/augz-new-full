<template>
    <NuxtLink :to="localePath('/')">
        <div class="flex items-center gap-x-2">
            <img :src="`/logos/main/${locale}.png`" :class="{
                'w-14': locale === 'ru' || locale === 'uz',
                'w-12': props.variant === 'sm' || locale === 'en',
                'md:-mr-2': locale === 'uz',
            }" alt="Logo" class="object-contain"/>
            <div :class="variant === 'sm' ? 'h-8' : 'h-6'" class="w-[1px] bg-black"></div>
            <span class="w-36 sm:w-52 md:w-64 text-xs">{{ $t('logo_desc') }}</span>
        </div>
    </NuxtLink>
</template>
<script setup lang="ts">
import { useI18n } from '#imports';

const { t, locale } = useI18n()
const localePath = useLocalePath()
const props = defineProps<{
    variant?: 'default' | 'sm'
}>()
</script>