<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * A page of the marketing site whose body is a list of sections (see App\Site\SectionRenderer).
 * `path` is the URL path without slashes: '' is the home page.
 */
class Page extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = ['options' => 'array'];

    public function sections()
    {
        return $this->hasMany(PageSection::class)->orderBy('sort_order')->orderBy('id');
    }

    public function seo()
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }

    public function schemaBlocks()
    {
        return $this->morphMany(SchemaBlock::class, 'schemaable')->orderBy('sort_order')->orderBy('id');
    }

    public function scopePublished($q)
    {
        return $q->where('status', 'published');
    }

    public function url(): string
    {
        return url('/' . $this->path);
    }
}
