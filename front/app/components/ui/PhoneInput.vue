<template>
  <IMaskComponent
    :mask="'+{998} (00) 000-00-00'"
    :unmask="false"
    :model-value="modelValue"
    type="tel"
    placeholder="+998 (00) 000-00-00"
    v-bind="$attrs"
    @complete="(val: string) => emit('update:modelValue', val)"
    @accept="(val: string) => { if (val !== modelValue) emit('update:modelValue', '') }"
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
