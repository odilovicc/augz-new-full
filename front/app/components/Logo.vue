<template>
    <NuxtLink :to="localePath('/')">
        <div class="flex items-center gap-x-2">
            <img :src="`/logos/main/${locale}.png`" :class="{
                'w-14': locale === 'ru' || locale === 'uz',
                'w-16': locale === 'en',
                'w-12': props.variant === 'sm',
            }" alt="Logo" class="object-contain"/>
            <div :class="variant === 'sm' ? 'h-8' : 'h-10'" class="w-[1px] bg-black"></div>
            <span :class="{
                'w-52 md:w-72': true,
                'text-xs': variant === 'sm'
            }">{{ $t('logo_desc') }}</span>
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