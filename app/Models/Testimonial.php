<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use SoftDeletes;

    protected $table = 'testimonials';

    protected $guarded = ['id'];

    protected $casts = ['is_visible' => 'boolean'];

    public function scopeShown($q)
    {
        return $q->where('is_visible', true)->orderBy('sort_order')->orderBy('id');
    }

    /** [[name, text], …] — the shape the review blocks were written for. */
    public static function pairs(): array
    {
        $rows = static::shown()->get(['name', 'text'])->map(fn ($t) => [$t->name, $t->text])->all();

        // Before the testimonials are imported (fresh install) fall back to the original list in config.
        return $rows ?: (static::withTrashed()->exists() ? [] : config('site.reviews', []));
    }
}
