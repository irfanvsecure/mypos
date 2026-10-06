# mypos

Laravel 12 rebuild of [mypos.pk](https://mypos.pk) — Pakistan's POS software for retail, restaurant, salon and service businesses, with FBR / PRA / KPRA / SRB integration pages. Migrated from WordPress (BeTheme) with all pages, blog posts, client portfolio and media preserved.

## What's inside

- **78 static pages** — Blade views in `resources/views/pages/{slug}.blade.php`, served by a catch-all route (`PageController`) at the same URLs as the old WordPress site.
- **Blog** (36 posts) and **clients** (45) — stored in the database, seeded from `database/data/*.json`.
- **Enquiry form** — leads saved to the `leads` table and emailed to `LEADS_EMAIL` (honeypot + rate limiting).
- **SEO** — WordPress titles/descriptions kept, JSON-LD (Organization, Breadcrumb, FAQ, BlogPosting), `/sitemap.xml`, 301s for old URLs (`config/site.php` → `redirects`), 410 for spam URLs.
- **One stylesheet** — `public/css/style.css`; behaviour in `public/js/app.js`. Site-wide settings (phone, menus, footer) in `config/site.php`.
- **Media** — WordPress uploads under `public/uploads/` (old `/wp-content/uploads/...` URLs redirect there).

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite      # or configure MySQL in .env
php artisan migrate --seed
php artisan serve
```

Optional `.env` keys:

| Key | Purpose |
|---|---|
| `APP_URL` | Public URL, used in canonical tags and the sitemap (`https://mypos.pk`) |
| `LEADS_EMAIL` | Where enquiries are emailed (default `info@mypos.pk`) |
| `MAIL_*` | SMTP settings for sending enquiry emails |
| `SITE_REMOTE_UPLOADS` | `true` = serve missing `/uploads` files from the old WordPress server (migration fallback); keep `false` |

## Tests

```bash
php artisan test
```

Smoke tests render every page, post and client page, check old-URL redirects, structured data and the enquiry form.
