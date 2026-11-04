<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Append-only audit trail of every content change (who / what / when, before and after). */
class ActivityLog extends Model
{
    public const UPDATED_AT = null;

    protected $table = 'activity_log';

    protected $guarded = ['id'];

    protected $casts = ['before' => 'array', 'after' => 'array'];

    public static function record(string $actor, string $action, ?Model $subject, ?string $summary = null, $before = null, $after = null): self
    {
        return static::create([
            'actor' => $actor,
            'action' => $action,
            'subject_type' => $subject ? class_basename($subject) : null,
            'subject_id' => $subject?->getKey(),
            'summary' => $summary ? mb_substr($summary, 0, 500) : null,
            'before' => $before,
            'after' => $after,
            'ip' => app()->runningInConsole() ? null : request()->ip(),
        ]);
    }
}
