<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * One block of a page.
 *  - type "html":      content = {html, embeds: [{component, attributes, slot?}]}; the html may hold {{tokens}}
 *  - type "component": content = {attributes, slot?}; rendered through resources/views/components/{component}
 * Every change to an existing section stores the previous state in section_revisions.
 */
class PageSection extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = ['content' => 'array', 'is_visible' => 'boolean'];

    protected static function booted(): void
    {
        static::updating(function (PageSection $s) {
            if ($s->isDirty(['content', 'type', 'component', 'key', 'sort_order', 'is_visible'])) {
                $s->revisions()->create([
                    'snapshot' => [
                        'key' => $s->getOriginal('key'),
                        'type' => $s->getOriginal('type'),
                        'component' => $s->getOriginal('component'),
                        'sort_order' => $s->getOriginal('sort_order'),
                        'is_visible' => (bool) $s->getOriginal('is_visible'),
                        'content' => json_decode($s->getRawOriginal('content'), true),
                    ],
                    'reason' => $s->revisionReason ?? null,
                    'actor' => $s->revisionActor ?? null,
                    'created_at' => now(),
                ]);
            }
        });
    }

    /** Set before save() to label the revision that the update creates. */
    public ?string $revisionReason = null;

    public ?string $revisionActor = null;

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function revisions()
    {
        return $this->hasMany(SectionRevision::class)->orderByDesc('id');
    }
}
