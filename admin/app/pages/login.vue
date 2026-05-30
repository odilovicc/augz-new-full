<template>
  <div class="w-full max-w-sm">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-800 p-8">
      <div class="flex items-center gap-3 mb-8">
        <div class="w-10 h-10 rounded-xl bg-primary-500 flex items-center justify-center text-white font-black">А</div>
        <div>
          <p class="font-bold text-gray-900 dark:text-white">АУГЗ</p>
          <p class="text-xs text-gray-400">Панель управления</p>
        </div>
      </div>

      <form class="flex flex-col gap-4" @submit.prevent="submit">
        <UFormField label="Email" :error="errors.email">
          <UInput
            v-model="form.email"
            type="email"
            placeholder="admin@admin.ru"
            autocomplete="email"
            class="w-full"
          />
        </UFormField>

        <UFormField label="Пароль" :error="errors.password">
          <UInput
            v-model="form.password"
            type="password"
            placeholder="••••••"
            autocomplete="current-password"
            class="w-full"
          />
        </UFormField>

        <UButton type="submit" :loading="loading" class="w-full justify-center mt-2" size="lg">
          Войти
        </UButton>

        <p v-if="errors.general" class="text-sm text-red-500 text-center">{{ errors.general }}</p>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'auth', middleware: 'auth' })

const { login } = useAuth()

const form = reactive({ email: '', password: '' })
const errors = reactive<Record<string, string>>({ email: '', password: '', general: '' })
const loading = ref(false)

async function submit() {
  errors.email = ''
  errors.password = ''
  errors.general = ''
  loading.value = true
  try {
    await login(form.email, form.password)
    await navigateTo('/')
  }
  catch (e: any) {
    const data = e?.data
    if (data?.errors?.email?.[0]) errors.email = data.errors.email[0]
    else if (data?.message) errors.general = data.message
    else errors.general = 'Ошибка входа. Проверьте данные.'
  }
  finally {
    loading.value = false
  }
}
</script>
