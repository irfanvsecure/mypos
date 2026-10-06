<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    protected $casts = ['published_at' => 'datetime'];

    /** Topic slug => label, used for the blog filter bar. */
    public const TOPICS = [
        'fbr-compliance' => 'FBR & Tax Compliance',
        'restaurant'     => 'Restaurant POS',
        'salon'          => 'Salon POS',
        'retail'         => 'Retail POS',
    ];

    public function scopePublished(Builder $q): Builder
    {
        return $q->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function getUrlAttribute(): string
    {
        return url('/' . $this->slug);
    }

    public function getTopicLabelAttribute(): string
    {
        return self::TOPICS[$this->topic] ?? 'Insights';
    }

    /** Content with id="" anchors on every <h2>, plus the list of those headings for a table of contents. */
    public function contentWithToc(): array
    {
        $toc = [];
        $used = [];
        $html = preg_replace_callback('#<h2>(.*?)</h2>#s', function ($m) use (&$toc, &$used) {
            $text = trim(strip_tags($m[1]));
            if ($text === '' || strcasecmp($text, 'Table of Contents') === 0) {
                return '';
            }
            $id = \Illuminate\Support\Str::slug($text) ?: 'section';
            $base = $id;
            for ($i = 2; isset($used[$id]); $i++) {
                $id = "$base-$i";
            }
            $used[$id] = true;
            $toc[] = [$id, $text];
            return '<h2 id="' . $id . '">' . $m[1] . '</h2>';
        }, $this->content);

        return [$html, $toc];
    }
}
