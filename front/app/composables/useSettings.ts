export interface SiteSettings {
  logo_desc?: { ru: string; uz: string; en: string }
  contacts: {
    phone: string
    email: string
    telegram: string
    telegram_url: string
  }
  address: {
    text: string
    zip: string
    maps_url: string
    lat: number
    lng: number
  }
  hours: {
    days: string
    from: string
    to: string
  }
  socials: Array<{
    id: string
    name: string
    handle: string
    url: string
    icon: string
  }>
  departments: Array<{
    name: string | { ru: string; uz: string; en: string }
    desc: string | { ru: string; uz: string; en: string }
    responsible: string | { ru: string; uz: string; en: string }
    phone: string
    email: string
  }>
}

const FALLBACK: SiteSettings = {
  logo_desc: { ru: 'Ассоциация участников государственных закупок (АУГЗ)', uz: 'Davlat zakazlarining ishtrokchilari assotsiatsiyasi', en: 'Association of Participants in Government Procurements (AUGZ)' },
  contacts: { phone: '+998 55 503 12 21', email: 'info@augz.uz', telegram: '@augz_uz', telegram_url: 'https://t.me/augz_uz' },
  address:  { text: 'г. Ташкент, Мирабадский район, ул. Нукуса, 89', zip: '100000', maps_url: '', lat: 41.2986, lng: 69.2757 },
  hours:    { days: 'Пн–Пт', from: '09:00', to: '18:00' },
  socials:  [],
  departments: [],
}

export function useSettings() {
  return useState<SiteSettings>('site-settings', () => FALLBACK)
}

export function useHoursLabel() {
  const settings = useSettings()
  return computed(() => {
    const h = settings.value?.hours
    if (!h?.days) return 'Пн–Пт · 9:00–18:00'
    return `${h.days} · ${h.from}–${h.to}`
  })
}
