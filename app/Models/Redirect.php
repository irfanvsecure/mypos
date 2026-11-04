<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Redirect extends Model
{
    use SoftDeletes;

    protected $table = 'redirects';

    protected $guarded = ['id'];

    protected $casts = ['last_hit_at' => 'datetime', 'is_auto' => 'boolean'];
}
