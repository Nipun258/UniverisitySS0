<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Authorize — {{ $client->name }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            font-family: 'Source Sans Pro', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a1f36 0%, #1d3557 50%, #457b9d 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .authorize-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.35);
            width: 100%;
            max-width: 480px;
            overflow: hidden;
        }

        .authorize-header {
            background: linear-gradient(135deg, #1d3557, #457b9d);
            padding: 32px 28px 24px;
            text-align: center;
            color: #fff;
        }

        .authorize-header .shield-icon {
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            font-size: 28px;
        }

        .authorize-header h2 {
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 4px;
        }

        .authorize-header p {
            font-size: 13px;
            opacity: 0.85;
            margin: 0;
        }

        .authorize-body {
            padding: 28px;
        }

        .user-chip {
            display: flex;
            align-items: center;
            background: #f1f4f8;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 22px;
        }

        .user-chip i {
            font-size: 28px;
            color: #457b9d;
            margin-right: 12px;
        }

        .user-chip .name {
            font-weight: 600;
            font-size: 15px;
        }

        .user-chip .email {
            font-size: 12px;
            color: #6c757d;
        }

        .scope-list {
            margin-bottom: 20px;
            padding: 0;
            list-style: none;
        }

        .scope-list li {
            display: flex;
            align-items: flex-start;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .scope-list li i {
            color: #28a745;
            margin-right: 8px;
            margin-top: 2px;
        }

        .info-box {
            background: #e8f4fd;
            border-left: 4px solid #457b9d;
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 13px;
            color: #1d3557;
            margin-bottom: 20px;
        }

        .divider {
            border-top: 1px solid #e9ecef;
            margin: 18px 0;
        }

        .btn-authorize {
            background: linear-gradient(135deg, #1d3557, #457b9d);
            border: none;
            color: #fff;
            border-radius: 8px;
            padding: 12px;
            font-size: 15px;
            font-weight: 600;
            width: 100%;
            margin-bottom: 10px;
            cursor: pointer;
            transition: opacity .2s;
        }

        .btn-authorize:hover {
            opacity: .9;
        }

        .btn-deny {
            background: transparent;
            border: 2px solid #dc3545;
            color: #dc3545;
            border-radius: 8px;
            padding: 10px;
            font-size: 14px;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-deny:hover {
            background: #dc3545;
            color: #fff;
        }

        .authorize-footer {
            text-align: center;
            font-size: 11px;
            color: #adb5bd;
            padding: 14px 28px 20px;
        }

    </style>
</head>
<body>

    <div class="authorize-card">

        {{-- Header --}}
        <div class="authorize-header">
            <div class="shield-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h2>{{ $client->name }}</h2>
            <p>is requesting access to your account</p>
        </div>

        {{-- Body --}}
        <div class="authorize-body">

            {{-- Logged-in user --}}
            <div class="user-chip">
                <i class="fas fa-user-circle"></i>
                <div>
                    <div class="name">{{ auth()->user()->name }}</div>
                    <div class="email">{{ auth()->user()->email }}</div>
                </div>
            </div>

            {{-- Scopes --}}
            @if(count($scopes) > 0)
            <p style="font-size:13px;font-weight:600;color:#495057;margin-bottom:10px;">
                This application will be able to:
            </p>
            <ul class="scope-list">
                @foreach ($scopes as $scope)
                <li>
                    <i class="fas fa-check-circle"></i>
                    {{ $scope->description }}
                </li>
                @endforeach
            </ul>
            @else
            <div class="info-box">
                <i class="fas fa-info-circle mr-1"></i>
                This application is requesting access to your basic profile information
                (name, email, and roles).
            </div>
            @endif

            <div class="divider"></div>

            <p style="font-size:12px;color:#6c757d;text-align:center;margin-bottom:18px;">
                By authorizing, you allow <strong>{{ $client->name }}</strong> to sign you in
                using your University credentials. You can revoke access at any time.
            </p>

            {{-- Approve --}}
            <form method="POST" action="{{ route('passport.authorizations.approve') }}">
                @csrf
                <input type="hidden" name="state" value="{{ $request->state }}">
                <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                <input type="hidden" name="auth_token" value="{{ $authToken }}">
                <button type="submit" class="btn-authorize">
                    <i class="fas fa-check mr-1"></i> Authorize Access
                </button>
            </form>

            {{-- Deny --}}
            <form method="POST" action="{{ route('passport.authorizations.deny') }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="state" value="{{ $request->state }}">
                <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                <input type="hidden" name="auth_token" value="{{ $authToken }}">
                <button type="submit" class="btn-deny">
                    <i class="fas fa-times mr-1"></i> Deny
                </button>
            </form>

        </div>

        <div class="authorize-footer">
            <i class="fas fa-lock mr-1"></i>
            University of Sri Jayewardenepura &mdash; Secure SSO Server
        </div>

    </div>

    <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>
