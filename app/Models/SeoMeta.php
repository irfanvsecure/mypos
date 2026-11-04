<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeoMeta extends Model
{
    use SoftDeletes;

    protected $table = 'seo_meta';

    protected $guarded = ['id'];

    protected $casts = [];

    public function seoable()
    {
        return $this->morphTo();
    }
}
