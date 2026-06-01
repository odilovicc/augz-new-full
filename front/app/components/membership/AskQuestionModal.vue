<template>
  <Teleport to="body">
    <Transition name="modal">
      <div
        v-if="modelValue"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        @keydown.esc="$emit('update:modelValue', false)"
      >
        <!-- Backdrop -->
        <div
          class="absolute inset-0 bg-black/70 backdrop-blur-sm"
          @click="$emit('update:modelValue', false)"
        />

        <!-- Modal panel -->
        <div class="relative z-10 w-full max-w-lg rounded-2xl overflow-hidden shadow-2xl" style="background: #0f1117; border: 1px solid rgba(255,255,255,0.08);">

          <!-- Close button -->
          <button
            class="absolute top-4 right-4 z-20 w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:text-white hover:bg-white/10 transition-colors"
            @click="$emit('update:modelValue', false)"
          >
            <Icon name="heroicons:x-mark" class="w-5 h-5" />
          </button>

          <!-- Form state -->
          <div v-if="!sent" class="p-8 flex flex-col gap-5">
            <div class="flex flex-col gap-1">
              <p class="text-xs font-bold tracking-widest uppercase text-(--theme-color)">{{ txt('support_label') }}</p>
              <h2 class="text-3xl font-black uppercase text-white leading-tight">{{ txt('title') }}</h2>
              <p class="text-sm text-gray-400 mt-1">{{ txt('subtitle') }}</p>
            </div>

            <!-- Trust badges -->
            <div class="flex flex-wrap gap-2">
              <div class="flex items-center gap-1.5 bg-white/5 border border-white/8 rounded-lg px-3 py-1.5">
                <Icon name="heroicons:clock" class="w-3.5 h-3.5 text-(--theme-color)" />
                <span class="text-xs text-gray-300 font-medium">{{ txt('badge_time') }}</span>
              </div>
              <div class="flex items-center gap-1.5 bg-white/5 border border-white/8 rounded-lg px-3 py-1.5">
                <Icon name="heroicons:gift" class="w-3.5 h-3.5 text-(--theme-color)" />
                <span class="text-xs text-gray-300 font-medium">{{ txt('badge_free') }}</span>
              </div>
              <div class="flex items-center gap-1.5 bg-white/5 border border-white/8 rounded-lg px-3 py-1.5">
                <Icon name="heroicons:academic-cap" class="w-3.5 h-3.5 text-(--theme-color)" />
                <span class="text-xs text-gray-300 font-medium">{{ txt('badge_experts') }}</span>
              </div>
            </div>

            <!-- Category chips -->
            <div class="flex flex-col gap-2">
              <p class="text-[11px] font-bold tracking-widest uppercase text-gray-500">{{ txt('category_label') }}</p>
              <div class="flex flex-wrap gap-2">
                <button
                  v-for="(cat, i) in categories"
                  :key="i"
                  type="button"
                  class="px-3 py-1.5 rounded-full text-xs font-semibold border transition-all duration-150"
                  :class="selectedCategoryIndex === i
                    ? 'bg-(--theme-color) border-(--theme-color) text-white'
                    : 'border-white/15 text-gray-400 hover:border-white/30 hover:text-white'"
                  @click="selectedCategoryIndex = i"
                >
                  {{ cat }}
                </button>
              </div>
            </div>

            <!-- Fields -->
            <div class="grid grid-cols-2 gap-4">
              <div class="flex flex-col gap-1.5">
                <label class="q-label">{{ txt('label_name') }} <span class="text-red-400">*</span></label>
                <input
                  v-model="form.name"
                  type="text"
                  :placeholder="txt('label_name')"
                  class="q-input"
                  :class="{ 'q-input-error': errors.name }"
                  @blur="validateName"
                />
                <p v-if="errors.name" class="q-err">{{ $t('ask_modal.err_name') }}</p>
              </div>
              <div class="flex flex-col gap-1.5">
                <label class="q-label">{{ txt('label_phone') }} <span class="text-red-400">*</span></label>
                <UiPhoneInput
                  v-model="form.phone"
                  class="q-input"
                  :class="{ 'q-input-error': errors.phone }"
                  @blur="validatePhone"
                />
                <p v-if="errors.phone" class="q-err">{{ $t('ask_modal.err_phone') }}</p>
              </div>
            </div>

            <div class="flex flex-col gap-1.5">
              <label class="q-label">{{ txt('label_email') }}</label>
              <input v-model="form.email" type="email" placeholder="email@company.uz" class="q-input" />
            </div>

            <div class="flex flex-col gap-1.5">
              <label class="q-label">{{ txt('label_question') }} <span class="text-red-400">*</span></label>
              <textarea
                v-model="form.question"
                rows="3"
                :placeholder="txt('label_question')"
                class="q-input resize-none"
                :class="{ 'q-input-error': errors.question }"
                @blur="validateQuestion"
              />
              <p v-if="errors.question" class="q-err">{{ $t('ask_modal.err_question') }}</p>
            </div>

            <p v-if="serverError" class="text-sm text-red-400">{{ serverError }}</p>

            <button
              type="button"
              :disabled="submitting"
              class="w-full py-3.5 rounded-xl bg-(--theme-color) text-white text-sm font-bold tracking-wide hover:brightness-110 active:scale-[0.98] transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed flex items-center justify-center gap-2"
              @click="submit"
            >
              <Icon v-if="submitting" name="heroicons:arrow-path" class="w-4 h-4 animate-spin" />
              <span>{{ submitting ? $t('ask_modal.btn_submitting') : txt('btn_submit') }}</span>
            </button>

            <p class="text-center text-[11px] text-gray-600">{{ txt('disclaimer') }}</p>
          </div>

          <!-- Success state -->
          <div v-else class="p-8 flex flex-col items-center gap-6 text-center" style="background: linear-gradient(135deg, #0f1117 0%, #0c2a1a 100%);">
            <div class="w-20 h-20 rounded-full flex items-center justify-center" style="background: rgba(34,197,94,0.15); border: 2px solid rgba(34,197,94,0.3);">
              <Icon name="heroicons:check" class="w-10 h-10 text-green-400" />
            </div>

            <div class="flex flex-col gap-2">
              <h2 class="text-3xl font-black uppercase text-white">{{ txt('success_title') }}</h2>
              <p class="text-sm text-gray-400 leading-relaxed max-w-xs mx-auto">{{ txt('success_subtitle') }}</p>
            </div>

            <div class="w-full flex flex-col gap-3 bg-white/5 border border-white/8 rounded-xl p-5">
              <p class="text-xs font-bold tracking-widest uppercase text-gray-500 text-left">{{ txt('contacts_label') }}</p>
              <div class="flex flex-col gap-2.5">
                <div class="flex items-center gap-3">
                  <div class="w-7 h-7 rounded-lg bg-green-500/10 flex items-center justify-center shrink-0">
                    <Icon name="heroicons:envelope" class="w-3.5 h-3.5 text-green-400" />
                  </div>
                  <span class="text-sm text-gray-300">{{ settings.contacts.email }}</span>
                </div>
                <div class="flex items-center gap-3">
                  <div class="w-7 h-7 rounded-lg bg-sky-500/10 flex items-center justify-center shrink-0">
                    <Icon name="simple-icons:telegram" class="w-3.5 h-3.5 text-sky-400" />
                  </div>
                  <span class="text-sm text-gray-300">{{ settings.contacts.telegram }}</span>
                </div>
                <div class="flex items-center gap-3">
                  <div class="w-7 h-7 rounded-lg bg-orange-500/10 flex items-center justify-center shrink-0">
                    <Icon name="heroicons:clock" class="w-3.5 h-3.5 text-(--theme-color)" />
                  </div>
                  <span class="text-sm text-gray-300">{{ txt('working_hours') }}</span>
                </div>
              </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 w-full">
              <NuxtLink
                :to="modal.btn_join_href || '/membership'"
                class="flex-1 py-3 rounded-xl bg-(--theme-color) text-white text-sm font-bold flex items-center justify-center gap-2 hover:brightness-110 transition-all"
                @click="$emit('update:modelValue', false)"
              >
                {{ txt('btn_join') }}
                <Icon name="heroicons:arrow-right" class="w-4 h-4" />
              </NuxtLink>
              <button
                type="button"
                class="flex-1 py-3 rounded-xl border border-white/15 text-white text-sm font-bold hover:bg-white/5 transition-all"
                @click="$emit('update:modelValue', false)"
              >
                {{ txt('btn_close') }}
              </button>
            </div>
          </div>

        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<style scoped>
.q-label {
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: #6b7280;
}
.q-input {
  background: #161b24;
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: 10px;
  padding: 11px 13px;
  font-size: 14px;
  color: #fff;
  outline: none;
  transition: border-color 0.2s;
  width: 100%;
}
.q-input::placeholder { color: #374151; }
.q-input:focus { border-color: #D1832C; }
.q-input-error { border-color: #f87171 !important; }
.q-err { font-size: 11px; color: #f87171; }

.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.2s ease;
}
.modal-enter-active .relative,
.modal-leave-active .relative {
  transition: transform 0.2s ease, opacity 0.2s ease;
}
.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}
.modal-enter-from .relative {
  transform: scale(0.95) translateY(8px);
  opacity: 0;
}
.modal-leave-to .relative {
  transform: scale(0.95) translateY(8px);
  opacity: 0;
}
</style>

<script setup lang="ts">
defineProps<{ modelValue: boolean }>()
defineEmits<{ (e: 'update:modelValue', val: boolean): void }>()

const { t, locale } = useI18n()
const config   = useRuntimeConfig()
const settings = useSettings()

// Page content from API (loaded in parent membership/index.vue)
const { data: pageData } = await useFetch<{ content: any }>(
  `${config.public.apiBase}/page/membership`,
)
const modal = computed(() => pageData.value?.content?.ask_modal ?? {})

// Helper: picks locale from API object, falls back to $t()
function txt(key: string): string {
  const field = modal.value[key]
  if (field && typeof field === 'object') {
    const lang = locale.value as string
    return field[lang] ?? field.ru ?? field.uz ?? field.en ?? t(`ask_modal.${key}`)
  }
  return t(`ask_modal.${key}`)
}

// Category chips — from API array of i18n objects, fallback to $t array
const categories = computed((): string[] => {
  const apiCats = modal.value.categories
  if (Array.isArray(apiCats) && apiCats.length) {
    const lang = locale.value as string
    return apiCats.map((c: any) => (typeof c === 'object' ? (c[lang] ?? c.ru ?? '') : c))
  }
  return t('ask_modal.categories') as unknown as string[]
})

const selectedCategoryIndex = ref(0)

const form = reactive({ name: '', phone: '', email: '', question: '' })
const errors = reactive({ name: '', phone: '', question: '' })
const submitting = ref(false)
const sent = ref(false)
const serverError = ref('')

function validateName() {
  errors.name = form.name.trim().length < 2 ? t('ask_modal.err_name') : ''
}
function validatePhone() {
  errors.phone = !form.phone ? t('ask_modal.err_phone') : ''
}
function validateQuestion() {
  errors.question = form.question.trim().length < 5 ? t('ask_modal.err_question') : ''
}

async function submit() {
  validateName()
  validatePhone()
  validateQuestion()
  if (errors.name || errors.phone || errors.question) return

  submitting.value = true
  serverError.value = ''
  try {
    const cats = categories.value
    await $fetch(`${config.public.apiBase}/questions`, {
      method: 'POST',
      body: {
        name: form.name,
        phone: form.phone,
        email: form.email || undefined,
        category: cats[selectedCategoryIndex.value] ?? 'Другое',
        question: form.question,
      },
    })
    sent.value = true
  } catch (e: any) {
    const errs = e?.data?.errors
    serverError.value = errs
      ? Object.values(errs).flat().join(' ')
      : e?.data?.message ?? t('ask_modal.err_question')
  } finally {
    submitting.value = false
  }
}
</script>
