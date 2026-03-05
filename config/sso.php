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
    'master_client_id'       => env('SSO_MASTER_CLIENT_ID', null),
    'master_client_redirect' => env('SSO_MASTER_CLIENT_REDIRECT', null),

];
