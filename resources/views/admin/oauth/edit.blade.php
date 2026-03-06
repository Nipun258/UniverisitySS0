@extends('admin.admin_master')
@section('admin')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit OAuth Client</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('oauth.client.index') }}">OAuth Clients</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-pencil-alt mr-1"></i> Edit Client: {{ $client->name }}</h3>
                        <div class="card-tools">
                            <span class="badge badge-{{ $client->revoked ? 'danger' : 'success' }} badge-lg">
                                {{ $client->revoked ? 'Revoked' : 'Active' }}
                            </span>
                        </div>
                    </div>
                    <form action="{{ route('oauth.client.update', $client->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">

                            @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            {{-- Read-only Client ID --}}
                            <div class="form-group">
                                <label>Client ID</label>
                                <input type="text" class="form-control bg-light" value="{{ $client->id }}" readonly>
                                <small class="text-muted">Read-only — this is the client's unique identifier.</small>
                            </div>

                            {{-- Client Name --}}
                            <div class="form-group">
                                <label for="name">Client Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $client->name) }}">
                                @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Redirect URI --}}
                            @php
                            $redirectValue = old('redirect',
                            is_array($client->redirect_uris)
                            ? implode("\n", $client->redirect_uris) // multiple URIs, newline-separated
                            : $client->redirect_uris
                            );
                            @endphp
                            <div class="form-group">
                                <label for="redirect">Redirect URI <span class="text-danger">*</span></label>
                                <input type="text" name="redirect" id="redirect" class="form-control @error('redirect') is-invalid @enderror" value="{{ $redirectValue }}">
                                @error('redirect')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">The callback URL for this OAuth client.</small>
                            </div>

                            {{-- Grant types read-only --}}
                            <div class="form-group">
                                <label>Grant Type</label>
                                <input type="text" class="form-control bg-light" value="{{ $client->personal_access_client ? 'Personal Access' : (empty($client->grant_types) ? 'Authorization Code' : implode(', ', $client->grant_types)) }}" readonly>
                                <small class="text-muted">Grant type cannot be changed after creation.</small>
                            </div>

                            {{-- App Portal URL --}}
                            <div class="form-group">
                                <label for="app_portal_url">
                                    <i class="fas fa-globe mr-1 text-info"></i> App Portal URL
                                    <small class="text-muted">(optional)</small>
                                </label>
                                <input type="url" name="app_portal_url" id="app_portal_url" class="form-control @error('app_portal_url') is-invalid @enderror" value="{{ old('app_portal_url', $client->app_portal_url) }}" placeholder="https://client-app.example.com">
                                @error('app_portal_url')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">
                                    The public URL of this application shown in the SSO App Portal.
                                    Leave blank to hide this app from the portal.
                                </small>
                            </div>

                            {{-- App Icon --}}
                            <div class="form-group">
                                <label for="app_icon">
                                    <i class="fas fa-icons mr-1 text-info"></i> Icon Class
                                    <small class="text-muted">(optional)</small>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="icon-preview">
                                            <i class="{{ $client->app_icon ?: 'fas fa-th-large' }}"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="app_icon" id="app_icon" class="form-control @error('app_icon') is-invalid @enderror" value="{{ old('app_icon', $client->app_icon ?: 'fas fa-th-large') }}" placeholder="fas fa-graduation-cap">
                                    @error('app_icon')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <small class="text-muted">
                                    Font Awesome 5 icon class, e.g. <code>fas fa-graduation-cap</code>,
                                    <code>fas fa-university</code>, <code>fas fa-laptop-code</code>.
                                </small>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-save"></i> Update Client
                                </button>
                                <a href="{{ route('oauth.client.index') }}" class="btn btn-secondary ml-2">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
