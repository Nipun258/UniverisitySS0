<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserInfoController extends Controller
{
    /**
     * Return the authenticated user's profile for SSO client applications.
     *
     * Client apps should call:
     *   GET /api/user
     *   Authorization: Bearer <access_token>
     *
     * The response includes the user record plus their Spatie roles and
     * permissions so that SSO clients can enforce RBAC without needing
     * their own role table.
     */
    public function show(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'id'          => $user->id,
            'name'        => $user->name,
            'email'       => $user->email,
            'status'      => $user->status ?? null,
            'roles'       => $user->getRoleNames(),         // from Spatie HasRoles
            'permissions' => $user->getAllPermissions()
                                  ->pluck('name'),
            'token_scopes' => $request->user()->token()->scopes ?? [],
        ]);
    }
}
