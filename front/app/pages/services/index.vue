<template>
  <div>
    <!-- Hero -->
    <div
      class="relative overflow-hidden min-h-[60vh] md:min-h-[72vh] flex items-center"
      :style="hero.image ? `background: url('${hero.image}') no-repeat center top / cover` : 'background: url(/img/Hero.png) no-repeat center top / cover'"
    >
      <div class="relative container mx-auto px-4 pb-16 pt-1">
        <div class="flex items-center gap-2 mb-6">
          <span class="w-8 h-0.5 bg-(--theme-color)" />
          <span class="text-xs font-bold uppercase tracking-[0.2em] text-gray-700">{{ t(hero.badge) || 'УСЛУГИ И ПРОЕКТЫ АУГЗ' }}</span>
        </div>

        <h1 class="text-4xl sm:text-5xl md:text-6xl font-black uppercase leading-none mb-4">
          {{ t(hero.title_1) || 'УСЛУГИ ' }} <span class="text-(--theme-color)">{{ t(hero.title_2) || 'АУГЗ' }}</span>
        </h1>

        <p class="text-sm sm:text-base text-gray-700 max-w-sm leading-relaxed mb-8">
          {{ t(hero.subtitle) || 'Консалтинг, цифровые продукты, аналитика и сопровождение для участников государственных и корпоративных закупок Узбекистана' }}
        </p>

        <div class="flex flex-wrap gap-2">
          <button
            v-for="(cat, idx) in heroCategories"
            :key="idx"
            :class="[
              'flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold border transition',
              activeCategory === idx
                ? 'bg-gray-900 text-white border-gray-900'
                : 'bg-white/80 text-gray-700 border-gray-200 hover:border-gray-400'
            ]"
            @click="scrollToSection(idx)"
          >
            <span class="w-2 h-2 rounded-full shrink-0" :style="`background: ${cat.color}`" />
            {{ cat.label }}
          </button>
        </div>
      </div>
    </div>


    <!-- Sections -->
    <template v-for="section in (sections.length ? sections : defaultSections)" :key="section.id">

      <!-- Type: consulting (items list + stats panel) -->
      <section v-if="section.type === 'consulting'" :id="section.id" class="section border-t border-gray-100">
        <div class="container mx-auto px-4">
          <div class="mb-10">
            <div class="flex items-center gap-2 mb-3">
              <span class="w-6 h-0.5 bg-(--theme-color)" />
              <span class="text-xs font-bold uppercase tracking-[0.18em] text-(--theme-color)">{{ t(section.badge) }}</span>
            </div>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-black uppercase leading-tight mb-3">{{ t(section.heading) }}</h2>
            <p class="text-sm text-gray-500 max-w-lg leading-relaxed">{{ t(section.subtitle) }}</p>
          </div>

          <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 lg:gap-8">
            <div class="lg:col-span-3 flex flex-col divide-y divide-gray-100">
              <div v-for="(item, j) in section.items" :key="j" class="group py-6 flex gap-5">
                <span class="text-xs text-gray-300 font-bold mt-1 shrink-0 w-5">{{ item.number }}</span>
                <div class="flex flex-col gap-2 flex-1">
                  <h3 class="font-bold text-gray-900 group-hover:text-(--theme-color) transition-colors leading-snug">{{ t(item.title) }}</h3>
                  <p class="text-sm text-gray-500 leading-relaxed">{{ t(item.desc) }}</p>
                  <div class="flex flex-wrap gap-1.5 mt-1">
                    <span v-for="tag in item.tags" :key="tag" class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] font-bold uppercase tracking-wide rounded">{{ tag }}</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="lg:col-span-2 flex flex-col gap-4">
              <div class="rounded-2xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                  <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">{{ t(section.stats_label) }}</span>
                </div>
                <div class="grid grid-cols-2 divide-x divide-y divide-gray-100">
                  <div v-for="(stat, k) in section.stats" :key="k" class="px-5 py-4 flex flex-col gap-0.5">
                    <span class="text-2xl font-black text-gray-900 leading-none">{{ stat.value }}</span>
                    <span class="text-xs text-gray-500 leading-snug">{{ t(stat.label) }}</span>
                  </div>
                </div>
                <div class="px-5 py-4 border-t border-gray-100 bg-gray-50">
                  <p class="text-xs text-gray-500 leading-relaxed">{{ t(section.stats_desc) }}</p>
                </div>
              </div>
              <a :href="section.cta_href" class="block w-full text-center px-5 py-3 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-(--theme-color) transition-colors">
                {{ t(section.cta_label) }} →
              </a>
              <div class="rounded-2xl bg-gray-900 px-5 py-5 flex flex-col gap-3">
                <h4 class="text-white font-bold text-sm">{{ t(section.express_title) }}</h4>
                <p class="text-gray-400 text-xs leading-relaxed">{{ t(section.express_desc) }}</p>
                <button class="w-full px-4 py-2.5 bg-(--theme-color) text-white text-sm font-semibold rounded-lg hover:opacity-90 transition-opacity">
                  {{ t(section.express_btn) }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Type: products (2×2 cards grid) -->
      <section v-else-if="section.type === 'products'" :id="section.id" class="section border-t border-gray-100 bg-[#f2f0eb]">
        <div class="container mx-auto px-4">
          <div class="mb-10">
            <div class="flex items-center gap-2 mb-3">
              <span class="w-6 h-0.5 bg-(--theme-color)" />
              <span class="text-xs font-bold uppercase tracking-[0.18em] text-(--theme-color)">{{ t(section.badge) }}</span>
            </div>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-black uppercase leading-tight mb-3">{{ t(section.heading) }}</h2>
            <p class="text-sm text-gray-500 max-w-lg leading-relaxed">{{ t(section.subtitle) }}</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div
              v-for="(product, p) in section.products"
              :key="p"
              class="bg-white rounded-2xl p-6 flex flex-col gap-4 border border-gray-100"
              :style="product.accent ? `border-top: 3px solid ${product.accent}` : ''"
            >
              <!-- Product header -->
              <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white text-base shrink-0" :style="`background: ${product.accent ?? '#D1832C'}`">
                  <Icon :name="product.icon" />
                </div>
                <div>
                  <p class="font-bold text-gray-900 text-sm leading-tight">{{ t(product.name) }}</p>
                  <p class="text-xs text-gray-400">{{ t(product.tagline) }}</p>
                </div>
              </div>

              <!-- Description -->
              <p class="text-sm text-gray-600 leading-relaxed">{{ t(product.desc) }}</p>

              <!-- Features -->
              <ul class="flex flex-col gap-1.5">
                <li v-for="f in product.features" :key="f" class="flex items-center gap-2 text-sm text-gray-700">
                  <Icon name="heroicons:check" class="w-4 h-4 shrink-0" :style="`color: ${product.accent ?? '#D1832C'}`" />
                  {{ f }}
                </li>
              </ul>

              <!-- Footer -->
              <div class="flex items-center justify-between mt-auto pt-2">
                <span
                  v-if="product.status"
                  class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide text-white"
                  :style="`background: ${product.status_color ?? '#6b7280'}`"
                >{{ product.status }}</span>
                <span v-else class="flex-1" />
                <a v-if="product.link" :href="product.link" class="text-sm font-semibold hover:underline" :style="`color: ${product.accent ?? '#D1832C'}`">
                  {{ t(product.link_label) }} →
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Type: flagship (dark promo card) -->
      <section v-else-if="section.type === 'flagship'" :id="section.id" class="section border-t border-gray-100">
        <div class="container mx-auto px-4">
          <div class="mb-8">
            <div class="flex items-center gap-2 mb-3">
              <span class="w-6 h-0.5 bg-(--theme-color)" />
              <span class="text-xs font-bold uppercase tracking-[0.18em] text-(--theme-color)">{{ t(section.badge) }}</span>
            </div>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-black uppercase leading-tight">{{ t(section.heading) }}</h2>
          </div>

          <div class="rounded-3xl bg-gray-900 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-5">

              <!-- Left: copy -->
              <div class="lg:col-span-3 p-8 md:p-10 flex flex-col gap-6">
                <div class="flex items-center gap-2">
                  <span class="w-5 h-0.5 bg-(--theme-color)" />
                  <span class="text-xs text-gray-400 uppercase tracking-widest">{{ t(section.product_label) }}</span>
                </div>
                <h3 class="text-4xl md:text-5xl font-black uppercase text-white leading-none">
                  {{ t(section.product_title_1) }}<br>
                  {{ t(section.product_title_2) }}<br>
                  <span class="text-(--theme-color)">{{ t(section.product_title_3) }}</span>
                </h3>
                <p class="text-sm text-gray-400 leading-relaxed max-w-sm">{{ t(section.product_desc) }}</p>

                <!-- Mini feature grid -->
                <div class="grid grid-cols-2 gap-3">
                  <div
                    v-for="(feat, f) in section.product_features"
                    :key="f"
                    class="rounded-xl bg-white/5 border border-white/8 px-4 py-3 flex flex-col gap-1"
                  >
                    <div class="flex items-center gap-2">
                      <Icon :name="feat.icon" class="w-4 h-4 text-(--theme-color) shrink-0" />
                      <span class="text-xs font-semibold text-white">{{ t(feat.title) }}</span>
                    </div>
                    <span class="text-[11px] text-gray-500">{{ t(feat.desc) }}</span>
                  </div>
                </div>

                <!-- CTAs -->
                <div class="flex flex-wrap gap-3 mt-2">
                  <a :href="section.cta_primary_href" class="px-6 py-3 bg-(--theme-color) text-white text-sm font-bold rounded-xl hover:opacity-90 transition-opacity">
                    {{ t(section.cta_primary_label) }} →
                  </a>
                  <a :href="section.cta_secondary_href" class="px-6 py-3 border border-white/20 text-white text-sm font-semibold rounded-xl hover:border-white/40 transition-colors">
                    {{ t(section.cta_secondary_label) }}
                  </a>
                </div>
              </div>

              <!-- Right: stats -->
              <div class="lg:col-span-2 border-t lg:border-t-0 lg:border-l border-white/8 flex flex-col divide-y divide-white/8">
                <div
                  v-for="(stat, s) in section.product_stats"
                  :key="s"
                  class="px-8 py-6 flex items-center gap-4"
                >
                  <div class="w-9 h-9 rounded-xl bg-white/5 flex items-center justify-center shrink-0">
                    <Icon :name="stat.icon" class="w-5 h-5 text-(--theme-color)" />
                  </div>
                  <div>
                    <p class="text-xl font-black text-white leading-none">{{ stat.value }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ t(stat.label) }}</p>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </section>

      <!-- Type: analytics (left: directions list, right: report cards) -->
      <section v-else-if="section.type === 'analytics'" :id="section.id" class="section border-t border-gray-100 bg-[#f2f0eb]">
        <div class="container mx-auto px-4">
          <div class="mb-10">
            <div class="flex items-center gap-2 mb-3">
              <span class="w-6 h-0.5 bg-(--theme-color)" />
              <span class="text-xs font-bold uppercase tracking-[0.18em] text-(--theme-color)">{{ t(section.badge) }}</span>
            </div>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-black uppercase leading-tight mb-3">{{ t(section.heading) }}</h2>
            <p class="text-sm text-gray-500 max-w-lg leading-relaxed">{{ t(section.subtitle) }}</p>
          </div>

          <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            <!-- Left: directions -->
            <div class="lg:col-span-2 flex flex-col gap-3">
              <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">{{ t(section.directions_label) }}</p>
              <div
                v-for="(dir, d) in section.directions"
                :key="d"
                class="bg-white rounded-xl p-5 flex flex-col gap-3 border border-gray-100"
              >
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center shrink-0">
                    <Icon :name="dir.icon" class="w-4 h-4 text-gray-500" />
                  </div>
                  <p class="font-bold text-gray-900 text-sm">{{ t(dir.title) }}</p>
                </div>
                <p class="text-xs text-gray-500 leading-relaxed">{{ t(dir.desc) }}</p>
                <div class="flex flex-wrap gap-1.5">
                  <span
                    v-for="tag in dir.tags" :key="tag"
                    class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide rounded"
                    :class="tag === 'ЗАКРЫТАЯ БД' || tag === 'ЧЛЕНЫ АУГЗ' || tag === 'НА ЗАКАЗ'
                      ? 'bg-gray-900 text-white'
                      : 'bg-green-50 text-green-700'"
                  >{{ tag }}</span>
                </div>
              </div>
            </div>

            <!-- Right: report cards -->
            <div class="lg:col-span-3 flex flex-col gap-4">
              <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">{{ t(section.reports_label) }}</p>
              <div
                v-for="(report, r) in section.reports"
                :key="r"
                class="bg-white rounded-xl p-5 flex flex-col gap-3 border border-gray-100"
              >
                <div class="flex items-start justify-between gap-4">
                  <p class="font-bold text-gray-900 text-sm leading-snug">{{ t(report.title) }}</p>
                  <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wide whitespace-nowrap">{{ report.meta }}</span>
                </div>
                <p class="text-xs text-gray-500 leading-relaxed">{{ t(report.desc) }}</p>
                <div class="flex items-center justify-between">
                  <span class="text-[11px] text-gray-400">{{ report.date }} · {{ report.downloads }}</span>
                  <a
                    :href="report.href ?? '#'"
                    class="flex items-center gap-1.5 px-3 py-1.5 border border-gray-200 rounded-lg text-xs font-semibold text-gray-700 hover:border-gray-400 transition-colors"
                  >
                    <Icon name="heroicons:arrow-down-tray" class="w-3.5 h-3.5" />
                    {{ t(report.btn) }}
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Type: support (3 pricing cards) -->
      <section v-else-if="section.type === 'support'" :id="section.id" class="section border-t border-gray-100">
        <div class="container mx-auto px-4">
          <div class="mb-10">
            <div class="flex items-center gap-2 mb-3">
              <span class="w-6 h-0.5 bg-(--theme-color)" />
              <span class="text-xs font-bold uppercase tracking-[0.18em] text-(--theme-color)">{{ t(section.badge) }}</span>
            </div>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-black uppercase leading-tight mb-3">{{ t(section.heading) }}</h2>
            <p class="text-sm text-gray-500 max-w-lg leading-relaxed">{{ t(section.subtitle) }}</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div
              v-for="(plan, p) in section.plans"
              :key="p"
              class="rounded-2xl border border-gray-100 bg-white flex flex-col gap-5 p-6 relative overflow-hidden"
              :style="plan.accent ? `border-top: 3px solid ${plan.accent}` : ''"
            >
              <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-gray-50 shrink-0">
                <Icon :name="plan.icon" class="w-5 h-5 text-gray-700" />
              </div>

              <div>
                <p class="font-bold text-gray-900 text-base mb-2">{{ t(plan.name) }}</p>
                <p class="text-sm text-gray-500 leading-relaxed">{{ t(plan.desc) }}</p>
              </div>

              <ul class="flex flex-col gap-2 flex-1">
                <li v-for="f in plan.features" :key="f" class="flex items-center gap-2 text-sm text-gray-700">
                  <Icon name="heroicons:check" class="w-4 h-4 shrink-0" :style="`color: ${plan.accent ?? '#D1832C'}`" />
                  {{ f }}
                </li>
              </ul>

              <div class="pt-4 border-t border-gray-100 mt-auto">
                <p class="text-sm font-semibold text-gray-500">{{ t(plan.price) }}</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Type: extra-services (5 cards grid) -->
      <section v-else-if="section.type === 'extra-services'" :id="section.id" class="section border-t border-gray-100 bg-[#f2f0eb]">
        <div class="container mx-auto px-4">
          <div class="mb-10">
            <div class="flex items-center gap-2 mb-3">
              <span class="w-6 h-0.5 bg-(--theme-color)" />
              <span class="text-xs font-bold uppercase tracking-[0.18em] text-(--theme-color)">{{ t(section.badge) }}</span>
            </div>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-black uppercase leading-tight mb-3">{{ t(section.heading) }}</h2>
            <p class="text-sm text-gray-500 max-w-lg leading-relaxed">{{ t(section.subtitle) }}</p>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div
              v-for="(svc, s) in section.services"
              :key="s"
              class="bg-white rounded-2xl p-6 flex flex-col gap-4 border border-gray-100"
            >
              <div class="text-2xl">{{ svc.emoji }}</div>
              <div>
                <p class="font-bold text-gray-900 text-sm mb-2">{{ t(svc.name) }}</p>
                <p class="text-sm text-gray-500 leading-relaxed">{{ t(svc.desc) }}</p>
              </div>
              <a :href="svc.href ?? '#'" class="mt-auto text-sm font-semibold text-(--theme-color) hover:underline">
                {{ t(svc.link_label) }} →
              </a>
            </div>
          </div>
        </div>
      </section>

      <!-- Type: cta-form (dark section with contacts + form) -->
      <section v-else-if="section.type === 'cta-form'" :id="section.id" class="bg-[#0f1420] py-20 md:py-28">
        <div class="container mx-auto px-4">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

            <!-- Left -->
            <div class="flex flex-col gap-8">
              <div>
                <div class="flex items-center gap-2 mb-5">
                  <span class="w-6 h-0.5 bg-(--theme-color)" />
                  <span class="text-xs font-bold uppercase tracking-[0.18em] text-(--theme-color)">{{ t(section.badge) }}</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black uppercase text-white leading-tight">
                  {{ t(section.heading_1) }}<br>
                  {{ t(section.heading_2) }}<br>
                  <span class="text-(--theme-color)">{{ t(section.heading_3) }}</span>
                </h2>
                <p class="mt-5 text-sm text-gray-400 leading-relaxed max-w-sm">{{ t(section.desc) }}</p>
              </div>

              <div class="flex flex-col gap-4">
                <div v-for="(contact, c) in ctaContacts" :key="c" class="flex items-center gap-4">
                  <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center shrink-0">
                    <Icon :name="contact.icon" class="w-5 h-5 text-(--theme-color)" />
                  </div>
                  <div>
                    <p class="text-[11px] text-gray-500 uppercase tracking-wide">{{ t(contact.label) }}</p>
                    <p class="text-sm text-white font-medium">{{ contact.value }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Right: form -->
            <div class="bg-[#161d2e] border border-white/8 rounded-2xl p-7 flex flex-col gap-5">
              <form v-if="!ctaSent" class="flex flex-col gap-4" @submit.prevent="submitCtaForm">
                <!-- Name -->
                <div class="flex flex-col gap-1.5">
                  <label class="cta-label">{{ t(section.form_name_label) || 'ВАШЕ ИМЯ' }} <span class="text-red-500">*</span></label>
                  <input
                    v-model="ctaForm.name"
                    type="text"
                    :placeholder="t(section.form_name_placeholder) || 'Фамилия Имя'"
                    class="cta-input"
                    :class="{ 'cta-input-error': ctaErrors.name }"
                    @blur="ctaErrors.name = ctaForm.name.trim().length < 2 ? 'Введите имя' : ''"
                  />
                  <p v-if="ctaErrors.name" class="text-[11px] text-red-400">{{ ctaErrors.name }}</p>
                </div>

                <!-- Phone -->
                <div class="flex flex-col gap-1.5">
                  <label class="cta-label">{{ t(section.form_phone_label) || 'ТЕЛЕФОН' }} <span class="text-red-500">*</span></label>
                  <UiPhoneInput
                    v-model="ctaForm.phone"
                    class="cta-input"
                    :class="{ 'cta-input-error': ctaErrors.phone }"
                    @blur="ctaErrors.phone = !ctaForm.phone ? 'Введите телефон' : ''"
                  />
                  <p v-if="ctaErrors.phone" class="text-[11px] text-red-400">{{ ctaErrors.phone }}</p>
                </div>

                <!-- Email -->
                <div class="flex flex-col gap-1.5">
                  <label class="cta-label">{{ t(section.form_email_label) || 'EMAIL' }}</label>
                  <input v-model="ctaForm.email" type="email" placeholder="email@uz" class="cta-input" />
                </div>

                <!-- Service -->
                <div class="flex flex-col gap-1.5">
                  <label class="cta-label">{{ t(section.form_service_label) || 'НУЖНАЯ УСЛУГА' }}</label>
                  <select v-model="ctaForm.service" class="cta-input">
                    <option value="" disabled>—</option>
                    <option v-for="opt in serviceOptions" :key="opt" :value="opt">{{ opt }}</option>
                  </select>
                </div>

                <p v-if="ctaServerError" class="text-sm text-red-400">{{ ctaServerError }}</p>

                <button
                  type="submit"
                  :disabled="ctaSubmitting"
                  class="w-full py-3.5 rounded-xl text-sm font-bold text-white transition-all disabled:opacity-60 bg-(--theme-color) hover:opacity-90"
                >
                  <span v-if="ctaSubmitting" class="flex items-center justify-center gap-2">
                    <Icon name="heroicons:arrow-path" class="w-4 h-4 animate-spin" /> Отправка...
                  </span>
                  <span v-else>{{ t(section.form_btn) || 'Отправить заявку' }} →</span>
                </button>
              </form>

              <!-- Success -->
              <div v-else class="flex flex-col items-center gap-4 py-8 text-center">
                <div class="w-14 h-14 rounded-full flex items-center justify-center bg-green-500/20">
                  <Icon name="heroicons:check" class="w-7 h-7 text-green-400" />
                </div>
                <div>
                  <p class="font-bold text-white text-base">Заявка отправлена!</p>
                  <p class="text-sm text-gray-400 mt-1">Мы свяжемся с вами в течение 4 рабочих часов</p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </section>

    </template>
  </div>
</template>

<style scoped>
.cta-label {
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: #6b7280;
}
.cta-input {
  background: #0f1420;
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: 10px;
  padding: 10px 14px;
  font-size: 14px;
  color: #fff;
  outline: none;
  width: 100%;
  transition: border-color 0.2s;
}
.cta-input::placeholder { color: #4b5563; }
.cta-input:focus { border-color: #D1832C; }
.cta-input-error { border-color: #f87171 !important; }
.cta-input option { background: #161d2e; }
</style>

<script setup lang="ts">
const config   = useRuntimeConfig()
const settings = useSettings()
const { locale } = useI18n()

const ctaContacts = computed(() => [
  { icon: 'heroicons:phone',                     label: { ru: 'Телефон', uz: 'Telefon', en: 'Phone' },   value: settings.value.contacts.phone },
  { icon: 'heroicons:envelope',                  label: { ru: 'Email',   uz: 'Email',   en: 'Email' },   value: settings.value.contacts.email },
  { icon: 'heroicons:map-pin',                   label: { ru: 'Адрес',   uz: 'Manzil',  en: 'Address' }, value: settings.value.address.text },
  { icon: 'heroicons:chat-bubble-left-ellipsis', label: { ru: 'Telegram',uz: 'Telegram', en: 'Telegram'},value: settings.value.contacts.telegram },
])
const activeCategory = ref(0)

const categoryToSection: Record<string, string> = {
  'Консалтинг':        'consulting',
  'Цифровые продукты': 'digital-products',
  'Аналитика':         'analytics',
  'Сопровождение':     'support',
  'Сервисы':           'extra-services',
}

function scrollToSection(idx: number) {
  activeCategory.value = idx
  const cat = heroCategories.value[idx]
  if (!cat) return
  const sectionId = categoryToSection[cat.label]
  if (!sectionId) return
  const el = document.getElementById(sectionId)
  if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' })
}
const ctaForm = reactive({ name: '', phone: '', email: '', service: '' })
const ctaErrors = reactive({ name: '', phone: '' })
const ctaSubmitting = ref(false)
const ctaSent = ref(false)
const ctaServerError = ref('')

async function submitCtaForm() {
  ctaErrors.name  = ctaForm.name.trim().length < 2 ? 'Введите имя' : ''
  ctaErrors.phone = !ctaForm.phone ? 'Введите телефон' : ''
  if (ctaErrors.name || ctaErrors.phone) return
  ctaSubmitting.value = true
  ctaServerError.value = ''
  try {
    await $fetch(`${config.public.apiBase}/leads`, {
      method: 'POST',
      body: { ...ctaForm, source: 'services-page' },
    })
    ctaSent.value = true
  } catch (e: any) {
    const errs = e?.data?.errors
    ctaServerError.value = errs
      ? Object.values(errs).flat().join(' ')
      : e?.data?.message ?? 'Ошибка отправки. Попробуйте снова.'
  } finally {
    ctaSubmitting.value = false
  }
}

function t(obj: any): string {
  if (!obj) return ''
  if (typeof obj === 'string') return obj
  const lang = locale.value as string
  return obj[lang] ?? obj.ru ?? obj.uz ?? obj.en ?? ''
}

const { data: pageData } = await useFetch<{ content: any }>(
  `${config.public.apiBase}/page/services`,
)
const pc = computed(() => pageData.value?.content ?? {})
const hero = computed(() => pc.value.hero ?? {})

// ── Services from API ────────────────────────────────────────────────────
interface Service {
  id: number
  category: string
  title: { ru: string; uz: string; en: string }
  desc: { ru: string; uz: string; en: string }
  tags: string[]
  sort_order: number
}

const { data: servicesData } = await useFetch<{ data: Service[] }>(
  `${config.public.apiBase}/services`,
)
const allServices = computed(() => servicesData.value?.data ?? [])

const categoryColors: Record<string, string> = {
  'Консалтинг':         '#D1832C',
  'Цифровые продукты':  '#F59E0B',
  'Аналитика':          '#3B82F6',
  'Сопровождение':      '#10B981',
  'Сервисы':            '#8B5CF6',
}

const categories = computed(() => {
  const seen = new Set<string>()
  const result: { name: string; color: string }[] = [{ name: 'Все', color: '#6b7280' }]
  for (const svc of allServices.value) {
    if (svc.category && !seen.has(svc.category)) {
      seen.add(svc.category)
      result.push({ name: svc.category, color: categoryColors[svc.category] ?? '#6b7280' })
    }
  }
  return result
})

// keep hero categories in sync for the filter chips
const heroCategories = computed(() => categories.value.map(c => ({ label: c.name, color: c.color })))

// service names for the CTA form dropdown
const serviceOptions = computed(() => allServices.value.map(s => t(s.title)))

// sections array kept for the hardcoded layout sections (flagship, cta-form etc.)
const sections = computed(() => pc.value.sections ?? [])

const defaultCategories = heroCategories

const defaultSections: any[] = [
  {
    id: 'consulting',
    type: 'consulting',
    badge: { ru: '01 — КОНСАЛТИНГ', uz: '01 — KONSALTING', en: '01 — CONSULTING' },
    heading: { ru: 'КОНСАЛТИНГ В СФЕРЕ ЗАКУПОК', uz: 'XARIDLAR SOHASIDA KONSALTING', en: 'PROCUREMENT CONSULTING' },
    subtitle: { ru: 'Экспертная поддержка для компаний, участвующих в государственных и корпоративных тендерах — от стратегии до победы', uz: "Davlat va korporativ tendirlarda ishtirok etayotgan kompaniyalar uchun strategiyadan g'alabaga qadar ekspert yordami", en: 'Expert support for companies participating in state and corporate tenders — from strategy to winning' },
    items: [
      {
        number: '01',
        title: { ru: 'Тендерная стратегия и анализ рынка', uz: 'Tender strategiyasi va bozor tahlili', en: 'Tender strategy and market analysis' },
        desc: { ru: 'Разработка индивидуальной стратегии участия в тендерах: анализ конкурентов, выбор перспективных лотов, ценовое позиционирование и прогноз вероятности победы', uz: "Raqobatchilar tahlili, istiqbolli lotlarni tanlash, narx pozitsiyalash va g'alaba ehtimolini prognoz qilish", en: 'Individual tender strategy: competitor analysis, lot selection, price positioning and win probability forecast' },
        tags: ['СТРАТЕГИЯ', 'АНАЛИЗ КОНКУРЕНТОВ', 'ЦЕНООБРАЗОВАНИЕ'],
      },
      {
        number: '02',
        title: { ru: 'Подготовка тендерной документации', uz: 'Tender hujjatlarini tayyorlash', en: 'Tender documentation preparation' },
        desc: { ru: 'Полный пакет документов для участия в тендере: техническое предложение, ценовая заявка, банковские гарантии. Соответствие требованиям законодательства и ТЗ', uz: "Tenderda ishtirok etish uchun to'liq hujjatlar paketi: texnik taklif, narx takliflari, bank kafolatlari", en: 'Full document package: technical proposal, price bid, bank guarantees. Legislative compliance' },
        tags: ['ДОКУМЕНТАЦИЯ', 'ЗАЯВКИ'],
      },
      {
        number: '03',
        title: { ru: 'Правовой консалтинг и обжалование', uz: 'Huquqiy konsalting va shikoyat', en: 'Legal consulting and appeals' },
        desc: { ru: 'Юридическая экспертиза тендерных условий, защита прав участников, подготовка жалоб и представительство интересов клиента в антимонопольных органах', uz: 'Tender shartlarini yuridik ekspertizasi, ishtirokchilar huquqlarini himoya qilish, shikoyatlar tayyorlash', en: "Legal audit of tender conditions, protection of participants' rights, complaint preparation and antitrust representation" },
        tags: ['ПРАВО', 'ОБЖАЛОВАНИЕ'],
      },
      {
        number: '04',
        title: { ru: 'Аудит закупочных процедур', uz: 'Xarid tartib-qoidalarini audit qilish', en: 'Procurement procedure audit' },
        desc: { ru: 'Независимая проверка закупочных процедур заказчика на соответствие требованиям законодательства, выявление рисков и рекомендации по улучшению', uz: "Buyurtmachining xarid tartib-qoidalarini qonunchilik talablariga muvofiqligini mustaqil tekshirish, xavflarni aniqlash", en: 'Independent audit of procurement procedures for legislative compliance, risk identification and improvement recommendations' },
        tags: ['АУДИТ', 'КОМПЛАЕНС', 'РИСКИ'],
      },
    ],
    stats: [
      { value: '73%', label: { ru: 'Средний % побед', uz: "O'rtacha g'alaba foizi", en: 'Average win rate' } },
      { value: '5 млрд', label: { ru: 'Сумм контрактов', uz: 'Shartnomalar summasi', en: 'Contract value' } },
      { value: '200+', label: { ru: 'Клиентов', uz: 'Mijozlar', en: 'Clients' } },
      { value: '98%', label: { ru: 'Обжалований', uz: 'Shikoyatlar', en: 'Appeals won' } },
    ],
    stats_label: { ru: 'Результаты наших клиентов', uz: 'Mijozlarimiz natijalari', en: "Our clients' results" },
    stats_desc: { ru: 'Мы помогли более 200 компаниям выстроить системную работу с тендерами и значительно увеличить долю выигранных контрактов', uz: "200 dan ortiq kompaniyaga tenderlar bilan tizimli ishlashni yo'lga qo'yishda yordam berdik", en: 'We have helped more than 200 companies build systematic work with tenders and increase their win rate' },
    cta_label: { ru: 'Получить консультацию', uz: 'Maslahat olish', en: 'Get a consultation' },
    cta_href: '/contacts',
    express_title: { ru: 'Экспресс-консультация', uz: 'Ekspress-maslahat', en: 'Express consultation' },
    express_desc: { ru: '30-минутный разбор вашей ситуации с экспертом АУГЗ. Получите конкретные рекомендации по участию в тендере', uz: "AUGZ mutaxassisi bilan 30 daqiqalik tahlil. Tenderda ishtirok etish bo'yicha tavsiyalar oling", en: '30-minute analysis with an AUGZ expert. Get specific recommendations for tender participation' },
    express_btn: { ru: 'Записаться', uz: "Ro'yxatdan o'tish", en: 'Sign up' },
  },
  {
    id: 'digital-products',
    type: 'products',
    badge: { ru: '02 — ЦИФРОВЫЕ ПРОДУКТЫ', uz: '02 — RAQAMLI MAHSULOTLAR', en: '02 — DIGITAL PRODUCTS' },
    heading: { ru: 'ЦИФРОВЫЕ ПРОДУКТЫ АУГЗ', uz: "AUGZ RAQAMLI MAHSULOTLARI", en: 'AUGZ DIGITAL PRODUCTS' },
    subtitle: { ru: 'Технологические решения для автоматизации, мониторинга и анализа закупочной деятельности', uz: 'Xarid faoliyatini avtomatlashtirish, monitoring va tahlil qilish uchun texnologik yechimlar', en: 'Technology solutions for automation, monitoring and analysis of procurement activities' },
    products: [
      {
        icon: 'heroicons:bolt',
        accent: '#D1832C',
        name: { ru: 'TenderZone', uz: 'TenderZone', en: 'TenderZone' },
        tagline: { ru: 'Агрегатор тендеров', uz: 'Tenderlar agregatori', en: 'Tender aggregator' },
        desc: { ru: 'Крупнейший агрегатор государственных и корпоративных тендеров Узбекистана. 15 000+ активных лотов, анализ и Telegram-уведомления в реальном времени', uz: "O'zbekistonning eng yirik davlat va korporativ tenderlar agregatori. 15 000+ faol lot, tahlil va real vaqtda Telegram-bildirishnomalar", en: "Uzbekistan's largest aggregator of state and corporate tenders. 15,000+ active lots, analysis and real-time Telegram notifications" },
        features: ['150 000+ тендеров в базе', 'Telegram-бот с уведомлениями', 'CRM для отдела закупок', 'Аналитика конкурентов'],
        link: 'https://trade.tzone.uz/page/tenders-all',
        link_label: { ru: 'trade.tzone.uz/page/tenders-all', uz: 'trade.tzone.uz/page/tenders-all', en: 'trade.tzone.uz/page/tenders-all' },
      },
      {
        icon: 'heroicons:chart-bar',
        accent: '#3B82F6',
        name: { ru: 'АУГЗ Аналитика', uz: 'AUGZ Analitika', en: 'AUGZ Analytics' },
        tagline: { ru: 'Платформа данных', uz: "Ma'lumotlar platformasi", en: 'Data platform' },
        desc: { ru: 'Интерактивная платформа с данными о рынке государственных закупок: динамика цен, рейтинги поставщиков, региональная статистика и прогнозные модели', uz: 'Davlat xaridlari bozori haqida ma\'lumotlar bilan interaktiv platforma: narx dinamikasi, yetkazib beruvchilar reytingi, mintaqaviy statistika va prognoz modellari', en: 'Interactive platform with public procurement market data: price dynamics, supplier rankings, regional statistics and forecasting models' },
        features: ['Интерактивные дашборды', 'Экспорт данных в Excel/PDF', 'API для интеграций', 'Прогнозная аналитика'],
        status: 'В РАЗРАБОТКЕ · BETA Q3 2026',
        status_color: '#3B82F6',
        link_label: { ru: 'Получить доступ', uz: 'Kirish olish', en: 'Get access' },
        link: '/contacts',
      },
      {
        icon: 'heroicons:shield-check',
        accent: '#10B981',
        name: { ru: 'Compliance Check', uz: 'Compliance Check', en: 'Compliance Check' },
        tagline: { ru: 'Проверка рисков', uz: 'Xatarlarni tekshirish', en: 'Risk checker' },
        desc: { ru: 'Автоматическая проверка тендерной документации заказчика на соответствие законодательству. Выявление дискриминационных требований и коррупционных рисков', uz: 'Buyurtmachining tender hujjatlarini qonunchilikka muvofiqligini avtomatik tekshirish. Kamsituvchi talablar va korrupsion xatarlarni aniqlash', en: 'Automatic compliance check of tender documentation against legislation. Detection of discriminatory requirements and corruption risks' },
        features: ['Проверка ТЗ за 5 минут', 'База нарушений АУГЗ', 'Генерация жалобы автоматически', 'Юридическая экспертиза'],
        status: 'PILOT · ДЛЯ ЧЛЕНОВ АУГЗ',
        status_color: '#10B981',
        link_label: { ru: 'Список ожидания', uz: 'Kutish ro\'yxati', en: 'Waitlist' },
        link: '/contacts',
      },
      {
        icon: 'heroicons:sparkles',
        accent: '#8B5CF6',
        name: { ru: 'AI TenderDoc', uz: 'AI TenderDoc', en: 'AI TenderDoc' },
        tagline: { ru: 'Автозаполнение заявок', uz: 'Arizalarni avtoto\'ldirish', en: 'Auto-fill applications' },
        desc: { ru: 'Искусственный интеллект анализирует техническое задание и автоматически генерирует конкурентоспособную заявку на участие в тендере за считанные минуты', uz: 'Sun\'iy intellekt texnik topshiriqni tahlil qiladi va bir necha daqiqada tenderda ishtirok etish uchun raqobatbardosh ariza avtomatik yaratadi', en: 'AI analyses the technical specification and automatically generates a competitive tender application in minutes' },
        features: ['Анализ ТЗ за 2 минуты', 'Генерация заявки по шаблону', 'На узбекском и русском', 'Интеграция с TenderZone'],
        status: 'ЗАПУСК СЕНТЯБРЬ 2026',
        status_color: '#8B5CF6',
        link_label: { ru: 'Список ожидания', uz: 'Kutish ro\'yxati', en: 'Waitlist' },
        link: '/contacts',
      },
    ],
  },
  {
    id: 'flagship',
    type: 'flagship',
    badge: { ru: '03 — ФЛАГМАНСКИЙ ПРОДУКТ', uz: '03 — FLAGMAN MAHSULOT', en: '03 — FLAGSHIP PRODUCT' },
    heading: { ru: 'TENDERZONE — ГЛАВНЫЙ ИНСТРУМЕНТ', uz: 'TENDERZONE — ASOSIY VOSITA', en: 'TENDERZONE — THE MAIN TOOL' },
    product_label: { ru: 'Официальный партнёрский продукт', uz: 'Rasmiy hamkorlik mahsuloti', en: 'Official partner product' },
    product_title_1: { ru: 'НАЙДИ', uz: 'TENDER', en: 'FIND' },
    product_title_2: { ru: 'ТЕНДЕР', uz: 'TOP', en: 'THE TENDER' },
    product_title_3: { ru: 'ПЕРВЫМ', uz: 'BIRINCHI', en: 'FIRST' },
    product_desc: { ru: 'Агрегатор государственных и корпоративных закупок Узбекистана. Уведомления, AI-анализ и документы — всё в одной платформе', uz: "O'zbekiston davlat va korporativ xaridlari agregatori. Bildirishnomalar, AI-tahlil va hujjatlar — hammasi bir platformada", en: "Uzbekistan's procurement aggregator. Notifications, AI analysis and documents — all in one platform" },
    product_features: [
      { icon: 'heroicons:bell', title: { ru: 'Уведомления', uz: 'Bildirishnomalar', en: 'Notifications' }, desc: { ru: 'В реальном времени через Telegram', uz: 'Telegram orqali real vaqtda', en: 'Real-time via Telegram' } },
      { icon: 'heroicons:chart-bar-square', title: { ru: 'Аналитика', uz: 'Analitika', en: 'Analytics' }, desc: { ru: 'История победителей конкурентов', uz: 'Raqobatchilar g\'oliblari tarixi', en: 'Competitor win history' } },
      { icon: 'heroicons:cpu-chip', title: { ru: 'AI-помощник', uz: 'AI-yordamchi', en: 'AI assistant' }, desc: { ru: 'Заявка за 20 минут', uz: '20 daqiqada ariza', en: 'Application in 20 min' } },
      { icon: 'heroicons:tag', title: { ru: 'Скидка АУГЗ', uz: 'AUGZ chegirmasi', en: 'AUGZ discount' }, desc: { ru: '-30% для членов ассоциации', uz: "Uyushma a'zolari uchun -30%", en: '-30% for association members' } },
    ],
    product_stats: [
      { icon: 'heroicons:document-text', value: '150 000+', label: { ru: 'Тендеров в базе', uz: 'Bazadagi tenderlar', en: 'Tenders in database' } },
      { icon: 'heroicons:users', value: '300+', label: { ru: 'Компаний-пользователей', uz: 'Kompaniya-foydalanuvchilar', en: 'Company users' } },
      { icon: 'heroicons:trophy', value: '58%', label: { ru: 'Побед членов АУГЗ через TZ', uz: "AUGZ a'zolarining TZ orqali g'alabalari", en: 'AUGZ member wins via TZ' } },
      { icon: 'heroicons:bolt', value: '5 МИН', label: { ru: 'Время обновления базы', uz: 'Bazani yangilash vaqti', en: 'Database update time' } },
    ],
    cta_primary_label: { ru: 'Попробовать бесплатно', uz: 'Bepul sinab ko\'rish', en: 'Try for free' },
    cta_primary_href: 'https://tzone.uz',
    cta_secondary_label: { ru: 'Подробнее о продукте', uz: 'Mahsulot haqida batafsil', en: 'Learn more' },
    cta_secondary_href: 'https://tzone.uz',
  },
  {
    id: 'analytics',
    type: 'analytics',
    badge: { ru: '04 — АНАЛИТИКА', uz: '04 — ANALITIKA', en: '04 — ANALYTICS' },
    heading: { ru: 'АНАЛИТИКА И ИССЛЕДОВАНИЯ', uz: 'ANALITIKA VA TADQIQOTLAR', en: 'ANALYTICS & RESEARCH' },
    subtitle: { ru: 'Данные и отчёты о рынке государственных закупок для принятия обоснованных решений и защиты интересов участников', uz: "Asosli qarorlar qabul qilish va ishtirokchilar manfaatlarini himoya qilish uchun davlat xaridlari bozori bo'yicha ma'lumotlar va hisobotlar", en: 'Data and reports on the public procurement market for informed decision-making and protection of participant interests' },
    directions_label: { ru: 'НАПРАВЛЕНИЯ', uz: "YO'NALISHLAR", en: 'DIRECTIONS' },
    directions: [
      {
        icon: 'heroicons:chart-bar',
        title: { ru: 'Мониторинг рынка закупок', uz: 'Xaridlar bozorini monitoring', en: 'Procurement market monitoring' },
        desc: { ru: 'Ежеквартальные отчёты об объёмах, структуре и динамике рынка государственных закупок по секторам, регионам и типам процедур', uz: 'Davlat xaridlari bozorining hajmi, tuzilishi va dinamikasi bo\'yicha choraklik hisobotlar', en: 'Quarterly reports on volumes, structure and dynamics of the public procurement market by sectors, regions and procedure types' },
        tags: ['ОБНОВЛЯЕТСЯ'],
      },
      {
        icon: 'heroicons:magnifying-glass',
        title: { ru: 'Индекс прозрачности закупок', uz: 'Xaridlar shaffoflik indeksi', en: 'Procurement transparency index' },
        desc: { ru: 'Рейтинг 14 регионов и крупнейших заказчиков по уровню прозрачности, конкурентности и цифровизации закупочных процедур', uz: '14 mintaqa va eng yirik buyurtmachilarning shaffoflik, raqobatbardoshlik va raqamlashtirish darajasi bo\'yicha reytingi', en: 'Ranking of 14 regions and major customers by transparency, competitiveness and digitalization of procurement procedures' },
        tags: ['ОБНОВЛЯЕТСЯ'],
      },
      {
        icon: 'heroicons:exclamation-triangle',
        title: { ru: 'Реестр нарушений и рисков', uz: 'Buzilishlar va xatarlar reestri', en: 'Violations and risks register' },
        desc: { ru: 'База данных выявленных нарушений в тендерных процедурах — дискриминационные требования, аффилированные победители, манипуляции с ценами', uz: 'Tender tartib-qoidalarida aniqlangan buzilishlar ma\'lumotlar bazasi', en: 'Database of identified violations in tender procedures — discriminatory requirements, affiliated winners, price manipulation' },
        tags: ['ОБНОВЛЯЕТСЯ', 'ЗАКРЫТАЯ БД', 'ЧЛЕНЫ АУГЗ'],
      },
      {
        icon: 'heroicons:globe-alt',
        title: { ru: 'Международные сравнения', uz: 'Xalqaro taqqoslashlar', en: 'International comparisons' },
        desc: { ru: 'Сравнительный анализ систем госзакупок Узбекистана, Казахстана, России, ОАЭ и других стран — лучшие практики и рекомендации для реформ', uz: "O'zbekiston, Qozog'iston, Rossiya, BAA va boshqa mamlakatlar davlat xaridlari tizimlarining qiyosiy tahlili", en: 'Comparative analysis of procurement systems in Uzbekistan, Kazakhstan, Russia, UAE and other countries — best practices and reform recommendations' },
        tags: ['ОБНОВЛЯЕТСЯ', 'НА ЗАКАЗ'],
      },
    ],
    reports_label: { ru: 'ПОСЛЕДНИЕ ОТЧЁТЫ', uz: 'SO\'NGGI HISOBOTLAR', en: 'LATEST REPORTS' },
    reports: [
      {
        title: { ru: 'Рынок госзакупок 2025: годовой отчёт', uz: 'Davlat xaridlari bozori 2025: yillik hisobot', en: 'Public procurement market 2025: annual report' },
        meta: 'PDF · 48 СТР.',
        desc: { ru: 'Полный анализ за 2025 год: 42 трлн сум контрактов, региональная разбивка, топ-100 заказчиков и поставщиков, выявленные нарушения', uz: '2025 yil uchun to\'liq tahlil: 42 trillion so\'m shartnomalar, mintaqaviy bo\'linma, top-100 buyurtmachilar va yetkazib beruvchilar', en: 'Full 2025 analysis: 42 trillion sum in contracts, regional breakdown, top-100 customers and suppliers, identified violations' },
        date: 'Март 2026',
        downloads: '5 440 скачиваний',
        btn: { ru: 'Скачать PDF', uz: 'PDF yuklab olish', en: 'Download PDF' },
        href: '#',
      },
      {
        title: { ru: 'Индекс прозрачности регионов — 2026', uz: 'Mintaqalar shaffoflik indeksi — 2026', en: 'Regional transparency index — 2026' },
        meta: 'PDF · 32 СТР.',
        desc: { ru: 'Рейтинг всех 14 регионов по 5 метрикам: цифровизация, конкурентность, доля МСБ, сроки, обжалования', uz: "Barcha 14 mintaqaning 5 ko'rsatkich bo'yicha reytingi: raqamlashtirish, raqobatbardoshlik, KO'B ulushi, muddatlar, shikoyatlar", en: 'Ranking of all 14 regions across 5 metrics: digitalization, competitiveness, SMB share, deadlines, appeals' },
        date: 'Апрель 2026',
        downloads: '3 120 скачиваний',
        btn: { ru: 'Скачать PDF', uz: 'PDF yuklab olish', en: 'Download PDF' },
        href: '#',
      },
      {
        title: { ru: 'Цифровизация закупок в СНГ: сравнение', uz: 'MDH davlatlarida xaridlarni raqamlashtirish: taqqoslash', en: 'CIS procurement digitalization: comparison' },
        meta: 'PDF · 28 СТР.',
        desc: { ru: 'Узбекистан, Казахстан, Кыргызстан — 5 метрик эффективности электронных закупочных систем и рекомендации', uz: "O'zbekiston, Qozog'iston, Qirg'iziston — elektron xarid tizimlarining 5 samaradorlik ko'rsatkichi va tavsiyalar", en: 'Uzbekistan, Kazakhstan, Kyrgyzstan — 5 efficiency metrics for electronic procurement systems and recommendations' },
        date: 'Март 2026',
        downloads: '2 270 скачиваний',
        btn: { ru: 'Скачать PDF', uz: 'PDF yuklab olish', en: 'Download PDF' },
        href: '#',
      },
    ],
  },
  {
    id: 'support',
    type: 'support',
    badge: { ru: '05 — СОПРОВОЖДЕНИЕ', uz: '05 — HAMROHLIK', en: '05 — SUPPORT' },
    heading: { ru: 'СОПРОВОЖДЕНИЕ УЧАСТНИКОВ', uz: 'ISHTIROKCHILARNI HAMROHLASH', en: 'PARTICIPANT SUPPORT' },
    subtitle: { ru: 'Полное юридическое и стратегическое сопровождение на всех этапах тендерного процесса — от поиска до исполнения контракта', uz: 'Tenderni topishdan shartnomani bajarishgacha barcha bosqichlarda to\'liq yuridik va strategik hamrohlik', en: 'Full legal and strategic support at all stages of the tender process — from search to contract execution' },
    plans: [
      {
        icon: 'heroicons:document-text',
        accent: '#D1832C',
        name: { ru: 'Базовое сопровождение', uz: 'Asosiy hamrohlik', en: 'Basic support' },
        desc: { ru: 'Поддержка на этапе подготовки и подачи заявки. Проверка документов, консультации по требованиям ТЗ и ценовой стратегии', uz: 'Ariza tayyorlash va topshirish bosqichida yordam. Hujjatlarni tekshirish, texnik shartlar va narx strategiyasi bo\'yicha maslahatlar', en: 'Support at the application preparation and submission stage. Document review, technical specification and pricing strategy consultations' },
        features: ['Проверка заявки', 'Анализ ТЗ и требований', 'Ценовые рекомендации', 'Консультация до 3 часов'],
        price: { ru: 'от 500 000 сум / тендер', uz: 'tender uchun 500 000 so\'mdan', en: 'from 500,000 UZS / tender' },
      },
      {
        icon: 'heroicons:scale',
        accent: '#8B5CF6',
        name: { ru: 'Правовая защита', uz: 'Huquqiy himoya', en: 'Legal protection' },
        desc: { ru: 'Полное юридическое сопровождение: обжалование дискриминационных условий, защита при отклонении заявки, представительство в ГЗКУ и Антимонопольном комитете', uz: 'To\'liq yuridik hamrohlik: kamsituvchi shartlarga shikoyat, ariza rad etilganda himoya, DXKU va Monopoliyaga qarshi qo\'mitada vakillik', en: 'Full legal support: appealing discriminatory conditions, protection against application rejection, representation before GPPA and Antimonopoly Committee' },
        features: ['Анализ оснований для жалобы', 'Подготовка жалобы', 'Представительство в органах', '98% успешных обжалований'],
        price: { ru: 'от 1 500 000 сум / дело', uz: 'ish uchun 1 500 000 so\'mdan', en: 'from 1,500,000 UZS / case' },
      },
      {
        icon: 'heroicons:trophy',
        accent: '#3B82F6',
        name: { ru: 'Комплексное VIP-сопровождение', uz: 'Kompleks VIP-hamrohlik', en: 'Comprehensive VIP support' },
        desc: { ru: 'Полный цикл от поиска тендера до исполнения контракта. Персональный менеджер, приоритетная поддержка 24/7 и гарантия качества результата', uz: 'Tenderni topishdan shartnomani bajarishgacha to\'liq tsikl. Shaxsiy menejer, 24/7 ustuvor qo\'llab-quvvatlash va natija sifati kafolati', en: 'Full cycle from tender search to contract execution. Personal manager, priority 24/7 support and quality result guarantee' },
        features: ['Поиск и отбор тендеров', 'Полный пакет документов', 'Правовая защита включена', 'Персональный менеджер'],
        price: { ru: 'По договору · индивидуально', uz: 'Shartnoma bo\'yicha · individual', en: 'By agreement · individual' },
      },
    ],
  },
  {
    id: 'extra-services',
    type: 'extra-services',
    badge: { ru: '06 — СЕРВИСЫ', uz: '06 — SERVISLAR', en: '06 — SERVICES' },
    heading: { ru: 'ДОПОЛНИТЕЛЬНЫЕ СЕРВИСЫ', uz: "QO'SHIMCHA SERVISLAR", en: 'ADDITIONAL SERVICES' },
    subtitle: { ru: 'Специализированные услуги для профессиональной работы с закупочным рынком', uz: 'Xaridlar bozori bilan professional ishlash uchun ixtisoslashtirilgan xizmatlar', en: 'Specialized services for professional work with the procurement market' },
    services: [
      {
        emoji: '📄',
        name: { ru: 'Шаблоны документов', uz: 'Hujjat shablonlari', en: 'Document templates' },
        desc: { ru: 'Библиотека из 50+ готовых шаблонов тендерных заявок, гарантийных писем, договоров и актов для Узбекистана', uz: "O'zbekiston uchun 50+ tayyor tender arizalari, kafolat xatlari, shartnomalar va dalolatnomalar kutubxonasi", en: 'Library of 50+ ready-made templates for tender applications, guarantee letters, contracts and acts for Uzbekistan' },
        link_label: { ru: 'Скачать', uz: 'Yuklab olish', en: 'Download' },
        href: '#',
      },
      {
        emoji: '🔔',
        name: { ru: 'Telegram-мониторинг', uz: 'Telegram-monitoring', en: 'Telegram monitoring' },
        desc: { ru: 'Персонализированный бот для мгновенных уведомлений о новых тендерах по вашим параметрам — до 50 уведомлений в день', uz: 'Parametrlaringiz bo\'yicha yangi tenderlar haqida tezkor bildirishnomalar uchun shaxsiylashtirilgan bot — kuniga 50 tagacha bildirishnoma', en: 'Personalised bot for instant notifications about new tenders by your parameters — up to 50 notifications per day' },
        link_label: { ru: 'Подключить', uz: "Ulash", en: 'Connect' },
        href: '#',
      },
      {
        emoji: '🏛',
        name: { ru: 'Аккредитация на площадках', uz: 'Maydonlarda akkreditatsiya', en: 'Platform accreditation' },
        desc: { ru: 'Помощь в регистрации и аккредитации на e-xarid.uz, TenderZone, cooperation.uz и других закупочных платформах', uz: 'e-xarid.uz, TenderZone, cooperation.uz va boshqa xarid platformalarida ro\'yxatdan o\'tish va akkreditatsiyada yordam', en: 'Assistance with registration and accreditation on e-xarid.uz, TenderZone, cooperation.uz and other procurement platforms' },
        link_label: { ru: 'Заказать', uz: 'Buyurtma berish', en: 'Order' },
        href: '#',
      },
      {
        emoji: '📰',
        name: { ru: 'PR и репутация', uz: 'PR va obro\'', en: 'PR & reputation' },
        desc: { ru: 'Размещение материалов о компании на площадках АУГЗ, участие в форумах как спикер, повышение узнаваемости на закупочном рынке', uz: 'AUGZ platformalarida kompaniya haqida materiallarni joylashtirish, forumlarda spiker sifatida ishtirok etish, xaridlar bozorida tanilishni oshirish', en: 'Placement of company materials on AUGZ platforms, participation in forums as a speaker, increasing brand recognition in the procurement market' },
        link_label: { ru: 'Обсудить', uz: 'Muhokama qilish', en: 'Discuss' },
        href: '#',
      },
      {
        emoji: '🎓',
        name: { ru: 'Корпоративное обучение', uz: 'Korporativ ta\'lim', en: 'Corporate training' },
        desc: { ru: 'Индивидуальные тренинги и воркшопы по госзакупкам для команды компании — офлайн в Ташкенте или онлайн', uz: 'Kompaniya jamoasi uchun individual treninglar va master-klasslar — Toshkentda oflayn yoki onlayn', en: 'Individual training and workshops on public procurement for your company team — offline in Tashkent or online' },
        link_label: { ru: 'Заказать тренинг', uz: 'Trening buyurtma berish', en: 'Order training' },
        href: '#',
      },
    ],
  },
  {
    id: 'cta',
    type: 'cta-form',
    badge: { ru: 'СВЯЗАТЬСЯ С НАМИ', uz: 'BIZ BILAN BOG\'LANISH', en: 'CONTACT US' },
    heading_1: { ru: 'ОБСУДИМ ВАШУ', uz: 'VAZIFANGIZNI', en: "LET'S DISCUSS" },
    heading_2: { ru: 'ЗАДАЧУ', uz: 'MUHOKAMA', en: 'YOUR TASK' },
    heading_3: { ru: 'БЕСПЛАТНО', uz: 'BEPUL', en: 'FOR FREE' },
    desc: { ru: 'Наши эксперты изучат вашу ситуацию и предложат оптимальное решение из нашего портфеля услуг', uz: 'Ekspertlarimiz vaziyatingizni o\'rganib, xizmatlar portfelimizdan optimal yechim taklif etadi', en: 'Our experts will study your situation and suggest the optimal solution from our service portfolio' },
    contacts: [
      { icon: 'heroicons:phone', label: { ru: 'Телефон', uz: 'Telefon', en: 'Phone' }, value: '+998 55 503 12 21' },
      { icon: 'heroicons:envelope', label: { ru: 'Email', uz: 'Email', en: 'Email' }, value: 'info@augz.uz' },
      { icon: 'heroicons:map-pin', label: { ru: 'Адрес', uz: 'Manzil', en: 'Address' }, value: 'г. Ташкент, ул. Нукус, д. 89' },
      { icon: 'heroicons:chat-bubble-left-ellipsis', label: { ru: 'Telegram', uz: 'Telegram', en: 'Telegram' }, value: '@augz_uz' },
    ],
    form_title: { ru: 'Оставьте заявку', uz: 'Ariza qoldiring', en: 'Leave a request' },
    form_subtitle: { ru: 'Ответим в течение 4 рабочих часов', uz: '4 ish soati ichida javob beramiz', en: 'We will respond within 4 business hours' },
    form_name_label: { ru: 'ВАШЕ ИМЯ', uz: 'ISMINGIZ', en: 'YOUR NAME' },
    form_name_placeholder: { ru: 'Фамилия Имя', uz: 'Familiya Ism', en: 'Full name' },
    form_phone_label: { ru: 'ТЕЛЕФОН', uz: 'TELEFON', en: 'PHONE' },
    form_email_label: { ru: 'EMAIL', uz: 'EMAIL', en: 'EMAIL' },
    form_service_label: { ru: 'НУЖНАЯ УСЛУГА', uz: 'KERAKLI XIZMAT', en: 'SERVICE NEEDED' },
    form_service_options: [
      'Консалтинг — стратегия и документация',
      'Правовое сопровождение и обжалование',
      'Цифровые продукты (TenderZone, AI)',
      'Аналитика и исследования',
      'Корпоративное обучение',
      'VIP-сопровождение',
      'Другое',
    ],
    form_btn: { ru: 'Отправить заявку', uz: 'Ariza yuborish', en: 'Submit request' },
  },
]

useSeoMeta({
  title: 'Услуги АУГЗ — консалтинг, аналитика, сопровождение в закупках',
  description: 'Полный спектр услуг для участников тендеров: тендерный консалтинг, юридическое сопровождение, аналитика рынка, цифровые решения и корпоративное обучение.',
  ogTitle: 'Услуги АУГЗ — консалтинг и сопровождение в закупках',
  ogDescription: 'Тендерный консалтинг, юридическое сопровождение, аналитика рынка, цифровые решения и обучение для участников государственных закупок.',
  ogImage: '/og-default.jpg',
  ogUrl: 'https://augz.uz/services',
  ogType: 'website',
  twitterCard: 'summary_large_image',
  twitterTitle: 'Услуги АУГЗ',
  twitterDescription: 'Консалтинг, аналитика, юридическое сопровождение и цифровые решения для участников тендеров.',
})
</script>
