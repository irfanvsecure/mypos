<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * A price shown on the site. Rows with a plan_key are the single source for that price: page content refers to
 * them as {{price:key}} ("2,000") or {{price_plain:key}} ("2000"), and the price builder reads them directly.
 */
class PricingPlan extends Model
{
    use SoftDeletes;

    protected $table = 'pricing_plans';

    protected $guarded = ['id'];

    protected $casts = ['features' => 'array', 'extra' => 'array', 'is_featured' => 'boolean', 'cta_new_tab' => 'boolean', 'is_visible' => 'boolean', 'price_pkr' => 'decimal:2'];

    /** @var array<string, float|null>|null plan_key => price, loaded once per request */
    private static ?array $prices = null;

    protected static function booted(): void
    {
        $flush = fn () => static::$prices = null;
        static::saved($flush);
        static::deleted($flush);
        static::restored($flush);
    }

    public function scopeShown($q, string $group)
    {
        return $q->where('plan_group', $group)->where('is_visible', true)->orderBy('sort_order')->orderBy('id');
    }

    /** Price in PKR of the plan with this key (null when unknown or not numeric). */
    public static function price(string $key): ?float
    {
        static::$prices ??= static::whereNotNull('plan_key')->pluck('price_pkr', 'plan_key')
            ->map(fn ($p) => $p === null ? null : (float) $p)->all();

        return static::$prices[$key] ?? null;
    }

    /** "2,000" (or "2000" when $plain), whole rupees; '' if the key is unknown. */
    public static function formatted(string $key, bool $plain = false): string
    {
        $p = static::price($key);
        if ($p === null) {
            return '';
        }
        $decimals = fmod($p, 1.0) == 0.0 ? 0 : 2;

        return $plain ? number_format($p, $decimals, '.', '') : number_format($p, $decimals);
    }
}
