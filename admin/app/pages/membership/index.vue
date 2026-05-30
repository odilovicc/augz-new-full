<template>
  <div class="p-8">
    <div class="mb-8">
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Тарифы членства</h1>
      <p class="text-sm text-gray-400 mt-0.5">Редактируйте цены и возможности каждого плана</p>
    </div>

    <div v-if="pending" class="flex items-center justify-center py-24">
      <UIcon name="i-lucide-loader-2" class="w-6 h-6 animate-spin text-gray-300" />
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div
        v-for="plan in plans"
        :key="plan.id"
        class="relative bg-white dark:bg-gray-900 rounded-2xl border dark:border-gray-800 overflow-hidden flex flex-col"
        :class="plan.is_popular ? 'border-amber-400 shadow-lg shadow-amber-50 dark:shadow-amber-950/30' : 'border-gray-200'"
      >
        <!-- Popular badge -->
        <div v-if="plan.is_popular" class="absolute top-0 right-0">
          <span class="inline-block bg-amber-400 text-white text-[10px] font-bold tracking-widest uppercase px-3 py-1 rounded-bl-xl">
            Популярный
          </span>
        </div>

        <div class="p-6 flex flex-col flex-1 gap-4">
          <!-- Header -->
          <div>
            <p class="text-[11px] font-bold tracking-widest uppercase text-gray-400 mb-1">{{ plan.label }}</p>
            <p class="text-3xl font-black text-gray-900 dark:text-white">
              {{ plan.price ?? 'Бесплатно' }}
              <span v-if="plan.currency" class="text-base font-medium text-gray-400"> {{ plan.currency }}</span>
            </p>
            <p class="text-xs text-gray-400 mt-1">{{ plan.period }}</p>
          </div>

          <UDivider />

          <!-- Features -->
          <ul class="flex flex-col gap-2 flex-1">
            <li v-for="feature in plan.features" :key="feature.text" class="flex items-center gap-2 text-sm">
              <UIcon
                :name="feature.included ? 'i-lucide-check-circle-2' : 'i-lucide-minus-circle'"
                class="shrink-0 w-4 h-4"
                :class="feature.included ? 'text-green-500' : 'text-gray-300 dark:text-gray-600'"
              />
              <span :class="feature.included ? 'text-gray-700 dark:text-gray-200' : 'text-gray-400'">{{ feature.text }}</span>
            </li>
          </ul>

          <!-- Edit button -->
          <UButton
            variant="outline"
            icon="i-lucide-pencil"
            class="w-full justify-center mt-2"
            @click="openEdit(plan)"
          >
            Редактировать
          </UButton>
        </div>
      </div>
    </div>
  </div>

  <!-- Slideover -->
  <USlideover v-model:open="slideOpen" title="Редактировать тариф" side="right" class="w-full max-w-xl">
    <template #body>
      <form v-if="form" class="flex flex-col gap-6 p-6" @submit.prevent="save">

        <!-- Basic info -->
        <div class="grid grid-cols-2 gap-4">
          <UFormField label="Название" class="col-span-2" required>
            <UInput v-model="form.label" class="w-full" placeholder="Профессиональный" />
          </UFormField>

          <UFormField label="Цена">
            <UInput v-model="form.price" class="w-full" placeholder="1 200 000" />
          </UFormField>

          <UFormField label="Валюта">
            <UInput v-model="form.currency" class="w-full" placeholder="сум" />
          </UFormField>

          <UFormField label="Период" class="col-span-2">
            <UInput v-model="form.period" class="w-full" placeholder="в год" />
          </UFormField>

          <UFormField label="Текст кнопки" class="col-span-2" required>
            <UInput v-model="form.cta_text" class="w-full" placeholder="Вступить сейчас" />
          </UFormField>
        </div>

        <UFormField label="Популярный тариф">
          <UToggle v-model="form.is_popular" />
        </UFormField>

        <UDivider label="Возможности" />

        <!-- Features list -->
        <div class="flex flex-col gap-2">
          <div
            v-for="(feature, index) in form.features"
            :key="index"
            class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50"
          >
            <UCheckbox v-model="feature.included" />
            <UInput v-model="feature.text" class="flex-1" size="sm" placeholder="Название возможности" />
            <UButton
              size="xs"
              variant="ghost"
              color="error"
              icon="i-lucide-trash-2"
              @click="removeFeature(index)"
            />
          </div>

          <UButton
            variant="outline"
            icon="i-lucide-plus"
            size="sm"
            class="mt-1"
            @click="addFeature"
          >
            Добавить возможность
          </UButton>
        </div>

        <p v-if="saveError" class="text-sm text-red-500">{{ saveError }}</p>

        <div class="flex gap-3 pt-2">
          <UButton type="submit" :loading="saving" class="flex-1 justify-center">Сохранить</UButton>
          <UButton variant="outline" @click="slideOpen = false">Отмена</UButton>
        </div>
      </form>
    </template>
  </USlideover>
</template>

<script setup lang="ts">
definePageMeta({ middleware: 'auth' })

const { apiFetch } = useApi()

const slideOpen = ref(false)
const saving = ref(false)
const saveError = ref('')

interface Feature { text: string; included: boolean }
interface Plan {
  id: number
  slug: string
  label: string
  price: string | null
  currency: string | null
  period: string | null
  is_popular: boolean
  cta_text: string
  features: Feature[]
  sort_order: number
}

interface FormState {
  id: number
  label: string
  price: string
  currency: string
  period: string
  is_popular: boolean
  cta_text: string
  features: Feature[]
}

const form = ref<FormState | null>(null)

const { data, pending, refresh } = await useAsyncData(
  'admin-membership-plans',
  () => apiFetch<{ data: Plan[] }>('/admin/membership-plans'),
)

const plans = computed(() => data.value?.data ?? [])

function openEdit(plan: Plan) {
  form.value = {
    id:         plan.id,
    label:      plan.label,
    price:      plan.price ?? '',
    currency:   plan.currency ?? '',
    period:     plan.period ?? '',
    is_popular: plan.is_popular,
    cta_text:   plan.cta_text,
    features:   plan.features.map(f => ({ ...f })),
  }
  saveError.value = ''
  slideOpen.value = true
}

function addFeature() {
  form.value?.features.push({ text: '', included: true })
}

function removeFeature(index: number) {
  form.value?.features.splice(index, 1)
}

async function save() {
  if (!form.value) return
  saving.value = true
  saveError.value = ''
  try {
    const body = {
      label:      form.value.label,
      price:      form.value.price || null,
      currency:   form.value.currency || null,
      period:     form.value.period || null,
      is_popular: form.value.is_popular,
      cta_text:   form.value.cta_text,
      features:   form.value.features.filter(f => f.text.trim()),
    }
    await apiFetch(`/admin/membership-plans/${form.value.id}`, { method: 'PUT', body })
    slideOpen.value = false
    await refresh()
  } catch (e: any) {
    saveError.value = e?.data?.message ?? 'Ошибка сохранения'
  } finally {
    saving.value = false
  }
}
</script>
