<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Guards the MCP endpoint with config('mcp_site.secret'), accepted either as "Authorization: Bearer <secret>"
 * or as the last path segment (/mcp/<secret>, for claude.ai custom connectors). Constant-time comparison,
 * 401 on mismatch, 503 when no secret is configured, and plain HTTP refused when require_https is on.
 */
class McpAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        $secret = (string) config('mcp_site.secret');
        if (strlen($secret) < 32) {
            return response()->json(['error' => 'MCP is switched off: set MCP_SECRET (at least 32 characters) in .env.'], 503);
        }

        if (config('mcp_site.require_https') && ! $request->secure()) {
            return response()->json(['error' => 'HTTPS is required.'], 403);
        }

        $given = (string) ($request->route('secret') ?? $request->bearerToken() ?? '');
        if ($given === '' || ! hash_equals($secret, $given)) {
            Log::channel('mcp')->warning('unauthorized', ['ip' => $request->ip(), 'path_variant' => $request->route('secret') !== null]);

            return response()->json(['error' => 'Unauthorized.'], 401, ['WWW-Authenticate' => 'Bearer']);
        }

        return $next($request);
    }
}
