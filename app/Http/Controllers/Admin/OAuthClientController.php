<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;

class OAuthClientController extends Controller
{
    protected ClientRepository $clients;

    public function __construct(ClientRepository $clients)
    {
        $this->clients = $clients;
    }

    /**
     * List all OAuth clients.
     */
    public function index()
    {
        $clients = Client::orderBy('created_at', 'desc')->get();
        return view('admin.oauth.index', compact('clients'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.oauth.create');
    }

    /**
     * Store a new OAuth client.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'redirect'     => 'required|url',
            'grant_type'   => 'required|in:authorization_code,client_credentials',
            'confidential' => 'nullable|boolean',
        ]);

        $confidential = $request->boolean('confidential', true);

        if ($request->grant_type === 'authorization_code') {
            $client = $this->clients->createAuthorizationCodeGrantClient(
                $request->name,
                [$request->redirect],
                $confidential
            );
        } else {
            // client_credentials
            $client = $this->clients->createClientCredentialsGrantClient($request->name);
            
            // Apply optional settings for client_credentials if provided
            $client->forceFill([
                'confidential' => $confidential,
                'secret'       => $confidential ? ($client->secret ?? Str::random(40)) : null,
            ])->save();

            if ($request->redirect) {
                $this->clients->update($client, $client->name, [$request->redirect]);
            }
        }

        // Flash credentials — secret is only visible at creation time
        session()->flash('new_oauth_client', [
            'name'      => $client->name,
            'id'        => $client->id,
            'secret'    => $client->secret ?? null,
            'grant'     => $request->grant_type,
        ]);

        return redirect()->route('oauth.client.index');
    }

    /**
     * Show edit form.
     */
    public function edit(string $id)
    {
        $client = Client::findOrFail($id);
        return view('admin.oauth.edit', compact('client'));
    }

    /**
     * Update an existing client.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'redirect' => 'required|string',
        ]);

        $client = Client::findOrFail($id);
        $client->update([
            'name'     => $request->name,
            'redirect' => [$request->redirect],   // Passport v13 stores as JSON array
        ]);

        return redirect()->route('oauth.client.index')
            ->with('message', 'OAuth client updated successfully.')
            ->with('alert-type', 'success');
    }

    /**
     * Revoke (soft-delete) an OAuth client.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        $client->update(['revoked' => true]);
        // Revoke all tokens for this client
        $client->tokens()->update(['revoked' => true]);

        return redirect()->route('oauth.client.index')
            ->with('message', 'OAuth client revoked successfully.')
            ->with('alert-type', 'warning');
    }

    /**
     * Regenerate client secret.
     */
    public function regenerateSecret(string $id)
    {
        $client = Client::findOrFail($id);
        $newSecret = Str::random(40);
        $client->update(['secret' => $newSecret]);

        session()->flash('new_oauth_client', [
            'type'   => 'regenerated',
            'name'   => $client->name,
            'id'     => $client->id,
            'secret' => $newSecret,
            'grant'  => null,
        ]);

        return redirect()->route('oauth.client.index');
    }
}
