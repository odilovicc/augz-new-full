<template>
    <button :class="{
        'px-4 py-2 rounded-md transition border border-transparent hover:cursor-pointer': true,
        'bg-[var(--theme-color)] text-white hover:bg-white hover:text-[var(--theme-color)] hover:border-[var(--theme-color)]': variant === 'primary',
        'border !border-[var(--theme-color)] text-[var(--theme-color)] hover:bg-[var(--theme-color)] hover:text-white': variant === 'outlined'
    }">
        <slot></slot>
    </button>
</template>
<script setup lang="ts">
type variant = "outlined" | "primary";

const props = withDefaults(
    defineProps<{
        variant?: variant
    }>(),
    {
        variant: "primary"
    }
)
</script>