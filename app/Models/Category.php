<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';

    protected $guarded = ['id'];

    protected $casts = [];

    public function posts()
    {
        return $this->hasMany(Post::class, 'topic', 'slug');
    }

    protected static function booted(): void
    {
        $flush = fn () => Post::flushTopics();
        static::saved($flush);
        static::deleted($flush);
        static::restored($flush);
    }

    public function seo()
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }
}
