<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * Compares two `site:snapshot` folders URL by URL and writes a Markdown report.
 *
 * A page passes only when its full HTML is byte-identical after two normalisations that are not content:
 * the per-session CSRF token, and the "?v=<filemtime>" cache-busters on the CSS/JS files.
 * For pages that differ, the report breaks the difference down into title/meta, JSON-LD, visible text,
 * image sources, links and the raw lines that changed.
 */
class SiteDiff extends Command
{
    protected $signature = 'site:diff
        {before : Snapshot label to compare from, e.g. baseline}
        {after : Snapshot label to compare to}
        {--only= : Comma-separated paths to compare (an empty item is the home page)}
        {--report= : Report file (default storage/app/reports/diff-<before>-vs-<after>.md)}';

    protected $description = 'Compare two site snapshots and report every difference';

    public function handle(): int
    {
        $root = storage_path('app/snapshots');
        $a = json_decode(File::get("$root/{$this->argument('before')}/manifest.json"), true);
        $b = json_decode(File::get("$root/{$this->argument('after')}/manifest.json"), true);

        $paths = array_keys($b['pages']);
        if (($only = $this->option('only')) !== null) {
            $paths = array_values(array_intersect($paths, explode(',', $only)));
        }

        $rows = [];
        $details = [];
        foreach ($paths as $path) {
            $label = $path === '' ? '/' : '/' . $path;
            if (!isset($a['pages'][$path])) {
                $rows[] = [$label, 'NEW', 'not in the "before" snapshot'];
                continue;
            }
            $ma = $a['pages'][$path];
            $mb = $b['pages'][$path];
            $issues = [];
            foreach (['status', 'location', 'content_type', 'x_robots'] as $k) {
                if ($this->normUrl($ma[$k] ?? null, $a['base']) !== $this->normUrl($mb[$k] ?? null, $b['base'])) {
                    $issues[] = "$k: `" . ($ma[$k] ?? 'null') . '` → `' . ($mb[$k] ?? 'null') . '`';
                }
            }

            $file = SiteSnapshot::fileName($path);
            $ha = $this->normalize(File::get("$root/{$this->argument('before')}/pages/$file"), $a['base']);
            $hb = $this->normalize(File::get("$root/{$this->argument('after')}/pages/$file"), $b['base']);

            if ($ha !== $hb) {
                $issues[] = 'HTML differs';
                $details[$label] = $this->explain($ha, $hb);
            }
            $rows[] = [$label, $issues ? 'DIFF' : 'identical', implode('; ', $issues)];
        }

        $failed = array_filter($rows, fn ($r) => $r[1] !== 'identical');
        $report = $this->report($rows, $details, count($failed));
        $out = $this->option('report') ?: storage_path("app/reports/diff-{$this->argument('before')}-vs-{$this->argument('after')}.md");
        File::ensureDirectoryExists(dirname($out));
        File::put($out, $report);

        $this->line(count($rows) - count($failed) . ' identical, ' . count($failed) . ' different. Report: ' . $out);
        foreach ($failed as $r) {
            $this->warn("  {$r[0]}: {$r[2]}");
        }

        return $failed ? self::FAILURE : self::SUCCESS;
    }

    private function normUrl(?string $v, string $base): ?string
    {
        return $v === null ? null : str_replace($base, '{base}', $v);
    }

    private function normalize(string $html, string $base): string
    {
        // Windows checkouts give the Blade files CRLF line endings; Linux servers render LF. Not content.
        $html = str_replace("\r\n", "\n", $html);
        // Empty lines between tags in <head> (e.g. around a @verbatim JSON-LD block) have no effect.
        $html = preg_replace_callback('#<head>.*?</head>#s', fn ($m) => preg_replace("/\n[ \t]*(?=\n)/", '', $m[0]), $html, 1);
        $html = preg_replace('/(name="_token"[^>]*value=")[^"]+"/', '$1{csrf}"', $html);
        $html = preg_replace('/(content=")[A-Za-z0-9]{40}(" name="csrf-token")/', '$1{csrf}$2', $html);
        $html = preg_replace('/\?v=\d{9,11}/', '?v={mtime}', $html);
        // Client portfolio pages list six *random* other clients on every request (ClientController::show).
        $html = preg_replace('#(Other businesses on myPOS\.</div>\s*</div>\s*<ul class="cs-grid">).*?(</ul>)#s', '$1{random clients}$2', $html);
        return str_replace($base, '{base}', $html);
    }

    /** Human-readable breakdown of how two versions of a page differ. */
    private function explain(string $a, string $b): array
    {
        $out = [];
        $pa = $this->parts($a);
        $pb = $this->parts($b);
        foreach ($pa as $k => $va) {
            $vb = $pb[$k];
            if ($va === $vb) {
                continue;
            }
            $removed = array_values(array_diff($va, $vb));
            $added = array_values(array_diff($vb, $va));
            if (!$removed && !$added) {
                $out[] = "**$k**: same items, different order or count";
                continue;
            }
            $out[] = "**$k**:";
            foreach (array_slice($removed, 0, 15) as $r) {
                $out[] = '  - before: `' . mb_strimwidth(str_replace('`', "'", $r), 0, 300, '…') . '`';
            }
            foreach (array_slice($added, 0, 15) as $r) {
                $out[] = '  - after:  `' . mb_strimwidth(str_replace('`', "'", $r), 0, 300, '…') . '`';
            }
        }

        // First raw lines that differ, for anything the breakdown above doesn't capture (attributes, classes…).
        $la = explode("\n", $a);
        $lb = explode("\n", $b);
        $shown = 0;
        for ($i = 0, $n = max(count($la), count($lb)); $i < $n && $shown < 6; $i++) {
            if (($la[$i] ?? null) !== ($lb[$i] ?? null)) {
                $out[] = "line " . ($i + 1) . ":";
                $out[] = '  - before: `' . mb_strimwidth(trim(str_replace('`', "'", $la[$i] ?? '(none)')), 0, 400, '…') . '`';
                $out[] = '  - after:  `' . mb_strimwidth(trim(str_replace('`', "'", $lb[$i] ?? '(none)')), 0, 400, '…') . '`';
                $shown++;
            }
        }

        return $out;
    }

    /** @return array<string, string[]> */
    private function parts(string $html): array
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_NOERROR);
        libxml_clear_errors();
        $xp = new \DOMXPath($dom);

        $list = fn (string $q, callable $f) => array_map($f, iterator_to_array($xp->query($q)));

        $body = $xp->query('//body')->item(0);
        $text = [];
        if ($body) {
            foreach ($xp->query('.//text()[not(ancestor::script) and not(ancestor::style)]', $body) as $t) {
                $s = trim(preg_replace('/\s+/u', ' ', $t->nodeValue));
                if ($s !== '') {
                    $text[] = $s;
                }
            }
        }

        return [
            'title & meta' => array_merge(
                $list('//title', fn ($n) => 'title: ' . $n->textContent),
                $list('//meta[@name or @property]', fn ($n) => ($n->getAttribute('name') ?: $n->getAttribute('property')) . ': ' . $n->getAttribute('content')),
                $list('//link[@rel="canonical"]', fn ($n) => 'canonical: ' . $n->getAttribute('href')),
            ),
            'JSON-LD' => $list('//script[@type="application/ld+json"]', fn ($n) => trim($n->textContent)),
            'visible text' => $text,
            'images' => $list('//img', fn ($n) => $n->getAttribute('src') . ' | alt=' . $n->getAttribute('alt') . ($n->getAttribute('srcset') ? ' | srcset=' . $n->getAttribute('srcset') : '')),
            'picture sources' => $list('//source', fn ($n) => $n->getAttribute('srcset')),
            'links' => $list('//a', fn ($n) => $n->getAttribute('href') . ' → ' . trim(preg_replace('/\s+/u', ' ', $n->textContent))),
            'forms' => $list('//form', fn ($n) => $n->getAttribute('action') . ' #' . $n->getAttribute('id')),
        ];
    }

    private function report(array $rows, array $details, int $failed): string
    {
        $md = "# Rendered-page diff: `{$this->argument('before')}` vs `{$this->argument('after')}`\n\n";
        $md .= 'Generated ' . now()->toDayDateTimeString() . '. ';
        $md .= 'Normalised before comparing: per-session CSRF token, `?v=<filemtime>` on CSS/JS, site root URL, CRLF vs LF line endings, empty lines inside `<head>`, and the six random "Other businesses" on client portfolio pages.' . "\n\n";
        $md .= '**' . (count($rows) - $failed) . ' identical, ' . $failed . " different** out of " . count($rows) . " URLs.\n\n";
        $md .= "| URL | Result | Notes |\n|---|---|---|\n";
        foreach ($rows as [$u, $r, $n]) {
            $md .= "| `$u` | " . ($r === 'identical' ? '✅ identical' : "❌ $r") . ' | ' . str_replace('|', '\\|', $n) . " |\n";
        }
        foreach ($details as $u => $lines) {
            $md .= "\n## `$u`\n\n" . implode("\n", $lines) . "\n";
        }
        return $md;
    }
}
