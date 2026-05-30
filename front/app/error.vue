<template>
  <div class="min-h-screen bg-[#f5f5f0] flex flex-col">

    <!-- Top accent bar -->
    <div class="h-1 w-full bg-(--theme-color)" />

    <!-- Main content -->
    <div class="flex-1 flex items-center justify-center px-4 py-20">
      <div class="max-w-lg w-full text-center">

        <!-- Illustration -->
        <div class="flex justify-center mb-8 select-none" aria-hidden="true">
          <svg v-if="!is500" width="340" height="260" viewBox="0 0 340 260" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Ground shadow -->
            <ellipse cx="170" cy="248" rx="110" ry="10" fill="#e0ddd8"/>

            <!-- Background document (tilted) -->
            <g transform="rotate(-8 160 130)">
              <rect x="80" y="60" width="100" height="130" rx="8" fill="white" stroke="#e5e1db" stroke-width="1.5"/>
              <rect x="95" y="85" width="70" height="6" rx="3" fill="#e5e1db"/>
              <rect x="95" y="100" width="55" height="5" rx="2.5" fill="#ede9e3"/>
              <rect x="95" y="113" width="65" height="5" rx="2.5" fill="#ede9e3"/>
              <rect x="95" y="126" width="45" height="5" rx="2.5" fill="#ede9e3"/>
              <rect x="95" y="139" width="60" height="5" rx="2.5" fill="#ede9e3"/>
              <!-- Stamp -->
              <rect x="115" y="158" width="36" height="18" rx="4" fill="#fef0de" stroke="#D1832C" stroke-width="1.5"/>
              <rect x="120" y="163" width="26" height="3" rx="1.5" fill="#D1832C"/>
              <rect x="122" y="169" width="18" height="3" rx="1.5" fill="#D1832C" opacity="0.5"/>
            </g>

            <!-- Main document (front) -->
            <rect x="130" y="50" width="108" height="142" rx="10" fill="white" stroke="#d6d2cb" stroke-width="1.5" filter="url(#shadow)"/>
            <!-- doc lines -->
            <rect x="147" y="74" width="74" height="7" rx="3.5" fill="#1a2236" opacity="0.12"/>
            <rect x="147" y="90" width="60" height="5" rx="2.5" fill="#e2ddd7"/>
            <rect x="147" y="103" width="68" height="5" rx="2.5" fill="#e2ddd7"/>
            <rect x="147" y="116" width="52" height="5" rx="2.5" fill="#e2ddd7"/>
            <rect x="147" y="129" width="64" height="5" rx="2.5" fill="#e2ddd7"/>
            <rect x="147" y="142" width="44" height="5" rx="2.5" fill="#e2ddd7"/>
            <!-- Big question mark on doc -->
            <text x="184" y="178" text-anchor="middle" font-size="32" font-weight="900" font-family="sans-serif" fill="#D1832C" opacity="0.18">?</text>
            <!-- doc dog-ear -->
            <path d="M222 50 L238 66 L222 66 Z" fill="#ede9e3"/>
            <path d="M222 50 L238 66" stroke="#d6d2cb" stroke-width="1.5"/>

            <!-- Person body -->
            <!-- legs -->
            <rect x="155" y="210" width="14" height="32" rx="7" fill="#1a2236"/>
            <rect x="175" y="210" width="14" height="32" rx="7" fill="#1a2236"/>
            <!-- shoes -->
            <ellipse cx="162" cy="242" rx="10" ry="5" fill="#111827"/>
            <ellipse cx="182" cy="242" rx="10" ry="5" fill="#111827"/>
            <!-- torso -->
            <rect x="148" y="158" width="48" height="58" rx="14" fill="#1a2236"/>
            <!-- collar accent -->
            <rect x="165" y="158" width="14" height="10" rx="4" fill="#D1832C"/>
            <!-- left arm (pointing at doc with magnifier) -->
            <path d="M148 175 Q118 168 108 160" stroke="#1a2236" stroke-width="14" stroke-linecap="round" fill="none"/>
            <!-- right arm (at side) -->
            <path d="M196 175 Q210 185 208 200" stroke="#1a2236" stroke-width="14" stroke-linecap="round" fill="none"/>

            <!-- Head -->
            <circle cx="172" cy="140" r="24" fill="#f5c9a0"/>
            <!-- hair -->
            <path d="M149 133 Q152 110 172 108 Q192 110 195 133" fill="#1a2236"/>
            <!-- eyes -->
            <circle cx="164" cy="138" r="3" fill="#1a2236"/>
            <circle cx="180" cy="138" r="3" fill="#1a2236"/>
            <!-- eye shine -->
            <circle cx="165.2" cy="136.8" r="1" fill="white"/>
            <circle cx="181.2" cy="136.8" r="1" fill="white"/>
            <!-- brow puzzled -->
            <path d="M161 131 Q164 128 167 131" stroke="#1a2236" stroke-width="1.5" stroke-linecap="round" fill="none"/>
            <path d="M177 130 Q180 133 183 130" stroke="#1a2236" stroke-width="1.5" stroke-linecap="round" fill="none"/>
            <!-- mouth - puzzled -->
            <path d="M167 147 Q172 144 177 147" stroke="#c2956a" stroke-width="1.5" stroke-linecap="round" fill="none"/>

            <!-- Magnifier -->
            <circle cx="106" cy="158" r="18" fill="none" stroke="#D1832C" stroke-width="4"/>
            <circle cx="106" cy="158" r="18" fill="#D1832C" opacity="0.08"/>
            <!-- magnifier glass shine -->
            <path d="M98 150 Q102 146 108 148" stroke="white" stroke-width="2" stroke-linecap="round" fill="none" opacity="0.6"/>
            <!-- handle -->
            <line x1="118" y1="170" x2="132" y2="184" stroke="#D1832C" stroke-width="5" stroke-linecap="round"/>

            <!-- Floating 404 -->
            <text x="170" y="30" text-anchor="middle" font-size="28" font-weight="900" font-family="sans-serif" letter-spacing="-1" fill="#1a2236" opacity="0.08">404</text>

            <!-- Small decorative dots -->
            <circle cx="50" cy="90" r="4" fill="#D1832C" opacity="0.25"/>
            <circle cx="38" cy="110" r="2.5" fill="#D1832C" opacity="0.18"/>
            <circle cx="62" cy="115" r="2" fill="#1a2236" opacity="0.12"/>
            <circle cx="290" cy="80" r="5" fill="#D1832C" opacity="0.2"/>
            <circle cx="305" cy="100" r="3" fill="#1a2236" opacity="0.1"/>
            <circle cx="278" cy="105" r="2" fill="#D1832C" opacity="0.15"/>

            <defs>
              <filter id="shadow" x="-10%" y="-10%" width="120%" height="120%">
                <feDropShadow dx="0" dy="4" stdDeviation="6" flood-color="#1a2236" flood-opacity="0.08"/>
              </filter>
            </defs>
          </svg>

          <!-- 500 illustration: server with warning -->
          <svg v-else width="320" height="240" viewBox="0 0 320 240" fill="none" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="160" cy="232" rx="100" ry="8" fill="#e0ddd8"/>
            <!-- Server stack -->
            <rect x="80" y="80" width="160" height="36" rx="8" fill="white" stroke="#d6d2cb" stroke-width="1.5"/>
            <circle cx="102" cy="98" r="5" fill="#22c55e"/>
            <circle cx="118" cy="98" r="5" fill="#D1832C"/>
            <rect x="135" y="93" width="90" height="4" rx="2" fill="#e2ddd7"/>
            <rect x="135" y="101" width="60" height="4" rx="2" fill="#ede9e3"/>

            <rect x="80" y="126" width="160" height="36" rx="8" fill="white" stroke="#d6d2cb" stroke-width="1.5"/>
            <circle cx="102" cy="144" r="5" fill="#ef4444"/>
            <circle cx="118" cy="144" r="5" fill="#e2ddd7"/>
            <rect x="135" y="139" width="90" height="4" rx="2" fill="#e2ddd7"/>
            <rect x="135" y="147" width="70" height="4" rx="2" fill="#ede9e3"/>

            <rect x="80" y="172" width="160" height="36" rx="8" fill="white" stroke="#d6d2cb" stroke-width="1.5"/>
            <circle cx="102" cy="190" r="5" fill="#e2ddd7"/>
            <circle cx="118" cy="190" r="5" fill="#e2ddd7"/>
            <rect x="135" y="185" width="90" height="4" rx="2" fill="#e2ddd7"/>
            <rect x="135" y="193" width="50" height="4" rx="2" fill="#ede9e3"/>

            <!-- Warning triangle -->
            <path d="M160 20 L210 105 L110 105 Z" fill="#D1832C" opacity="0.15"/>
            <path d="M160 20 L210 105 L110 105 Z" fill="none" stroke="#D1832C" stroke-width="3" stroke-linejoin="round"/>
            <text x="160" y="86" text-anchor="middle" font-size="38" font-weight="900" font-family="sans-serif" fill="#D1832C">!</text>

            <circle cx="60" cy="100" r="4" fill="#D1832C" opacity="0.2"/>
            <circle cx="48" cy="120" r="2.5" fill="#D1832C" opacity="0.15"/>
            <circle cx="260" cy="95" r="5" fill="#D1832C" opacity="0.2"/>
            <circle cx="275" cy="118" r="3" fill="#1a2236" opacity="0.1"/>
          </svg>
        </div>

        <!-- Title & description -->
        <h1 class="text-2xl sm:text-3xl font-black text-gray-900 mb-3">{{ title }}</h1>
        <p class="text-gray-500 text-sm sm:text-base leading-relaxed mb-10 max-w-sm mx-auto">{{ description }}</p>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
          <NuxtLink
            :to="localePath('/')"
            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-(--theme-color) text-white font-semibold text-sm hover:opacity-90 transition-opacity"
          >
            <Icon name="heroicons:home" class="w-4 h-4" />
            {{ t('error_page.btn_home') }}
          </NuxtLink>
          <button
            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-200 bg-white text-gray-700 font-semibold text-sm hover:border-gray-300 hover:bg-gray-50 transition"
            @click="handleBack"
          >
            <Icon name="heroicons:arrow-left" class="w-4 h-4" />
            {{ t('error_page.btn_back') }}
          </button>
        </div>

        <!-- 500 only: retry -->
        <button
          v-if="is500"
          class="mt-4 text-xs text-gray-400 hover:text-(--theme-color) transition-colors underline underline-offset-2"
          @click="clearError({ redirect: '/' })"
        >
          {{ t('error_page.btn_retry') }}
        </button>

      </div>
    </div>

    <!-- Footer strip -->
    <div class="border-t border-gray-200 bg-white">
      <div class="container mx-auto px-4 py-5 flex flex-col sm:flex-row items-center justify-between gap-3">
        <span class="text-xs text-gray-400">{{ t('footer.copyright') }}</span>
        <div class="flex items-center gap-4">
          <a href="tel:+998555031221" class="flex items-center gap-1.5 text-xs text-gray-500 hover:text-(--theme-color) transition-colors">
            <Icon name="mdi:phone" class="w-3.5 h-3.5" />
            +998 55 503 12 21
          </a>
          <a href="mailto:info@augz.uz" class="flex items-center gap-1.5 text-xs text-gray-500 hover:text-(--theme-color) transition-colors">
            <Icon name="mdi:email" class="w-3.5 h-3.5" />
            info@augz.uz
          </a>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup lang="ts">
import type { NuxtError } from '#app'

const props = defineProps<{ error: NuxtError }>()

const { t } = useI18n()
const localePath = useLocalePath()
const router = useRouter()

const code = computed(() => props.error.statusCode ?? 500)
const is500 = computed(() => code.value >= 500)

const icon = computed(() =>
  is500.value ? 'heroicons:exclamation-triangle' : 'heroicons:magnifying-glass'
)

const title = computed(() =>
  is500.value ? t('error_page.title_500') : t('error_page.title_404')
)

const description = computed(() =>
  is500.value ? t('error_page.desc_500') : t('error_page.desc_404')
)

function handleBack() {
  if (window.history.length > 1) {
    router.back()
  } else {
    clearError({ redirect: '/' })
  }
}
</script>
