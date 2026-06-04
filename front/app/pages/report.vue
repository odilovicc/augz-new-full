<template>
  <div class="min-h-screen bg-[#f5f4f2]">

    <!-- ─── TOP BAR ─── -->
    <div class="bg-[#1a2236] text-white">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-14">
        <div class="flex items-center gap-2">
          <span class="w-4 h-px bg-(--theme-color)" />
          <span class="text-[11px] font-bold tracking-widest uppercase text-(--theme-color)">{{ t(c?.hero?.badge) }}</span>
        </div>
        <button
          class="w-8 h-8 rounded-full border border-white/25 flex items-center justify-center text-white/60 hover:text-white hover:border-white/50 transition"
          @click="$router.back()"
        >
          <Icon name="heroicons:x-mark" class="w-4 h-4" />
        </button>
      </div>
    </div>

    <!-- ─── HERO BANNER ─── -->
    <div class="bg-[#1a2236] text-white">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-0 lg:pt-14">
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black uppercase tracking-tight leading-none mb-3">
          {{ t(c?.hero?.title) }} <span class="text-(--theme-color)">АУГЗ</span>
        </h1>
        <p class="text-sm lg:text-base text-white/50 mb-8">{{ t(c?.hero?.subtitle) }}</p>

        <!-- ─── TABS ─── -->
        <div class="flex gap-1">
          <button
            v-for="tab in tabs"
            :key="tab.key"
            class="flex items-center gap-2 px-5 py-3 text-sm font-semibold rounded-t-xl transition-colors"
            :class="
              activeTab === tab.key
                ? 'bg-[#f5f4f2] text-gray-900'
                : 'text-white/60 hover:text-white hover:bg-white/10'
            "
            @click="activeTab = tab.key"
          >
            <Icon :name="tab.icon" class="w-4 h-4" />
            {{ tab.label }}
          </button>
        </div>
      </div>
    </div>

    <!-- ─── MAIN CONTENT ─── -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">

      <!-- ══════════════════════════════════════
           TAB 1 — ПОДАТЬ ЖАЛОБУ
      ══════════════════════════════════════ -->
      <div v-show="activeTab === 'submit'">

        <!-- Steps progress -->
        <div class="bg-white rounded-2xl border border-gray-200 px-5 py-4 mb-6 overflow-x-auto no-scrollbar">
          <div class="flex items-center gap-0 min-w-max">
            <template v-for="(step, i) in (formSteps as Step[])" :key="step.label">
              <div class="flex items-center gap-2 shrink-0">
                <div
                  class="w-6 h-6 rounded-full flex items-center justify-center text-[11px] font-bold shrink-0"
                  :class="
                    step.status === 'done'   ? 'bg-green-500 text-white'
                    : step.status === 'active' ? 'bg-(--theme-color) text-white'
                    : 'bg-gray-100 text-gray-400'
                  "
                >
                  <Icon v-if="step.status === 'done'" name="heroicons:check" class="w-3 h-3" />
                  <span v-else>{{ (i as number) + 1 }}</span>
                </div>
                <span
                  class="text-xs font-medium whitespace-nowrap"
                  :class="
                    step.status === 'done'   ? 'text-green-600'
                    : step.status === 'active' ? 'text-gray-900 font-bold'
                    : 'text-gray-400'
                  "
                >{{ step.label }}</span>
              </div>
              <div v-if="(i as number) < formSteps.length - 1" class="w-8 lg:w-12 h-px bg-gray-200 mx-2 shrink-0" />
            </template>
          </div>
        </div>

        <div class="lg:grid lg:grid-cols-[1fr_2fr] lg:gap-10 xl:gap-16">

          <!-- LEFT SIDEBAR -->
          <aside class="hidden lg:flex flex-col gap-6">
            <div class="rounded-2xl border border-blue-100 bg-blue-50 p-5">
              <div class="flex items-start gap-3 mb-3">
                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                  <Icon name="ph:info" class="w-4 h-4 text-blue-600" />
                </div>
                <p class="text-sm font-semibold text-blue-900 leading-snug">{{ t(c?.sidebar?.info_title) }}</p>
              </div>
              <ul class="space-y-2.5 text-sm text-blue-800/80">
                <li v-for="(item, i) in c?.sidebar?.info_items" :key="i" class="flex items-start gap-2">
                  <span class="w-1.5 h-1.5 rounded-full bg-blue-400 mt-1.5 shrink-0" />
                  {{ t(item) }}
                </li>
              </ul>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 space-y-4">
              <p class="text-xs font-bold uppercase tracking-widest text-gray-400">{{ $t('report_page.stats_title') }}</p>
              <div v-for="(stat, i) in c?.sidebar?.stats" :key="i" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-orange-50 flex items-center justify-center shrink-0">
                  <Icon :name="stat.icon" class="w-4 h-4 text-(--theme-color)" />
                </div>
                <div>
                  <p class="text-lg font-black text-gray-900 leading-none">
                    {{ stat.dynamic ? (complaintStats?.total ?? 0) : stat.value }}
                  </p>
                  <p class="text-xs text-gray-400 mt-0.5">{{ t(stat.label) }}</p>
                </div>
              </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5">
              <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3">{{ $t('report_page.need_help') }}</p>
              <a :href="`tel:${phoneRaw}`" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-lg bg-orange-50 flex items-center justify-center shrink-0 group-hover:bg-(--theme-color) transition">
                  <Icon name="ph:phone" class="w-4 h-4 text-(--theme-color) group-hover:text-white transition" />
                </div>
                <div>
                  <p class="text-sm font-bold text-gray-900">{{ settings.contacts.phone }}</p>
                  <p class="text-xs text-gray-400">{{ hoursLabel }}</p>
                </div>
              </a>
            </div>
          </aside>

          <!-- FORM -->
          <div>
            <div class="lg:hidden rounded-xl border border-blue-100 bg-blue-50/70 p-4 mb-6 text-sm text-blue-800 leading-relaxed">
              {{ t(c?.info_banner?.text) }}&nbsp;<strong>{{ t(c?.info_banner?.days) }}</strong>&nbsp;
              {{ t(c?.info_banner?.after_text) }}&nbsp;<strong>{{ t(c?.info_banner?.track_word) }}</strong>&nbsp;{{ t(c?.info_banner?.suffix) }}
            </div>

            <form class="space-y-6" @submit.prevent="submitComplaint">

              <!-- Block 1 -->
              <div class="bg-white rounded-2xl border border-gray-200 p-5 sm:p-6 lg:p-8">
                <div class="flex items-center gap-3 mb-6">
                  <div class="w-8 h-8 rounded-full bg-(--theme-color) text-white text-sm font-bold flex items-center justify-center shrink-0">1</div>
                  <h2 class="text-base lg:text-lg font-bold text-gray-900">{{ t(c?.form?.section1_title) }}</h2>
                </div>
                <div class="space-y-5">
                  <div>
                    <label class="field-label">{{ t(c?.form?.label_org) }}</label>
                    <input v-model="form.organization" type="text" :placeholder="t(c?.form?.placeholder_org)" :class="['field', fieldErrors.organization && 'border-red-400']" @input="delete fieldErrors.organization" />
                    <p v-if="fieldErrors.organization" class="field-error">{{ fieldErrors.organization }}</p>
                  </div>
                  <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                      <label class="field-label">{{ t(c?.form?.label_tender) }}</label>
                      <input v-model="form.tenderNumber" type="text" :placeholder="t(c?.form?.placeholder_tender)" :class="['field', fieldErrors.tender_number && 'border-red-400']" @input="delete fieldErrors.tender_number" />
                      <p v-if="fieldErrors.tender_number" class="field-error">{{ fieldErrors.tender_number }}</p>
                    </div>
                    <div>
                      <label class="field-label">{{ t(c?.form?.label_date) }}</label>
                      <input v-model="form.date" type="date" class="field" />
                    </div>
                  </div>
                  <div>
                    <label class="field-label">{{ t(c?.form?.label_desc) }} <span class="text-red-500">*</span></label>
                    <textarea v-model="form.description" rows="5" :placeholder="t(c?.form?.placeholder_desc)" :class="['field resize-none', fieldErrors.description && 'border-red-400']" @input="delete fieldErrors.description" />
                    <div class="flex items-center justify-between mt-1">
                      <p v-if="fieldErrors.description" class="field-error">{{ fieldErrors.description }}</p>
                      <p v-else class="text-xs text-gray-400" :class="form.description.trim().length < 10 && form.description.length > 0 ? 'text-red-400' : ''">
                        {{ form.description.trim().length }}<span class="opacity-50">{{ $t('report_page.char_min') }}</span>
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Block 2 -->
              <div class="bg-white rounded-2xl border border-gray-200 p-5 sm:p-6 lg:p-8">
                <div class="flex items-center gap-3 mb-6">
                  <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 text-sm font-bold flex items-center justify-center shrink-0">2</div>
                  <h2 class="text-base lg:text-lg font-bold text-gray-900">{{ t(c?.form?.section2_title) }}</h2>
                  <span class="text-xs text-gray-400 font-medium">{{ t(c?.form?.section2_optional) }}</span>
                </div>
                <div
                  class="rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 py-12 px-6 flex flex-col items-center gap-4 cursor-pointer hover:border-(--theme-color)/50 hover:bg-orange-50/20 transition-colors"
                  @click="triggerFileInput"
                  @dragover.prevent
                  @drop.prevent="handleDrop"
                >
                  <div class="w-12 h-12 rounded-full bg-gray-200/80 flex items-center justify-center">
                    <Icon name="ph:paperclip" class="w-6 h-6 text-gray-400" />
                  </div>
                  <div class="text-center">
                    <p class="text-sm font-semibold text-gray-700">{{ t(c?.form?.upload_title) }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ t(c?.form?.upload_hint) }}</p>
                    <p class="mt-2 inline-block text-[11px] text-gray-400 bg-gray-200/60 rounded px-2.5 py-1">
                      {{ t(c?.form?.upload_formats) }}
                    </p>
                  </div>
                  <input ref="fileInputRef" type="file" class="hidden" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" @change="handleFileChange" />
                </div>
                <p v-if="fieldErrors.attachments" class="mt-2 field-error">{{ fieldErrors.attachments }}</p>
                <div v-if="uploadedFiles.length" class="mt-4 grid sm:grid-cols-2 gap-2">
                  <div v-for="(file, i) in uploadedFiles" :key="i" class="flex items-center justify-between rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5">
                    <div class="flex items-center gap-2 min-w-0">
                      <Icon name="ph:file-text" class="w-4 h-4 text-gray-400 shrink-0" />
                      <span class="text-xs text-gray-700 truncate">{{ file.name }}</span>
                    </div>
                    <button type="button" class="text-gray-300 hover:text-red-500 transition shrink-0 ml-2" @click="removeFile(i)">
                      <Icon name="heroicons:x-mark" class="w-4 h-4" />
                    </button>
                  </div>
                </div>
              </div>

              <!-- Block 3 -->
              <div class="bg-white rounded-2xl border border-gray-200 p-5 sm:p-6 lg:p-8">
                <div class="flex items-center gap-3 mb-6">
                  <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 text-sm font-bold flex items-center justify-center shrink-0">3</div>
                  <h2 class="text-base lg:text-lg font-bold text-gray-900">{{ t(c?.form?.section3_title) }}</h2>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 px-5 py-4 flex items-center justify-between mb-6">
                  <div>
                    <p class="text-sm font-semibold text-gray-900">{{ t(c?.form?.anon_label) }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ t(c?.form?.anon_hint) }}</p>
                  </div>
                  <button
                    type="button"
                    class="relative w-11 h-6 rounded-full transition-colors duration-200 focus:outline-none shrink-0 ml-4"
                    :class="form.anonymous ? 'bg-(--theme-color)' : 'bg-gray-300'"
                    @click="form.anonymous = !form.anonymous"
                  >
                    <span
                      class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform duration-200"
                      :class="form.anonymous ? 'translate-x-5' : 'translate-x-0'"
                    />
                  </button>
                </div>
                <Transition name="fade">
                  <div v-if="!form.anonymous" class="space-y-5">
                    <div class="grid sm:grid-cols-2 gap-4">
                      <div>
                        <label class="field-label">{{ t(c?.form?.label_name) }} <span class="text-red-500">*</span></label>
                        <input v-model="form.name" type="text" :placeholder="t(c?.form?.placeholder_name)" :class="['field', fieldErrors.name && 'border-red-400']" @input="delete fieldErrors.name" />
                        <p v-if="fieldErrors.name" class="field-error">{{ fieldErrors.name }}</p>
                      </div>
                      <div>
                        <label class="field-label">{{ t(c?.form?.label_sender_org) }}</label>
                        <input v-model="form.senderOrg" type="text" :placeholder="t(c?.form?.placeholder_sender_org)" class="field" />
                      </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                      <div>
                        <label class="field-label">{{ t(c?.form?.label_phone) }} <span class="text-red-500">*</span></label>
                        <UiPhoneInput v-model="form.phone" :class="['field', fieldErrors.phone && 'border-red-400']" @blur="onPhoneBlur" />
                        <p v-if="fieldErrors.phone" class="field-error">{{ fieldErrors.phone }}</p>
                      </div>
                      <div>
                        <label class="field-label">{{ t(c?.form?.label_email) }}</label>
                        <input v-model="form.email" type="email" placeholder="example@mail.com" :class="['field', fieldErrors.email && 'border-red-400']" @input="delete fieldErrors.email" />
                        <p v-if="fieldErrors.email" class="field-error">{{ fieldErrors.email }}</p>
                      </div>
                    </div>
                  </div>
                </Transition>
                <div class="mt-6 flex items-start gap-3">
                  <button
                    type="button"
                    class="mt-0.5 w-4 h-4 shrink-0 rounded border-2 flex items-center justify-center transition"
                    :class="form.agree ? 'bg-(--theme-color) border-(--theme-color)' : 'border-gray-300 bg-white'"
                    @click="form.agree = !form.agree"
                  >
                    <Icon v-if="form.agree" name="heroicons:check" class="w-2.5 h-2.5 text-white" />
                  </button>
                  <p class="text-xs text-gray-500 leading-relaxed">
                    {{ t(c?.form?.agree_text) }}
                    <NuxtLink :to="localePath('/privacy')" class="text-(--theme-color) underline underline-offset-2 hover:no-underline">{{ t(c?.form?.agree_privacy) }}</NuxtLink>
                    {{ t(c?.form?.agree_and) }}
                    <NuxtLink :to="localePath('/appeals-rules')" class="text-(--theme-color) underline underline-offset-2 hover:no-underline">{{ t(c?.form?.agree_rules) }}</NuxtLink>
                    АУГЗ
                  </p>
                </div>
              </div>

              <!-- Actions -->
              <p v-if="submitError" class="text-sm text-red-500 font-medium">{{ submitError }}</p>
              <div class="flex flex-col sm:flex-row gap-3">
                <button
                  type="submit"
                  class="flex-1 py-4 rounded-xl bg-(--theme-color) text-white text-sm font-bold hover:brightness-110 active:scale-[0.99] transition-all disabled:opacity-40 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                  :disabled="!canSubmit || submitting"
                >
                  <Icon v-if="submitting" name="ph:spinner" class="w-4 h-4 animate-spin" />
                  {{ t(c?.form?.btn_submit) }}
                </button>
                <a
                  :href="`tel:${phoneRaw}`"
                  class="flex-1 py-4 rounded-xl border-2 border-(--theme-color) text-(--theme-color) text-sm font-bold text-center hover:bg-(--theme-color) hover:text-white transition-all sm:flex-none sm:px-10"
                >
                  {{ t(c?.form?.btn_call) }}
                </a>
              </div>

            </form>
          </div>
        </div>
      </div>

      <!-- ══════════════════════════════════════
           TAB 2 — ОТСЛЕДИТЬ СТАТУС
      ══════════════════════════════════════ -->
      <div v-show="activeTab === 'track'">
        <div class="lg:grid lg:grid-cols-[1fr_2fr] lg:gap-10 xl:gap-16">

          <!-- LEFT SIDEBAR -->
          <aside class="hidden lg:flex flex-col gap-6">
            <div class="rounded-2xl border border-orange-100 bg-orange-50/60 p-5">
              <div class="flex items-start gap-3 mb-3">
                <div class="w-8 h-8 rounded-lg bg-orange-100 flex items-center justify-center shrink-0">
                  <Icon name="ph:magnifying-glass" class="w-4 h-4 text-(--theme-color)" />
                </div>
                <p class="text-sm font-semibold text-gray-800 leading-snug">{{ t(c?.track?.sidebar_title) }}</p>
              </div>
              <ul class="space-y-2.5 text-sm text-gray-600">
                <li v-for="(item, i) in c?.track?.sidebar_items" :key="i" class="flex items-start gap-2">
                  <span class="w-1.5 h-1.5 rounded-full bg-orange-400 mt-1.5 shrink-0" />
                  {{ t(item) }}
                </li>
              </ul>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 space-y-4">
              <p class="text-xs font-bold uppercase tracking-widest text-gray-400">{{ $t('report_page.statuses_title') }}</p>
              <div v-for="(legend, i) in c?.track?.status_legend" :key="i" class="flex items-center gap-3">
                <div class="w-2.5 h-2.5 rounded-full shrink-0" :style="{ backgroundColor: legendColor(legend.color) }" />
                <div>
                  <p class="text-sm font-semibold text-gray-900">{{ t(legend.label) }}</p>
                  <p class="text-xs text-gray-400">{{ t(legend.desc) }}</p>
                </div>
              </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5">
              <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3">{{ $t('report_page.need_help') }}</p>
              <a :href="`tel:${phoneRaw}`" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-lg bg-orange-50 flex items-center justify-center shrink-0 group-hover:bg-(--theme-color) transition">
                  <Icon name="ph:phone" class="w-4 h-4 text-(--theme-color) group-hover:text-white transition" />
                </div>
                <div>
                  <p class="text-sm font-bold text-gray-900">{{ settings.contacts.phone }}</p>
                  <p class="text-xs text-gray-400">{{ hoursLabel }}</p>
                </div>
              </a>
            </div>
          </aside>

          <!-- TRACK CONTENT -->
          <div class="space-y-5">

            <!-- Saved complaints hint -->
            <Transition name="fade">
              <div v-if="savedComplaints.length" class="bg-white rounded-2xl border border-orange-100 p-5">
                <div class="flex items-center gap-2 mb-3">
                  <div class="w-7 h-7 rounded-lg bg-orange-50 flex items-center justify-center shrink-0">
                    <Icon name="ph:bookmark-simple" class="w-4 h-4 text-(--theme-color)" />
                  </div>
                  <p class="text-sm font-bold text-gray-900">{{ $t('report_page.saved_title') }}</p>
                  <span class="text-xs text-gray-400">{{ $t('report_page.saved_hint') }}</span>
                </div>
                <div class="space-y-2">
                  <button
                    v-for="item in savedComplaints"
                    :key="item.track_code"
                    class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl border border-gray-100 hover:border-(--theme-color)/40 hover:bg-orange-50/30 transition-colors group text-left"
                    @click="trackInput = item.track_code; searchTrack()"
                  >
                    <div class="flex items-center gap-2.5 min-w-0">
                      <Icon name="ph:file-text" class="w-4 h-4 text-gray-300 group-hover:text-(--theme-color) transition shrink-0" />
                      <span class="font-mono text-sm font-bold text-gray-800 tracking-wide">{{ item.track_code }}</span>
                    </div>
                    <span class="text-xs text-gray-400 shrink-0">
                      {{ new Date(item.created_at).toLocaleDateString('ru-RU', { day: '2-digit', month: '2-digit', year: 'numeric' }) }}
                    </span>
                  </button>
                </div>
              </div>
            </Transition>

            <!-- Search box -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5 sm:p-6 lg:p-8">
              <h2 class="text-base lg:text-lg font-bold text-gray-900 mb-1">{{ t(c?.track?.search_title) }}</h2>
              <p class="text-sm text-gray-400 mb-5">{{ t(c?.track?.search_hint) }}</p>
              <div class="flex gap-3">
                <input
                  v-model="trackInput"
                  type="text"
                  :placeholder="c?.track?.search_placeholder"
                  class="field flex-1 font-mono text-base tracking-wide uppercase"
                  @keydown.enter="searchTrack"
                />
                <button
                  class="shrink-0 px-6 py-3 rounded-xl bg-(--theme-color) text-white text-sm font-bold hover:brightness-110 active:scale-95 transition disabled:opacity-40 flex items-center gap-2"
                  :disabled="!trackInput.trim() || trackState === 'loading'"
                  @click="searchTrack"
                >
                  <Icon v-if="trackState === 'loading'" name="ph:spinner" class="w-4 h-4 animate-spin" />
                  {{ t(c?.track?.btn_find) }}
                </button>
              </div>
            </div>

            <!-- Empty state -->
            <Transition name="fade">
              <div v-if="trackState === 'idle'" class="bg-white rounded-2xl border border-gray-200 p-10 flex flex-col items-center text-center gap-3">
                <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                  <Icon name="ph:magnifying-glass" class="w-7 h-7 text-gray-300" />
                </div>
                <p class="text-sm font-semibold text-gray-500">{{ t(c?.track?.empty_title) }}</p>
                <p class="text-xs text-gray-400 max-w-xs">{{ t(c?.track?.empty_hint) }}</p>
              </div>
            </Transition>

            <!-- Not found -->
            <Transition name="fade">
              <div v-if="trackState === 'not-found'" class="bg-white rounded-2xl border border-red-100 p-8 flex flex-col items-center text-center gap-3">
                <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center">
                  <Icon name="heroicons:x-mark" class="w-7 h-7 text-red-400" />
                </div>
                <p class="text-base font-bold text-gray-900">{{ t(c?.track?.not_found_title) }}</p>
                <p class="text-sm text-gray-500 max-w-xs">{{ t(c?.track?.not_found_text) }}</p>
                <a :href="`tel:${phoneRaw}`" class="mt-1 text-sm font-semibold text-(--theme-color) hover:underline">{{ settings.contacts.phone }}</a>
              </div>
            </Transition>

            <!-- Result card -->
            <Transition name="fade">
              <div v-if="trackState === 'found' && resolvedTrackResult" class="space-y-4">

                <!-- Status header -->
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                  <div class="px-5 sm:px-8 py-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                      <p class="text-[11px] font-bold uppercase tracking-widest text-gray-400 mb-1">{{ $t('report_page.track_code_label') }}</p>
                      <p class="text-2xl font-black text-gray-900 tracking-wide font-mono">{{ resolvedTrackResult.track_code }}</p>
                    </div>
                    <div
                      class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold self-start sm:self-auto"
                      :class="resolvedTrackResult.statusColor"
                    >
                      <span class="w-2 h-2 rounded-full bg-current opacity-70" />
                      {{ resolvedTrackResult.statusLabel }}
                    </div>
                  </div>

                  <div class="grid sm:grid-cols-2 lg:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-gray-100">
                    <div class="px-5 py-4">
                      <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">{{ t(c?.success_modal?.meta_date) }}</p>
                      <p class="text-sm font-semibold text-gray-900">{{ resolvedTrackResult.submitted }}</p>
                    </div>
                    <div class="px-5 py-4">
                      <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">{{ t(c?.success_modal?.meta_expert) }}</p>
                      <p class="text-sm font-semibold text-gray-900">{{ resolvedTrackResult.expert }}</p>
                    </div>
                    <div class="px-5 py-4">
                      <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">{{ t(c?.success_modal?.meta_deadline) }}</p>
                      <p class="text-sm font-semibold text-gray-900">{{ resolvedTrackResult.deadline }}</p>
                    </div>
                  </div>
                </div>

                <!-- Progress timeline -->
                <div class="bg-white rounded-2xl border border-gray-200 p-5 sm:p-8">
                  <h3 class="text-sm font-bold text-gray-900 mb-6">{{ t(c?.track?.stages_title) }}</h3>
                  <div class="relative">
                    <div class="absolute left-3.5 top-0 bottom-0 w-px bg-gray-200" />
                    <div class="space-y-0">
                      <div v-for="(stage, i) in (resolvedTrackResult.stages as Stage[])" :key="stage.label" class="relative flex gap-5 pb-6 last:pb-0">
                        <div
                          class="relative z-10 w-7 h-7 rounded-full flex items-center justify-center shrink-0 text-xs font-bold border-2"
                          :class="
                            stage.status === 'done'   ? 'bg-green-500 border-green-500 text-white'
                            : stage.status === 'active' ? 'bg-(--theme-color) border-(--theme-color) text-white'
                            : 'bg-white border-gray-300 text-gray-400'
                          "
                        >
                          <Icon v-if="stage.status === 'done'" name="heroicons:check" class="w-3.5 h-3.5" />
                          <span v-else>{{ (i as number) + 1 }}</span>
                        </div>
                        <div class="flex-1 pt-0.5">
                          <div class="flex items-center justify-between gap-3 flex-wrap">
                            <p class="text-sm font-semibold" :class="stage.status === 'pending' ? 'text-gray-400' : 'text-gray-900'">{{ stage.label }}</p>
                            <span v-if="stage.date" class="text-xs text-gray-400">{{ stage.date }}</span>
                            <span v-else-if="stage.eta" class="text-xs text-gray-400 italic">{{ stage.eta }}</span>
                          </div>
                          <p v-if="stage.note" class="text-xs text-gray-500 mt-1 leading-relaxed">{{ stage.note }}</p>
                          <div v-if="stage.files?.length" class="mt-2 flex flex-wrap gap-2">
                            <a
                              v-for="file in stage.files"
                              :key="file.url"
                              :href="file.url"
                              target="_blank"
                              class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-lg border border-gray-200 hover:border-(--theme-color)/50 hover:text-(--theme-color) transition-colors"
                            >
                              <Icon name="ph:paperclip" class="w-3 h-3" />
                              {{ file.name }}
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3">
                  <button
                    class="flex-1 py-4 rounded-xl bg-(--theme-color) text-white text-sm font-bold hover:brightness-110 transition"
                    @click="activeTab = 'submit'"
                  >
                    {{ t(c?.track?.btn_new) }}
                  </button>
                  <a
                    :href="`tel:${phoneRaw}`"
                    class="flex-1 py-4 rounded-xl border-2 border-gray-200 text-gray-700 text-sm font-bold text-center hover:border-gray-300 transition sm:flex-none sm:px-10"
                  >
                    {{ t(c?.track?.btn_call) }}
                  </a>
                </div>

              </div>
            </Transition>

          </div>
        </div>
      </div>
    </div>

    <!-- ─── SUCCESS MODAL ─── -->
    <Teleport to="body">
      <Transition name="modal">
        <div v-if="showSuccess" class="fixed top-20 inset-0 z-50 overflow-y-auto px-4">
          <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showSuccess = false" />
          <div class="relative z-10 w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden mx-auto my-8">

            <div class="bg-[#1e6b45] px-6 pt-7 pb-6 flex flex-col items-center text-center">
              <div class="w-12 h-12 rounded-full border-2 border-white/40 flex items-center justify-center mb-3">
                <Icon name="heroicons:check" class="w-6 h-6 text-white" />
              </div>
              <h2 class="text-xl font-black uppercase text-white tracking-tight leading-tight mb-1">
                {{ t(c?.success_modal?.title) }}
              </h2>
              <p class="text-xs text-white/70">{{ t(c?.success_modal?.subtitle) }}</p>
            </div>

            <div class="px-5 py-5 space-y-3">
              <div class="rounded-xl border border-gray-200 bg-gray-50 p-3.5">
                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">{{ t(c?.success_modal?.track_label) }}</p>
                <div class="flex items-center gap-3">
                  <span class="text-xl font-black text-gray-900 tracking-wide flex-1 font-mono">{{ trackCodeForModal }}</span>
                  <button
                    class="shrink-0 px-3 py-1.5 rounded-lg bg-(--theme-color) text-white text-xs font-bold hover:brightness-110 active:scale-95 transition flex items-center gap-1.5"
                    @click="copyTrackCode"
                  >
                    <Icon name="ph:copy" class="w-3.5 h-3.5" />
                    {{ copied ? t(c?.success_modal?.btn_copied) : t(c?.success_modal?.btn_copy) }}
                  </button>
                </div>
                <p v-if="form.email && !form.anonymous" class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                  <Icon name="ph:envelope" class="w-3.5 h-3.5" />
                  {{ t(c?.success_modal?.email_prefix) }}
                  <span class="text-gray-600 ml-0.5">{{ form.email }}</span>
                </p>
                <p v-else class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                  <Icon name="ph:envelope-slash" class="w-3.5 h-3.5" />
                  {{ $t('report_page.no_email_sent') }}
                </p>
              </div>

              <div class="grid grid-cols-3 gap-2">
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-2.5">
                  <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-1">{{ t(c?.success_modal?.meta_date) }}</p>
                  <p class="text-xs font-semibold text-gray-900">{{ submittedAt }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-2.5">
                  <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-1">{{ t(c?.success_modal?.meta_expert) }}</p>
                  <p class="text-xs font-semibold text-gray-900">{{ t(c?.success_modal?.expert_name) }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-2.5">
                  <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-1">{{ t(c?.success_modal?.meta_deadline) }}</p>
                  <p class="text-xs font-semibold text-gray-900">{{ deadlineAt }}</p>
                </div>
              </div>

              <div class="flex gap-2">
                <button
                  class="flex-1 py-3 rounded-xl bg-(--theme-color) text-white text-sm font-bold hover:brightness-110 transition flex items-center justify-center gap-2"
                  @click="goToTrack"
                >
                  <Icon name="ph:magnifying-glass" class="w-4 h-4" />
                  {{ t(c?.success_modal?.btn_track) }}
                </button>
                <button
                  class="flex-1 py-3 rounded-xl border-2 border-gray-200 text-gray-600 text-sm font-semibold hover:border-gray-300 hover:text-gray-800 transition"
                  @click="showSuccess = false"
                >
                  {{ t(c?.success_modal?.btn_close) }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>

  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: false })

import type { ReportPageContent } from '~/composables/usePageContent'

const config = useRuntimeConfig()
const { data: pageData } = await useFetch<{ slug: string; content: ReportPageContent }>(
  `${config.public.apiBase}/page/report`,
  { key: 'report-page', server: true },
)

const { data: complaintStats, refresh: refreshStats } = await useFetch<{ total: number; launched: string; avg_days: number }>(
  `${config.public.apiBase}/complaints/stats`,
  { key: 'complaint-stats', server: true },
)

const c = computed(() => pageData.value?.content ?? null)
const t = useLocaleText()
const { t: $t, locale } = useI18n()
const settings = useSettings()
const localePath = useLocalePath()
const hoursLabel = useHoursLabel()
const phoneRaw = computed(() => settings.value.contacts.phone.replace(/[\s\-()]/g, ''))

const activeTab = ref<'submit' | 'track'>('submit')

const tabs = computed<{ key: 'submit' | 'track'; label: string; icon: string }[]>(() => [
  { key: 'submit', label: t(c.value?.form?.tabs?.submit) || 'Подать жалобу',    icon: 'ph:paper-plane-tilt' },
  { key: 'track',  label: t(c.value?.form?.tabs?.track)  || 'Отследить статус', icon: 'ph:magnifying-glass' },
])

interface Step { label: string; status: string }
interface ProgressStep { label: string; time: string; status: string }
interface Stage { label: string; status: string; date: string; eta: string; note: string; files: { name: string; url: string; mime: string }[] }

const formSteps = computed<Step[]>(() => {
  const submitted = createdComplaint.value !== null
  const detailsDone  = form.description.trim().length > 0
  const docsDone     = uploadedFiles.value.length > 0
  const contactsDone = form.anonymous || (form.name.trim().length > 0 && form.phone.trim().length > 0)

  const done = [detailsDone, docsDone, contactsDone, submitted]

  function stepStatus(i: number): string {
    if (submitted) return 'done'
    if (done[i]) return 'done'
    if (done.slice(0, i).every(Boolean)) return 'active'
    return 'pending'
  }

  const defaultLabels = ['Детали', 'Документы', 'Контакты', 'Готово']
  const cmsLabels: string[] = (c.value?.form?.steps ?? []).map((step: any) => t(step.label) || '')
  const labels = defaultLabels.map((d, i) => cmsLabels[i] || d)

  return labels.map((label, i) => ({ label, status: stepStatus(i) }))
})

const statusMap = computed<Record<string, { label: string; color: string }>>(() => ({
  new:               { label: $t('report_page.status.new'),               color: 'bg-blue-100 text-blue-700' },
  analyzing:         { label: $t('report_page.status.analyzing'),         color: 'bg-indigo-100 text-indigo-700' },
  investigating:     { label: $t('report_page.status.investigating'),     color: 'bg-violet-100 text-violet-700' },
  forming_response:  { label: $t('report_page.status.forming_response'),  color: 'bg-yellow-100 text-yellow-700' },
  official_response: { label: $t('report_page.status.official_response'), color: 'bg-orange-100 text-orange-700' },
  closed:            { label: $t('report_page.status.closed'),            color: 'bg-green-100 text-green-700' },
}))

const PIPELINE = computed(() => [
  { key: 'new',               label: $t('report_page.pipeline.new_label'),         eta: '',                                         note: $t('report_page.pipeline.new_note') },
  { key: 'analyzing',         label: $t('report_page.pipeline.analyzing_label'),   eta: $t('report_page.pipeline.analyzing_eta'),   note: $t('report_page.pipeline.analyzing_note') },
  { key: 'investigating',     label: $t('report_page.pipeline.investigating_label'), eta: $t('report_page.pipeline.investigating_eta'), note: '' },
  { key: 'forming_response',  label: $t('report_page.pipeline.forming_label'),     eta: $t('report_page.pipeline.forming_eta'),     note: '' },
  { key: 'official_response', label: $t('report_page.pipeline.official_label'),    eta: $t('report_page.pipeline.official_eta'),    note: '' },
  { key: 'closed',            label: $t('report_page.pipeline.closed_label'),      eta: '',                                         note: '' },
])

function buildStages(complaint: any): Stage[] {
  const createdAt = new Date(complaint.created_at)
  const loc = locale.value === 'en' ? 'en-GB' : locale.value === 'uz' ? 'uz-UZ' : 'ru-RU'
  const fmtDay = (d: Date) => d.toLocaleString(loc, { day: 'numeric', month: 'long', year: 'numeric' })
  const addDays = (d: Date, n: number) => { const r = new Date(d); r.setDate(r.getDate() + n); return r }
  const fmt = (d: Date) => d.toLocaleString(loc, { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' })

  const currentIdx = PIPELINE.value.findIndex(p => p.key === complaint.status)

  return PIPELINE.value.map((stage, i) => {
    let status: 'done' | 'active' | 'pending'
    if (i < currentIdx) status = 'done'
    else if (i === currentIdx) status = currentIdx === PIPELINE.length - 1 ? 'done' : 'active'
    else status = 'pending'

    const offsetDays = [0, 1, 3, 7, 10, 12][i] ?? i * 2
    const date = i === 0
      ? fmt(createdAt)
      : (i < currentIdx ? fmtDay(addDays(createdAt, offsetDays)) : '')

    const note = stage.key === 'official_response' && complaint.response_message
      ? complaint.response_message
      : stage.note

    return {
      label: stage.label,
      status,
      date,
      eta: status === 'pending' ? stage.eta : '',
      note,
      files: stage.key === 'official_response' ? (complaint.response_files ?? []) : [],
    }
  })
}

const form = reactive({
  organization: '',
  tenderNumber: '',
  date: '',
  description: '',
  anonymous: false,
  name: '',
  senderOrg: '',
  phone: '',
  email: '',
  agree: false,
})

const uploadedFiles = ref<File[]>([])
const fileInputRef = ref<HTMLInputElement | null>(null)
const showSuccess = ref(false)
const submitting = ref(false)
const submitError = ref('')
const copied = ref(false)
const createdComplaint = ref<any>(null)

const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]+$/

interface FieldErrors {
  description?: string
  organization?: string
  tender_number?: string
  name?: string
  phone?: string
  email?: string
  attachments?: string
}

const fieldErrors = ref<FieldErrors>({})

function validate(): boolean {
  const e: FieldErrors = {}

  if (!form.description.trim())
    e.description = $t('report_page.err_required')
  else if (form.description.trim().length < 10)
    e.description = $t('report_page.err_min10')

  if (form.organization.length > 255)
    e.organization = $t('report_page.err_max255')

  if (form.tenderNumber.length > 100)
    e.tender_number = $t('report_page.err_max100')

  if (!form.anonymous) {
    if (!form.name.trim())
      e.name = $t('report_page.err_required')
    else if (form.name.length > 255)
      e.name = $t('report_page.err_max255')

    if (!form.phone.trim())
      e.phone = $t('report_page.err_required')
    else if (form.phone.length > 50)
      e.phone = $t('report_page.err_max50')

    if (form.email && !EMAIL_RE.test(form.email))
      e.email = $t('report_page.err_email')
    else if (form.email.length > 255)
      e.email = $t('report_page.err_max255')
  }

  if (uploadedFiles.value.length > 5)
    e.attachments = $t('report_page.err_max5files')

  fieldErrors.value = e
  return Object.keys(e).length === 0
}

const canSubmit = computed(() =>
  form.description.trim().length >= 10 &&
  form.agree &&
  (form.anonymous || (form.name.trim() && form.phone.trim()))
)

const progressSteps = computed<ProgressStep[]>(() =>
  (c.value?.success_modal?.progress_steps ?? [
    { label: { ru: 'Принята',  uz: 'Qabul',     en: 'Received' },  time: { ru: 'сейчас',     uz: 'hozir',       en: 'now' } },
    { label: { ru: 'Анализ',   uz: 'Tahlil',    en: 'Analysis' },  time: { ru: '1 день',     uz: '1 kun',       en: '1 day' } },
    { label: { ru: 'Изучение', uz: 'O\'rganish', en: 'Study' },    time: { ru: '3–5 дней',   uz: '3–5 kun',     en: '3–5 days' } },
    { label: { ru: 'Позиция',  uz: 'Pozitsiya', en: 'Position' },  time: { ru: '5–8 дней',   uz: '5–8 kun',     en: '5–8 days' } },
    { label: { ru: 'Ответ',    uz: 'Javob',     en: 'Answer' },    time: { ru: 'до 10 дней', uz: '10 kungacha', en: 'up to 10 days' } },
  ]).map((ps: any, i: number): ProgressStep => ({
    label:  t(ps.label) || ps.label,
    time:   t(ps.time)  || ps.time,
    status: i === 0 ? 'done' : i === 1 ? 'active' : 'pending',
  }))
)

const loc = computed(() => locale.value === 'en' ? 'en-GB' : locale.value === 'uz' ? 'uz-UZ' : 'ru-RU')

const submittedAt = computed(() =>
  createdComplaint.value
    ? new Date(createdComplaint.value.created_at).toLocaleString(loc.value, { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' })
    : new Date().toLocaleString(loc.value, { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' })
)

const deadlineAt = computed(() => {
  const base = createdComplaint.value ? new Date(createdComplaint.value.created_at) : new Date()
  base.setDate(base.getDate() + 10)
  return $t('report_page.deadline_prefix') + base.toLocaleString(loc.value, { day: 'numeric', month: 'long', year: 'numeric' })
})

const trackCodeForModal = computed(() => createdComplaint.value?.track_code ?? '')

function triggerFileInput() { fileInputRef.value?.click() }

function handleFileChange(e: Event) {
  const input = e.target as HTMLInputElement
  if (!input.files) return
  addFiles(Array.from(input.files))
  input.value = ''
}

function handleDrop(e: DragEvent) {
  if (!e.dataTransfer?.files) return
  addFiles(Array.from(e.dataTransfer.files))
}

function addFiles(files: File[]) {
  const remaining = 5 - uploadedFiles.value.length
  uploadedFiles.value.push(...files.slice(0, remaining))
}

function removeFile(i: number) { uploadedFiles.value.splice(i, 1) }

const TAILWIND_COLOR_MAP: Record<string, string> = {
  'bg-blue-400':   '#60a5fa',
  'bg-indigo-400': '#818cf8',
  'bg-violet-400': '#a78bfa',
  'bg-yellow-400': '#facc15',
  'bg-orange-400': '#fb923c',
  'bg-orange-500': '#f97316',
  'bg-green-400':  '#4ade80',
  'bg-green-500':  '#22c55e',
  'bg-red-400':    '#f87171',
}

const legendColor = (cls: string) => TAILWIND_COLOR_MAP[cls?.trim()] ?? '#9ca3af'

function onPhoneBlur() {
  if (!form.phone) fieldErrors.value.phone = $t('report_page.err_required')
}

async function copyTrackCode() {
  if (!trackCodeForModal.value) return
  await navigator.clipboard.writeText(trackCodeForModal.value)
  copied.value = true
  setTimeout(() => { copied.value = false }, 2000)
}

async function submitComplaint() {
  if (!validate() || !canSubmit.value || submitting.value) return
  submitting.value = true
  submitError.value = ''
  try {
    const body = new FormData()
    if (form.organization)  body.append('organization',   form.organization)
    if (form.tenderNumber)  body.append('tender_number',  form.tenderNumber)
    if (form.date)          body.append('violation_date', form.date)
    body.append('description', form.description)
    body.append('anonymous',   form.anonymous ? '1' : '0')
    if (!form.anonymous) {
      if (form.name)      body.append('name',       form.name)
      if (form.senderOrg) body.append('sender_org', form.senderOrg)
      if (form.phone)     body.append('phone',      form.phone)
      if (form.email)     body.append('email',      form.email)
    }
    for (const file of uploadedFiles.value) {
      body.append('attachments[]', file)
    }
    const res = await $fetch<{ data: any }>(`${config.public.apiBase}/complaints`, {
      method: 'POST',
      body,
    })
    createdComplaint.value = res.data
    saveTrackCode(res.data.track_code, res.data.created_at)
    showSuccess.value = true
    refreshStats()
  } catch {
    submitError.value = $t('report_page.err_submit')
  } finally {
    submitting.value = false
  }
}

function goToTrack() {
  showSuccess.value = false
  if (trackCodeForModal.value) {
    trackInput.value = trackCodeForModal.value
    activeTab.value = 'track'
    searchTrack()
  }
}

// ── Saved complaints (localStorage) ──
const LS_KEY = 'augz_complaints'

interface SavedComplaint { track_code: string; created_at: string }

const savedComplaints = ref<SavedComplaint[]>([])

function loadSaved() {
  if (import.meta.client) {
    try {
      savedComplaints.value = JSON.parse(localStorage.getItem(LS_KEY) ?? '[]')
    } catch { savedComplaints.value = [] }
  }
}

function saveTrackCode(track_code: string, created_at: string) {
  if (!import.meta.client) return
  const list: SavedComplaint[] = JSON.parse(localStorage.getItem(LS_KEY) ?? '[]')
  if (!list.find(x => x.track_code === track_code)) {
    list.unshift({ track_code, created_at })
    localStorage.setItem(LS_KEY, JSON.stringify(list.slice(0, 20)))
    savedComplaints.value = list.slice(0, 20)
  }
}

onMounted(loadSaved)

// ── Track ──
const trackInput = ref('')
const trackState = ref<'idle' | 'found' | 'not-found' | 'loading'>('idle')
const trackResult = ref<any>(null)

async function searchTrack() {
  const code = trackInput.value.trim().toUpperCase()
  if (!code) return
  trackState.value = 'loading'
  try {
    const res = await $fetch<{ data: any }>(`${config.public.apiBase}/complaints/track/${code}`)
    trackResult.value = res.data
    trackState.value = 'found'
  } catch {
    trackResult.value = null
    trackState.value = 'not-found'
  }
}

const resolvedTrackResult = computed<{ stages: Stage[]; statusLabel: string; statusColor: string; submitted: string; expert: string; deadline: string; [key: string]: any } | null>(() => {
  const tr = trackResult.value
  if (!tr) return null
  const st = statusMap.value[tr.status] ?? { label: tr.status, color: 'bg-gray-100 text-gray-600' }
  return {
    ...tr,
    statusLabel: st.label,
    statusColor: st.color,
    submitted: new Date(tr.created_at).toLocaleString(loc.value, { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' }),
    expert:   t(c.value?.success_modal?.expert_name) || 'AUGZ',
    deadline: (() => { const d = new Date(tr.created_at); d.setDate(d.getDate() + 10); return $t('report_page.deadline_prefix') + d.toLocaleString(loc.value, { day: 'numeric', month: 'long', year: 'numeric' }) })(),
    stages: buildStages(tr),
  }
})

useSeoMeta({
  title: 'Сообщить о нарушении в закупках — АУГЗ',
  description: 'Подайте жалобу на нарушения в государственных закупках через официальную форму АУГЗ. Отслеживайте статус обращения онлайн.',
  ogTitle: 'Сообщить о нарушении в закупках — АУГЗ',
  ogDescription: 'Подайте жалобу на нарушения в государственных закупках через официальную форму АУГЗ.',
  ogImage: '/og-default.jpg',
  ogUrl: 'https://augz.uz/report',
  ogType: 'website',
  twitterCard: 'summary_large_image',
  twitterTitle: 'Сообщить о нарушении — АУГЗ',
  twitterDescription: 'Подайте жалобу на нарушения в государственных закупках через форму АУГЗ.',
  robots: 'noindex, nofollow',
})
</script>

<style scoped>
.field {
  width: 100%;
  border-radius: 0.5rem;
  border: 1px solid #e5e7eb;
  background: #f9fafb;
  padding: 0.75rem 1rem;
  font-size: 0.875rem;
  color: #111827;
  transition: border-color 0.15s, background 0.15s;
}
.field::placeholder { color: #9ca3af; }
.field[type="date"]::-webkit-calendar-picker-indicator { cursor: pointer; opacity: 0.5; }
.field[type="date"]::-webkit-calendar-picker-indicator:hover { opacity: 1; }
.field:focus {
  outline: none;
  border-color: var(--theme-color);
  background: #fff;
}

.field-error {
  font-size: 11px;
  color: #ef4444;
  margin-top: 0.25rem;
}

.field-label {
  display: block;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  color: #6b7280;
  margin-bottom: 0.5rem;
}

.fade-enter-active, .fade-leave-active { transition: opacity 0.2s ease, transform 0.2s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; transform: translateY(-8px); }

.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

.modal-enter-active, .modal-leave-active { transition: opacity 0.25s ease; }
.modal-enter-active .relative.z-10, .modal-leave-active .relative.z-10 { transition: opacity 0.25s ease, transform 0.25s ease; }
.modal-enter-from, .modal-leave-to { opacity: 0; }
.modal-enter-from .relative.z-10, .modal-leave-to .relative.z-10 { opacity: 0; transform: scale(0.95) translateY(12px); }
</style>
