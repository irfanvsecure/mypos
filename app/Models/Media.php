<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes;

    protected $table = 'media';

    protected $guarded = ['id'];

    protected $casts = ['variants' => 'array'];

    public function url(): string
    {
        return asset($this->path);
    }
}
