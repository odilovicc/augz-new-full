export function useApi() {
  const config = useRuntimeConfig()
  const token = useCookie('admin_token')

  function apiFetch<T>(path: string, options: Parameters<typeof $fetch>[1] = {}) {
    return $fetch<T>(`${config.public.apiBase}${path}`, {
      ...options,
      headers: {
        ...(options.headers as Record<string, string> ?? {}),
        ...(token.value ? { Authorization: `Bearer ${token.value}` } : {}),
        Accept: 'application/json',
      },
    })
  }

  return { apiFetch }
}
