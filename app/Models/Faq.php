<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use SoftDeletes;

    protected $table = 'faqs';

    protected $guarded = ['id'];

    protected $casts = ['is_html' => 'boolean', 'is_visible' => 'boolean'];

    public function scopeShown($q, string $group)
    {
        return $q->where('faq_group', $group)->where('is_visible', true)->orderBy('sort_order')->orderBy('id');
    }

    /** [[question, answer], …] for a group, in display order. */
    public static function pairs(string $group): array
    {
        return static::shown($group)->get(['question', 'answer'])->map(fn ($f) => [$f->question, $f->answer])->all();
    }
}
