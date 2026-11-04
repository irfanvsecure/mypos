<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = ['published_at' => 'datetime'];

    public function getUrlAttribute(): string
    {
        return url('/portfolio-item/' . $this->slug);
    }
}
