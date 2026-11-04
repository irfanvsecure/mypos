<?php

return [
    // Long random secret (64 hex chars). Generate: php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"
    // Empty = the MCP endpoint answers 503 (switched off).
    'secret' => env('MCP_SECRET', ''),

    // Refuse plain-HTTP calls. On by default outside local/testing.
    'require_https' => env('MCP_REQUIRE_HTTPS', ! in_array(env('APP_ENV', 'production'), ['local', 'testing'], true)),

    // Calls per minute per IP.
    'rate_limit' => (int) env('MCP_RATE_LIMIT', 120),

    // Optional Cloudflare cache purge after every change (token permission: Zone → Cache Purge → Purge).
    'cloudflare' => [
        'token' => env('CLOUDFLARE_API_TOKEN'),
        'zone' => env('CLOUDFLARE_ZONE_ID'),
    ],

    'images' => [
        'max_width' => 1600,              // larger uploads are scaled down (original kept)
        'srcset_widths' => [480, 800, 1200],
        'webp_quality' => 82,
        'max_upload_mb' => 10,
        'max_megapixels' => 50,            // larger images are refused before decoding (memory)

        // Hosts upload_image_from_url may download from (comma-separated). Empty = all public hosts.
        // Every host in a redirect chain must be listed, e.g. images.pexels.com,images.unsplash.com,unsplash.com
        'url_allowed_hosts' => array_values(array_filter(array_map(fn ($h) => strtolower(trim($h)), explode(',', (string) env('MCP_IMAGE_URL_ALLOWED_HOSTS', ''))))),
        'oversized_kb' => 300,             // audit_images flags files above this
    ],
];
