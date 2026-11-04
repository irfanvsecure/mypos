<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = ['published_at' => 'datetime'];

    /** Original topics; the categories table (seeded from these) is the source once it has rows. */
    public const TOPICS = [
        'fbr-compliance' => 'FBR & Tax Compliance',
        'restaurant'     => 'Restaurant POS',
        'salon'          => 'Salon POS',
        'retail'         => 'Retail POS',
    ];

    /** @var array<string, string>|null */
    private static ?array $topics = null;

    /** Category slug => name, in display order (the blog filter bar). */
    public static function topics(): array
    {
        try {
            return static::$topics ??= (Category::orderBy('sort_order')->orderBy('id')->pluck('name', 'slug')->all() ?: self::TOPICS);
        } catch (\Throwable) {
            return self::TOPICS;
        }
    }

    public static function flushTopics(): void
    {
        static::$topics = null;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'topic', 'slug');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function seo()
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }

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
        return self::topics()[$this->topic] ?? 'Insights';
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

        // The site uses no h4 headings; demote any in post content to h3.
        $html = preg_replace('#<(/?)h4\b#i', '<$1h3', $html);

        return [$html, $toc];
    }
}
