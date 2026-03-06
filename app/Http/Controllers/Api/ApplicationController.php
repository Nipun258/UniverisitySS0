<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Passport\Client;

class ApplicationController extends Controller
{
    /**
     * Return a list of all active OAuth client applications configured for the portal.
     * This endpoint is called by the Master Client App to render the SSO App Portal.
     *
     * Client apps should call:
     *   GET /api/applications
     *   Authorization: Bearer <access_token>
     *
     * Returns:
     *   200 [ { "id": "...", "name": "...", "app_portal_url": "...", "app_icon": "..." }, ... ]
     */
    public function index(Request $request)
    {
        // For now, we return all active portal applications for every authenticated user.
        // In the future, this could be filtered based on $request->user()->roles/permissions.
        
        $masterClientUrl = config('sso.master_client_url') ?? env('SSO_MASTER_CLIENT_URL');

        $clients = Client::where('revoked', false)
            ->whereNotNull('app_portal_url')
            ->where('app_portal_url', '!=', '')
            ->where('app_portal_url', '!=', $masterClientUrl) // Exclude the master client
            ->get()
            ->filter(function (Client $client) {
                // Return only authorization_code clients (web apps)
                $grants = is_array($client->grant_types)
                    ? $client->grant_types
                    : json_decode($client->grant_types ?? '[]', true);

                return in_array('authorization_code', (array) $grants);
            })
            ->map(function (Client $client) {
                return [
                    'id'             => $client->id,
                    'name'           => $client->name,
                    'app_portal_url' => $client->app_portal_url,
                    'app_icon'       => $client->app_icon,
                ];
            })
            ->values();

        return response()->json($clients, 200);
    }
}
