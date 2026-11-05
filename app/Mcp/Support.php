<?php

namespace App\Mcp;

use App\Models\ActivityLog;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Post;
use App\Site\HtmlSanitizer;
use App\Site\SiteCache;
use App\Site\Tokens;
use Illuminate\Database\Eloquent\Model;

/** Helpers shared by the tool groups. */
class Support
{
    public const ACTOR = 'mcp';

    /** URL paths that belong to the app itself and cannot be used by pages or posts. */
    public const RESERVED = ['blogs', 'clients', 'portfolio-item', 'sitemap.xml', 'robots.txt', 'mcp', 'enquiry', 'thank-you',
        'uploads', 'tag', 'wp-content', 'up', 'images', 'css', 'js', 'vendor', 'storage', 'favicon.ico'];

    public static function path(string $page): string
    {
        $p = trim(strtolower(trim($page)), '/');
        if (preg_match('#^https?://[^/]+/?(.*)$#', $p, $m)) {
            $p = trim($m[1], '/');
        }

        return in_array($p, ['home', 'index'], true) ? '' : $p;
    }

    public static function page(string $page, bool $withTrashed = false): Page
    {
        $path = self::path($page);
        $q = Page::query()->where('path', $path);
        if ($withTrashed) {
            $q->withTrashed();
        }

        return $q->first() ?? throw new ToolError("No page at /$path. Use list_pages to see the paths.");
    }

    public static function section(Page $page, string $key): PageSection
    {
        return $page->sections()->where('key', $key)->first()
            ?? throw new ToolError("Page /{$page->path} has no section \"$key\". Use get_page_sections to see the keys.");
    }

    public static function post(string|int $ref, bool $withTrashed = false): Post
    {
        $q = Post::query();
        if ($withTrashed) {
            $q->withTrashed();
        }
        $post = is_numeric($ref) ? $q->find((int) $ref) : $q->where('slug', trim((string) $ref, '/'))->first();

        return $post ?? throw new ToolError("No blog post \"$ref\". Use list_blogs to see the slugs.");
    }

    /** Validate a URL path for a page or post: lower-case words joined by hyphens, optional sub-folders. */
    public static function assertFreePath(string $path, ?Model $ignore = null): void
    {
        if (! preg_match('#^[a-z0-9]+(?:-[a-z0-9]+)*(?:/[a-z0-9]+(?:-[a-z0-9]+)*)*$#', $path)) {
            throw new ToolError("\"$path\" is not a valid URL path: use lower-case letters, digits and hyphens (e.g. car-wash-pos).");
        }
        if (in_array(explode('/', $path)[0], self::RESERVED, true)) {
            throw new ToolError("\"$path\" is reserved by the site.");
        }
        $page = Page::withTrashed()->where('path', $path)->first();
        if ($page && ! ($ignore instanceof Page && $ignore->is($page))) {
            throw new ToolError("A page already uses /$path" . ($page->trashed() ? ' (in the trash: restore or purge it)' : '') . '.');
        }
        $post = Post::withTrashed()->where('slug', $path)->first();
        if ($post && ! ($ignore instanceof Post && $ignore->is($post))) {
            throw new ToolError("A blog post already uses /$path" . ($post->trashed() ? ' (in the trash: restore or purge it)' : '') . '.');
        }
    }

    /**
     * Sanitize HTML and check its placeholders.
     *
     * @return array{0:string,1:string[]} [clean html, what the sanitizer removed]
     */
    public static function html(string $html, int $embeds = 0, string $field = 'html'): array
    {
        if ($bad = Tokens::invalid($html, $embeds)) {
            throw new ToolError("$field has unknown placeholders: " . implode(' ', $bad) . '. Allowed: {{' . implode('}}, {{', Tokens::NAMES)
                . '}}, {{price:key}}, {{price_plain:key}}, {{download:key.field}}' . ($embeds ? ', {{embed:0..' . ($embeds - 1) . '}}' : '') . '.');
        }
        $r = (new HtmlSanitizer())->clean($html);

        return [$r['html'], $r['removed']];
    }

    /** Sanitize every string in a nested array of component attributes. */
    public static function attributes(array $attrs, array &$removed): array
    {
        array_walk_recursive($attrs, function (&$v, $k) use (&$removed) {
            if (is_string($v)) {
                [$v, $r] = self::html($v, 0, "attribute \"$k\"");
                array_push($removed, ...$r);
            } elseif (! is_null($v) && ! is_scalar($v)) {
                throw new ToolError("attribute \"$k\" must be text, a number, true/false or a list.");
            }
        });

        return $attrs;
    }

    /** Plain text field: no markup allowed. */
    public static function text(?string $v, string $field): ?string
    {
        if ($v !== null && $v !== strip_tags($v)) {
            throw new ToolError("$field must be plain text (no HTML).");
        }

        return $v === null ? null : trim($v);
    }

    /** Internal links are stored as {{base}}/path so they follow the domain; external URLs stay as given. */
    public static function storeUrl(string $url): string
    {
        $url = trim($url);
        foreach (array_filter([rtrim(url('/'), '/'), rtrim((string) config('site.url'), '/'), 'https://mypos.pk', 'https://www.mypos.pk']) as $root) {
            if ($url === $root || str_starts_with($url, $root . '/') || str_starts_with($url, $root . '#') || str_starts_with($url, $root . '?')) {
                return '{{base}}' . substr($url, strlen($root));
            }
        }
        if (str_starts_with($url, '/') && ! str_starts_with($url, '//')) {
            return '{{base}}' . $url;
        }
        if (! preg_match('#^(https?://|mailto:|tel:|\#|\{\{)#i', $url)) {
            throw new ToolError("\"$url\" is not a usable link: give a path like /pricing or a full https:// URL.");
        }

        return $url;
    }

    /** Path part of an internal URL ("/pricing" → "pricing"), or null for external links. */
    public static function internalPath(string $href): ?string
    {
        $h = html_entity_decode(trim($href), ENT_QUOTES | ENT_HTML5);
        $h = preg_replace('/^\{\{base\}\}/', '', $h, 1, $tok);
        if (! $tok) {
            foreach (array_filter([rtrim(url('/'), '/'), rtrim((string) config('site.url'), '/'), 'https://mypos.pk', 'https://www.mypos.pk', 'http://mypos.pk']) as $root) {
                if ($h === $root || str_starts_with($h, $root . '/') || str_starts_with($h, $root . '#') || str_starts_with($h, $root . '?')) {
                    $h = substr($h, strlen($root));
                    $tok = 1;
                    break;
                }
            }
        }
        if (! $tok && ! (str_starts_with($h, '/') && ! str_starts_with($h, '//'))) {
            return null;
        }
        $h = preg_replace('/[#].*$/', '', $h);

        return trim((string) parse_url('http://x' . ($h === '' ? '/' : $h), PHP_URL_PATH), '/');
    }

    public static function assertStamp(Model $m, ?string $expected): void
    {
        if ($expected !== null && $expected !== '' && $m->updated_at?->toIso8601String() !== $expected) {
            throw new ToolError('This item changed since you read it (now ' . $m->updated_at?->toIso8601String()
                . "). Read it again and retry, so newer edits are not overwritten.");
        }
    }

    public static function log(string $action, ?Model $subject, string $summary, $before = null, $after = null): void
    {
        ActivityLog::record(self::ACTOR, $action, $subject, $summary, $before, $after);
    }

    /** After a write: clear caches (and Cloudflare for these paths). */
    public static function changed(array $paths = []): array
    {
        return SiteCache::changed($paths);
    }

    /** A page or a blog post by path / slug: ['type' => 'page'|'post', 'model' => …]. Pages win on a tie. */
    public static function target(string $ref): array
    {
        $path = self::path($ref);
        if ($page = Page::where('path', $path)->first()) {
            return ['type' => 'page', 'model' => $page];
        }
        if (! str_contains($path, '/') && ($post = Post::where('slug', $path)->first())) {
            return ['type' => 'post', 'model' => $post];
        }
        throw new ToolError("No page or blog post at /$path.");
    }

    /** Crawler view of a page or post (headings, links, images, meta…), see SiteAnalyzer. */
    public static function analyze(string $ref): array
    {
        $t = self::target($ref);

        return $t['type'] === 'page' ? \App\Site\SiteAnalyzer::page($t['model']) : \App\Site\SiteAnalyzer::post($t['model']);
    }

    /**
     * What a visitor gets at an internal path: 200 (page, post or app route), 301/302 (with target), 404 or 410.
     *
     * @return array{status:int, to?:string, what?:string}
     */
    public static function resolvePath(string $path): array
    {
        $path = trim(preg_replace('/[?#].*$/', '', $path), '/');
        if ($path !== strtolower($path)) {
            return ['status' => 301, 'to' => '/' . strtolower($path), 'what' => 'lower-case redirect'];
        }
        $map = \App\Http\Middleware\SiteRedirects::map();
        if (isset($map[$path])) {
            [, $code, $to] = $map[$path];

            return $code === 410 ? ['status' => 410, 'what' => 'gone'] : ['status' => $code, 'to' => $to, 'what' => 'redirect'];
        }
        if (Page::published()->where('path', $path)->exists()) {
            return ['status' => 200, 'what' => 'page'];
        }
        if (in_array($path, ['blogs', 'clients', 'thank-you', 'sitemap.xml', 'robots.txt'], true)) {
            return ['status' => 200, 'what' => 'route'];
        }
        if (! str_contains($path, '/') && Post::published()->where('slug', $path)->exists()) {
            return ['status' => 200, 'what' => 'post'];
        }
        if (preg_match('#^portfolio-item/([a-z0-9-]+)$#', $path, $m)) {
            return ['status' => \App\Models\Client::where('slug', $m[1])->exists() ? 200 : 404, 'what' => 'client'];
        }
        if (preg_match('#^tag/([a-z0-9-]+)$#', $path, $m)) {
            return ['status' => \App\Models\Tag::where('slug', $m[1])->exists() ? 200 : 404, 'what' => 'tag'];
        }
        if (preg_match('#^(uploads|images|css|js|vendor)/#', $path) || $path === 'favicon.ico') {
            return ['status' => is_file(public_path($path)) ? 200 : 404, 'what' => 'file'];
        }
        return ['status' => 404];
    }

    public static function stamp(?Model $m): ?string
    {
        return $m?->updated_at?->toIso8601String();
    }
}
