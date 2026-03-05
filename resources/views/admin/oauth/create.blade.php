@extends('admin.admin_master')
@section('admin')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">New OAuth Client</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('oauth.client.index') }}">OAuth Clients</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-plus-circle mr-1"></i> Register New Client</h3>
                    </div>
                    <form action="{{ route('oauth.client.store') }}" method="POST">
                        @csrf
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

                            {{-- Client Name --}}
                            <div class="form-group">
                                <label for="name">Client Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. My University Portal">
                                @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Grant Type --}}
                            <div class="form-group">
                                <label for="grant_type">Grant Type <span class="text-danger">*</span></label>
                                <select name="grant_type" id="grant_type" class="form-control select2bs4 @error('grant_type') is-invalid @enderror">
                                    <option value="authorization_code" {{ old('grant_type') == 'authorization_code' ? 'selected' : '' }}>
                                        Authorization Code (Redirect-based SSO)
                                    </option>
                                    <option value="client_credentials" {{ old('grant_type') == 'client_credentials' ? 'selected' : '' }}>
                                        Client Credentials (Server-to-Server)
                                    </option>
                                </select>
                                @error('grant_type')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">
                                    Use <strong>Authorization Code</strong> for web apps that redirect users to login.<br>
                                    Use <strong>Client Credentials</strong> for machine-to-machine API access.
                                </small>
                            </div>

                            {{-- Redirect URI --}}
                            <div class="form-group" id="redirect_group">
                                <label for="redirect">Redirect URI <span class="text-danger">*</span></label>
                                <input type="url" name="redirect" id="redirect" class="form-control @error('redirect') is-invalid @enderror" value="{{ old('redirect', 'https://') }}" placeholder="https://your-client-app.com/auth/callback">
                                @error('redirect')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">The URL the authorization server will redirect to after login.</small>
                            </div>

                            {{-- Confidential --}}
                            <div class="form-group">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="confidential" name="confidential" value="1" {{ old('confidential', true) ? 'checked' : '' }}>
                                    <label for="confidential">
                                        Confidential Client (generates a client secret)
                                    </label>
                                </div>
                                <small class="text-muted">
                                    Confidential clients (web servers) can securely store a secret.
                                    Public clients (mobile/SPA apps) should uncheck this.
                                </small>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Client
                            </button>
                            <a href="{{ route('oauth.client.index') }}" class="btn btn-secondary ml-2">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>

                {{-- Info Card --}}
                <div class="callout callout-info">
                    <h5><i class="fas fa-info-circle"></i> How SSO clients use this</h5>
                    <p class="mb-1">After creating a client, share these details with the client application developer:</p>
                    <ul>
                        <li><strong>Authorization URL:</strong> <code>{{ url('/oauth/authorize') }}</code></li>
                        <li><strong>Token URL:</strong> <code>{{ url('/oauth/token') }}</code></li>
                        <li><strong>User Info URL:</strong> <code>{{ url('/api/user') }}</code></li>
                        <li>Client ID and Secret (shown after creation)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
