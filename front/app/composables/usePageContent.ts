export interface I18nText { ru: string; uz: string; en: string }

export interface AboutPageContent {
  hero: {
    image: string
    heading: I18nText
    subtitle: I18nText
    btn_label: I18nText
    btn_href: string
  }
  intro: {
    badge: I18nText
    heading: I18nText
    desc: I18nText
    btn_label: I18nText
    btn_href: string
    stats: Array<{ icon: string; value: string; label: I18nText; accent_color: string }>
  }
  mission: {
    label: I18nText
    heading: I18nText
    text: I18nText
    location: I18nText
    stats: Array<{ icon: string; value: string; label: I18nText }>
  }
  values: {
    heading: I18nText
    items: Array<{ icon: string; title: I18nText; desc: I18nText }>
  }
  leaders: {
    label: I18nText
    heading: I18nText
    subtitle: I18nText
  }
  timeline: {
    label: I18nText
    heading: I18nText
    items: Array<{ year: string; title: I18nText; desc: I18nText }>
  }
}

export interface HomePageContent {
  hero: {
    image: string
    title_1: I18nText; title_2: I18nText; title_3: I18nText
    subtitle: I18nText
    btn_primary:   { label: I18nText; href: string }
    btn_secondary: { label: I18nText; href: string }
  }
  about: {
    heading: I18nText
    all_services_label: I18nText
    features: Array<{ icon: string; title: I18nText; desc: I18nText }>
  }
  stats: {
    label: I18nText; heading: I18nText
    items: Array<{ icon: string; value: I18nText; label: I18nText }>
  }
  partners: {
    heading: I18nText
    logos: Array<{ src: string; alt: string }>
  }
  contacts: {
    label: I18nText; heading: I18nText
    address_value: I18nText
    phone: string; email: string
  }
  footer: {
    tagline: I18nText; description: I18nText
  }
}

export interface ReportPageContent {
  hero:         { badge: I18nText; title: I18nText; subtitle: I18nText }
  info_banner:  { text: I18nText; days: I18nText; after_text: I18nText; track_word: I18nText; suffix: I18nText }
  sidebar: {
    info_title: I18nText
    info_items: I18nText[]
    stats: Array<{ icon: string; value: string; label: I18nText }>
  }
  form: {
    tabs: { submit: I18nText; track: I18nText }
    steps: Array<{ label: I18nText }>
    section1_title: I18nText; label_org: I18nText; placeholder_org: I18nText
    label_tender: I18nText; placeholder_tender: I18nText; label_date: I18nText
    label_desc: I18nText; placeholder_desc: I18nText
    section2_title: I18nText; section2_optional: I18nText
    upload_title: I18nText; upload_hint: I18nText; upload_formats: I18nText
    section3_title: I18nText; anon_label: I18nText; anon_hint: I18nText
    label_name: I18nText; placeholder_name: I18nText
    label_sender_org: I18nText; placeholder_sender_org: I18nText
    label_phone: I18nText; label_email: I18nText
    agree_text: I18nText; agree_privacy: I18nText; agree_and: I18nText; agree_rules: I18nText
    btn_submit: I18nText; btn_call: I18nText
  }
  track: {
    sidebar_title: I18nText; sidebar_items: I18nText[]
    status_legend: Array<{ color: string; label: I18nText; desc: I18nText }>
    search_title: I18nText; search_hint: I18nText; search_placeholder: string
    btn_find: I18nText; empty_title: I18nText; empty_hint: I18nText
    not_found_title: I18nText; not_found_text: I18nText
    stages_title: I18nText; btn_new: I18nText; btn_call: I18nText
  }
  success_modal: {
    title: I18nText; subtitle: I18nText; track_label: I18nText
    btn_copy: I18nText; btn_copied: I18nText; email_prefix: I18nText
    meta_category: I18nText; meta_date: I18nText; meta_expert: I18nText; meta_deadline: I18nText
    expert_name: I18nText; category_name: I18nText
    progress_steps: Array<{ label: I18nText; time: I18nText }>
    btn_track: I18nText; btn_close: I18nText
  }
}

export function usePageContent() {
  return useState<HomePageContent | null>('home-page-content', () => null)
}

export function useAboutPageContent() {
  return useState<AboutPageContent | null>('about-page-content', () => null)
}

export function useLocaleText() {
  const { locale } = useI18n()
  return (field: I18nText | undefined): string => {
    if (!field) return ''
    return field[locale.value as 'ru' | 'uz' | 'en'] ?? field.ru ?? ''
  }
}
