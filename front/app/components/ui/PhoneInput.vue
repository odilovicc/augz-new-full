<template>
  <IMaskComponent
    mask="+{0}000000000000"
    :unmask="false"
    :model-value="modelValue"
    type="tel"
    placeholder="+_ ___ ___ ____"
    v-bind="$attrs"
    @accept="(val: string) => emit('update:modelValue', val)"
    @blur="$emit('blur')"
  />
</template>

<script setup lang="ts">
import { IMaskComponent } from 'vue-imask'

defineOptions({ inheritAttrs: false })

defineProps<{ modelValue: string }>()
const emit = defineEmits<{
  (e: 'update:modelValue', val: string): void
  (e: 'blur'): void
}>()
</script>
