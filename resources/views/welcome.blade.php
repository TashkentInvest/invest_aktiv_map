<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@lang('panel.site_title')</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <style>
        html, body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1f4037, #99f2c8);
            color: #ffffff;
            height: 100%;
            overflow-x: hidden;
        }
        .full-height {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            text-align: center;
            padding: 20px;
        }
        .panel_site_title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 30px;
        }
        .panel_site_title a {
            color: #ffd700;
            text-decoration: none;
        }
        .welcome_box h1 {
            font-size: 64px;
            font-weight: 700;
            margin-bottom: 40px;
            text-transform: uppercase;
            letter-spacing: 3px;
            animation: fadeInDown 1s ease-in-out;
        }
        .btn {
            font-size: 18px;
            padding: 15px 30px;
            color: #ffffff;
            background-color: #ff8c00;
            border: none;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s ease;
            display: inline-block;
            margin: 10px;
        }
        .btn:hover {
            background-color: #ffa500;
        }
        .panel_footer {
            margin-top: 50px;
            font-size: 14px;
        }
        .panel_footer a {
            color: #ffd700;
            text-decoration: none;
        }
        /* Video Container */
        .video-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 250px;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            overflow: hidden;
            animation: fadeInUp 1s ease-in-out;
        }
        .video-container a {
            display: block;
        }
        .video-container img {
            width: 100%;
            height: auto;
            display: block;
        }
        /* Animations */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-50px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Responsive */
        @media (max-width: 768px) {
            .welcome_box h1 {
                font-size: 48px;
            }
            .video-container {
                width: 200px;
            }
        }
        @media (max-width: 480px) {
            .welcome_box h1 {
                font-size: 36px;
            }
            .btn {
                font-size: 16px;
                padding: 12px 25px;
            }
            .video-container {
                width: 150px;
                bottom: 10px;
                right: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Video Section -->
    <div class="video-container">
        <a href="https://t.me/az_etc" target="_blank">
            <img src="{{ asset('assets/reklama/reklamaTeamdev.gif') }}" alt="Teamdev GIF" />
        </a>
    </div>
    <div class="full-height">
        <div class="content">
             <h3 class="panel_site_title">
                @lang('panel.site_title')
            </h3>
            {{-- <h3 class="panel_site_title">
                @lang('panel.site_title') <br>
                Web-sayt yoki platformalar yaratish uchun
                <a href="tel:+998333088099">+998(33)308-80-99</a>
            </h3> --}}
            <div class="welcome_box">
                <h1>@lang('panel.welcome')</h1>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/aktivs') }}" class="btn">@lang('global.home')</a>
                    @else
                        <a href="{{ route('login') }}" class="btn">@lang('global.login')</a>
                    @endauth
                @endif
            </div>
            <div class="panel_footer">
                <strong>&copy; {{ date('Y') }}
                    <a href="#">Tashkent Invest Company</a>.</strong>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <!-- Optional: Include particle.js or any other scripts you need -->
    <script>
        $(window).on('load', function() {
            $(".loader-in").fadeOut();
            $(".loader").delay(150).fadeOut("fast");
            $(".wrapper").fadeIn("fast");
            $("#app").fadeIn("fast");
        });
    </script>
</body>
</html>
