<?php

namespace App\Site;

use App\Mcp\Support;
use App\Models\Page;
use App\Models\Post;
use App\Models\Setting;
use DOMDocument;
use DOMElement;
use DOMXPath;
use Illuminate\Support\Facades\Cache;

/**
 * Reads rendered pages the way a crawler would: headings, links, images, meta tags, structured data and word
 * counts, each tied to the section (or header / footer) it sits in. Results are cached per page and refreshed
 * when that page, its sections or SEO, or any setting changes.
 */
class SiteAnalyzer
{
    /** @return array<string, array> keyed by URL path ('' = home); pages first, then published posts */
    public static function all(bool $withPosts = true): array
    {
        $out = [];
        foreach (Page::published()->orderBy('path')->get() as $page) {
            $out[$page->path] = self::page($page);
        }
        if ($withPosts) {
            foreach (Post::published()->orderBy('slug')->get() as $post) {
                $out[$post->slug] = self::post($post);
            }
        }

        return $out;
    }

    public static function page(Page $page): array
    {
        $stamp = implode('|', [$page->updated_at, $page->sections()->withTrashed()->max('updated_at'), $page->seo?->updated_at,
            $page->schemaBlocks()->max('updated_at'), self::globalStamp()]);

        return self::cached('page:' . $page->id, $stamp, fn () => self::parse(PageRenderer::page($page, true), $page->path, 'page'));
    }

    public static function post(Post $post): array
    {
        $stamp = implode('|', [$post->updated_at, self::globalStamp()]);

        return self::cached('post:' . $post->id, $stamp, fn () => self::parse(PageRenderer::post($post), $post->slug, 'post'));
    }

    private static function globalStamp(): string
    {
        return (string) max(Setting::max('updated_at'), \App\Models\PricingPlan::max('updated_at'), \App\Models\Download::max('updated_at'),
            \App\Models\Faq::max('updated_at'), \App\Models\Testimonial::max('updated_at'), \App\Models\ClientLogo::max('updated_at'));
    }

    private static function cached(string $key, string $stamp, callable $make): array
    {
        $store = Cache::get(SiteCache::ANALYSIS_KEY, []);
        if (($store[$key]['stamp'] ?? null) === $stamp) {
            return $store[$key]['data'];
        }
        $data = $make();
        $store = Cache::get(SiteCache::ANALYSIS_KEY, []);
        $store[$key] = ['stamp' => $stamp, 'data' => $data];
        Cache::put(SiteCache::ANALYSIS_KEY, $store, now()->addDay());

        return $data;
    }

    /** Parse rendered HTML (with optional <!--§S:key--> section markers) into an analysis record. */
    public static function parse(string $html, string $path, string $type): array
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_NOERROR | LIBXML_NONET);
        libxml_clear_errors();
        $xp = new DOMXPath($dom);

        $meta = fn (string $q) => ($n = $xp->query($q)->item(0)) instanceof DOMElement ? $n->getAttribute('content') : null;
        $canonical = ($n = $xp->query('//link[@rel="canonical"]')->item(0)) instanceof DOMElement ? $n->getAttribute('href') : null;

        $schemaTypes = [];
        foreach ($xp->query('//script[@type="application/ld+json"]') as $s) {
            $data = json_decode($s->textContent, true);
            foreach (isset($data['@graph']) ? $data['@graph'] : [$data] as $node) {
                foreach ((array) ($node['@type'] ?? []) as $t) {
                    $schemaTypes[] = $t;
                }
            }
        }

        $headings = $links = $images = [];
        $words = [];
        $firstParagraph = null;
        $section = null;
        $position = 0;

        $walk = function (\DOMNode $node) use (&$walk, &$section, &$headings, &$links, &$images, &$words, &$firstParagraph, &$position, $type) {
            foreach ($node->childNodes as $child) {
                if ($child instanceof \DOMComment) {
                    if (preg_match('/^§S:(.+)$/', $child->data, $m)) {
                        $section = $m[1];
                    } elseif ($child->data === '§/S') {
                        $section = null;
                    }
                    continue;
                }
                if ($child instanceof \DOMText) {
                    if (! in_array($child->parentNode->nodeName, ['script', 'style', 'noscript'], true)) {
                        $n = str_word_count(preg_replace('/[^\p{L}\p{N}\s\'-]+/u', ' ', $child->nodeValue));
                        if ($n) {
                            $where = self::region($child, $section, $type);
                            $words[$where] = ($words[$where] ?? 0) + $n;
                        }
                    }
                    continue;
                }
                if (! $child instanceof DOMElement) {
                    continue;
                }
                $tag = strtolower($child->nodeName);
                if (in_array($tag, ['script', 'style', 'noscript', 'template'], true)) {
                    continue;
                }
                $where = self::region($child, $section, $type);

                if (preg_match('/^h([1-6])$/', $tag, $m)) {
                    $headings[] = ['level' => (int) $m[1], 'text' => self::text($child), 'section' => $where, 'position' => ++$position];
                } elseif ($tag === 'a' && $child->hasAttribute('href')) {
                    $href = $child->getAttribute('href');
                    $rel = strtolower($child->getAttribute('rel'));
                    $links[] = [
                        'href' => $href,
                        'path' => Support::internalPath($href),
                        'anchor' => self::text($child) ?: ($child->getAttribute('aria-label') ?: ($child->getElementsByTagName('img')->item(0)?->getAttribute('alt') ?? '')),
                        'nofollow' => str_contains($rel, 'nofollow'),
                        'section' => $where,
                    ];
                } elseif ($tag === 'img') {
                    $picture = $child->parentNode && strtolower($child->parentNode->nodeName) === 'picture' ? $child->parentNode : null;
                    $webpSource = false;
                    if ($picture) {
                        foreach ($picture->getElementsByTagName('source') as $src) {
                            $webpSource = $webpSource || str_contains($src->getAttribute('type'), 'webp') || str_contains($src->getAttribute('srcset'), '.webp');
                        }
                    }
                    $images[] = [
                        'src' => $child->getAttribute('src'),
                        'alt' => $child->hasAttribute('alt') ? $child->getAttribute('alt') : null,
                        'width' => $child->getAttribute('width') ?: null,
                        'height' => $child->getAttribute('height') ?: null,
                        'loading' => $child->getAttribute('loading') ?: null,
                        'webp' => $webpSource || preg_match('/\.webp(\?|$)/i', $child->getAttribute('src')) === 1,
                        'section' => $where,
                        'position' => ++$position,
                    ];
                } elseif ($tag === 'p' && $firstParagraph === null && ! in_array($where, self::CHROME, true)) {
                    $t = self::text($child);
                    if (mb_strlen($t) >= 40) {
                        $firstParagraph = $t;
                    }
                }
                $walk($child);
            }
        };
        $walk($dom->documentElement ?? $dom);

        $contentWords = array_sum(array_diff_key($words, array_flip(self::CHROME)));

        return [
            'path' => $path,
            'type' => $type,
            'title' => ($t = $xp->query('//title')->item(0)) ? trim($t->textContent) : null,
            'description' => $meta('//meta[@name="description"]'),
            'robots' => $meta('//meta[@name="robots"]'),
            'canonical' => $canonical,
            'og_image' => $meta('//meta[@property="og:image"]'),
            'og_title' => $meta('//meta[@property="og:title"]'),
            'schema_types' => array_values(array_unique($schemaTypes)),
            'headings' => $headings,
            'links' => $links,
            'images' => $images,
            'words' => ['by_section' => $words, 'content_total' => $contentWords],
            'first_paragraph' => $firstParagraph,
        ];
    }

    /**
     * Inside <main>: the section key (or "post" / "content"). Outside: "header" (site header / nav, offer bar),
     * "footer", or "chrome" (floating WhatsApp button, sticky bar).
     */
    private static function region(\DOMNode $node, ?string $section, string $type): string
    {
        $outside = 'chrome';
        for ($n = $node; $n; $n = $n->parentNode) {
            $name = $n->nodeName;
            if ($name === 'main') {
                return $section ?? ($type === 'post' ? 'post' : 'content');
            }
            if ($name === 'footer') {
                $outside = 'footer';
            } elseif (($name === 'nav' || $name === 'header') && $outside === 'chrome') {
                $outside = 'header';
            } elseif ($n instanceof DOMElement && str_contains(' ' . $n->getAttribute('class') . ' ', ' offer-bar ')) {
                $outside = 'header';
            }
        }

        return $outside;
    }

    public const CHROME = ['header', 'footer', 'chrome'];

    private static function text(\DOMNode $n): string
    {
        return trim(preg_replace('/\s+/u', ' ', $n->textContent));
    }
}
