import type { I18nText } from './usePageContent'

export interface ServiceItem {
  number: string
  title: I18nText
  desc: I18nText
  tags: string[]
}

export interface ServiceSection {
  id: string
  badge: I18nText
  heading: I18nText
  subtitle: I18nText
  items: ServiceItem[]
  stats: Array<{ value: string; label: I18nText }>
  stats_label: I18nText
  stats_desc: I18nText
  cta_label: I18nText
  cta_href: string
  express_title: I18nText
  express_desc: I18nText
  express_btn: I18nText
}

export interface ServicesPageContent {
  hero: {
    image: string
    badge: I18nText
    title_1: I18nText
    title_2: I18nText
    subtitle: I18nText
    categories: Array<{ label: I18nText; color: string }>
  }
  sections: ServiceSection[]
}

export function useServicesPageContent() {
  return useState<ServicesPageContent | null>('services-page-content', () => null)
}
