// Fetches global site settings once on SSR, stored in useState so client hydrates without refetch
export default defineNuxtPlugin(async () => {
  const config   = useRuntimeConfig()
  const settings = useSettings()

  try {
    const data = await $fetch<any>(`${config.public.apiBase}/settings`)
    if (data && typeof data === 'object') {
      settings.value = data
    }
  } catch {
    // keep fallback values
  }
})
