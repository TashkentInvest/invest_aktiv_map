<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@lang('panel.site_title')</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <style>
        html, body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            height: 100%;
            /* background-color: #f8f9fa; */
            overflow: hidden;
            color: #343a40; /* Dark text color */
        }

        .full-height {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-image: url('https://demo.toshkentinvest.uz/assets/frontend/Content/Gallery/Image/banner3.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.4); /* Dark overlay */
            z-index: -1;
        }

        .content {
            position: relative;
            text-align: center;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9); /* White background with opacity */
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            width: 100%;
        }

        .panel_site_title {
            font-size: 36px;
            font-weight: 700;
            color: #0057b8; /* Primary blue color */
            margin-bottom: 30px;
            text-transform: uppercase;
        }

        .welcome_box h1 {
            font-size: 60px;
            font-weight: 700;
            color: #343a40; /* Dark grey text */
            margin-bottom: 40px;
            text-transform: uppercase;
        }

        .btn {
            font-size: 18px;
            padding: 12px 30px;
            color: #fff;
            background-color: #0057b8; /* Primary blue */
            border: none;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            z-index: 100000000 !important;
        }

        .btn:hover {
            background-color: #003f89; /* Darker blue on hover */
            transform: translateY(-4px);
        }

        .panel_footer {
            margin-top: 40px;
            font-size: 14px;
            color: #6c757d; /* Light grey text */
        }

        .panel_footer a {
            color: #0057b8; /* Primary blue */
            text-decoration: none;
            font-weight: 600;
        }

        /* Logo Styles */
        .logo {
            max-width: 200px;
            margin-bottom: 20px;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .panel_site_title {
                font-size: 28px;
            }

            .welcome_box h1 {
                font-size: 48px;
            }

            .btn {
                font-size: 16px;
                padding: 10px 25px;
            }
        }

        @media (max-width: 480px) {
            .panel_site_title {
                font-size: 24px;
            }

            .welcome_box h1 {
                font-size: 36px;
            }

            .btn {
                font-size: 14px;
                padding: 8px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="full-height">
        <div class="overlay"></div>
        <div class="content">
            <!-- Toshkent Invest Logo -->
            <img src="https://toshkentinvest.uz/assets/frontend/tild6238-3031-4265-a564-343037346231/tic_logo_blue.png" alt="Toshkent Invest Logo" class="logo">
            
            {{-- <h3 class="panel_site_title">@lang('panel.site_title')</h3> --}}
            
            <div class="welcome_box">
                <h1>Хуш келибсиз!</h1>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('aktivs.index') }}" class="btn">Кириш</a>
                    @else
                        <a href="{{ route('login') }}" class="btn">Логин</a>
                    @endauth
                @endif
            </div>

            <div class="panel_footer">
                <strong>&copy; {{ date('Y') }}
                    <a href="#">Tashkent Invest Company</a>.
                </strong>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
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
