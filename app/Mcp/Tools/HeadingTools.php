<?php

namespace App\Mcp\Tools;

use App\Mcp\P;
use App\Mcp\SiteTool;
use App\Mcp\Support;
use App\Mcp\ToolError;
use App\Site\HtmlEdit;
use App\Site\SiteAnalyzer;

/** Heading outline, heading edits and heading audit. */
class HeadingTools
{
    public static function tools(): array
    {
        return [
            new SiteTool('get_page_outline', 'The H1–H6 outline of the rendered page or blog post (including headings inside components, header and footer): level, text, section and position, plus word counts per section and in total.', [
                'page' => P::str('Page path or blog post slug ("" or "home" for the home page).')->reqAllowEmpty(),
            ], function (array $a) {
                $an = Support::analyze($a['page']);

                return [
                    'path' => $an['path'], 'type' => $an['type'],
                    'headings' => $an['headings'],
                    'words' => $an['words'],
                ];
            }, readOnly: true),

            new SiteTool('update_heading', 'Change the text and/or level (1–6) of a heading inside one section. Classes, attributes and inline markup around the changed words are kept. Headings that come from a component attribute (e.g. a FAQ title) can change text but not level.', [
                'page' => P::str('Page path.')->reqAllowEmpty(),
                'section' => P::str('Section key.')->req(),
                'old_text' => P::str('The heading text as shown on the page.')->req(),
                'new_text' => P::str('New text (plain).'),
                'level' => P::int('New level 1–6.', ['min:1', 'max:6']),
            ], function (array $a) {
                if (! isset($a['new_text']) && ! isset($a['level'])) {
                    throw new ToolError('Give new_text and/or level.');
                }
                if (isset($a['new_text']) && $a['new_text'] !== strip_tags($a['new_text'])) {
                    throw new ToolError('new_text must be plain text.');
                }
                $p = Support::page($a['page']);
                $s = Support::section($p, $a['section']);
                $c = $s->content;
                $done = false;

                foreach (['html', 'slot'] as $part) {
                    if ($done) {
                        break;
                    }
                    if ($part === 'html' && isset($c['html'])) {
                        [$c['html'], $done] = HtmlEdit::updateHeading($c['html'], $a['old_text'], $a['new_text'] ?? null, $a['level'] ?? null);
                    } elseif ($part === 'slot' && isset($c['slot']['html'])) {
                        [$c['slot']['html'], $done] = HtmlEdit::updateHeading($c['slot']['html'], $a['old_text'], $a['new_text'] ?? null, $a['level'] ?? null);
                    }
                }
                if (! $done && isset($c['attributes'])) {
                    // Heading text passed to a component (e.g. <x-faq title="…">).
                    foreach ($c['attributes'] as $k => $v) {
                        if (is_string($v) && HtmlEdit::plain($v) === HtmlEdit::plain($a['old_text'])) {
                            if (isset($a['level'])) {
                                throw new ToolError("This heading is the component's \"$k\" attribute; its level is fixed by the component.");
                            }
                            $c['attributes'][$k] = HtmlEdit::encodeLikeSource($a['new_text']);
                            $done = true;
                            break;
                        }
                    }
                }
                if (! $done) {
                    $found = array_map(fn ($h) => 'H' . $h['level'] . ': ' . $h['text'], HtmlEdit::headings(($c['html'] ?? '') . ($c['slot']['html'] ?? '')));
                    throw new ToolError('No heading reading "' . $a['old_text'] . '" in this section.' . ($found ? ' Headings here: ' . implode(' | ', $found) : ''));
                }

                return PageTools::saveSection($p, $s, $c, 'update_heading');
            }),

            new SiteTool('audit_headings', 'Check headings: missing H1, more than one H1, skipped levels (H2 → H4), empty or duplicate headings, headings over 70 characters. For one page/post or the whole site.', [
                'page' => P::str('Page path or post slug; leave empty for every page and post.'),
            ], function (array $a) {
                $items = isset($a['page']) ? [Support::analyze($a['page'])] : array_values(SiteAnalyzer::all());
                $report = [];
                foreach ($items as $an) {
                    $issues = self::headingIssues($an['headings']);
                    if ($issues || isset($a['page'])) {
                        $report[] = ['path' => '/' . $an['path'], 'type' => $an['type'], 'issues' => $issues];
                    }
                }

                return ['checked' => count($items), 'with_issues' => count(array_filter($report, fn ($r) => $r['issues'])), 'pages' => $report];
            }, readOnly: true),
        ];
    }

    public static function headingIssues(array $headings): array
    {
        $issues = [];
        $h1 = array_values(array_filter($headings, fn ($h) => $h['level'] === 1));
        if (! $h1) {
            $issues[] = 'No H1.';
        } elseif (count($h1) > 1) {
            $issues[] = count($h1) . ' H1 headings: ' . implode(' | ', array_column($h1, 'text'));
        }
        $prev = 0;
        $seen = [];
        foreach ($headings as $h) {
            if ($prev && $h['level'] > $prev + 1) {
                $issues[] = "Skipped level: H{$prev} → H{$h['level']} \"{$h['text']}\" (section {$h['section']})";
            }
            if ($h['text'] === '') {
                $issues[] = "Empty H{$h['level']} (section {$h['section']})";
            } elseif (mb_strlen($h['text']) > 70) {
                $issues[] = "H{$h['level']} over 70 characters (" . mb_strlen($h['text']) . "): \"{$h['text']}\"";
            }
            $key = mb_strtolower($h['text']);
            if ($h['text'] !== '' && isset($seen[$key])) {
                $issues[] = "Duplicate heading \"{$h['text']}\" (H{$seen[$key]} and H{$h['level']})";
            }
            $seen[$key] = $h['level'];
            $prev = $h['level'];
        }

        return array_values(array_unique($issues));
    }
}
