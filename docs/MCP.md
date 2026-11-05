# mypos.pk MCP server: deploy and connect

The website has a built-in MCP server. Once it is deployed and added to claude.ai as a custom connector, Claude can manage the marketing site: pages and sections, prices, FAQs, reviews, logos, downloads, blog, images, SEO, structured data, links, redirects, sitemap/robots and settings. The full list of 97 tools is in [mcp-tools.md](mcp-tools.md).

**Scope:** website content only. There is no tool for SQL, shell commands, files outside `public/uploads`, `.env`, or any POS-application data. Website enquiries are read-only, and phone numbers, emails and IPs are never returned. `tests/Feature/Mcp/IsolationTest.php` proves the tools only touch the website tables.

---

## 1. Deploy to mypos.pk

The site runs on production only; the old staging subdomain has been removed. Every deploy and every MCP edit affects the live site.

### Before you start

- The project's `public/` folder should be the web server's document root.
- PHP 8.2+ with the `gd` extension (WebP support), `pdo_sqlite` or `pdo_mysql`, `mbstring` and `fileinfo`.
- These must be writable by the web server: `storage/`, `bootstrap/cache/`, `public/uploads/`, and the SQLite file and its folder if you use SQLite.

### Option A: git pull over SSH

```bash
cd /path/to/mypos                       # the project folder (the one containing artisan)
php artisan down                        # maintenance page while deploying

git fetch origin
git checkout main
git pull origin main

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

1. In **Git Version Control**, open the repository, switch the checked-out branch to `main`, and click **Update from Remote**. Then click **Deploy HEAD Commit** if your setup uses a deploy path.
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

The pages were copied from Blade files into the database once, and the result is committed as `database/data/site-content.json`, which `site:import` loads. The Blade files and the extraction command have since been removed. The live database is now the source of truth, and that JSON file does not include later MCP edits. **Do not run `site:import --force` on production.** It would replace the live pages with the older copy.

To move content to another server: `php artisan site:export` on the source, copy `database/data/site-content.json`, then `php artisan site:import --force` on the target.

## 2. `.env` settings

Add these to the server's `.env` (never commit them):

```dotenv
APP_URL=https://mypos.pk
SITE_NOINDEX=false                      # true hides every page from search engines
SITE_CANONICAL_HOST=mypos.pk            # http:// and www. redirect to https://mypos.pk
HSTS_MAX_AGE=86400                      # raise to 31536000 once HTTPS has proved stable

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
- Zone Resources: **Include → Specific zone → mypos.pk**.
- Nothing else.

The Zone ID is on the zone's Overview page. Also add a Cache Rule that bypasses the cache for `/mcp*`, and make sure no WAF or bot rule challenges `POST /mcp` (claude.ai's servers call it).

After editing `.env`, run `php artisan optimize:clear && php artisan optimize`.

## 3. Check that it works

```bash
# Expect 401 (no secret):
curl -s -o /dev/null -w "%{http_code}\n" -X POST https://mypos.pk/mcp

# Expect a list of 97 tools:
curl -s -X POST "https://mypos.pk/mcp/YOUR_SECRET" \
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
https://mypos.pk/mcp/<MCP_SECRET>
```

1. claude.ai → **Settings → Connectors → Add custom connector**.
2. Name: `mypos.pk website`. URL: the connector URL above. Leave OAuth / advanced settings empty.
3. Click **Add**.
4. In a chat, open the tools menu and switch the connector on. Try something like: *"List the pages of the website"*, *"Run audit_meta and show the 10 worst pages"*, or *"Show the SEO report for /car-wash-pos"*.

For clients that can send headers (Claude Code, the MCP inspector), use `https://mypos.pk/mcp` with the header `Authorization: Bearer <MCP_SECRET>`.

Treat the connector URL like a password: anyone with it can edit the site. To revoke access, put a new `MCP_SECRET` in `.env`, run `php artisan optimize:clear && php artisan optimize`, and update the connector URL in claude.ai.

## 5. Search engines

`SITE_NOINDEX` is a manual switch in `.env`, and the MCP cannot change it. After changing it, run `php artisan optimize:clear && php artisan optimize`.
