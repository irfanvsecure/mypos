<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

/**
 * Redirects and 410s from the redirects table, checked before routing on GET/HEAD requests.
 * The path → [status, target] map is cached; it is flushed whenever a redirect changes.
 */
class SiteRedirects
{
    public const CACHE_KEY = 'site.redirects.v1';

    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->isMethod('GET') && ! $request->isMethod('HEAD')) {
            return $next($request);
        }

        $path = trim($request->path(), '/');
        $hit = self::map()[$path] ?? null;
        if (! $hit) {
            return $next($request);
        }

        [$id, $status, $to] = $hit;
        $id && Redirect::whereKey($id)->update(['hits' => DB::raw('hits + 1'), 'last_hit_at' => now()]);

        if ($status === 410) {
            abort(410);
        }

        return redirect(str_starts_with($to, 'http') ? $to : url($to), $status);
    }

    /** @return array<string, array{0:int,1:int,2:?string}> */
    public static function map(): array
    {
        try {
            return Cache::rememberForever(self::CACHE_KEY, function () {
                if (! Redirect::withTrashed()->exists()) {
                    // Fresh install, table not filled yet (site:extract --globals / site:import): use config/site.php.
                    return collect(config('site.redirects'))->map(fn ($to) => [0, 301, $to])
                        ->merge(collect(config('site.gone'))->mapWithKeys(fn ($p) => [$p => [0, 410, null]]))->all();
                }

                return Redirect::get(['id', 'from_path', 'status_code', 'to_url'])
                    ->mapWithKeys(fn ($r) => [$r->from_path => [$r->id, (int) $r->status_code, $r->to_url]])->all();
            });
        } catch (\Throwable) {
            return [];
        }
    }

    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
