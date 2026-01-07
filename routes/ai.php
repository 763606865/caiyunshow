<?php

use Laravel\Mcp\Server\Facades\Mcp;

// Mcp::web('demo', \App\Mcp\Servers\PublicServer::class); // Available at /mcp/demo
// Mcp::local('demo', \App\Mcp\Servers\LocalServer::class); // Start with ./artisan mcp:start demo
Mcp::web('/mcp/weather', App\Mcp\Servers\WeatherServer::class)->middleware(['throttle:mcp']);
