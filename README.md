# Деплой AUGZ на cPanel

Монорепозиторий состоит из трёх частей, каждая деплоится отдельно:

| Часть | Технология | Домен (пример) |
|---|---|---|
| `back/` | Laravel 11 + PHP 8.3 + PostgreSQL | `api.augz.uz` |
| `front/` | Nuxt 4 (SSR, Node.js) | `augz.uz` |
| `admin/` | Nuxt 4 (SSR, Node.js) | `admin.augz.uz` |

---

## Требования к хостингу

| Требование | Минимум |
|---|---|
| PHP | 8.3+ |
| Node.js | 20+ (LTS) |
| PostgreSQL | 14+ |
| Composer | 2.x |
| SSH-доступ | Обязателен для миграций и npm build |
| cPanel | С модулем «Setup Node.js App» (Phusion Passenger или аналог) |
| Apache mod_rewrite | Включён |
| Apache mod_proxy | Включён (для проксирования Node.js) |

> **Важно.** Большинство дешёвых shared-хостингов не поддерживают Node.js. Перед покупкой убедитесь, что в cPanel есть раздел **Software → Setup Node.js App**.

---

## Часть 1 — Laravel Backend (`back/`)

### 1.1 Структура файлов на сервере

cPanel даёт корневую директорию пользователя `/home/<username>/`. Разместите проект так:

```
/home/<username>/
├── augz_back/          ← весь Laravel-проект (НЕ в public_html)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   ├── .env
│   └── ...
└── public_html/
    └── api/            ← или отдельный subdomain-folder
        ├── index.php   ← точка входа (переадресует в augz_back/public)
        └── .htaccess
```

Если под API выделен субдомен `api.augz.uz`, cPanel создаст папку вроде `/home/<username>/api.augz.uz/`. Туда и кладём `public/`-файлы Laravel.

### 1.2 Загрузка файлов

```bash
# На локальной машине — создаём архив без vendor и .env
zip -r augz_back.zip back/ \
  --exclude "back/vendor/*" \
  --exclude "back/.env" \
  --exclude "back/node_modules/*"
```

Загрузите архив через **cPanel → File Manager → Upload**, распакуйте в `/home/<username>/augz_back/`.

### 1.3 Установка зависимостей через SSH

```bash
cd ~/augz_back
composer install --no-dev --optimize-autoloader
```

### 1.4 Настройка `.env`

Создайте файл `~/augz_back/.env` на основе `.env.example`:

```dotenv
APP_NAME=AUGZ
APP_ENV=production
APP_KEY=                          # заполнится после php artisan key:generate
APP_DEBUG=false
APP_URL=https://api.augz.uz

# --- PostgreSQL ---
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1                 # обычно localhost на shared hosting
DB_PORT=5432
DB_DATABASE=<cpanel_user>_augz    # cPanel добавляет префикс username_
DB_USERNAME=<cpanel_user>_augz
DB_PASSWORD=ваш_пароль

# --- Sanctum CORS ---
SANCTUM_STATEFUL_DOMAINS=augz.uz,admin.augz.uz
SESSION_DOMAIN=.augz.uz

# --- Остальное ---
CACHE_STORE=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
LOG_CHANNEL=stack
LOG_LEVEL=error

MAIL_MAILER=smtp
MAIL_HOST=mail.augz.uz
MAIL_PORT=465
MAIL_USERNAME=noreply@augz.uz
MAIL_PASSWORD=
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=noreply@augz.uz
MAIL_FROM_NAME="AUGЗ"
```

### 1.5 База данных PostgreSQL в cPanel

1. Откройте **cPanel → Databases → PostgreSQL Databases**.
2. Создайте базу данных: введите `augz` → нажмите **Create Database**.  
   Итоговое имя будет `<cpanel_user>_augz`.
3. Создайте пользователя: введите `augz` и пароль → **Create User**.  
   Итоговое имя `<cpanel_user>_augz`.
4. В разделе «Add User To Database» выберите пользователя и базу → **Add** → установите **ALL PRIVILEGES**.
5. Занесите имя, пользователя и пароль в `.env` (см. выше).

> **PDO pgsql.** На некоторых хостингах расширение `pdo_pgsql` нужно включить вручную через **cPanel → PHP Selector → Extensions** — найдите `pdo_pgsql` и активируйте.

### 1.6 Настройка точки входа

Отредактируйте `/home/<username>/api.augz.uz/index.php`:

```php
<?php

define('LARAVEL_START', microtime(true));

require __DIR__.'/../augz_back/vendor/autoload.php';

$app = require_once __DIR__.'/../augz_back/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);
```

Файл `.htaccess` в той же папке (`/home/<username>/api.augz.uz/.htaccess`):

```apache
Options -MultiViews -Indexes
RewriteEngine On

# CORS preflight
RewriteCond %{REQUEST_METHOD} OPTIONS
RewriteRule ^(.*)$ $1 [R=200,L]

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [L]
```

### 1.7 Первый запуск

```bash
cd ~/augz_back

# Генерируем APP_KEY
php artisan key:generate

# Права на папки кэша и хранилища
chmod -R 755 storage bootstrap/cache
chown -R nobody:nobody storage bootstrap/cache   # или www-data, зависит от хостинга

# Миграции + сиды
php artisan migrate --seed --force

# Кэширование конфигов для production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Симлинк для storage (если используете загрузку файлов)
php artisan storage:link
```

### 1.8 Проверка

```bash
curl https://api.augz.uz/api/news
# Ожидаемый ответ: {"data":[...]}
```

---

## Часть 2 — Frontend (`front/`) — публичный сайт

### 2.1 Билд локально

Nuxt 4 в режиме SSR запускает Node.js-сервер, поэтому **нельзя просто загрузить файлы как статику**. Соберите `.output` локально и загрузите готовый артефакт.

```bash
cd front

# Установите переменные для production
cp .env.example .env.production
# Отредактируйте .env.production:
# NUXT_PUBLIC_API_BASE=https://api.augz.uz/api
# NUXT_PUBLIC_SITE_URL=https://augz.uz
# NUXT_PUBLIC_YANDEX_MAPS_API_KEY=ваш_ключ

npm install
npm run build
# Результат: front/.output/
```

Папка `.output/` содержит:
- `.output/server/` — Node.js-сервер (точка входа: `index.mjs`)
- `.output/public/` — статические ассеты

### 2.2 Загрузка на сервер

```bash
# Пакуем только .output
cd front
zip -r front_output.zip .output/
```

Загрузите `front_output.zip` и распакуйте в `/home/<username>/augz_front/`.

Итоговая структура:
```
/home/<username>/augz_front/
└── .output/
    ├── server/
    │   └── index.mjs
    └── public/
```

### 2.3 Setup Node.js App в cPanel

1. **cPanel → Software → Setup Node.js App → Create Application**
2. Настройки:

   | Поле | Значение |
   |---|---|
   | Node.js version | 20.x (или последняя LTS) |
   | Application mode | Production |
   | Application root | `/home/<username>/augz_front/.output/server` |
   | Application URL | `augz.uz` |
   | Application startup file | `index.mjs` |

3. Нажмите **Create**.
4. cPanel назначит порт (например, `35000`). Запомните его.

### 2.4 Переменные окружения в Node.js App

В том же разделе «Setup Node.js App» добавьте Environment Variables:

```
NUXT_PUBLIC_API_BASE=https://api.augz.uz/api
NUXT_PUBLIC_SITE_URL=https://augz.uz
NUXT_PUBLIC_YANDEX_MAPS_API_KEY=ваш_ключ
PORT=35000                          # порт, назначенный cPanel
HOST=0.0.0.0
NODE_ENV=production
```

### 2.5 `.htaccess` для проксирования

В папке публичного корня домена `augz.uz` (обычно `/home/<username>/public_html/.htaccess`):

```apache
Options +FollowSymLinks -Indexes
DirectoryIndex disabled

<IfModule mod_rewrite.c>
  RewriteEngine On

  # Статика Nuxt — отдаём напрямую из .output/public
  RewriteCond %{REQUEST_URI} ^/_nuxt/
  RewriteRule ^_nuxt/(.*)$ /home/<username>/augz_front/.output/public/_nuxt/$1 [L]

  # Всё остальное → Node.js
  RewriteRule ^(.*)$ http://localhost:35000/$1 [P,L]
</IfModule>
```

> Замените `35000` на реальный порт, который выдал cPanel, и `<username>` — на имя вашего пользователя.

### 2.6 Статические ассеты (альтернатива)

Nuxt кладёт все статические файлы в `.output/public/`. Чтобы Apache отдавал их напрямую (быстрее, без Node.js), создайте симлинк:

```bash
ln -s ~/augz_front/.output/public ~/public_html/_nuxt_static
```

И добавьте в `.htaccess` перед правилом проксирования:

```apache
RewriteCond %{REQUEST_URI} ^/_nuxt/
RewriteRule ^_nuxt/(.*)$ /_nuxt_static/_nuxt/$1 [L]
```

---

## Часть 3 — Admin (`admin/`)

Процесс идентичен `front/`, но на субдомене `admin.augz.uz`.

### 3.1 Билд локально

```bash
cd admin

# admin использует pnpm (см. packageManager в package.json)
npm install -g pnpm   # если ещё не установлен
pnpm install
pnpm run build
# Результат: admin/.output/
```

Перед билдом обновите `admin/nuxt.config.ts`:

```ts
runtimeConfig: {
  public: {
    apiBase: 'https://api.augz.uz/api',
  },
},
```

Или задайте через `.env`:
```
NUXT_PUBLIC_API_BASE=https://api.augz.uz/api
```

### 3.2 Загрузка и Setup Node.js App

Аналогично `front/`, но:

| Поле | Значение |
|---|---|
| Application root | `/home/<username>/augz_admin/.output/server` |
| Application URL | `admin.augz.uz` |
| Application startup file | `index.mjs` |
| Port (назначит cPanel) | например, `35001` |

### 3.3 `.htaccess` для субдомена

В корне субдомена `admin.augz.uz` (папку создаёт cPanel автоматически при добавлении субдомена):

```apache
Options +FollowSymLinks -Indexes
DirectoryIndex disabled

<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteRule ^(.*)$ http://localhost:35001/$1 [P,L]
</IfModule>
```

---

## CORS — настройка Laravel для работы с фронтендами

Файл `back/config/cors.php`:

```php
'allowed_origins' => [
    'https://augz.uz',
    'https://admin.augz.uz',
],
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
'supports_credentials' => true,
```

После изменения:
```bash
php artisan config:cache
```

---

## SSL (HTTPS)

1. В cPanel найдите **Security → SSL/TLS** или **Let's Encrypt SSL**.
2. Выдайте бесплатный сертификат для:
   - `augz.uz`
   - `admin.augz.uz`
   - `api.augz.uz`
3. Включите **Force HTTPS Redirect** через cPanel или добавьте в каждый `.htaccess`:

```apache
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]
```

---

## Обновление проекта (повторный деплой)

### Backend (Laravel)

```bash
# 1. Загрузить обновлённые файлы
# 2. Зайти по SSH:
cd ~/augz_back
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Frontend / Admin (Nuxt)

```bash
# Локально:
npm run build   # или pnpm run build для admin

# Загрузить новый .output/ на сервер
# Перезапустить Node.js App в cPanel → Setup Node.js App → Restart
```

---

## Типичные ошибки и их решение

| Ошибка | Причина | Решение |
|---|---|---|
| `502 Bad Gateway` | Node.js не запущен | cPanel → Setup Node.js App → Start/Restart |
| `could not find driver (pgsql)` | Расширение pdo_pgsql не включено | cPanel → PHP Selector → Extensions → включить `pdo_pgsql` |
| `storage` не доступен для записи | Права 644 вместо 755 | `chmod -R 755 storage bootstrap/cache` |
| `APP_KEY` пустой | `.env` не содержит ключа | `php artisan key:generate` |
| CORS-ошибки | `allowed_origins` не совпадает | Проверьте `config/cors.php` и пересоберите кэш |
| Nuxt 404 на всех страницах | Неправильный порт в `.htaccess` | Сверьте порт в cPanel Setup Node.js App и в `RewriteRule` |
| `permission denied` на `storage/logs` | Неверный владелец файла | `chown -R nobody:nobody storage` (или `www-data`) |

---

## Проверочный чеклист перед запуском

- [ ] `APP_DEBUG=false` в `.env` Laravel
- [ ] `APP_KEY` сгенерирован
- [ ] Миграции выполнены (`php artisan migrate --force`)
- [ ] `php artisan config:cache && route:cache && view:cache` выполнен
- [ ] SSL-сертификаты выданы на все три домена
- [ ] CORS в Laravel настроен на `augz.uz` и `admin.augz.uz`
- [ ] Node.js App запущен для `front/` и `admin/`
- [ ] Переменная `NUXT_PUBLIC_API_BASE` указывает на `https://api.augz.uz/api`
- [ ] Проверен `GET https://api.augz.uz/api/news` — отдаёт данные
- [ ] Проверен `https://augz.uz` — открывается сайт
- [ ] Проверен `https://admin.augz.uz/login` — открывается панель
