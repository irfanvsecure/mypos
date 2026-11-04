<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PricingPlan extends Model
{
    use SoftDeletes;

    protected $table = 'pricing_plans';

    protected $guarded = ['id'];

    protected $casts = ['features' => 'array', 'extra' => 'array', 'is_featured' => 'boolean', 'cta_new_tab' => 'boolean', 'is_visible' => 'boolean', 'price_pkr' => 'decimal:2'];

    public function scopeShown($q, string $group)
    {
        return $q->where('plan_group', $group)->where('is_visible', true)->orderBy('sort_order')->orderBy('id');
    }
}
