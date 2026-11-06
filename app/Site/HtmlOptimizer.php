<?php

namespace App\Site;

/**
 * Last pass over every HTML page before it is sent: keeps the markup the browser sees equivalent while
 * making it smaller and free of inline style attributes (Semrush "Inline styles" and "low text-HTML ratio").
 *
 * 1. style="…" values that are listed in resources/data/inline-styles.json are replaced by a class
 *    (x-xxxxxx). The matching rules, with !important so they win exactly like the inline style did, are the
 *    generated block at the end of public/css/style.css. Both come from `php artisan site:extract-styles`.
 *    A style value that is not in the map (new content added later) stays inline, so nothing can lose its look.
 * 2. Runs of whitespace between tags and in text collapse to one character. The browser collapses them the
 *    same way when it renders, and the site has no white-space:pre text.
 *
 * <script>, <style>, <pre>, <textarea> and comments are passed through untouched.
 */
class HtmlOptimizer
{
    public const MAP_FILE = 'data/inline-styles.json';

    /** A start tag, with quoted attribute values that may contain ">" (from the HTML spec's attribute syntax). */
    private const TAG = '<[a-zA-Z][^\s/>]*(?:\s+[^\s"\'>\/=]+(?:\s*=\s*(?:"[^"]*"|\'[^\']*\'|[^\s"\'>]+))?)*\s*\/?>';

    /** @param array<string,string> $map style attribute value => class name */
    public function __construct(private array $map) {}

    public static function fromMapFile(): self
    {
        static $map;
        if ($map === null) {
            $json = @file_get_contents(resource_path(self::MAP_FILE));
            $map = $json ? (json_decode($json, true) ?: []) : [];
        }

        return new self($map);
    }

    public function optimize(string $html): string
    {
        // Raw-text elements and comments are kept byte for byte (only a <pre>/<textarea> opening tag is looked at).
        if (preg_match_all('#<(script|style|pre|textarea)\b[^>]*>.*?</\1\s*>|<!--.*?-->#is', $html, $raw, PREG_OFFSET_CAPTURE) === false) {
            return $html;
        }

        $out = '';
        $pos = 0;
        foreach ($raw[0] as [$block, $offset]) {
            $out .= $this->optimizeSegment(substr($html, $pos, $offset - $pos)) . $this->classifyStyle($block, true);
            $pos = $offset + strlen($block);
        }

        return $out . $this->optimizeSegment(substr($html, $pos));
    }

    private function optimizeSegment(string $segment): string
    {
        $tokens = preg_split('#(' . self::TAG . '|</[a-zA-Z][^>]*>)#s', $segment, -1, PREG_SPLIT_DELIM_CAPTURE);
        if ($tokens === false) {
            return $segment;
        }

        $out = '';
        foreach ($tokens as $i => $token) {
            if ($i % 2 === 1) {
                $out .= $token[1] === '/' ? $token : $this->classifyStyle($token);
            } else {
                $out .= preg_replace_callback('/\s{2,}/', fn ($m) => str_contains($m[0], "\n") ? "\n" : ' ', $token);
            }
        }

        return $out;
    }

    /**
     * Swap a mapped style attribute on a start tag for its class. With $rawElement the token is a whole
     * <script>/<pre>/… element or a comment, and only the opening tag of a <pre>/<textarea> is looked at.
     */
    private function classifyStyle(string $tag, bool $rawElement = false): string
    {
        if ($rawElement) {
            if (! preg_match('#^<(pre|textarea)\b#i', $tag) || ! preg_match('#^' . self::TAG . '#s', $tag, $m)) {
                return $tag;
            }

            return $this->classifyStyle($m[0]) . substr($tag, strlen($m[0]));
        }

        if (! str_contains($tag, 'style') || ! preg_match('#\sstyle\s*=\s*(?:"([^"]*)"|\'([^\']*)\')#i', $tag, $m, PREG_OFFSET_CAPTURE)) {
            return $tag;
        }

        $value = ($m[1][1] ?? -1) >= 0 ? $m[1][0] : $m[2][0];
        $class = $this->map[$value] ?? null;
        if ($class === null) {
            return $tag;
        }

        $tag = substr($tag, 0, $m[0][1]) . substr($tag, $m[0][1] + strlen($m[0][0]));

        if (preg_match('#\sclass\s*=\s*(?:"([^"]*)"|\'([^\']*)\'|([^\s"\'>]+))#i', $tag, $c, PREG_OFFSET_CAPTURE)) {
            $existing = '';
            foreach ([1, 2, 3] as $g) {
                if (($c[$g][1] ?? -1) >= 0) {
                    $existing = $c[$g][0];
                }
            }
            $classes = trim($existing) === '' ? $class : rtrim($existing) . ' ' . $class;

            return substr($tag, 0, $c[0][1]) . ' class="' . $classes . '"' . substr($tag, $c[0][1] + strlen($c[0][0]));
        }

        return preg_replace('#\s*(/?>)$#', ' class="' . $class . '"$1', $tag, 1);
    }
}
