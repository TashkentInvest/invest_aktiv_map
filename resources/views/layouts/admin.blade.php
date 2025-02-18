<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aktiv</title>
    <!-- core:css -->
    <link rel="stylesheet" href="{{ asset('edo_template/assets/vendors/core/core.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet"
        href="{{ asset('edo_template/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <!-- end plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('edo_template/assets/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('edo_template/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('edo_template/assets/css/demo_1/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('assets/logo_blue_tic.png') }}" />

    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    @yield('styles')
</head>

<body class="sidebar-dark">
    <div class="main-wrapper">

        <!-- partial:partials/_sidebar.html -->

        @include('layouts.edo_sidebar')

        {{-- @include('layouts.edo-setting_nav') --}}
        <!-- partial -->

        <div class="page-wrapper">

            <!-- partial:partials/_navbar.html -->
            <nav class="navbar">
                <a href="#" class="sidebar-toggler">
                    <i data-feather="menu"></i>
                </a>
                <div class="navbar-content">
                    {{-- <form class="search-form">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i data-feather="search"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" id="navbarForm" placeholder="Search here...">
                        </div>
                    </form> --}}
                    <ul class="navbar-nav">

                        <li class="nav-item dropdown nav-profile">
                            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="profile">
                            </a>
                            <div class="dropdown-menu" aria-labelledby="profileDropdown">
                                <div class="dropdown-header d-flex flex-column align-items-center">
                                    <div class="figure mb-3">
                                        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="">
                                    </div>
                                    <div class="info text-center">
                                        <p class="name font-weight-bold mb-0">{{ auth()->user()->name ?? '--' }}</p>
                                        <p class="email text-muted mb-3">{{ auth()->user()->email ?? '--' }}</p>
                                    </div>
                                </div>
                                <div class="dropdown-body">
                                    <ul class="profile-nav p-0 pt-3">
                                        {{-- <li class="nav-item">
                                            <a href="{{route('userIndex')}}" class="nav-link">
                                                <i data-feather="user"></i>
                                                <span>Profile</span>
                                            </a>
                                        </li> --}}
                                        <li class="nav-item">
                                            <a href="{{ route('userEdit', auth()->user()->id) }}" class="nav-link">
                                                <i data-feather="edit"></i>
                                                <span>Таҳрир қилиш</span>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="nav-link">
                                                @csrf
                                                <i data-feather="log-out"></i>
                                                <button
                                                    style="background: transparent; border:none; outline:none; padding:0;margin:0;"
                                                    type="submit">Чиқиш</button>
                                            </form>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- partial -->

            <div class="page-content">
                @yield('content')
            </div>

            <style>
                .select2-container .select2-selection--single {

                    height: auto !important;

                }

                .select2-container--default .select2-selection--single .select2-selection__rendered {
                    line-height: auto !important;
                }

                .select2-container--default .select2-selection--single .select2-selection__arrow {

                    display: none !important;
                }

                select,
                .email-compose-fields .select2-container--default .select2-selection--multiple,
                .select2-container--default .select2-selection--single,
                .select2-container--default .select2-selection--single .select2-search__field,
                .typeahead,
                .tt-query,
                .tt-hint {

                    padding: 0 !important;
                    /* font-size: 0.875rem; */


                }
            </style>

            <!-- partial:partials/_footer.html -->
            <footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between">
                <p class="text-muted text-center text-md-left">Copyright © {{ date('Y') }} <a
                        href="https://www.teamdev.uz" target="_blank">TeamDev.uz</a>. All rights reserved</p>
                <p class="text-muted text-center text-md-left mb-0 d-none d-md-block">Handcrafted With <i
                        class="mb-1 text-primary ml-1 icon-small" data-feather="heart"></i></p>
            </footer>
            <!-- partial -->

        </div>
    </div>

    <!-- core:js -->
    <script src="{{ asset('edo_template/assets/vendors/core/core.js') }}"></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <script src="{{ asset('edo_template/assets/vendors/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('edo_template/assets/vendors/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('edo_template/assets/vendors/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('edo_template/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('edo_template/assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('edo_template/assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <!-- end plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('edo_template/assets/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('edo_template/assets/js/template.js') }}"></script>
    <!-- endinject -->
    <!-- custom js for this page -->
    <script src="{{ asset('edo_template/assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('edo_template/assets/js/datepicker.js') }}"></script>
    <!-- end custom js for this page -->

    @yield('scripts')


    {{-- custom test --}}

    <!-- JAVASCRIPT -->

    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <!-- form advanced init -->
    <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>

    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->


    <style>
        /* .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 0 !important;
        } */
    </style>
</body>

</html>
