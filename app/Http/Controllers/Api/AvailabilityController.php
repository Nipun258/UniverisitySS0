<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    /**
     * Availability check endpoint – called by SSO client applications.
     *
     * Client apps should call:
     *   GET /api/availability
     *   Authorization: Bearer <access_token>
     *
     * Returns:
     *   200  { "available": true,  "user": { id, name, email, status } }
     *   401  { "message": "Unauthenticated." }          ← handled by Passport middleware
     *   403  { "available": false, "message": "..." }   ← token valid but user inactive
     */
    public function check(Request $request)
    {
        $user = $request->user();

        // If the user account is inactive (status == 0) treat as unavailable
        if (isset($user->status) && (int) $user->status === 0) {
            return response()->json([
                'available' => false,
                'message'   => 'User account is inactive.',
            ], 403);
        }

        return response()->json([
            'available' => true,
            'user'      => [
                'id'     => $user->id,
                'name'   => $user->name,
                'email'  => $user->email,
                'status' => $user->status ?? 1,
            ],
        ], 200);
    }
}
