<?php

use App\Http\Middleware\McpAuthenticate;
use App\Mcp\SiteServer;
use Laravel\Mcp\Facades\Mcp;

/*
| MCP server for the marketing website (claude.ai custom connector). Not in the "web" group: no session,
| no CSRF. Two ways in, same server:
|   POST /mcp            with "Authorization: Bearer <MCP_SECRET>"
|   POST /mcp/<secret>   (the URL itself carries the secret, for connectors that cannot send headers)
*/
Mcp::web('/mcp', SiteServer::class)->middleware([McpAuthenticate::class, 'throttle:mcp']);
Mcp::web('/mcp/{secret}', SiteServer::class)->middleware([McpAuthenticate::class, 'throttle:mcp'])
    ->where('secret', '[A-Za-z0-9_\-]{32,200}');
