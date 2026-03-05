<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PersonalTokenController extends Controller
{
    /**
     * List all active personal access tokens for the authenticated user.
     *
     * GET /api/tokens
     * Authorization: Bearer <access_token>
     */
    public function index(Request $request)
    {
        $tokens = $request->user()
            ->tokens()
            ->where('revoked', false)
            ->where('expires_at', '>', now())
            ->get()
            ->map(fn ($token) => [
                'id'         => $token->id,
                'name'       => $token->name,
                'scopes'     => $token->scopes,
                'created_at' => $token->created_at,
                'expires_at' => $token->expires_at,
            ]);

        return response()->json($tokens);
    }

    /**
     * Create a new personal access token for the authenticated user.
     *
     * POST /api/tokens/create
     * Body: { "name": "My App Token", "scopes": [] }
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'scopes' => 'array',
        ]);

        $token = $request->user()->createToken(
            $request->name,
            $request->scopes ?? []
        );

        return response()->json([
            'access_token' => $token->accessToken,
            'token_id'     => $token->token->id,
            'token_type'   => 'Bearer',
            'expires_at'   => $token->token->expires_at,
        ], 201);
    }

    /**
     * Revoke (delete) a personal access token.
     *
     * DELETE /api/tokens/{tokenId}
     * Authorization: Bearer <access_token>
     */
    public function destroy(Request $request, string $tokenId)
    {
        $token = $request->user()
            ->tokens()
            ->where('id', $tokenId)
            ->first();

        if (! $token) {
            return response()->json(['message' => 'Token not found.'], 404);
        }

        $token->revoke();

        return response()->json(['message' => 'Token revoked successfully.']);
    }
}
