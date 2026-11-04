<?php

namespace App\Site;

/**
 * Allow-list HTML sanitizer for content written through the MCP tools.
 *
 * It never re-serialises markup: text, comments and every allowed tag are kept byte for byte, and a tag is
 * rewritten only when something has to be removed from it. That way the existing hand-built sections (SVG,
 * inline styles, data-* hooks used by app.js, {{placeholders}}) pass through unchanged — see
 * tests/Feature/SanitizerRoundTripTest, which runs every stored section through it.
 *
 * Removed: <script>/<style>/<form>/<object>/… (with their content), unknown tags (content kept), event
 * handler and other unlisted attributes, javascript:/data:/vbscript: URLs, iframes not from YouTube/Vimeo/Google
 * Maps, SVG <use>/<mpath> references that are not "#id", and CSS that can run code or load from odd schemes.
 *
 * Alpine.js attributes (x-data, @click, :class) are NOT allowed: the site does not load Alpine, and on an
 * Alpine page those attributes are JavaScript, which this allow-list exists to keep out.
 */
class HtmlSanitizer
{
    /** Elements removed together with everything inside them. */
    private const DROP_WITH_CONTENT = ['script', 'style', 'form', 'object', 'embed', 'applet', 'template', 'noscript',
        'textarea', 'select', 'frame', 'frameset', 'noembed', 'noframes', 'xmp', 'plaintext', 'math', 'base', 'meta', 'link', 'title'];

    private const TAGS = [
        // structure & text
        'a', 'abbr', 'address', 'article', 'aside', 'b', 'bdi', 'bdo', 'blockquote', 'br', 'button', 'caption', 'cite', 'code',
        'col', 'colgroup', 'dd', 'del', 'details', 'dfn', 'div', 'dl', 'dt', 'em', 'figcaption', 'figure', 'footer', 'h1', 'h2',
        'h3', 'h4', 'h5', 'h6', 'header', 'hr', 'i', 'iframe', 'img', 'input', 'ins', 'kbd', 'label', 'legend', 'fieldset', 'li',
        'main', 'mark', 'nav', 'ol', 'p', 'picture', 'pre', 'q', 's', 'samp', 'section', 'small', 'source', 'span', 'strong',
        'sub', 'summary', 'sup', 'table', 'tbody', 'td', 'tfoot', 'th', 'thead', 'time', 'tr', 'track', 'u', 'ul', 'var',
        'video', 'audio', 'wbr',
        // SVG (lower-cased)
        'svg', 'g', 'path', 'circle', 'ellipse', 'line', 'polyline', 'polygon', 'rect', 'text', 'tspan', 'defs', 'symbol',
        'use', 'lineargradient', 'radialgradient', 'stop', 'clippath', 'mask', 'pattern', 'desc', 'animatemotion', 'mpath',
    ];

    private const ATTRS = [
        'id', 'class', 'style', 'title', 'role', 'tabindex', 'hidden', 'lang', 'dir', 'translate',
        'href', 'target', 'rel', 'download', 'hreflang',
        'src', 'srcset', 'sizes', 'alt', 'width', 'height', 'loading', 'decoding', 'fetchpriority', 'media', 'poster',
        'controls', 'autoplay', 'muted', 'loop', 'playsinline', 'preload', 'kind', 'srclang', 'label', 'default',
        'allow', 'allowfullscreen', 'frameborder', 'referrerpolicy',
        'type', 'value', 'min', 'max', 'step', 'name', 'placeholder', 'checked', 'disabled', 'readonly', 'required',
        'autocomplete', 'inputmode', 'for', 'open',
        'colspan', 'rowspan', 'scope', 'headers', 'span', 'start', 'reversed', 'datetime', 'cite',
        // SVG presentation & geometry (lower-cased)
        'viewbox', 'xmlns', 'xmlns:xlink', 'xlink:href', 'd', 'cx', 'cy', 'r', 'rx', 'ry', 'x', 'y', 'x1', 'x2', 'y1', 'y2',
        'dx', 'dy', 'points', 'fill', 'fill-opacity', 'fill-rule', 'stroke', 'stroke-width', 'stroke-linecap', 'stroke-linejoin',
        'stroke-dasharray', 'stroke-dashoffset', 'stroke-miterlimit', 'stroke-opacity', 'opacity', 'transform', 'offset',
        'stop-color', 'stop-opacity', 'gradientunits', 'gradienttransform', 'preserveaspectratio', 'shape-rendering',
        'clip-path', 'clip-rule', 'mask', 'font-size', 'font-weight', 'font-family', 'text-anchor', 'dominant-baseline',
        'patternunits', 'focusable', 'vector-effect', 'begin', 'dur', 'repeatcount', 'path', 'rotate', 'keypoints', 'keytimes',
    ];

    private const URL_ATTRS = ['href', 'src', 'xlink:href', 'poster', 'cite'];

    private const IFRAME_HOSTS = '/^https:\/\/(www\.)?(youtube\.com|youtube-nocookie\.com|player\.vimeo\.com|google\.com\/maps)\//i';

    /** @var string[] what the last clean() removed, for error messages */
    private array $removed = [];

    /** @return array{html: string, removed: string[]} */
    public function clean(string $html): array
    {
        $this->removed = [];
        $out = '';
        $i = 0;
        $n = strlen($html);

        while ($i < $n) {
            $lt = strpos($html, '<', $i);
            if ($lt === false) {
                $out .= substr($html, $i);
                break;
            }
            $out .= substr($html, $i, $lt - $i);

            if (substr($html, $lt, 4) === '<!--') {
                $end = strpos($html, '-->', $lt + 4);
                $end = $end === false ? $n : $end + 3;
                $comment = substr($html, $lt, $end - $lt);
                if (preg_match('/^<!--\s*\[if|<!\[endif/i', $comment)) {
                    $this->removed[] = 'conditional comment';
                } else {
                    $out .= $comment;
                }
                $i = $end;
                continue;
            }

            if (! preg_match('/\G<(\/?)([a-zA-Z][a-zA-Z0-9:-]*)/', $html, $m, 0, $lt)) {
                // "<" that does not start a tag (e.g. "a < b", "<!DOCTYPE", "<?"): keep it as text, escaped.
                $out .= '&lt;';
                $i = $lt + 1;
                continue;
            }

            $closing = $m[1] === '/';
            $name = strtolower($m[2]);
            $end = $this->tagEnd($html, $lt);
            $tag = substr($html, $lt, $end - $lt);

            if (in_array($name, self::DROP_WITH_CONTENT, true)) {
                $this->removed[] = "<$name> element";
                $void = in_array($name, ['base', 'meta', 'link'], true) || str_ends_with(rtrim($tag), '/>');
                $i = $closing || $void ? $end : $this->skipElement($html, $end, $name);
                continue;
            }
            if (! in_array($name, self::TAGS, true)) {
                $this->removed[] = "<$name> tag";
                $i = $end;
                continue;
            }

            $out .= $closing ? $tag : $this->cleanTag($tag, $name);
            $i = $end;
        }

        return ['html' => $out, 'removed' => array_values(array_unique($this->removed))];
    }

    /** One opening tag: kept as-is unless an attribute must go. */
    private function cleanTag(string $tag, string $name): string
    {
        $attrs = $this->parseAttributes($tag);
        $keep = [];
        $changed = false;
        foreach ($attrs as [$raw, $attr, $value]) {
            $reason = $this->rejectAttribute($name, $attr, $value);
            if ($reason !== null) {
                $this->removed[] = $reason;
                $changed = true;
            } else {
                $keep[] = $raw;
            }
        }

        if ($name === 'iframe' && ! $this->safeIframe($attrs)) {
            $this->removed[] = '<iframe> from a host that is not allowed';
            return '';
        }
        if (! $changed) {
            return $tag;
        }

        $selfClose = str_ends_with(rtrim($tag), '/>') ? '/>' : '>';
        preg_match('/^<[a-zA-Z][a-zA-Z0-9:-]*/', $tag, $open);

        return $open[0] . ($keep ? ' ' . implode(' ', $keep) : '') . $selfClose;
    }

    private function rejectAttribute(string $tag, string $attr, ?string $value): ?string
    {
        if (str_starts_with($attr, 'on')) {
            return "event handler $attr";
        }
        $allowed = in_array($attr, self::ATTRS, true)
            || preg_match('/^data-[a-z0-9_.:-]+$/', $attr) || preg_match('/^aria-[a-z]+$/', $attr);
        if (! $allowed) {
            return "attribute $attr";
        }
        if ($value === null) {
            return null;
        }
        $plain = $this->decoded($value);

        if (in_array($attr, self::URL_ATTRS, true)) {
            if (in_array($tag, ['use', 'mpath'], true) && ! str_starts_with($plain, '#')) {
                return "$tag reference outside the page";
            }
            if (! $this->safeUrl($plain)) {
                return "unsafe URL in $attr";
            }
        }
        if ($attr === 'srcset') {
            foreach (explode(',', $plain) as $candidate) {
                if (! $this->safeUrl(trim(preg_split('/\s+/', trim($candidate))[0] ?? ''))) {
                    return 'unsafe URL in srcset';
                }
            }
        }
        if ($attr === 'style' && ! $this->safeCss($plain)) {
            return 'unsafe CSS in style';
        }

        return null;
    }

    private function safeUrl(string $url): bool
    {
        $u = preg_replace('/[\x00-\x20]+/', '', $url);
        if ($u === '' || preg_match('/^(#|\/|\?|\.|\{\{)/', $u)) {
            return true;
        }
        if (preg_match('/^([a-z][a-z0-9+.-]*):/i', $u, $m)) {
            return in_array(strtolower($m[1]), ['http', 'https', 'mailto', 'tel'], true);
        }

        return true; // relative path such as "uploads/x.png"
    }

    private function safeCss(string $css): bool
    {
        $c = strtolower(preg_replace('/\/\*.*?\*\/|\\\\|\s+/s', '', $css));
        if (preg_match('/expression\(|javascript:|vbscript:|behavior:|-moz-binding|@import/', $c)) {
            return false;
        }
        preg_match_all('/url\(([\'"]?)(.*?)\1\)/', $c, $urls);
        foreach ($urls[2] as $u) {
            if (! $this->safeUrl($u)) {
                return false;
            }
        }

        return true;
    }

    private function safeIframe(array $attrs): bool
    {
        foreach ($attrs as [, $attr, $value]) {
            if ($attr === 'src') {
                return (bool) preg_match(self::IFRAME_HOSTS, $this->decoded((string) $value));
            }
        }

        return false;
    }

    private function decoded(string $v): string
    {
        return html_entity_decode($v, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /** @return array<int, array{0:string,1:string,2:?string}> [raw text, lower-case name, raw value|null] */
    private function parseAttributes(string $tag): array
    {
        $body = preg_replace('/^<[a-zA-Z][a-zA-Z0-9:-]*/', '', $tag);
        $body = preg_replace('/\/?>$/', '', $body);
        preg_match_all('/([^\s=\/>"\']+)(?:\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>"\']+))?/', $body, $m, PREG_SET_ORDER);

        return array_map(fn ($a) => [$a[0], strtolower($a[1]), isset($a[2]) ? trim($a[2], '"\'') : null], $m);
    }

    private function tagEnd(string $s, int $i): int
    {
        $quote = null;
        for ($n = strlen($s); $i < $n; $i++) {
            $c = $s[$i];
            if ($quote) {
                if ($c === $quote) {
                    $quote = null;
                }
            } elseif ($c === '"' || $c === "'") {
                $quote = $c;
            } elseif ($c === '>') {
                return $i + 1;
            }
        }

        return $n;
    }

    /** Offset after the closing tag of a dropped element (or end of input). */
    private function skipElement(string $s, int $from, string $name): int
    {
        if (preg_match('/<\/' . preg_quote($name, '/') . '\s*>/i', $s, $m, PREG_OFFSET_CAPTURE, $from)) {
            return $m[0][1] + strlen($m[0][0]);
        }

        return strlen($s);
    }
}
