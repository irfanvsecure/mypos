<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];

    protected $casts = ['published_at' => 'datetime'];

    public function getUrlAttribute(): string
    {
        return url('/portfolio-item/' . $this->slug);
    }
}
