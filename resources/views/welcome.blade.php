<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>USJNet Sphere — App Portal</title>
    <link rel="icon" href="{{ asset('backend/dist/img/logo.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style (AdminLTE includes Bootstrap 4) -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">

    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Source Sans Pro', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Top Navbar for Login/Logout */
        .portal-nav {
            background: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: relative;
            z-index: 100;
        }

        .portal-nav .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
            font-weight: 700;
            color: #8B1A1A;
            text-decoration: none;
        }

        .portal-nav .brand img {
            height: 35px;
        }

        .portal-nav .user-actions a,
        .portal-nav .user-actions form button {
            margin-left: 15px;
            font-size: 14px;
            font-weight: 600;
        }

        /* Hero Slideshow Section */
        .hero-section {
            width: 100%;
            height: 380px;
            position: relative;
            overflow: hidden;
            background: #1d3557;
        }

        .hero-slide {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
            z-index: 1;
        }

        .hero-slide.active {
            opacity: 1;
            z-index: 2;
        }

        /* Add a subtle overlay to make text pop if needed */
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.1), transparent);
            z-index: 3;
        }

        /* Grid Section */
        .app-grid-container {
            max-width: 1200px;
            margin: -40px auto 60px;
            /* Pull up over the image slightly */
            padding: 0 20px;
            position: relative;
            z-index: 10;
        }

        .app-card {
            background: #fff;
            border-radius: 12px;
            padding: 24px 15px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            height: 100%;
            border: 2px solid transparent;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #333;
        }

        .app-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
            border-color: #8B1A1A;
            color: #8B1A1A;
        }

        .app-icon {
            font-size: 42px;
            margin-bottom: 16px;
            background: -webkit-linear-gradient(135deg, #1d3557, #457b9d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: transform 0.3s ease;
        }

        .app-card:hover .app-icon {
            transform: scale(1.1);
        }

        .app-title {
            font-size: 15px;
            font-weight: 600;
            margin: 0;
            color: #495057;
        }

        @media (max-width: 768px) {
            .hero-section {
                height: 260px;
            }

            .app-grid-container {
                margin-top: -20px;
            }

            .app-card {
                padding: 18px 10px;
            }

            .app-icon {
                font-size: 32px;
            }
        }

    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="portal-nav">
        <a href="/" class="brand">
            <img src="{{ asset('backend/dist/img/login/USJNet-SignInNew.png') }}" alt="USJ">

        </a>
        <div class="user-actions">
            @auth
            <span class="text-muted mr-3 d-none d-sm-inline"><i class="fas fa-user-circle"></i> {{ auth()->user()->name }}</span>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3 ml-2">Logout</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="btn btn-primary btn-sm rounded-pill px-4">Sign In</a>
            @endauth
        </div>
    </nav>

    <!-- Hero Slideshow -->
    <section class="hero-section">
        <!-- We use the same slides we generated for the login page -->
        <div class="hero-slide active" style="background-image: url('{{ asset('backend/dist/img/login/slide3.jpg') }}');"></div>
        <div class="hero-slide" style="background-image: url('{{ asset('backend/dist/img/login/slide2.jpg') }}');"></div>
        <div class="hero-slide" style="background-image: url('{{ asset('backend/dist/img/login/slide1.jpg') }}');"></div>
        <div class="hero-slide" style="background-image: url('{{ asset('backend/dist/img/login/slide4.jpg') }}');"></div>
        <div class="hero-overlay"></div>
    </section>

    <!-- App Grid -->
    <section class="app-grid-container">

        @php
        // List of apps to show on the dashboard.
        // Update the 'url' to point to real SSO callback origins or internal routes.
        $apps = [
        ['name' => 'My Profile', 'icon' => 'fas fa-id-badge', 'url' => route('dashboard')],
        ['name' => 'My Salary', 'icon' => 'fas fa-envelope-open-text','url' => '#'],
        ['name' => 'E-Resources', 'icon' => 'fas fa-book-reader', 'url' => '#'],
        ['name' => 'Downloads', 'icon' => 'fas fa-cloud-download-alt','url' => '#'],
        ['name' => 'HRMS', 'icon' => 'fas fa-chalkboard-teacher','url' => '#'],
        ['name' => 'Vehicle Pass Admin', 'icon' => 'fas fa-clipboard-list', 'url' => 'http://127.0.0.1:8001/login/sso'],
        ['name' => 'Research Allowance', 'icon' => 'fas fa-hand-holding-usd', 'url' => '#'],
        ['name' => 'USJNet Admin', 'icon' => 'fas fa-shield-alt', 'url' => '#'],
        ['name' => 'Add Email to Database','icon' => 'fas fa-user-shield', 'url' => '#'],
        ['name' => 'FGS MIS', 'icon' => 'fas fa-desktop', 'url' => '#'],
        ['name' => 'SIMS', 'icon' => 'fas fa-th-large', 'url' => '#'],
        ['name' => 'Welfare', 'icon' => 'fas fa-life-ring', 'url' => '#'],
        ];
        @endphp


        <div class="row">
            @foreach($apps as $app)
            <div class="col-6 col-sm-4 col-md-3 col-lg-3 mb-4">
                <a href="{{ $app['url'] }}" class="app-card">
                    <div class="app-icon">
                        <i class="{{ $app['icon'] }}"></i>
                    </div>
                    <h3 class="app-title">{{ $app['name'] }}</h3>
                </a>
            </div>
            @endforeach
        </div>

    </section>

    <!-- Footer -->
    <footer class="text-center pb-4 text-muted" style="font-size: 13px;">
        &copy; {{ date('Y') }} University of Sri Jayewardenepura. All Rights Reserved.
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Slideshow Logic -->
    <script>
        $(document).ready(function() {
            let slides = $('.hero-slide');
            let current = 0;

            if (slides.length > 1) {
                setInterval(function() {
                    $(slides[current]).removeClass('active');
                    current = (current + 1) % slides.length;
                    $(slides[current]).addClass('active');
                }, 6000); // Change image every 6 seconds
            }
        });

    </script>
</body>
</html>
