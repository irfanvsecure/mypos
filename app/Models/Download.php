<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * A downloadable app. Single source for its version, size, download count and file link: page content refers
 * to them as {{download:key.field}} (fields in FIELDS).
 */
class Download extends Model
{
    use SoftDeletes;

    protected $table = 'downloads';

    protected $guarded = ['id'];

    protected $casts = ['extra' => 'array', 'is_visible' => 'boolean'];

    /** Placeholder field => column (or extra.* key). */
    public const FIELDS = [
        'app_name' => 'app_name', 'platform' => 'platform', 'version' => 'version', 'file_size' => 'file_size',
        'download_count' => 'download_count', 'download_count_plain' => 'download_count', 'file_url' => 'file_url', 'store_url' => 'store_url',
        'published' => 'extra.published', 'updated' => 'extra.updated', 'files' => 'extra.files',
    ];

    /** @var array<string, self>|null */
    private static ?array $byKey = null;

    protected static function booted(): void
    {
        $flush = fn () => static::$byKey = null;
        static::saved($flush);
        static::deleted($flush);
        static::restored($flush);
    }

    /** Value of a placeholder field for the download with this key; null if either is unknown. */
    public static function field(string $key, string $field): ?string
    {
        if (! isset(self::FIELDS[$field])) {
            return null;
        }
        static::$byKey ??= static::all()->keyBy('key')->all();
        $d = static::$byKey[$key] ?? null;
        if (! $d) {
            return null;
        }
        $col = self::FIELDS[$field];
        $v = str_starts_with($col, 'extra.') ? ($d->extra[substr($col, 6)] ?? null) : $d->$col;

        if ($v !== null && $field === 'download_count' && ctype_digit((string) $v)) {
            return number_format((int) $v); // "17,135"; download_count_plain gives "17135"
        }

        return $v === null ? null : (string) $v;
    }
}
