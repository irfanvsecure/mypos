<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientLogo extends Model
{
    use SoftDeletes;

    protected $table = 'client_logos';

    protected $guarded = ['id'];

    protected $casts = ['is_visible' => 'boolean'];

    public function scopeShown($q, string $group)
    {
        return $q->where('logo_group', $group)->where('is_visible', true)->orderBy('sort_order')->orderBy('id');
    }

    /** [[image, name], …] for a group, in display order. */
    public static function pairs(string $group): array
    {
        // The proof strip renders several times per page: one query per group per request.
        return static::$memo[$group] ??= static::shown($group)->get(['image', 'name'])->map(fn ($l) => [$l->image, $l->name])->all();
    }

    private static array $memo = [];

    protected static function booted(): void
    {
        $flush = fn () => static::$memo = [];
        static::saved($flush);
        static::deleted($flush);
        static::restored($flush);
    }
}
