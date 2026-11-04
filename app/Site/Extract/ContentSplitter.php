<?php

namespace App\Site\Extract;

/**
 * Splits a page's rendered content (with <!--§Ek--> component markers) into its top-level blocks.
 * Each item: ['before' => text in front of it, 'kind' => 'element'|'component', 'html' => …, 'key' => marker key]
 */
class ContentSplitter
{
    private const VOID = ['area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'source', 'track', 'wbr'];

    private const RAW = ['script', 'style', 'textarea'];

    /** @return array{items: array<int, array>, tail: string} */
    public static function split(string $html): array
    {
        $items = [];
        $before = '';
        $i = 0;
        $n = strlen($html);

        while ($i < $n) {
            $lt = strpos($html, '<', $i);
            if ($lt === false) {
                $before .= substr($html, $i);
                break;
            }
            $before .= substr($html, $i, $lt - $i);

            if (preg_match('/\G<!--§E(\d+)-->/', $html, $m, 0, $lt)) {
                $close = '<!--§/E' . $m[1] . '-->';
                $end = strpos($html, $close, $lt);
                if ($end === false) {
                    throw new \RuntimeException("Unclosed component marker {$m[1]}");
                }
                $end += strlen($close);
                $items[] = ['before' => $before, 'kind' => 'component', 'key' => (int) $m[1], 'html' => substr($html, $lt, $end - $lt)];
                $before = '';
                $i = $end;
            } elseif (str_starts_with(substr($html, $lt, 4), '<!--')) {
                $end = strpos($html, '-->', $lt);
                $end = $end === false ? $n : $end + 3;
                $before .= substr($html, $lt, $end - $lt);
                $i = $end;
            } elseif (preg_match('/\G<([a-zA-Z][a-zA-Z0-9-]*)/', $html, $m, 0, $lt)) {
                $end = self::elementEnd($html, $lt, strtolower($m[1]));
                $items[] = ['before' => $before, 'kind' => 'element', 'key' => null, 'html' => substr($html, $lt, $end - $lt)];
                $before = '';
                $i = $end;
            } else {
                throw new \RuntimeException('Unexpected markup at top level: ' . substr($html, $lt, 60));
            }
        }

        return ['items' => $items, 'tail' => $before];
    }

    /** Offset just past the element that starts at $i. */
    public static function elementEnd(string $s, int $i, string $name): int
    {
        $end = self::tagEnd($s, $i);
        if (in_array($name, self::VOID, true) || $s[$end - 2] === '/') {
            return $end;
        }
        if (in_array($name, self::RAW, true)) {
            $close = stripos($s, '</' . $name, $end);
            return self::tagEnd($s, $close);
        }

        $depth = 1;
        $p = $end;
        while ($depth > 0) {
            $lt = strpos($s, '<', $p);
            if ($lt === false) {
                throw new \RuntimeException("Unclosed <$name>");
            }
            if (substr($s, $lt, 4) === '<!--') {
                $p = strpos($s, '-->', $lt) + 3;
            } elseif (preg_match('/\G<\/([a-zA-Z][a-zA-Z0-9-]*)\s*>/', $s, $m, 0, $lt)) {
                $depth--;
                $p = $lt + strlen($m[0]);
            } elseif (preg_match('/\G<([a-zA-Z][a-zA-Z0-9-]*)/', $s, $m, 0, $lt)) {
                $tag = strtolower($m[1]);
                $te = self::tagEnd($s, $lt);
                if (in_array($tag, self::RAW, true)) {
                    $te = self::tagEnd($s, stripos($s, '</' . $tag, $te));
                } elseif (! in_array($tag, self::VOID, true) && $s[$te - 2] !== '/') {
                    $depth++;
                }
                $p = $te;
            } else {
                $p = $lt + 1; // a bare "<" in text
            }
        }

        return $p;
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
        throw new \RuntimeException('Unclosed tag');
    }
}
