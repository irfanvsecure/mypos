# mypos

Laravel 12 rebuild of [mypos.pk](https://mypos.pk): POS software for Pakistan (retail, restaurant, salon, laundry, tailor) with FBR / PRA / KPRA / SRB integration pages. It was migrated from WordPress (BeTheme) with all pages, blog posts, client portfolio and media preserved, and it includes an **MCP server** so Claude (claude.ai custom connector) can manage the site.

## What's inside

- **78 pages from the database.** Each page is a list of sections in `pages` / `page_sections`, rendered by `resources/views/site/page.blade.php` with `App\Site\SectionRenderer`:
  - **HTML sections** hold HTML with `{{placeholders}}` (site URL, per-page WhatsApp link, phone, prices…).
  - **Component sections** feed an existing Blade component its attributes.
  - Every change keeps a revision.
  - The original Blade files in `resources/views/pages/` are kept as a fallback until the MCP is signed off on staging. They are never used for a path that has a database page (in any state).
- **Single sources:**
  - prices in `pricing_plans` (`{{price:key}}`);
  - download facts in `downloads` (`{{download:key.field}}`);
  - FAQs in `faqs` (the FAQPage structured data follows);
  - reviews in `testimonials`;
  - logo strips in `client_logos`;
  - the rating in the `rating_value` setting;
  - site settings (phone, menus, footer, offer bar…) in `settings`, overriding `config/site.php`.
- **Blog** (36 posts, categories, tags with `/tag/{slug}` archives) and the **client portfolio**.
- **Enquiry forms**: leads go to the `leads` table and are emailed to `LEADS_EMAIL` (honeypot and rate limit). The thank-you page fires the Meta Pixel Lead event.
- **SEO**:
  - per-page meta, canonical, robots, OG / Twitter (`seo_meta`);
  - JSON-LD blocks (`schema_blocks`) plus automatic Organization, breadcrumbs and FAQPage;
  - `/sitemap.xml` (live) and `/robots.txt`;
  - redirects and 410s in `redirects`.
- **Pre-launch switch**: with `SITE_NOINDEX=true`, every response is `noindex, nofollow`, whatever a page's robots setting says.
- **One stylesheet** (`public/css/style.css`) and one script (`public/js/app.js`). Media lives in `public/uploads/`.

## MCP server

`POST /mcp` (header `Authorization: Bearer <MCP_SECRET>`) or `POST /mcp/<MCP_SECRET>` (for claude.ai connectors). It has 97 tools for pages, sections, headings, links, pricing, FAQs, reviews, logos, downloads, blog, images, SEO, structured data, redirects, sitemap/robots, settings, read-only enquiries, trash, activity log and cache.

- Deploy, `.env`, and how to add it in claude.ai: **[docs/MCP.md](docs/MCP.md)**
- Every tool with a one-line description: **[docs/mcp-tools.md](docs/mcp-tools.md)**

## Setup (local)

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite      # or configure MySQL in .env
php artisan migrate
php artisan db:seed --class=ContentSeeder   # blog posts + clients
php artisan site:import                     # pages, sections, prices, FAQs, settings… (database/data/site-content.json)
php artisan serve
```

| `.env` key | Purpose |
|---|---|
| `APP_URL` | Public URL, used in canonical tags and the sitemap (`https://mypos.pk`) |
| `SITE_NOINDEX` | `true` until launch: noindex everywhere, no sitemap in robots.txt |
| `LEADS_EMAIL`, `MAIL_*` | Where and how enquiries are emailed |
| `MCP_SECRET` | Secret for the MCP endpoint (64 hex characters; empty = MCP off) |
| `MCP_REQUIRE_HTTPS`, `MCP_RATE_LIMIT`, `TRUSTED_PROXIES` | MCP transport settings (see docs/MCP.md) |
| `MCP_IMAGE_URL_ALLOWED_HOSTS` | Optional list of hosts `upload_image_from_url` may download from |
| `CLOUDFLARE_API_TOKEN`, `CLOUDFLARE_ZONE_ID` | Optional Cloudflare cache purge after changes |
| `SITE_REMOTE_UPLOADS` | Migration fallback for missing `/uploads` files; keep `false` |

## Content commands

| Command | What it does |
|---|---|
| `php artisan site:export` / `site:import [--force]` | Write / load the website tables as `database/data/site-content.json` |
| `php artisan site:extract` | One-time copy of Blade pages into the database (already done, do not run on servers) |
| `php artisan site:snapshot <label>` + `site:diff <a> <b>` | Save the rendered HTML of every URL and compare two saves (proof that a change altered nothing else) |

Phase 1 migration diff reports: [docs/phase1/](docs/phase1/).

## Tests

```bash
php artisan test
```

88 tests cover:
- every page, post and client page rendering, old-URL redirects and the enquiry form;
- the HTML sanitizer round-trip over all stored content;
- the MCP endpoint (auth, HTTPS, JSON-RPC) and every tool (create / update / delete / restore, validation);
- the isolation test proving the MCP cannot read anything outside the website tables.
