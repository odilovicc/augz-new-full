export function useAuth() {
  const token = useCookie('admin_token', { maxAge: 60 * 60 * 24 * 7 })
  const user = useState<{ id: number; name: string; email: string } | null>('auth_user', () => null)

  const isLoggedIn = computed(() => !!token.value)

  async function login(email: string, password: string) {
    const config = useRuntimeConfig()
    const data = await $fetch<{ token: string; user: typeof user.value }>(`${config.public.apiBase}/auth/login`, {
      method: 'POST',
      body: { email, password },
      headers: { Accept: 'application/json' },
    })
    token.value = data.token
    user.value = data.user
  }

  async function logout() {
    const { apiFetch } = useApi()
    await apiFetch('/auth/logout', { method: 'POST' }).catch(() => {})
    token.value = null
    user.value = null
    await navigateTo('/login')
  }

  async function fetchMe() {
    if (!token.value) return
    const { apiFetch } = useApi()
    try {
      user.value = await apiFetch('/auth/me')
    }
    catch {
      token.value = null
      user.value = null
    }
  }

  return { token, user, isLoggedIn, login, logout, fetchMe }
}
