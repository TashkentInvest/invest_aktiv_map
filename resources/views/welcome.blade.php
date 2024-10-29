<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@lang('panel.site_title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">

    
    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <style>
        html, body {
            /* background-color: #fff; */
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            margin: 0;
            background: url('assets/images/banner_home.jpg');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }

        canvas{
            display:block;
            vertical-align:bottom;
        }

        #particles-js{
            width: 100%;
            height: 100%;
        }
        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            height: 100vh;
            text-align: center;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .panel_site_title{
            margin: 20px 0 0 0;
            text-transform: uppercase;
            color: #fff;
            font-weight: 700;
            font-size: 20px;
        }

        /* .title {
            font-size: 84px;
        } */
        .content .welcome_box h1{
            font-size: 60px;
            color: #fff;
            font-weight: 700;
            margin-bottom: 0;
        }

        .content .welcome_box .btn{
            font-size: 20px;
            padding: 13px 0;
            color: #fff;
            background-color: #03D0C9;
            width: 200px;
            color: #fff;
            font-weight: 700;
            display: inline-flex;
            text-align: center;
            justify-content: center;
            text-decoration: unset;
            border-radius: 5px;
        }
        .panel_footer{
            margin: 0 0 20px 0;
            color: #fff;
        }

        .panel_footer a{
            color: #fff;
            text-decoration: none;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        @media (max-width: 575px){
            .content .welcome_box h1 {
                font-size: 45px;
                color: #fff;
                font-weight: 700;
                margin-bottom: 0;
            }
        }

        @media (max-width: 475px){
            .content .welcome_box h1 {
                font-size: 39px;
                color: #fff;
                font-weight: 700;
                margin-bottom: 0;
            }
        }
    </style>
</head>
<body>
<div class="wrapper flex-center position-ref full-height">
    <div id="particles-js">
        <div class="content" >
            <h3 class="panel_site_title">@lang('panel.site_title')</h3>
            <div class="welcome_box">
                <h1>@lang('panel.welcome')</h1>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home') }}" class="btn btn-success">@lang('global.home')</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-success">@lang('global.login')</a>
                    @endauth
                @endif
            </div>
            <span class="panel_footer">
                <strong>&copy; {{ date('Y') }} 
                    <a href="#">Tashkent Invest Company</a>.</strong>
            </span>
        </div>
    </div>
</div>
</body>
</html>

<script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('assets/js/particles/particles.js') }}"></script>
<script src="{{ asset('assets/js/particles/app.js') }}"></script>
<script>
    $(window).on('load', function() {
        $(".loader-in").fadeOut();
        $(".loader").delay(150).fadeOut("fast");
        $(".wrapper").fadeIn("fast");
        $("#app").fadeIn("fast");
    });
</script>