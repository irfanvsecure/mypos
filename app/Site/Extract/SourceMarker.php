<?php

namespace App\Site\Extract;

/**
 * Used only by `site:extract`: returns a copy of a page's Blade source in which
 *  - every <x-component> tag is wrapped in Recorder::open()/close() calls (output markers + data capture), and
 *  - the inside of every @push('head') is wrapped in <!--§H--> … <!--§/H--> so page-level structured data can
 *    be told apart from what components push.
 * The markers are Blade directives (@extractOpen / @extractClose, registered only by site:extract-render), so
 * Blade swallows the same newlines it swallowed after the original tag.
 */
class SourceMarker
{
    public static function mark(string $src): string
    {
        $src = str_replace("\r\n", "\n", $src);
        $src = self::markPushes($src);

        return self::markComponents($src);
    }

    private static function markPushes(string $src): string
    {
        return preg_replace_callback("/@push\('head'\)\n(.*?)@endpush/s", fn ($m) => "@push('head')\n<!--§H-->" . $m[1] . '<!--§/H-->@endpush', $src);
    }

    private static function markComponents(string $src): string
    {
        $out = '';
        $pos = 0;
        while (preg_match('/<x-([a-z0-9][a-z0-9.\-]*)/', $src, $m, PREG_OFFSET_CAPTURE, $pos)) {
            $start = $m[0][1];
            $name = $m[1][0];
            $openEnd = self::tagEnd($src, $start);
            $tag = substr($src, $start, $openEnd - $start);
            $end = $openEnd;
            if ($src[$openEnd - 2] !== '/') {
                // Paired tag: mark the components inside its slot too.
                $end = self::closingEnd($src, $openEnd, $name);
                $closeStart = strrpos(substr($src, 0, $end), '</x-');
                $tag .= self::markComponents(substr($src, $openEnd, $closeStart - $openEnd)) . substr($src, $closeStart, $end - $closeStart);
            }
            $out .= substr($src, $pos, $start - $pos)
                . "@extractOpen('" . $name . "')"
                . $tag
                . '@extractClose';
            $pos = $end;
        }

        return $out . substr($src, $pos);
    }

    /** Offset just past the ">" that ends the tag starting at $i (quotes respected). */
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
        throw new \RuntimeException('Unclosed component tag.');
    }

    /** Offset just past the </x-name> matching an opening tag that ended at $i (same-name nesting counted). */
    private static function closingEnd(string $s, int $i, string $name): int
    {
        $depth = 1;
        $q = preg_quote($name, '/');
        while (preg_match('/<x-' . $q . '(?=[\s\/>])|<\/x-' . $q . '\s*>/', $s, $m, PREG_OFFSET_CAPTURE, $i)) {
            if ($m[0][0][1] === '/') {
                if (--$depth === 0) {
                    return $m[0][1] + strlen($m[0][0]);
                }
                $i = $m[0][1] + strlen($m[0][0]);
            } else {
                $end = self::tagEnd($s, $m[0][1]);
                if ($s[$end - 2] !== '/') {
                    $depth++;
                }
                $i = $end;
            }
        }
        throw new \RuntimeException("No closing </x-$name>.");
    }
}
