<template>
  <div v-if="!sent" class="flex flex-col gap-4">
    <div class="flex flex-col gap-1.5">
      <label class="lf-label">{{ $t('lead_form.name') }} <span class="text-red-500">*</span></label>
      <input
        v-model="form.name"
        type="text"
        :placeholder="$t('lead_form.name_placeholder')"
        class="lf-input"
        :class="{ 'lf-input-error': errors.name }"
        @blur="validateName"
      />
      <p v-if="errors.name" class="lf-err">{{ $t('lead_form.err_name') }}</p>
    </div>

    <div class="flex flex-col gap-1.5">
      <label class="lf-label">{{ $t('lead_form.phone') }} <span class="text-red-500">*</span></label>
      <UiPhoneInput
        v-model="form.phone"
        class="lf-input"
        :class="{ 'lf-input-error': errors.phone }"
        @blur="validatePhone"
      />
      <p v-if="errors.phone" class="lf-err">{{ $t('lead_form.err_phone') }}</p>
    </div>

    <div class="flex flex-col gap-1.5">
      <label class="lf-label">{{ $t('lead_form.email') }}</label>
      <input
        v-model="form.email"
        type="email"
        placeholder="email@company.uz"
        class="lf-input"
      />
    </div>

    <p v-if="serverError" class="text-sm text-red-500">{{ serverError }}</p>

    <button
      type="button"
      :disabled="submitting"
      class="w-full py-3.5 rounded-xl font-bold text-sm tracking-wide transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed flex items-center justify-center gap-2"
      :class="submitClass"
      @click="submit('free')"
    >
      <Icon v-if="submitting && lastType === 'free'" name="heroicons:arrow-path" class="w-4 h-4 animate-spin" />
      {{ $t('lead_form.btn_free') }}
    </button>

    <button
      v-if="showDemo"
      type="button"
      :disabled="submitting"
      class="w-full py-3.5 rounded-xl font-bold text-sm tracking-wide border-2 transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed flex items-center justify-center gap-2"
      :class="demoClass"
      @click="submit('demo')"
    >
      <Icon v-if="submitting && lastType === 'demo'" name="heroicons:arrow-path" class="w-4 h-4 animate-spin" />
      {{ $t('lead_form.btn_demo') }}
    </button>

    <p class="text-center text-[11px] text-gray-400">{{ $t('lead_form.disclaimer') }}</p>
  </div>

  <!-- Success -->
  <div v-else class="flex flex-col items-center gap-4 py-4 text-center">
    <div class="w-14 h-14 rounded-full flex items-center justify-center bg-green-100">
      <Icon name="heroicons:check" class="w-7 h-7 text-green-600" />
    </div>
    <div>
      <p class="font-bold text-lg" :class="successTextClass">{{ $t('lead_form.success_title') }}</p>
      <p class="text-sm mt-1" :class="successSubClass">{{ $t('lead_form.success_subtitle') }}</p>
    </div>
  </div>
</template>

<script setup lang="ts">
const props = defineProps<{
  source: string          // page identifier sent to backend: 'tenderzone', 'membership', etc.
  showDemo?: boolean      // show "Запросить демо" button
  dark?: boolean          // dark background variant
  initialType?: 'free' | 'demo'
}>()

const config = useRuntimeConfig()
const { t } = useI18n()

const form = reactive({ name: '', phone: '', email: '' })
const errors = reactive({ name: '', phone: '' })
const submitting = ref(false)
const sent = ref(false)
const serverError = ref('')
const lastType = ref<'free' | 'demo'>(props.initialType ?? 'free')

const submitClass = computed(() =>
  props.dark
    ? 'bg-(--theme-color) text-white hover:brightness-110 active:scale-[0.98]'
    : 'bg-(--theme-color) text-white hover:brightness-110 active:scale-[0.98]'
)
const demoClass = computed(() =>
  props.dark
    ? 'border-(--theme-color) text-(--theme-color) hover:bg-(--theme-color) hover:text-white'
    : 'border-(--theme-color) text-(--theme-color) hover:bg-(--theme-color) hover:text-white'
)
const successTextClass = computed(() => props.dark ? 'text-white' : 'text-gray-900')
const successSubClass  = computed(() => props.dark ? 'text-gray-400' : 'text-gray-500')

function validateName() {
  errors.name = form.name.trim().length < 2 ? t('lead_form.err_name') : ''
}
function validatePhone() {
  errors.phone = !form.phone ? t('lead_form.err_phone') : ''
}

async function submit(type: 'free' | 'demo') {
  validateName()
  validatePhone()
  if (errors.name || errors.phone) return

  lastType.value = type
  submitting.value = true
  serverError.value = ''
  try {
    await $fetch(`${config.public.apiBase}/leads`, {
      method: 'POST',
      body: {
        name:   form.name,
        phone:  form.phone,
        email:  form.email || undefined,
        source: props.source,
        type,
      },
    })
    sent.value = true
  } catch (e: any) {
    const errs = e?.data?.errors
    serverError.value = errs
      ? Object.values(errs).flat().join(' ')
      : e?.data?.message ?? t('lead_form.err_server')
  } finally {
    submitting.value = false
  }
}
</script>

<style scoped>
.lf-label {
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: #6b7280;
}
.lf-input {
  background: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 10px;
  padding: 11px 13px;
  font-size: 14px;
  color: #111827;
  outline: none;
  transition: border-color 0.2s;
  width: 100%;
}
.lf-input:focus { border-color: #D1832C; }
.lf-input-error { border-color: #f87171 !important; }
.lf-err { font-size: 11px; color: #ef4444; }
</style>
