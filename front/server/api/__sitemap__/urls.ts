import { defineEventHandler } from 'h3'

interface NewsItem {
  id: number
  published_at: string | null
  image: string | null
}

export default defineEventHandler(async () => {
  const config = useRuntimeConfig()
  const apiBase = config.public.apiBase

  try {
    const res = await $fetch<{ data: NewsItem[] }>(
      `${apiBase}/news?per_page=200&sort=newest`,
    )

    return (res.data ?? []).map((article) => ({
      loc: `/news/${article.id}`,
      lastmod: article.published_at ?? undefined,
      changefreq: 'weekly',
      priority: 0.8,
      images: article.image
        ? [{ loc: article.image, title: `Article ${article.id}` }]
        : undefined,
    }))
  } catch {
    return []
  }
})
