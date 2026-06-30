<?php

declare(strict_types=1);

use App\Mcp\Servers\ServicesServer;
use Laravel\Mcp\Facades\Mcp;

/*
|--------------------------------------------------------------------------
| MCP Server
|--------------------------------------------------------------------------
|
| Exposes content + lead management to Claude (or any MCP client) over HTTP.
| Authenticated via Sanctum bearer token — generate one for the admin user
| with `php artisan services:mcp-token`.
|
*/

Mcp::web('/mcp/services', ServicesServer::class)
    ->middleware('auth:sanctum');
