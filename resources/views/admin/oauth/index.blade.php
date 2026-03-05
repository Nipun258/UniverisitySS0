@extends('admin.admin_master')
@section('admin')
{{-- Content Header --}}
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">OAuth Clients</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">OAuth Clients</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        {{-- Stats / Add Button row --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $clients->where('revoked', false)->count() }}</h3>
                        <p>Active Clients</p>
                    </div>
                    <div class="icon"><i class="fas fa-plug"></i></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $clients->where('revoked', true)->count() }}</h3>
                        <p>Revoked Clients</p>
                    </div>
                    <div class="icon"><i class="fas fa-ban"></i></div>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center justify-content-end">
                @can('oauth.client.create')
                <a href="{{ route('oauth.client.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus-circle"></i> New OAuth Client
                </a>
                @endcan
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-key mr-1"></i> Registered Clients</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Client Name</th>
                                        <th>Client ID</th>
                                        <th>Grant Types</th>
                                        <th>Redirect URI</th>
                                        <th>Status</th>
                                        <th width="25%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($clients as $key => $client)
                                    <tr class="{{ $client->revoked ? 'table-secondary text-muted' : '' }}">
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <strong>{{ $client->name }}</strong>
                                            @if($client->personal_access_client)
                                            <span class="badge badge-secondary ml-1">Personal Access</span>
                                            @endif
                                        </td>
                                        <td>
                                            <code style="font-size:12px;">{{ $client->id }}</code>
                                            @if($client->secret)
                                            <br><small class="text-muted">Secret: <code>{{ Str::mask($client->secret, '*', 4) }}</code></small>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                            $grants = $client->grant_types ?? [];
                                            if($client->personal_access_client) $grants = ['personal_access'];
                                            elseif(empty($grants)) $grants = ['authorization_code'];
                                            @endphp
                                            @foreach($grants as $grant)
                                            <span class="badge badge-{{ $grant == 'authorization_code' ? 'primary' : ($grant == 'personal_access' ? 'dark' : 'info') }}">
                                                {{ str_replace('_', ' ', ucfirst($grant)) }}
                                            </span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @php
                                            $redirectDisplay = is_array($client->redirect_uris)
                                            ? implode(', ', $client->redirect_uris)
                                            : ($client->redirect_uris ?: '—');
                                            @endphp
                                            <small>{{ $redirectDisplay }}</small>
                                        </td>
                                        <td>
                                            @if($client->revoked)
                                            <span class="badge badge-danger">Revoked</span>
                                            @else
                                            <span class="badge badge-success">Active</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$client->revoked)
                                            @can('oauth.client.update')
                                            <a href="{{ route('oauth.client.edit', $client->id) }}" class="btn btn-sm btn-info mb-1">
                                                <i class="fas fa-pencil-alt"></i> Edit
                                            </a>
                                            @endcan
                                            @if($client->secret && !$client->personal_access_client)
                                            @can('oauth.client.update')
                                            <a href="javascript:void(0)" class="btn btn-sm btn-warning mb-1" onclick="confirmRegenerate('{{ route('oauth.client.regenerate', $client->id) }}', '{{ addslashes($client->name) }}')">
                                                <i class="fas fa-sync-alt"></i> New Secret
                                            </a>
                                            @endcan
                                            @endif
                                            @if(!$client->personal_access_client)
                                            @can('oauth.client.delete')
                                            <a href="{{ route('oauth.client.destroy', $client->id) }}" class="btn btn-sm btn-danger mb-1" id="delete">
                                                <i class="fas fa-ban"></i> Revoke
                                            </a>
                                            @endcan
                                            @endif
                                            @else
                                            <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-plug fa-2x mb-2 d-block"></i>
                                            No OAuth clients registered yet.
                                            <a href="{{ route('oauth.client.create') }}">Create one</a>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
    function confirmRegenerate(url, clientName) {
        Swal.fire({
            title: 'Regenerate Secret?'
            , icon: 'warning'
            , width: 520
            , showCancelButton: true
            , confirmButtonColor: '#fd7e14'
            , cancelButtonColor: '#6c757d'
            , confirmButtonText: '<i class="fas fa-sync-alt"></i>&nbsp;Yes, Regenerate'
            , cancelButtonText: 'Cancel'
            , html: `
            <p>You are about to regenerate the secret for:<br>
            <strong>${clientName}</strong></p>
            <div class="alert alert-danger text-left p-2 mt-2" style="font-size:13px;">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>All existing access tokens</strong> issued with the current secret
                will be immediately invalidated. Connected client apps will stop working
                until they are reconfigured with the new secret.
            </div>
        `
        , }).then(function(result) {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

</script>

@if(session('new_oauth_client'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nc = @json(session('new_oauth_client'));

        function copyText(text, btnId) {
            navigator.clipboard.writeText(text).then(function() {
                var btn = document.getElementById(btnId);
                var orig = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
                btn.className = btn.className.replace('btn-outline-secondary', 'btn-success');
                setTimeout(function() {
                    btn.innerHTML = orig;
                    btn.className = btn.className.replace('btn-success', 'btn-outline-secondary');
                }, 2000);
            });
        }

        var secretRow = nc.secret ? `
        <div class="text-left mb-2">
            <label style="font-size:11px;letter-spacing:1px;font-weight:700;text-transform:uppercase;color:#6c757d;">Client Secret</label>
            <div class="d-flex align-items-center">
                <code id="nc-secret" style="flex:1;background:#fff3cd;border:1px solid #ffc107;border-radius:4px;padding:8px 10px;font-size:13px;word-break:break-all;">
                    ${nc.secret}
                </code>
                <button type="button" id="btn-copy-secret"
                        class="btn btn-sm btn-outline-secondary ml-2"
                        onclick="copyText('${nc.secret}', 'btn-copy-secret')">
                    <i class="fas fa-copy"></i> Copy
                </button>
            </div>
        </div>` : '';

        var isRegen = nc.type === 'regenerated';
        var titleIcon = isRegen ?
            '<i class="fas fa-sync-alt" style="color:#fd7e14;"></i>' :
            '<i class="fas fa-check-circle" style="color:#28a745;"></i>';
        var titleText = isRegen ? 'Secret Regenerated!' : 'Client Created!';
        var grantBadge = nc.grant ?
            `&nbsp;<span class="badge badge-primary">${nc.grant.replace('_',' ')}</span>` :
            '';

        Swal.fire({
            title: titleIcon + '&nbsp; ' + titleText
            , width: 660
            , allowOutsideClick: false
            , showCloseButton: true
            , confirmButtonText: '<i class="fas fa-check"></i>&nbsp; I\'ve saved the credentials'
            , confirmButtonColor: isRegen ? '#fd7e14' : '#28a745'
            , html: `
            <p style="color:#6c757d;margin-bottom:16px;">
                ${isRegen
                    ? 'The old secret is now invalid. Save the new one immediately.'
                    : 'Store these credentials securely now.'
                }<br>
                <strong style="color:#dc3545;">
                    <i class="fas fa-exclamation-triangle"></i>
                    The secret will NOT be shown again.
                </strong>
            </p>

            <div class="text-left mb-3">
                <label style="font-size:11px;letter-spacing:1px;font-weight:700;text-transform:uppercase;color:#6c757d;">Client Name</label>
                <div style="background:#f4f4f4;border-radius:4px;padding:8px 10px;font-size:14px;">
                    <strong>${nc.name}</strong>${grantBadge}
                </div>
            </div>

            <div class="text-left mb-3">
                <label style="font-size:11px;letter-spacing:1px;font-weight:700;text-transform:uppercase;color:#6c757d;">Client ID</label>
                <div class="d-flex align-items-center">
                    <code id="nc-id" style="flex:1;background:#f4f4f4;border-radius:4px;padding:8px 10px;font-size:13px;word-break:break-all;">
                        ${nc.id}
                    </code>
                    <button type="button" id="btn-copy-id"
                            class="btn btn-sm btn-outline-secondary ml-2"
                            onclick="copyText('${nc.id}', 'btn-copy-id')">
                        <i class="fas fa-copy"></i> Copy
                    </button>
                </div>
            </div>

            ${secretRow}
        `
        , });
    });

</script>
@endif

@endsection
