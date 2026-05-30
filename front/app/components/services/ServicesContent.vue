<template>
  <div>
    <ServiceSection
      v-for="(section, i) in sections"
      :key="section.id"
      :section="section"
      :index="i"
    />
  </div>
</template>
<script setup lang="ts">
import ServiceSection from '~/components/services/ServiceSection.vue'
const content = useServicesPageContent()
const sections = computed(() => content.value?.sections ?? [])
</script>
