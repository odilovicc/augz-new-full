<template>
    <div>
        <!-- Hero -->
        <div
            class="relative overflow-hidden min-h-[88vh] flex items-center"
            style="background: url('/img/Hero.png') center/cover no-repeat;"
        >
            <div class="relative z-10 container mx-auto px-4 py-20 md:py-28 mr-auto">
                <!-- Breadcrumb -->
                <nav class="flex items-center gap-1.5 text-xs text-gray-400 mb-8">
                    <a href="/" class="hover:text-(--theme-color) transition-colors">{{ t(ui.breadcrumb_home) || 'Главная' }}</a>
                    <span>/</span>
                    <span class="text-gray-700">{{ t(ui.breadcrumb_current) || 'Членство' }}</span>
                </nav>

                <div class="flex flex-col gap-y-5 max-w-xl">
                    <!-- Section label -->
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-0.5 bg-(--theme-color)"></div>
                        <span class="text-xs font-semibold tracking-widest uppercase text-(--theme-color)">{{ t(hero.label) || 'Членство в АУГЗ' }}</span>
                    </div>

                    <!-- Main heading -->
                    <h1 class="text-5xl md:text-[3.5rem] font-black uppercase flex flex-col gap-y-4">
                        <span>{{ t(hero.heading_1) || 'Станьте' }}</span>
                        <span>{{ t(hero.heading_2) || 'Частью' }}</span>
                        <span class="text-(--theme-color)">{{ t(hero.heading_3) || 'Сообщества' }}</span>
                    </h1>

                    <!-- Description -->
                    <p class="text-sm text-gray-500 leading-relaxed md:w-full">
                        {{ t(hero.desc) || 'Более 1000 компаний и специалистов уже используют возможности АУГЗ.' }}
                    </p>

                    <!-- CTA buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 mt-1">
                        <a :href="hero.btn_primary?.href || '#form'"><UiButton class="px-7 py-3 text-sm font-semibold">{{ t(hero.btn_primary?.label) || 'Вступить сейчас' }}</UiButton></a>
                        <a :href="hero.btn_secondary?.href || '#benefits'"><UiButton variant="outlined" class="px-7 py-3 text-sm font-semibold">{{ t(hero.btn_secondary?.label) || 'Узнать подробнее' }}</UiButton></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Преимущества членства -->
        <section id="benefits" class="section bg-[#0f1117]">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl md:text-4xl font-black uppercase text-white mb-10">{{ t(benefitsData.heading) || 'Преимущества членства' }}</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
                    <div
                        v-for="benefit in benefits"
                        :key="benefit.title"
                        class="rounded-xl border border-white/10 bg-white/5 p-4 md:p-6 flex flex-col gap-3"
                    >
                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg flex items-center justify-center shrink-0" :class="benefit.iconBg">
                            <Icon :name="benefit.icon" class="text-base md:text-xl text-white" />
                        </div>
                        <div>
                            <p class="text-sm md:text-base font-semibold text-white mb-1 leading-tight">{{ benefit.title }}</p>
                            <p class="text-xs md:text-sm text-gray-400 leading-relaxed">{{ benefit.description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Кто может вступить -->
        <section class="section bg-white border-y border-gray-100">
            <div class="container mx-auto px-4">
                <div class="mb-10">
                    <p class="text-xs font-semibold tracking-widest uppercase text-(--theme-color) mb-3">Членство</p>
                    <h2 class="text-3xl md:text-4xl font-black uppercase text-gray-900">{{ t(memberTypesData.heading) || 'Кто может вступить' }}</h2>
                </div>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
                    <div
                        v-for="type in memberTypes"
                        :key="type.title"
                        class="group rounded-2xl border border-gray-100 bg-gray-50 hover:bg-white hover:border-(--theme-color)/30 hover:shadow-md p-5 md:p-6 flex flex-col gap-4 transition-all duration-300"
                    >
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-orange-50 shrink-0 group-hover:bg-(--theme-color)/10 transition-colors">
                            <Icon :name="type.icon" class="text-xl text-(--theme-color)" />
                        </div>
                        <div>
                            <p class="text-sm md:text-base font-bold text-gray-900 mb-1 leading-tight">{{ type.title }}</p>
                            <p class="text-xs md:text-sm text-gray-500 leading-relaxed">{{ type.description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Подать заявку -->
        <section id="form" class="relative bg-[#0f1117] overflow-hidden">
            <!-- Diagonal cut top -->
            <div class="absolute top-0 left-0 right-0 h-16 bg-[#f7f7f8]" style="clip-path: polygon(0 0, 100% 0, 100% 0, 0 100%);" />

            <div class="container mx-auto px-4 py-24 md:py-32 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                    <!-- Left: copy -->
                    <div class="flex flex-col gap-8">
                        <div>
                            <p class="text-xs font-bold tracking-widest uppercase text-(--theme-color) mb-4">{{ t(formData.label) || 'Вступление' }}</p>
                            <h2 class="text-4xl md:text-5xl font-black uppercase text-white leading-tight">
                                {{ t(formData.heading) || 'Подайте заявку' }}<br/>
                                <span class="text-(--theme-color)">{{ t(formData.heading_accent) || 'на вступление' }}</span>
                            </h2>
                            <p class="mt-5 text-sm text-gray-400 leading-relaxed max-w-sm">
                                {{ t(formData.desc) || 'Мы свяжемся с вами в течение 24 часов.' }}
                            </p>
                        </div>

                        <!-- Trust signals -->
                        <div class="flex flex-col gap-4">
                            <div v-for="signal in trustSignals" :key="signal.title" class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" :class="signal.bg">
                                    <Icon :name="signal.icon" class="text-lg" :class="signal.color" />
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-white">{{ signal.title }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ signal.subtitle }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Decorative stat -->
                        <div class="flex items-center gap-4 pt-4 border-t border-white/8">
                            <span class="text-5xl font-black text-(--theme-color)">{{ formData.stat_value || '1000+' }}</span>
                            <span class="text-sm text-gray-400 leading-snug">{{ t(formData.stat_label) || 'компаний и специалистов уже в сети АУГЗ' }}</span>
                        </div>
                    </div>

                    <!-- Right: form -->
                    <div class="relative">
                        <!-- Glow behind form -->
                        <div class="absolute -inset-4 rounded-3xl bg-gradient-to-br from-orange-500/8 via-transparent to-transparent blur-2xl pointer-events-none" />

                        <form class="relative bg-[#161b24] border border-white/8 rounded-2xl p-8 flex flex-col gap-5" @submit.prevent="submitApplication">
                            <div class="grid grid-cols-1 gap-5">
                                <!-- Name -->
                                <div class="form-field">
                                    <label class="field-label">{{ t(ui.form_name_label) || 'Ваше имя' }} <span class="text-red-400">*</span></label>
                                    <input
                                        v-model="appForm.name"
                                        type="text"
                                        :placeholder="t(ui.form_name_placeholder) || 'Фамилия Имя Отчество'"
                                        class="field-input"
                                        :class="{ 'field-input-error': fieldErrors.name }"
                                        @blur="validateField('name')"
                                    />
                                    <p v-if="fieldErrors.name" class="field-error">{{ t(ui.err_name) || fieldErrors.name }}</p>
                                </div>

                                <!-- Org -->
                                <div class="form-field">
                                    <label class="field-label">{{ t(ui.form_org_label) || 'Организация' }}</label>
                                    <input v-model="appForm.organization" type="text" :placeholder="t(ui.form_org_placeholder) || 'Название компании или ИП'" class="field-input" />
                                </div>

                                <!-- Phone + Email -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="form-field">
                                        <label class="field-label">{{ t(ui.form_phone_label) || 'Телефон' }} <span class="text-red-400">*</span></label>
                                        <UiPhoneInput
                                            v-model="appForm.phone"
                                            class="field-input"
                                            :class="{ 'field-input-error': fieldErrors.phone }"
                                            @blur="validateField('phone')"
                                        />
                                        <p v-if="fieldErrors.phone" class="field-error">{{ t(ui.err_phone) || fieldErrors.phone }}</p>
                                    </div>
                                    <div class="form-field">
                                        <label class="field-label">{{ t(ui.form_email_label) || 'Email' }} <span class="text-red-400">*</span></label>
                                        <input
                                            v-model="appForm.email"
                                            type="email"
                                            placeholder="email@company.uz"
                                            class="field-input"
                                            :class="{ 'field-input-error': fieldErrors.email }"
                                            @blur="validateField('email')"
                                        />
                                        <p v-if="fieldErrors.email" class="field-error">{{ t(ui.err_email) || fieldErrors.email }}</p>
                                    </div>
                                </div>

                            </div>

                            <!-- General server error -->
                            <p v-if="appError" class="text-sm text-red-400">{{ appError }}</p>

                            <!-- Submit -->
                            <button
                                type="submit"
                                :disabled="appSubmitting || appSent"
                                class="mt-1 w-full py-4 rounded-xl text-sm font-bold tracking-wide transition-all duration-200 flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed"
                                :class="appSent ? 'bg-green-500 text-white' : 'bg-(--theme-color) text-white hover:brightness-110 active:scale-[0.98]'"
                            >
                                <template v-if="appSent">
                                    <Icon name="heroicons:check" class="text-base" />
                                    {{ t(ui.form_sent) || 'Заявка отправлена' }}
                                </template>
                                <template v-else-if="appSubmitting">
                                    <Icon name="heroicons:arrow-path" class="text-base animate-spin" />
                                    {{ t(ui.form_sending) || 'Отправка...' }}
                                </template>
                                <template v-else>
                                    {{ t(ui.form_submit) || 'Отправить заявку' }}
                                    <Icon name="heroicons:arrow-right" class="text-base" />
                                </template>
                            </button>

                            <p class="text-center text-[11px] text-gray-600">
                                {{ t(ui.form_disclaimer) || 'Нажимая кнопку, вы соглашаетесь с политикой конфиденциальности АУГЗ' }}
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Ask question modal -->
        <MembershipAskQuestionModal v-model="askModalOpen" />

        <!-- CTA финальный -->
        <section class="relative overflow-hidden bg-[#0f1117]">
            <!-- Texture lines -->
            <div class="absolute inset-0 cta-grid-texture pointer-events-none opacity-30" />
            <!-- Orange glow center -->
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse 70% 60% at 50% 100%, rgba(209,131,44,0.18) 0%, transparent 70%);" />

            <div class="relative z-10 container mx-auto px-4 py-24 md:py-32 text-center flex flex-col items-center gap-8">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 border border-white/10 bg-white/5 backdrop-blur-sm rounded-full px-5 py-2">
                    <span class="w-2 h-2 rounded-full bg-(--theme-color) animate-pulse" />
                    <span class="text-xs font-semibold tracking-widest uppercase text-gray-300">{{ t(ctaData.badge) || '1000+ членов уже с нами' }}</span>
                </div>

                <!-- Heading -->
                <h2 class="text-5xl md:text-7xl font-black uppercase text-white">
                    <template v-for="(line, i) in (t(ctaData.heading) || 'Готовы стать\nчастью').split('\n')" :key="i">
                        {{ line }}<br v-if="i < (t(ctaData.heading) || 'Готовы стать\nчастью').split('\n').length - 1" />
                    </template>
                    <span class="text-(--theme-color) ml-2"> {{ t(ctaData.accent) || 'АУГЗ?' }}</span>
                </h2>

                <!-- Subtext -->
                <p class="text-sm text-gray-400 leading-relaxed max-w-md">
                    {{ t(ctaData.desc) || 'Вступите сегодня и получите доступ к возможностям, которые помогут вашему бизнесу расти.' }}
                </p>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 mt-2">
                    <a :href="ctaData.btn_primary?.href || '#form'"><UiButton class="px-8 py-3.5 text-sm font-bold">{{ t(ctaData.btn_primary?.label) || 'Вступить в АУГЗ' }}</UiButton></a>
                    <UiButton variant="outlined" class="px-8 py-3.5 text-sm font-bold" @click="askModalOpen = true">{{ t(ctaData.btn_secondary?.label) || 'Задать вопрос' }}</UiButton>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
.form-field {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.field-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #6b7280;
}
.field-input {
    background: #0f1117;
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 10px;
    padding: 12px 14px;
    font-size: 14px;
    color: #fff;
    outline: none;
    transition: border-color 0.2s;
    width: 100%;
}
.field-input::placeholder {
    color: #374151;
}
.field-input:focus {
    border-color: #D1832C;
}
.field-input-error {
    border-color: #f87171 !important;
}
.field-error {
    font-size: 11px;
    color: #f87171;
    margin-top: 4px;
}
.field-input option {
    background: #161b24;
    color: #fff;
}
.cta-grid-texture {
    background-image:
        linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
    background-size: 60px 60px;
}
</style>

<script setup lang="ts">
const config = useRuntimeConfig()
const askModalOpen = ref(false)

const { data: pageData } = await useFetch<{ content: any }>(
    `${config.public.apiBase}/page/membership`,
)
const pc = computed(() => pageData.value?.content ?? {})

const hero            = computed(() => pc.value.hero         ?? {})
const benefitsData    = computed(() => pc.value.benefits    ?? {})
const memberTypesData = computed(() => pc.value.member_types ?? {})
const formData        = computed(() => pc.value.form         ?? {})
const ctaData         = computed(() => pc.value.cta          ?? {})
const ui              = computed(() => pc.value.ui           ?? {})

const { locale } = useI18n()

function t(obj: any): string {
    if (!obj) return ''
    const lang = locale.value as string
    return obj[lang] ?? obj.ru ?? obj.uz ?? obj.en ?? ''
}

const appForm = reactive({ name: '', organization: '', phone: '', email: '' })

// ── Validation ───────────────────────────────────────────────
const fieldErrors = reactive<Record<string, string>>({ name: '', phone: '', email: '' })

function validateField(field: 'name' | 'phone' | 'email') {
    if (field === 'name') {
        fieldErrors.name = appForm.name.trim().length < 2 ? 'Введите полное имя' : ''
    }
    if (field === 'phone') {
        fieldErrors.phone = !appForm.phone ? 'Введите корректный номер телефона' : ''
    }
    if (field === 'email') {
        const ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(appForm.email)
        fieldErrors.email = appForm.email && !ok ? 'Введите корректный email' : ''
    }
}

function validateAll(): boolean {
    validateField('name')
    validateField('phone')
    validateField('email')
    return !fieldErrors.name && !fieldErrors.phone && !fieldErrors.email
}

// ── Submit ───────────────────────────────────────────────────
const appSubmitting = ref(false)
const appSent = ref(false)
const appError = ref('')

async function submitApplication() {
    if (!validateAll()) return
    appSubmitting.value = true
    appError.value = ''
    try {
        await $fetch(`${config.public.apiBase}/membership-applications`, {
            method: 'POST',
            body: { ...appForm },
        })
        appSent.value = true
        Object.assign(appForm, { name: '', organization: '', phone: '', email: '' })
    } catch (e: any) {
        const errors = e?.data?.errors
        if (errors) {
            appError.value = Object.values(errors).flat().join(' ')
        } else {
            appError.value = e?.data?.message ?? 'Ошибка отправки. Попробуйте позже.'
        }
    } finally {
        appSubmitting.value = false
    }
}



const benefits = computed(() =>
    (benefitsData.value.items ?? []).map((item: any) => ({
        icon:        item.icon,
        iconBg:      item.icon_bg,
        title:       t(item.title),
        description: t(item.description),
    }))
)

const memberTypes = computed(() =>
    (memberTypesData.value.items ?? []).map((item: any) => ({
        icon:        item.icon,
        title:       t(item.title),
        description: t(item.description),
    }))
)

const trustSignals = computed(() =>
    (formData.value.trust_signals ?? []).map((s: any) => ({
        icon:     s.icon,
        bg:       s.bg,
        color:    s.color,
        title:    t(s.title),
        subtitle: t(s.subtitle),
    }))
)
</script>
