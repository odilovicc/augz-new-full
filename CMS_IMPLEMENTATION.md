# CMS Implementation — Редактируемый контент (Back + Admin)

## Цель

Сделать статический контент сайта (тексты, изображения, переводы) редактируемым из
административной панели без участия разработчика. Динамические сущности (услуги, новости,
видео) управляются через отдельные CRUD-страницы.

---

## Архитектурное решение

**Один запрос на страницу.** Весь статический контент страницы хранится в PostgreSQL как
JSONB-поле и возвращается единственным `GET /api/page/{slug}`. Frontend делает этот запрос
один раз при SSR, результат сохраняется в `useState` и доступен всем дочерним компонентам.

**Два типа контента:**

| Тип | Хранение | Редактирование |
|-----|----------|----------------|
| Статический (тексты, кнопки, изображения страниц) | `pages.content` (JSONB) | `/admin/pages/[slug]` |
| Динамический (услуги, новости, видео) | Отдельные таблицы | Отдельные CRUD-страницы |

---

## Backend (`back/`)

### 1. Миграции

**`2026_05_22_175937_create_pages_table.php`**
```
pages
  id
  slug        string, unique   — идентификатор страницы (home, news, services, membership)
  content     jsonb            — весь контент страницы
  timestamps
```

**`2026_05_22_183912_create_services_table.php`**
```
services
  id
  image       string nullable  — URL изображения в Laravel storage
  title       string           — название (ru, основной язык)
  tag         string nullable  — тег (ru)
  desc        text nullable    — описание (ru)
  translations jsonb           — переводы { uz: {title, tag, desc}, en: {title, tag, desc} }
  sort_order  integer default 0
  timestamps
```

### 2. Модели

**`app/Models/Page.php`**
```php
protected $fillable = ['slug', 'content'];
protected $casts    = ['content' => 'array'];
```

**`app/Models/Service.php`**
```php
protected $fillable = ['image', 'title', 'tag', 'desc', 'translations', 'sort_order'];
protected $casts    = ['translations' => 'array'];
```

### 3. Контроллеры

**`app/Http/Controllers/Api/PageController.php`** — публичный
- `show(string $slug)` — кеширует на 3600с через `Cache::remember("page:{$slug}", ...)`, возвращает `{ slug, content }`
- Только известные slug'и (`home`, `news`, `services`, `membership`) — остальные 404

**`app/Http/Controllers/Api/Admin/PageController.php`** — под auth:sanctum
- `show(string $slug)` — возвращает полный content для формы редактирования
- `update(UpdatePageRequest $request, string $slug)` — сохраняет, вызывает `Cache::forget("page:{$slug}")`

**`app/Http/Controllers/Api/Admin/ServiceController.php`** — под auth:sanctum
- `index()` — список всех услуг через `ServiceResource::collection`
- `store(StoreServiceRequest)` — создаёт, `sort_order = max(sort_order) + 1`
- `update(UpdateServiceRequest, Service)` — обновляет
- `destroy(Service)` — удаляет

**`app/Http/Controllers/Api/ServiceController.php`** — публичный
- `index()` — возвращает все услуги через `ServiceResource::collection`

### 4. Resource

**`app/Http/Resources/ServiceResource.php`**

Возвращает i18n-объекты для всех текстовых полей:
```php
'title' => ['ru' => $this->title, 'uz' => ..., 'en' => ...],
'tag'   => ['ru' => $this->tag ?? '', 'uz' => ..., 'en' => ...],
'desc'  => ['ru' => $this->desc ?? '', 'uz' => ..., 'en' => ...],
```
Так фронтенд получает единообразную структуру `{ ru, uz, en }` для каждого поля.

### 5. Form Requests

- `UpdatePageRequest` — валидирует `content` как массив
- `StoreServiceRequest` / `UpdateServiceRequest` — валидируют `title`, `image`, `sort_order`, `translations`

### 6. Маршруты (`routes/api.php`)

```php
// Публичные
GET  /api/page/{slug}      → PageController@show
GET  /api/services         → ServiceController@index

// Админ (auth:sanctum)
GET  /api/admin/page/{slug}           → Admin\PageController@show
PUT  /api/admin/page/{slug}           → Admin\PageController@update

GET  /api/admin/services              → Admin\ServiceController@index
POST /api/admin/services              → Admin\ServiceController@store
PUT  /api/admin/services/{service}    → Admin\ServiceController@update
DELETE /api/admin/services/{service}  → Admin\ServiceController@destroy
```

### 7. Сидеры

**`PageSeeder.php`**
- Заполняет `pages` для slug `home` через `Page::updateOrCreate(['slug' => 'home'], ['content' => [...]])`
- Все URL изображений строятся через `config('app.url')` → переносимо между окружениями
- Содержит: hero (с изображением), about (features — 4 карточки без услуг), stats, partners (с логотипами), contacts, footer
- Полные переводы ru/uz/en для каждого текстового поля

**`ServiceSeeder.php`**
- 5 услуг через `Service::updateOrCreate(['title' => $data['title']], $data)`
- Изображения: `{config('app.url')}/storage/pages/cons1-5.png`
- Полные переводы ru/uz/en

**`DatabaseSeeder.php`**
```php
$this->call([
    AdminUserSeeder::class,
    NewsArticleSeeder::class,
    VideoSeeder::class,
    PageSeeder::class,
    ServiceSeeder::class,
]);
```

Запуск: `php artisan migrate --seed` — база будет заполнена полностью.

---

## Admin Panel (`admin/`)

### 1. Новые компоненты

**`app/components/ImageUpload.vue`**
- Drag-and-drop загрузка изображений через `POST /api/admin/upload/image`
- Если изображение выбрано — показывает крупный 16:9 превью (max 320px высотой) с hover-оверлеем «Заменить»
- Если изображения нет — показывает drop-zone
- URL-инпут для ручного ввода ссылки
- Compact-режим для логотипов (маленькая кнопка загрузки)

**`app/components/I18nField.vue`**
- Рендерит три строки (ru / uz / en) для одного поля
- Поддерживает `type="input"` и `type="textarea"`

**`app/components/SaveBar.vue`**
- Кнопка сохранения с loading-состоянием
- Показывает «Сохранено» на 2 секунды после успеха

### 2. Страница редактора страниц

**`app/pages/pages/[slug].vue`**

Универсальный редактор для любого slug. Для `home` отображает 6 вкладок:
- **Hero** — изображение фона, три строки заголовка, подзаголовок, две кнопки (label + href)
- **О нас** — заголовок раздела, label кнопки, 4 feature-карточки (icon + title + desc). Уведомление: карточки услуг управляются в разделе «Услуги»
- **Статистика** — label, заголовок, 5 stat-карточек (icon + value + label)
- **Партнёры** — заголовок, список логотипов (src + alt + ImageUpload)
- **Контакты** — label, заголовок, адрес, телефон, email
- **Подвал** — tagline, описание

Единая кнопка `Сохранить` (SaveBar) отправляет весь объект `content` через `PUT /api/admin/page/{slug}`.

### 3. Страница услуг

**`app/pages/services/index.vue`**
- Таблица: миниатюра, название/описание (ru), тег, sort_order, кнопки редактирования/удаления
- USlideover с языковыми вкладками (🇷🇺 / 🇺🇿 / 🇬🇧)
- Индикатор незаполненного перевода (жёлтая точка)
- Поля на каждой вкладке: название (обязательно), тег, описание
- ImageUpload + поле порядка сортировки
- Создание / редактирование через один `save()` — `POST` или `PUT` в зависимости от наличия `editItem`

### 4. Навигация (`app/layouts/default.vue`)

```
Контент страниц          ← статический CMS
  Главная  (/pages/home)
  Стр. новостей  (/pages/news)
  Стр. услуг  (/pages/services)
  Стр. членства  (/pages/membership)

Динамика                 ← CRUD сущностей
  Услуги  (/services)
  Новости  (/news)
  Видео  (/videos)
```

---

## Frontend (`front/`)

### Composables

**`app/composables/usePageContent.ts`**
```typescript
export function usePageContent() {
  return useState<HomePageContent | null>('home-page-content', () => null)
}

export function useLocaleText() {
  const { locale } = useI18n()
  return (field: I18nText | undefined): string =>
    field?.[locale.value as 'ru' | 'uz' | 'en'] ?? field?.ru ?? ''
}
```

**`app/pages/index.vue`** — один SSR-запрос:
```typescript
const { data } = await useFetch<{ slug: string; content: HomePageContent }>(
  `${config.public.apiBase}/page/home`,
  { key: 'home-page', server: true },
)
if (data.value?.content) { pageContent.value = data.value.content }
```

Все дочерние компоненты вызывают `usePageContent()` и `useLocaleText()` — дополнительных
запросов к API нет.

**`app/components/SectionAbout.vue`** — услуги загружаются отдельно (динамика):
```typescript
const { data: servicesData } = await useAsyncData(
  'services-list',
  () => $fetch<{ data: Service[] }>(`${config.public.apiBase}/services?lang=${locale.value}`),
  { watch: [locale] },
)
```

---

## Поток данных

```
Admin редактирует контент
  → PUT /api/admin/page/home { content: {...} }
  → Контроллер сохраняет в DB + инвалидирует кеш

Пользователь открывает сайт
  → SSR: GET /api/page/home
  → Кеш (1 час) → DB → { slug, content }
  → useState('home-page-content') = content
  → Все компоненты читают из useState — 0 доп. запросов
```

---

## Запуск с нуля

```bash
# Backend
cd back
cp .env.example .env        # настроить DB, APP_URL
php artisan key:generate
php artisan migrate --seed  # создаст таблицы + заполнит контент и сущности

# Admin
cd admin && npm install && npm run dev   # http://localhost:4000

# Frontend
cd front && npm install && npm run dev  # http://localhost:3000
```

Credentials по умолчанию: `admin@admin.ru` / `123123`
