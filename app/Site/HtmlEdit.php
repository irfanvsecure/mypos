<?php

namespace App\Site;

use App\Mcp\ToolError;

/**
 * Small, exact edits on stored HTML strings. Nothing is re-serialised: only the characters being changed are
 * touched, so classes, attributes, whitespace and {{placeholders}} around them stay byte for byte.
 */
class HtmlEdit
{
    /**
     * Split HTML into ['tag'|'text'|'comment', string, offset] pieces.
     *
     * @return array<int, array{0:string,1:string,2:int}>
     */
    public static function tokens(string $html): array
    {
        $out = [];
        $i = 0;
        $n = strlen($html);
        while ($i < $n) {
            $lt = strpos($html, '<', $i);
            if ($lt === false) {
                $out[] = ['text', substr($html, $i), $i];
                break;
            }
            if ($lt > $i) {
                $out[] = ['text', substr($html, $i, $lt - $i), $i];
            }
            if (substr($html, $lt, 4) === '<!--') {
                $end = strpos($html, '-->', $lt);
                $end = $end === false ? $n : $end + 3;
                $out[] = ['comment', substr($html, $lt, $end - $lt), $lt];
            } elseif (preg_match('/\G<\/?[a-zA-Z]/', $html, $m, 0, $lt)) {
                $end = self::tagEnd($html, $lt);
                $out[] = ['tag', substr($html, $lt, $end - $lt), $lt];
                // Script / style bodies are not text.
                if (preg_match('/^<(script|style)\b/i', $out[count($out) - 1][1], $mm)) {
                    $close = stripos($html, '</' . $mm[1], $end);
                    $close = $close === false ? $n : $close;
                    $out[] = ['comment', substr($html, $end, $close - $end), $end];
                    $end = $close;
                }
            } else {
                $out[] = ['text', '<', $lt];
                $end = $lt + 1;
            }
            $i = $end;
        }

        return $out;
    }

    /** Replace $find in text only (never inside tags or attributes). Returns [new html, count, contexts]. */
    public static function replaceText(string $html, string $find, string $replace, bool $caseSensitive = true, int $limit = -1): array
    {
        $count = 0;
        $contexts = [];
        $out = '';
        // Matched on the decoded text (so "Pakistan’s" finds "Pakistan&rsquo;s"); only a text run that changes is
        // re-encoded, every other byte stays as stored.
        $pattern = '/' . preg_quote(html_entity_decode($find, ENT_QUOTES | ENT_HTML5), '/') . '/' . ($caseSensitive ? 'u' : 'iu');
        $replaceText = html_entity_decode($replace, ENT_QUOTES | ENT_HTML5);
        foreach (self::tokens($html) as [$type, $s]) {
            if ($type === 'text' && ($limit < 0 || $count < $limit)) {
                $decoded = html_entity_decode($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $before = $count;
                $changed = preg_replace_callback($pattern, function ($m) use (&$count, $replaceText, $limit) {
                    if ($limit >= 0 && $count >= $limit) {
                        return $m[0];
                    }
                    $count++;

                    return $replaceText;
                }, $decoded);
                if ($count > $before) {
                    $contexts[] = trim(preg_replace('/\s+/u', ' ', $decoded));
                    $s = self::encodeLikeSource($changed);
                }
            }
            $out .= $s;
        }

        return [$out, $count, array_slice(array_values(array_unique($contexts)), 0, 10)];
    }

    /** Text as it is written in the stored HTML: & < > escaped, quotes and everything else left as typed. */
    public static function encodeLikeSource(string $text): string
    {
        return str_replace(['&', '<', '>'], ['&amp;', '&lt;', '&gt;'], html_entity_decode($text, ENT_QUOTES | ENT_HTML5));
    }

    /** Plain text of an HTML fragment, whitespace collapsed. */
    public static function plain(string $html): string
    {
        return trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5)));
    }

    /**
     * Headings (h1–h6) in stored HTML: level, plain text, offsets of the opening tag, inner HTML and closing tag.
     *
     * @return array<int, array{level:int,text:string,open:array{0:int,1:int},inner:array{0:int,1:int},close:array{0:int,1:int}}>
     */
    public static function headings(string $html): array
    {
        $found = [];
        preg_match_all('/<h([1-6])\b[^>]*>/i', $html, $m, PREG_OFFSET_CAPTURE);
        foreach ($m[0] as $i => [$tag, $pos]) {
            $level = (int) $m[1][$i][0];
            $innerStart = $pos + strlen($tag);
            if (! preg_match('/<\/h' . $level . '\s*>/i', $html, $c, PREG_OFFSET_CAPTURE, $innerStart)) {
                continue;
            }
            $found[] = [
                'level' => $level,
                'text' => self::plain(substr($html, $innerStart, $c[0][1] - $innerStart)),
                'open' => [$pos, strlen($tag)],
                'inner' => [$innerStart, $c[0][1] - $innerStart],
                'close' => [$c[0][1], strlen($c[0][0])],
            ];
        }

        return $found;
    }

    /** Change the text and/or level of the heading whose text is $old. Keeps every attribute and inline tag. */
    public static function updateHeading(string $html, string $old, ?string $new, ?int $level): array
    {
        $old = self::plain($old);
        $matches = array_values(array_filter(self::headings($html), fn ($h) => $h['text'] === $old));
        if (! $matches) {
            return [$html, false];
        }
        if (count($matches) > 1) {
            throw new ToolError("More than one heading in this section reads \"$old\"; change it with update_page_section.");
        }
        $h = $matches[0];
        $inner = substr($html, $h['inner'][0], $h['inner'][1]);

        if ($new !== null && self::plain($new) !== $old) {
            $inner = self::replaceInnerText($inner, $old, $new);
        }
        $open = substr($html, $h['open'][0], $h['open'][1]);
        $close = substr($html, $h['close'][0], $h['close'][1]);
        if ($level !== null && $level !== $h['level']) {
            $open = preg_replace('/^<h[1-6]/i', '<h' . $level, $open);
            $close = '</h' . $level . '>';
        }

        $html = substr($html, 0, $h['open'][0]) . $open . $inner . $close . substr($html, $h['close'][0] + $h['close'][1]);

        return [$html, true];
    }

    /**
     * New text for a heading whose inner HTML may contain inline tags (<span class="hx-hl">…</span>): the changed
     * part must fall inside a single text run, so the markup around it is kept.
     */
    private static function replaceInnerText(string $inner, string $old, string $new): string
    {
        $new = self::plain($new);
        if (! str_contains($inner, '<')) {
            return self::encodeLikeSource($new);
        }
        // Common prefix / suffix between old and new text → the part that actually changes.
        $p = 0;
        $max = min(mb_strlen($old), mb_strlen($new));
        while ($p < $max && mb_substr($old, $p, 1) === mb_substr($new, $p, 1)) {
            $p++;
        }
        $s = 0;
        while ($s < $max - $p && mb_substr($old, -$s - 1, 1) === mb_substr($new, -$s - 1, 1)) {
            $s++;
        }
        $from = mb_substr($old, $p, mb_strlen($old) - $p - $s);
        $to = mb_substr($new, $p, mb_strlen($new) - $p - $s);

        // Find which text run holds old[p .. len-s] and change it there.
        $pos = 0;
        $out = '';
        $done = false;
        foreach (self::tokens($inner) as [$type, $piece]) {
            if ($type === 'text' && ! $done) {
                $t = html_entity_decode($piece, ENT_QUOTES | ENT_HTML5);
                $len = mb_strlen(preg_replace('/\s+/u', ' ', $t));
                $start = $pos;
                $pos += $len;
                if ($p >= $start && $p + mb_strlen($from) <= $pos + 1) {
                    $local = $p - $start;
                    // Leading whitespace of the run is collapsed in plain(); skip it when indexing.
                    $lead = strlen($t) - strlen(ltrim($t));
                    $decoded = mb_substr($t, 0, $lead + $local) . $to . mb_substr($t, $lead + $local + mb_strlen($from));
                    $out .= self::encodeLikeSource($decoded);
                    $done = true;
                    continue;
                }
            }
            $out .= $piece;
        }
        if (! $done) {
            throw new ToolError('This heading mixes text and inline markup in a way that cannot be edited safely; change it with update_page_section.');
        }

        return $out;
    }

    /** Wrap the first occurrence of $anchor (in text, not already inside a link) in <a href="$href">. */
    public static function addLink(string $html, string $anchor, string $href): array
    {
        $out = '';
        $done = false;
        $inLink = 0;
        $needle = html_entity_decode($anchor, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        foreach (self::tokens($html) as [$type, $s]) {
            $decoded = $type === 'text' ? html_entity_decode($s, ENT_QUOTES | ENT_HTML5, 'UTF-8') : '';
            if ($type === 'tag') {
                if (preg_match('/^<a\b/i', $s)) {
                    $inLink++;
                } elseif (preg_match('/^<\/a\s*>/i', $s)) {
                    $inLink = max(0, $inLink - 1);
                }
            } elseif ($type === 'text' && ! $done && $inLink && str_contains($decoded, $needle)) {
                throw new ToolError("\"$anchor\" is already a link in this section.");
            } elseif ($type === 'text' && ! $done && ($p = mb_strpos($decoded, $needle)) !== false) {
                // Only this text run is re-encoded; the rest of the section keeps its stored bytes.
                $s = self::encodeLikeSource(mb_substr($decoded, 0, $p))
                    . '<a href="' . htmlspecialchars($href, ENT_QUOTES) . '">' . self::encodeLikeSource($needle) . '</a>'
                    . self::encodeLikeSource(mb_substr($decoded, $p + mb_strlen($needle)));
                $done = true;
            }
            $out .= $s;
        }

        return [$out, $done];
    }

    /**
     * Links (<a href>) in stored HTML whose href points at $href (compared by normalised path / URL).
     *
     * @return array<int, array{open:array{0:int,1:int},inner:array{0:int,1:int},close:array{0:int,1:int},href:string,text:string}>
     */
    public static function links(string $html, ?callable $matches = null): array
    {
        $found = [];
        preg_match_all('/<a\b[^>]*>/i', $html, $m, PREG_OFFSET_CAPTURE);
        foreach ($m[0] as [$tag, $pos]) {
            if (! preg_match('/\shref\s*=\s*("([^"]*)"|\'([^\']*)\')/i', $tag, $h)) {
                continue;
            }
            $href = $h[2] !== '' ? $h[2] : ($h[3] ?? '');
            $innerStart = $pos + strlen($tag);
            if (! preg_match('/<\/a\s*>/i', $html, $c, PREG_OFFSET_CAPTURE, $innerStart)) {
                continue;
            }
            if ($matches && ! $matches($href)) {
                continue;
            }
            $found[] = ['open' => [$pos, strlen($tag)], 'inner' => [$innerStart, $c[0][1] - $innerStart],
                'close' => [$c[0][1], strlen($c[0][0])], 'href' => $href, 'text' => self::plain(substr($html, $innerStart, $c[0][1] - $innerStart))];
        }

        return $found;
    }

    /** Apply edits to links matched by links(): new href, new anchor text, or unwrap (keep the text). */
    public static function editLinks(string $html, array $links, ?string $newHref, ?string $newAnchor, bool $unlink): string
    {
        foreach (array_reverse($links) as $l) {
            $open = substr($html, $l['open'][0], $l['open'][1]);
            $inner = substr($html, $l['inner'][0], $l['inner'][1]);
            $close = substr($html, $l['close'][0], $l['close'][1]);
            if ($unlink) {
                $replacement = $inner;
            } else {
                if ($newHref !== null) {
                    $open = preg_replace('/(\shref\s*=\s*)("[^"]*"|\'[^\']*\')/i', '$1"' . htmlspecialchars($newHref, ENT_QUOTES) . '"', $open, 1);
                }
                if ($newAnchor !== null) {
                    $inner = str_contains($inner, '<') ? self::replaceInnerText($inner, self::plain($inner), $newAnchor) : self::encodeLikeSource($newAnchor);
                }
                $replacement = $open . $inner . $close;
            }
            $html = substr($html, 0, $l['open'][0]) . $replacement . substr($html, $l['close'][0] + $l['close'][1]);
        }

        return $html;
    }

    private static function tagEnd(string $s, int $i): int
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
}
