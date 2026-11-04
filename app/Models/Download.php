<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Download extends Model
{
    use SoftDeletes;

    protected $table = 'downloads';

    protected $guarded = ['id'];

    protected $casts = ['extra' => 'array', 'is_visible' => 'boolean'];
}
