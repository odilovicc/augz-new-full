# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project structure

Monorepo with three top-level directories:

- `front/` — public-facing Nuxt 4 website (landing page for an Uzbekistan procurement association)
- `back/` — Laravel 11 + PostgreSQL backend (REST API)
- `admin/` — Nuxt 4 + Nuxt UI admin panel

## Front (`front/`)

### Commands

```bash
cd front
npm install          # install dependencies
npm run dev          # dev server at http://localhost:3000
npm run build        # production build
npm run generate     # static site generation
npm run preview      # preview production build
```

### Stack

- **Nuxt 4** with `app/` directory layout (source lives in `front/app/`, not `front/`)
- **Tailwind CSS v4** via `@tailwindcss/vite` plugin (no `tailwind.config.ts` — config is in CSS)
- **`@nuxt/icon`** for icons, **`@nuxt/fonts`** for font loading (Manrope)
- No state management library; no test suite yet

### Architecture

The site is a single-page landing (`app/pages/index.vue`) composed of sequential section components:

```
Navbar → Hero → SectionAbout → SectionNews → SectionStats → SectionPartners → SectionContacts → AppFooter
```

**`app/components/ui/`** — shared primitives (`UiButton`, `VideoCard`). `UiButton` accepts a `variant` prop: `"primary"` (default, filled orange) or `"outlined"`.

**Theme color** is `#D1832C` (orange), defined as `--theme-color` in `app/assets/css/main.css`. Reference it in Tailwind with `text-(--theme-color)` / `bg-(--theme-color)`.

**`.section` utility class** in `main.css` provides standard vertical padding for all landing sections — use it on the root element of every `Section*.vue`.

### Environment

Copy `.env.example` → `.env` and fill in:

```
NUXT_PUBLIC_YANDEX_MAPS_API_KEY=   # required for the contacts/map section
```

## Back (`back/`)

### Stack
- **Laravel 11** + **PostgreSQL** + **Laravel Sanctum** (token-based auth)

### Commands
```bash
cd back
php artisan migrate --seed   # first-time setup (creates tables + default admin + seed data)
php artisan serve            # API at http://localhost:8000
```

### Default admin credentials
- Email: `admin@admin.ru`
- Password: `123123`

### API overview
- Public: `GET /api/news`, `GET /api/news/featured`, `GET /api/news/{id}`, `GET /api/videos`
- Auth: `POST /api/auth/login` → returns `{ token, user }`; `POST /api/auth/logout`; `GET /api/auth/me`
- Admin (Bearer token required): `GET|POST /api/admin/news`, `PUT|DELETE /api/admin/news/{id}`, `GET|POST /api/admin/videos`, `PUT|DELETE /api/admin/videos/{id}`

## Admin (`admin/`)

### Stack
- **Nuxt 4** + **Nuxt UI v4** (components, forms, slideovers) + Tailwind CSS v4
- Token stored in cookie `admin_token` (7-day expiry)
- `app/middleware/auth.ts` — guards all pages except `/login`
- `app/composables/useAuth.ts` — login / logout / fetchMe
- `app/composables/useApi.ts` — authenticated `$fetch` wrapper

### Commands
```bash
cd admin
npm install
npm run dev   # http://localhost:4000
```

### Pages
- `/login` — login form (layout: auth)
- `/` — dashboard with links to sections
- `/news` — news CRUD table + slideover form
- `/videos` — video CRUD table + slideover form
