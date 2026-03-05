<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('backend/dist/img/logo.png') }}" type="image/png">
    <title>USJNet Sphere | SSO Admin Portal</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Source Sans Pro', sans-serif;
            background: #fff;
        }

        .login-wrapper {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ── LEFT PANEL ── */
        .login-left {
            width: 38%;
            min-width: 320px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 52px;
            background: #fff;
            z-index: 2;
        }

        .login-logo { margin-bottom: 30px; }
        .login-logo img { width: 100%; max-width: 320px; height: auto; }

        .login-left h3 {
            font-size: 26px;
            font-weight: 600;
            color: #222;
            margin: 0 0 6px;
        }

        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #8B1A1A;
            color: #FFD600;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 20px;
            margin-bottom: 28px;
        }

        .form-group { margin-bottom: 18px; }
        .form-group label {
            font-size: 12px;
            font-weight: 600;
            color: #888;
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-bottom: 6px;
            display: block;
        }
        .form-group input {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            transition: border-color .2s;
            background: #fafafa;
        }
        .form-group input:focus {
            border-color: #8B1A1A;
            background: #fff;
        }
        .form-group .input-wrap { position: relative; }
        .form-group .input-wrap .toggle-pw {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #aaa;
            font-size: 14px;
            background: none;
            border: none;
            padding: 0;
        }

        .btn-signin {
            width: 100%;
            padding: 13px;
            background: #8B1A1A;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: .3px;
            cursor: pointer;
            transition: background .2s;
        }
        .btn-signin:hover { background: #6d1414; }

        .alert-error {
            background: #fde8e8;
            border: 1px solid #f5c6c6;
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 13px;
            color: #8B1A1A;
            margin-bottom: 18px;
        }

        .back-link {
            text-align: center;
            margin-top: 18px;
            font-size: 12px;
            color: #999;
        }
        .back-link a { color: #457b9d; text-decoration: none; }
        .back-link a:hover { text-decoration: underline; }

        /* ── RIGHT PANEL ── */
        .login-right {
            flex: 1;
            position: relative;
            overflow: hidden;
        }
        .slide {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 1.2s ease-in-out;
        }
        .slide.active { opacity: 1; }
        .slide-1 { background-image: url('{{ asset('backend/dist/img/login/slide1.jpg') }}'); }
        .slide-2 { background-image: url('{{ asset('backend/dist/img/login/slide2.jpg') }}'); }
        .slide-3 { background-image: url('{{ asset('backend/dist/img/login/slide3.jpg') }}'); }
        .slide-4 { background-image: url('{{ asset('backend/dist/img/login/slide4.jpg') }}'); }

        /* Admin panel overlay on right side */
        .admin-overlay {
            position: absolute;
            top: 24px;
            right: 24px;
            background: rgba(139, 26, 26, 0.85);
            color: #FFD600;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            z-index: 10;
            backdrop-filter: blur(4px);
        }

        .slide-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 14px 28px;
            background: rgba(100, 10, 10, 0.80);
            font-size: 18px;
            font-weight: 600;
            color: #FFD600;
            letter-spacing: .3px;
            opacity: 0;
            transform: translateY(6px);
            transition: opacity 1.2s ease-in-out, transform 1.2s ease-in-out;
        }
        .slide.active .slide-caption { opacity: 1; transform: translateY(0); }

        @media (max-width: 768px) {
            .login-wrapper { flex-direction: column; }
            .login-left { width: 100%; padding: 32px 24px; }
            .login-right { height: 260px; }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">

        {{-- LEFT: Form --}}
        <div class="login-left">

            <div class="login-logo">
                <img src="{{ asset('backend/dist/img/login/USJNet-SignInNew.png') }}" alt="USJNet Sphere">
            </div>

            <h3>SSO Admin Portal</h3>
            <div class="admin-badge">
                <i class="fas fa-shield-alt"></i> Restricted Access
            </div>

            {{-- Errors --}}
            @if ($errors->any())
            <div class="alert-error">
                <i class="fas fa-exclamation-circle mr-1"></i>
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('sso.admin.login.post') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="admin@sjp.ac.lk"
                           required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <input type="password" id="password" name="password"
                               placeholder="••••••••"
                               required autocomplete="current-password">
                        <button type="button" class="toggle-pw" onclick="togglePw()" tabindex="-1">
                            <i class="fas fa-eye" id="pw-icon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-signin">
                    <i class="fas fa-sign-in-alt mr-1"></i> Sign In to Admin Portal
                </button>
            </form>

            <div class="back-link">
                <a href="{{ route('login') }}">
                    <i class="fas fa-arrow-left mr-1"></i> Back to regular login
                </a>
            </div>

        </div>

        {{-- RIGHT: Slideshow --}}
        <div class="login-right">
            <div class="admin-overlay">
                <i class="fas fa-server mr-1"></i> SSO Administration
            </div>

            <div class="slide slide-1 active">
                <div class="slide-caption">Single Sign-On — Central Identity Provider</div>
            </div>
            <div class="slide slide-2">
                <div class="slide-caption">Manage OAuth Clients &amp; Access Policies</div>
            </div>
            <div class="slide slide-3">
                <div class="slide-caption">Secure Authentication for All University Systems</div>
            </div>
            <div class="slide slide-4">
                <div class="slide-caption">Role-Based Permissions &amp; Audit Logs</div>
            </div>
        </div>

    </div>

    <script>
        var slides = document.querySelectorAll('.slide');
        var current = 0;
        var timer;

        function showSlide(n) {
            slides[current].classList.remove('active');
            current = (n + slides.length) % slides.length;
            slides[current].classList.add('active');
        }
        function startTimer() {
            timer = setInterval(function() { showSlide(current + 1); }, 5000);
        }
        startTimer();

        function togglePw() {
            var inp = document.getElementById('password');
            var icon = document.getElementById('pw-icon');
            if (inp.type === 'password') {
                inp.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                inp.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>
