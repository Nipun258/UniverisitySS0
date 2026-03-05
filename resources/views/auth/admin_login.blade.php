<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('backend/dist/img/logo.png') }}" type="image/png">
    <title>USJNet Sphere | Sign In</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Source Sans Pro', sans-serif;
            background: #fff;
        }

        /* ── Layout ── */
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

        .login-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 40px;
        }

        .login-logo img {
            height: 42px;
        }

        .login-logo-text {
            line-height: 1.15;
        }

        .login-logo-text .brand {
            font-size: 22px;
            font-weight: 700;
            color: #8B1A1A;
            letter-spacing: -.3px;
        }

        .login-logo-text .brand span {
            color: #c8a000;
        }

        .login-logo-text .subtitle {
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 1.5px;
            color: #888;
            text-transform: uppercase;
        }

        .login-left h3 {
            font-size: 26px;
            font-weight: 600;
            color: #222;
            margin: 0 0 28px;
        }

        .form-group {
            margin-bottom: 18px;
        }

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

        .form-group .input-wrap {
            position: relative;
        }

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

        .forgot-link {
            text-align: right;
            font-size: 12px;
            margin-top: -8px;
            margin-bottom: 22px;
        }

        .forgot-link a {
            color: #457b9d;
            text-decoration: none;
        }

        .forgot-link a:hover {
            text-decoration: underline;
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

        .btn-signin:hover {
            background: #6d1414;
        }

        .login-footer-msg {
            text-align: center;
            font-size: 12px;
            color: #999;
            margin-top: 22px;
        }

        .login-footer-msg a {
            color: #457b9d;
        }

        .alert-error {
            background: #fde8e8;
            border: 1px solid #f5c6c6;
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 13px;
            color: #8B1A1A;
            margin-bottom: 18px;
        }

        /* ── RIGHT PANEL — Slideshow ── */
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

        .slide.active {
            opacity: 1;
        }

        /* Slide images */
        .slide-1 {
            background-image: url('{{ asset('backend/dist/img/login/slide1.jpg') }}');
        }

        .slide-2 {
            background-image: url('{{ asset('backend/dist/img/login/slide2.jpg') }}');
        }

        .slide-3 {
            background-image: url('{{ asset('backend/dist/img/login/slide3.jpg') }}');
        }

        .slide-4 {
            background-image: url('{{ asset('backend/dist/img/login/slide4.jpg') }}');
        }

        /* Caption bar */
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

        .slide.active .slide-caption {
            opacity: 1;
            transform: translateY(0);
        }

        /* Nav arrows */
        .slide-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.18);
            border: none;
            color: #fff;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            font-size: 16px;
            cursor: pointer;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s;
        }

        .slide-nav:hover {
            background: rgba(255, 255, 255, 0.35);
        }

        .slide-nav.prev {
            left: 14px;
        }

        .slide-nav.next {
            right: 14px;
        }

        /* Dot indicators */
        .slide-dots {
            position: absolute;
            bottom: 60px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 7px;
            z-index: 10;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.45);
            cursor: pointer;
            transition: background .3s, transform .3s;
        }

        .dot.active {
            background: #FFD600;
            transform: scale(1.3);
        }

        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }

            .login-left {
                width: 100%;
                padding: 32px 24px;
            }

            .login-right {
                height: 260px;
            }
        }

    </style>
</head>
<body>

    <div class="login-wrapper">

        {{-- ── LEFT: Form ── --}}
        <div class="login-left">

            {{-- Logo --}}
            <div class="login-logo" style="margin-bottom: 30px;">
                <img src="{{ asset('backend/dist/img/login/USJNet-SignInNew.png') }}" alt="USJNet Sphere" style="width: 100%; max-width: 320px; height: auto;">
            </div>

            <h3>Sign In</h3>

            {{-- Errors --}}
            @if ($errors->any())
            <div class="alert-error">
                <i class="fas fa-exclamation-circle mr-1"></i>
                {{ $errors->first() }}
            </div>
            @endif

            @if (session('status'))
            <div class="alert-error" style="background:#e8f4fd;border-color:#b8d9f0;color:#1d3557;">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">USJNet ID</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="your@email.sjp.ac.lk" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
                        <button type="button" class="toggle-pw" onclick="togglePw()" tabindex="-1">
                            <i class="fas fa-eye" id="pw-icon"></i>
                        </button>
                    </div>
                </div>

                <div class="forgot-link">
                    <a href="{{ route('password.request') }}">Forgot my password</a>
                </div>

                <button type="submit" class="btn-signin">Sign In</button>
            </form>

            {{-- <div class="login-footer-msg">
      I am not a member. <a href="{{ route('register') }}">Sign Up to be a member</a>
        </div> --}}

    </div>

    {{-- ── RIGHT: Slideshow ── --}}
    <div class="login-right">

        <div class="slide slide-1 active">
            <div class="slide-caption">Ability to change the password on your own</div>
        </div>
        <div class="slide slide-2">
            <div class="slide-caption">Provision to integrate more services</div>
        </div>
        <div class="slide slide-3">
            <div class="slide-caption">Ability to reset the password when you forget</div>
        </div>
        <div class="slide slide-4">
            <div class="slide-caption">Mobile-friendly</div>
        </div>

        <button class="slide-nav prev" onclick="changeSlide(-1)">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="slide-nav next" onclick="changeSlide(1)">
            <i class="fas fa-chevron-right"></i>
        </button>

        <div class="slide-dots">
            <div class="dot active" onclick="goToSlide(0)"></div>
            <div class="dot" onclick="goToSlide(1)"></div>
            <div class="dot" onclick="goToSlide(2)"></div>
            <div class="dot" onclick="goToSlide(3)"></div>
        </div>

    </div>

    </div>

    <script>
        var slides = document.querySelectorAll('.slide');
        var dots = document.querySelectorAll('.dot');
        var current = 0;
        var timer;

        function showSlide(n) {
            slides[current].classList.remove('active');
            dots[current].classList.remove('active');
            current = (n + slides.length) % slides.length;
            slides[current].classList.add('active');
            dots[current].classList.add('active');
        }

        function changeSlide(dir) {
            clearInterval(timer);
            showSlide(current + dir);
            startTimer();
        }

        function goToSlide(n) {
            clearInterval(timer);
            showSlide(n);
            startTimer();
        }

        function startTimer() {
            timer = setInterval(function() {
                showSlide(current + 1);
            }, 5000);
        }

        startTimer();

        // Toggle password visibility
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
