<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SectionRevision extends Model
{
    use SoftDeletes;

    public const UPDATED_AT = null;

    protected $guarded = ['id'];

    protected $casts = ['snapshot' => 'array'];

    public function section()
    {
        return $this->belongsTo(PageSection::class, 'page_section_id');
    }
}
