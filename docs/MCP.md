# mypos.pk MCP server: deploy and connect

The website has a built-in MCP server. Once it is deployed and added to claude.ai as a custom connector, Claude can manage the marketing site: pages and sections, prices, FAQs, reviews, logos, downloads, blog, images, SEO, structured data, links, redirects, sitemap/robots and settings. The full list of 97 tools is in [mcp-tools.md](mcp-tools.md).

**Scope:** website content only. There is no tool for SQL, shell commands, files outside `public/uploads`, `.env`, or any POS-application data. Website enquiries are read-only, and phone numbers, emails and IPs are never returned. `tests/Feature/Mcp/IsolationTest.php` proves the tools only touch the website tables.

---

## 1. Deploy to staging (myposs.mait.ae) first

Run the steps on staging, test from claude.ai, and only then repeat them on production.

### Before you start

- The web server's document root must be the project's `public/` folder, not the project root. On staging, someone once copied `public/*` into the project root; undo that if it is still there.
- PHP 8.2+ with the `gd` extension (WebP support), `pdo_sqlite` or `pdo_mysql`, `mbstring` and `fileinfo`.
- These must be writable by the web server: `storage/`, `bootstrap/cache/`, `public/uploads/`, and the SQLite file and its folder if you use SQLite.

### Option A: git pull over SSH

```bash
cd /path/to/mypos                       # the project folder (the one containing artisan)
php artisan down                        # maintenance page while deploying

git fetch origin
git checkout feature/mcp-content        # later: main, once merged
git pull origin feature/mcp-content

composer install --no-dev --optimize-autoloader
php artisan migrate --force

# First deploy only: load the website content (pages, sections, prices, FAQs, settings…)
php artisan db:seed --class=ContentSeeder --force   # blog posts + client portfolio, skip if already there
php artisan site:import                             # refuses if pages already exist; --force replaces them

php artisan optimize:clear
php artisan optimize                    # caches config, routes and views
php artisan up
```

### Option B: cPanel → Git Version Control

1. In **Git Version Control**, open the repository, switch the checked-out branch to `feature/mcp-content`, and click **Update from Remote**. Then click **Deploy HEAD Commit** if your setup uses a deploy path.
2. Open **Terminal** in cPanel (or SSH) and run, in the project folder:

   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan migrate --force
   php artisan db:seed --class=ContentSeeder --force   # first deploy only, if posts/clients are missing
   php artisan site:import                             # first deploy only
   php artisan optimize:clear && php artisan optimize
   ```

   With no Terminal available, ask the host to run these commands once. Deploying through File Manager uploads alone is not enough, because the migrations and the content import must run.

### About the extraction command

`php artisan site:extract` is the one-time command that copied the Blade pages into the database. It has already run, and its result is committed as `database/data/site-content.json`, which `site:import` loads. **Do not run `site:extract` on the server.** It would rebuild pages from the old Blade files and lose the follow-up work: single-source prices and downloads, the FAQ tables and the rating setting.

To move content edited on one server to another later: `php artisan site:export` on the source, copy `database/data/site-content.json`, then `php artisan site:import --force` on the target.

## 2. `.env` settings

Add these to the server's `.env` (never commit them):

```dotenv
APP_URL=https://myposs.mait.ae          # production: https://mypos.pk
SITE_NOINDEX=true                       # keep true until launch: every page stays noindex

# MCP
MCP_SECRET=                             # paste the generated secret (see below)
MCP_REQUIRE_HTTPS=true                  # default outside local; leave on
MCP_RATE_LIMIT=120                      # calls per minute per IP
MCP_IMAGE_URL_ALLOWED_HOSTS=            # optional, comma-separated; empty = all public hosts
TRUSTED_PROXIES=*                       # if behind Cloudflare or a load balancer, so HTTPS is detected

# Optional: Cloudflare cache purge after every change
CLOUDFLARE_API_TOKEN=
CLOUDFLARE_ZONE_ID=
```

**Generate the secret** (64 hexadecimal characters):

```bash
php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"
```

**Cloudflare token** (only if Cloudflare is in front): Cloudflare dashboard → My Profile → API Tokens → Create Token → Custom token.
- Permission: **Zone → Cache Purge → Purge**.
- Zone Resources: **Include → Specific zone → mypos.pk** (or the staging zone).
- Nothing else.

The Zone ID is on the zone's Overview page. Also add a Cache Rule that bypasses the cache for `/mcp*`, and make sure no WAF or bot rule challenges `POST /mcp` (claude.ai's servers call it).

After editing `.env`, run `php artisan optimize:clear && php artisan optimize`.

## 3. Check that it works

```bash
# Expect 401 (no secret):
curl -s -o /dev/null -w "%{http_code}\n" -X POST https://myposs.mait.ae/mcp

# Expect a list of 97 tools:
curl -s -X POST "https://myposs.mait.ae/mcp/YOUR_SECRET" \
  -H "Content-Type: application/json" -H "Accept: application/json, text/event-stream" \
  -d '{"jsonrpc":"2.0","id":1,"method":"tools/list"}' | head -c 300
```

What the endpoint answers:

| Situation | Response |
|---|---|
| `MCP_SECRET` empty or shorter than 32 characters | 503 (MCP switched off) |
| Plain `http://` while HTTPS is required | 403 |
| Wrong or missing secret | 401 |

Every call is logged in `storage/logs/mcp-YYYY-MM-DD.log` (tool, result, duration, IP). Content changes are also in the `activity_log` table, which the `activity_log` tool shows with before / after values.

## 4. Add it to claude.ai

Connector URL format (the secret is part of the URL):

```
https://myposs.mait.ae/mcp/<MCP_SECRET>
```

1. claude.ai → **Settings → Connectors → Add custom connector**.
2. Name: `mypos.pk website (staging)`. URL: the connector URL above. Leave OAuth / advanced settings empty.
3. Click **Add**.
4. In a chat, open the tools menu and switch the connector on. Try something like: *"List the pages of the website"*, *"Run audit_meta and show the 10 worst pages"*, or *"Show the SEO report for /car-wash-pos"*.

For clients that can send headers (Claude Code, the MCP inspector), use `https://myposs.mait.ae/mcp` with the header `Authorization: Bearer <MCP_SECRET>`.

Treat the connector URL like a password: anyone with it can edit the site. To revoke access, put a new `MCP_SECRET` in `.env`, run `php artisan optimize:clear && php artisan optimize`, and update the connector URL in claude.ai.

## 5. After staging is signed off

1. Merge `feature/mcp-content` into `main`. Remove the fallback Blade files (`resources/views/home.blade.php`, `resources/views/pages/*`) in one commit; the database renders every page.
2. Repeat sections 1–4 on production with `APP_URL=https://mypos.pk` and its own new `MCP_SECRET`.
3. Launch is a separate, manual step. Set `SITE_NOINDEX=false` and run `php artisan optimize:clear && php artisan optimize`. The MCP cannot change this.

## Good to know

- **Revisions:** every section change keeps the previous version (`list_section_revisions` / `restore_section_revision`). Deletions go to the trash (`list_trash` / `restore_item`); `purge_item` with `confirm=true` is the only permanent delete.
- **Speed:** the first site-wide audit (`audit_meta`, `find_orphan_pages`, `audit_headings` without a page) renders every page and takes about 30–40 seconds. Results are cached per page until that page changes.
- **Uploaded images** go to `public/uploads/YYYY/MM/` (or the `folder` you give): a WebP copy (max 1600 px) and srcset sizes. A base64 upload also keeps the file as sent. A URL download records its source URL instead. Back up `public/uploads/` with the database.
- **Downloading images by URL:** `upload_image_from_url` and the URL option of `upload_image` share one download path. It fetches on the server, re-checks every redirect, and never connects to a private or reserved address. Errors are JSON with an `error` code: `url_not_allowed`, `fetch_failed`, `not_an_image`, `too_large` or `processing_failed`. If `MCP_IMAGE_URL_ALLOWED_HOSTS` is set, every host in a redirect chain must be on the list. `unsplash.com/photos/<id>/download` links redirect to a bot-protection check and fail as `fetch_failed` (HTTP 401); use the direct `images.unsplash.com` link.
- **Developer checks:** `php artisan test` (88 tests). `php artisan site:snapshot <label>` + `php artisan site:diff <a> <b>` compare the rendered HTML of every URL before and after a change. Run `php artisan serve --port=8090` first.
