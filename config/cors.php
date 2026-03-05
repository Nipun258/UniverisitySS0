<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Configure which origins, methods, and headers are permitted for
    | cross-origin requests. For this SSO server, client apps on different
    | origins need access to:
    |   - /api/*          → user-info & token management endpoints
    |   - /oauth/token    → token issuance (Passport)
    |
    | Set CORS_ALLOWED_ORIGINS in .env to a comma-separated list of
    | allowed client app origins, e.g.:
    |   CORS_ALLOWED_ORIGINS=http://localhost:8001,https://portal.sjp.ac.lk
    |
    | Use * to allow all origins (only for local development).
    |
    */

    'paths' => [
        'api/*',
        'oauth/token',
        'oauth/token/refresh',
    ],

    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],

    'allowed_origins' => array_filter(
        explode(',', env('CORS_ALLOWED_ORIGINS', 'http://localhost:8001'))
    ),

    'allowed_origins_patterns' => [],

    'allowed_headers' => [
        'Content-Type',
        'X-Requested-With',
        'Authorization',
        'Accept',
        'Origin',
        'X-CSRF-TOKEN',
    ],

    'exposed_headers' => [],

    'max_age' => 86400, // 24 hours — browsers cache preflight result

    // Keep false: Passport uses Bearer tokens, not session cookies.
    // Set true only if you need cookie-based auth across origins.
    'supports_credentials' => false,

];
