<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SSO Master Client Application
    |--------------------------------------------------------------------------
    | After a direct SSO login (no pending OAuth callback), the SSO initiates
    | the OAuth authorization flow for this master client so the user lands
    | in the client app fully authenticated — no second login required.
    |
    | master_client_id       — OAuth client_id of the master application
    | master_client_redirect — The redirect_uri registered for that client
    |                          (must exactly match what is stored in oauth_clients)
    */
    /*
    |--------------------------------------------------------------------------
    | SSO Server Base URL
    |--------------------------------------------------------------------------
    | The base URL of the SSO server (no trailing slash).
    | Used by client applications to call SSO API endpoints such as
    | /api/availability.
    |
    | Set SSO_BASE_URL in your client application's .env file, e.g.:
    |   SSO_BASE_URL=https://usjnetsso.sjp.ac.lk/sso
    */
    'base_url' => env('SSO_BASE_URL'),

    'master_client_id'       => env('SSO_MASTER_CLIENT_ID', null),
    'master_client_redirect' => env('SSO_MASTER_CLIENT_REDIRECT', null),

];
