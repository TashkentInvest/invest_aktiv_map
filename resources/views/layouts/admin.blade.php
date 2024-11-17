<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@lang('panel.site_title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/dark_logo.png') }}">

    <!-- App CSS -->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

    <!-- Additional Plugin CSS -->
    <link rel="stylesheet" href="{{ asset('assets/new/assets/css/plugins/jsvectormap.min.css') }}">

    <!-- Icon Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/new/assets/fonts/phosphor/duotone/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/new/assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/new/assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/new/assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/new/assets/fonts/material.css') }}">

    <!-- Template Styles -->
    <link rel="stylesheet" href="{{ asset('assets/new/assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('assets/new/assets/css/style-preset.css') }}">


    @yield('styles')
</head>

<body data-sidebar="{{ auth()->user()->theme()['sidebar'] ?? '' }}"
    data-layout-mode="{{ auth()->user()->theme()['body'] ?? '' }}">

    <div id="preloader">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <style>
            @media(max-width: 757px) {
                .card-body {
                    overflow: scroll !important;
                }
            }
        </style>

        <header class="pc-header">
            <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
                <div class="me-auto pc-mob-drp">
                    <ul class="list-unstyled">
                        <!-- ======= Menu collapse Icon ===== -->
                        <li class="pc-h-item pc-sidebar-collapse">
                            <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="pc-h-item pc-sidebar-popup">
                            <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        {{-- <li class="dropdown pc-h-item d-inline-flex d-md-none">
                            <a class="pc-head-link dropdown-toggle arrow-none m-0" data-bs-toggle="dropdown"
                                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="ph-duotone ph-magnifying-glass"></i>
                            </a>
                            <div class="dropdown-menu pc-h-dropdown drp-search">
                                <form action="{{ route('search') }}" method="GET" class="px-3">
                                    <div class="mb-0 d-flex align-items-center">
                                        <input type="search" name="query" class="form-control border-0 shadow-none"
                                            placeholder="Search...">
                                        <button type="submit"
                                            class="btn btn-light-secondary btn-search">Search</button>
                                    </div>
                                </form>

                            </div>
                        </li>
                        <li class="pc-h-item d-none d-md-inline-flex">
                            <form action="{{ route('search') }}" method="GET" class="form-search">
                                <i class="ph-duotone ph-magnifying-glass icon-search"></i>
                                <input type="search" name="query" class="form-control" placeholder="Search...">
                                <button type="submit" class="btn btn-search"
                                    style="padding: 0"><kbd>ctrl+k</kbd></button>
                            </form>

                        </li> --}}
                    </ul>
                </div>
                <!-- [Mobile Media Block end] -->
                <div class="ms-auto">
                    <ul class="list-unstyled">
                        <li class="dropdown pc-h-item">
                            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="ph-duotone ph-sun-dim"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                                <a href="#!" class="dropdown-item" onclick="layout_change('dark')">
                                    <i class="ph-duotone ph-moon"></i>
                                    <span>Dark</span>
                                </a>
                                <a href="#!" class="dropdown-item" onclick="layout_change('light')">
                                    <i class="ph-duotone ph-sun-dim"></i>
                                    <span>Light</span>
                                </a>
                                <a href="#!" class="dropdown-item" onclick="layout_change_default()">
                                    <i class="ph-duotone ph-cpu"></i>
                                    <span>Default</span>
                                </a>
                            </div>
                        </li>


                        {{-- <li class="pc-h-item">
                            <a class="pc-head-link pct-c-btn" href="#" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvas_pc_layout">
                                <i class="ph-duotone ph-gear-six"></i>
                            </a>
                        </li> --}}
                        {{-- <li class="dropdown pc-h-item">
                            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="ph-duotone ph-diamonds-four"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                                <a href="#!" class="dropdown-item">
                                    <i class="ph-duotone ph-user"></i>
                                    <span>My Account</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="ph-duotone ph-gear"></i>
                                    <span>Settings</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="ph-duotone ph-lifebuoy"></i>
                                    <span>Support</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="ph-duotone ph-lock-key"></i>
                                    <span>Lock Screen</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="ph-duotone ph-power"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li> --}}
                        {{-- <li class="dropdown pc-h-item">
                            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="ph-duotone ph-bell"></i>
                                <span class="badge bg-success pc-h-badge">3</span>
                            </a>
                            <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                                <div class="dropdown-header d-flex align-items-center justify-content-between">
                                    <h5 class="m-0">Notifications</h5>
                                    <ul class="list-inline ms-auto mb-0">
                                        <li class="list-inline-item">
                                            <a href="../application/mail.html"
                                                class="avtar avtar-s btn-link-hover-primary">
                                                <i class="ti ti-link f-18"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="dropdown-body text-wrap header-notification-scroll position-relative"
                                    style="max-height: calc(100vh - 235px)">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <p class="text-span">Today</p>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <img src="{{ asset('assets/new/assets/images/user/avatar-2.jpg') }}"
                                                        alt="user-image" class="user-avtar avtar avtar-s">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1 me-3 position-relative">
                                                            <h6 class="mb-0 text-truncate">Keefe Bond added new tags to
                                                                💪 Design system</h6>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <span class="text-sm">2 min ago</span>
                                                        </div>
                                                    </div>
                                                    <p class="position-relative mt-1 mb-2"><br><span
                                                            class="text-truncate">Lorem Ipsum has been the industry's
                                                            standard dummy text ever since the 1500s.</span></p>
                                                    <span
                                                        class="badge bg-light-primary border border-primary me-1 mt-1">web
                                                        design</span>
                                                    <span
                                                        class="badge bg-light-warning border border-warning me-1 mt-1">Dashobard</span>
                                                    <span
                                                        class="badge bg-light-success border border-success me-1 mt-1">Design
                                                        System</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <div class="avtar avtar-s bg-light-primary">
                                                        <i class="ph-duotone ph-chats-teardrop f-18"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1 me-3 position-relative">
                                                            <h6 class="mb-0 text-truncate">Message</h6>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <span class="text-sm">1 hour ago</span>
                                                        </div>
                                                    </div>
                                                    <p class="position-relative mt-1 mb-2"><br><span
                                                            class="text-truncate">Lorem Ipsum has been the industry's
                                                            standard dummy text ever since the 1500s.</span></p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <p class="text-span">Yesterday</p>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <div class="avtar avtar-s bg-light-danger">
                                                        <i class="ph-duotone ph-user f-18"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1 me-3 position-relative">
                                                            <h6 class="mb-0 text-truncate">Challenge invitation</h6>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <span class="text-sm">12 hour ago</span>
                                                        </div>
                                                    </div>
                                                    <p class="position-relative mt-1 mb-2"><br><span
                                                            class="text-truncate"><strong> Jonny aber </strong> invites
                                                            to join the challenge</span></p>
                                                    <button
                                                        class="btn btn-sm rounded-pill btn-outline-secondary me-2">Decline</button>
                                                    <button class="btn btn-sm rounded-pill btn-primary">Accept</button>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <div class="avtar avtar-s bg-light-info">
                                                        <i class="ph-duotone ph-notebook f-18"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1 me-3 position-relative">
                                                            <h6 class="mb-0 text-truncate">Forms</h6>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <span class="text-sm">2 hour ago</span>
                                                        </div>
                                                    </div>
                                                    <p class="position-relative mt-1 mb-2">Lorem Ipsum is simply dummy
                                                        text of the printing and typesetting industry. Lorem Ipsum has
                                                        been the industry's standard
                                                        dummy text ever since the 1500s.</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <img src="{{ asset('assets/new/assets/images/user/avatar-2.jpg') }}"
                                                        alt="user-image" class="user-avtar avtar avtar-s">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1 me-3 position-relative">
                                                            <h6 class="mb-0 text-truncate">Keefe Bond added new tags to
                                                                💪 Design system</h6>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <span class="text-sm">2 min ago</span>
                                                        </div>
                                                    </div>
                                                    <p class="position-relative mt-1 mb-2"><br><span
                                                            class="text-truncate">Lorem Ipsum has been the industry's
                                                            standard dummy text ever since the 1500s.</span></p>
                                                    <button
                                                        class="btn btn-sm rounded-pill btn-outline-secondary me-2">Decline</button>
                                                    <button class="btn btn-sm rounded-pill btn-primary">Accept</button>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <div class="avtar avtar-s bg-light-success">
                                                        <i class="ph-duotone ph-shield-checkered f-18"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1 me-3 position-relative">
                                                            <h6 class="mb-0 text-truncate">Security</h6>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <span class="text-sm">5 hour ago</span>
                                                        </div>
                                                    </div>
                                                    <p class="position-relative mt-1 mb-2">Lorem Ipsum is simply dummy
                                                        text of the printing and typesetting industry. Lorem Ipsum has
                                                        been the industry's standard
                                                        dummy text ever since the 1500s.</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="dropdown-footer">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <div class="d-grid"><button class="btn btn-primary">Archive all</button>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-grid"><button class="btn btn-outline-secondary">Mark all as
                                                    read</button></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li> --}}
                        <!-- Lang start -->
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                @if (session('locale') == 'uz')
                                    <img id="header-lang-img" src="{{ asset('assets/images/flags/uzbekistan.jpg') }}"
                                        alt="Header Language" height="16">
                                @else
                                    <img id="header-lang-img" src="{{ asset('assets/images/flags/russia.jpg') }}"
                                        alt="Header Language" height="16">
                                @endif
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->

                                <a href="{{ route('changelang', 'ru') }}" class="dropdown-item notify-item language"
                                    data-lang="ru">
                                    <img src="{{ asset('assets/images/flags/russia.jpg') }}" alt="user-image"
                                        class="me-1" height="12"> <span class="align-middle">Русский</span>
                                </a>
                                <a href="{{ route('changelang', 'uz') }}" class="dropdown-item notify-item language"
                                    data-lang="uz">
                                    <img src="{{ asset('assets/images/flags/uzbekistan.jpg') }}" alt="user-image"
                                        class="me-1" height="12"> <span class="align-middle">O'zbekcha</span>
                                </a>
                            </div>
                        </div>
                        <!-- Lang end -->
                        {{-- <li class="dropdown pc-h-item header-user-profile">
                            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                                href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside"
                                aria-expanded="false">
                                <img src="{{ asset('assets/new/assets/images/user/avatar-2.jpg') }}" alt="user-image"
                                    class="user-avtar">
                            </a>
                            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                                <div class="dropdown-header d-flex align-items-center justify-content-between">
                                    <h5 class="m-0">Profile</h5>
                                </div>
                                <div class="dropdown-body">
                                    <div class="profile-notification-scroll position-relative"
                                        style="max-height: calc(100vh - 225px)">
                                        <ul class="list-group list-group-flush w-100">
                                            <li class="list-group-item">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <img src="{{ asset('assets/new/assets/images/user/avatar-2.jpg') }}"
                                                            alt="user-image" class="wid-50 rounded-circle">
                                                    </div>
                                                    <div class="flex-grow-1 mx-3">
                                                        <h5 class="mb-0">Carson Darrin</h5>
                                                        <a class="link-primary"
                                                            href="mailto:carson.darrin@company.io">carson.darrin@company.io</a>
                                                    </div>
                                                    <span class="badge bg-primary">PRO</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <a href="#" class="dropdown-item">
                                                    <span class="d-flex align-items-center">
                                                        <i class="ph-duotone ph-key"></i>
                                                        <span>Change password</span>
                                                    </span>
                                                </a>
                                                <a href="#" class="dropdown-item">
                                                    <span class="d-flex align-items-center">
                                                        <i class="ph-duotone ph-envelope-simple"></i>
                                                        <span>Recently mail</span>
                                                    </span>
                                                    <div class="user-group">
                                                        <img src="{{ asset('assets/new/assets/images/user/avatar-1.jpg') }}"
                                                            alt="user-image" class="avtar">
                                                        <img src="{{ asset('assets/new/assets/images/user/avatar-2.jpg') }}"
                                                            alt="user-image" class="avtar">
                                                        <img src="{{ asset('assets/new/assets/images/user/avatar-3.jpg') }}"
                                                            alt="user-image" class="avtar">
                                                    </div>
                                                </a>
                                                <a href="#" class="dropdown-item">
                                                    <span class="d-flex align-items-center">
                                                        <i class="ph-duotone ph-calendar-blank"></i>
                                                        <span>Schedule meetings</span>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                <a href="#" class="dropdown-item">
                                                    <span class="d-flex align-items-center">
                                                        <i class="ph-duotone ph-heart"></i>
                                                        <span>Favorite</span>
                                                    </span>
                                                </a>
                                                <a href="#" class="dropdown-item">
                                                    <span class="d-flex align-items-center">
                                                        <i class="ph-duotone ph-arrow-circle-down"></i>
                                                        <span>Download</span>
                                                    </span>
                                                    <span
                                                        class="avtar avtar-xs rounded-circle bg-danger text-white">10</span>
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="dropdown-item">
                                                    <span class="d-flex align-items-center">
                                                        <i class="ph-duotone ph-globe-hemisphere-west"></i>
                                                        <span>Languages</span>
                                                    </span>
                                                    <span class="flex-shrink-0">
                                                        <select
                                                            class="form-select bg-transparent form-select-sm border-0 shadow-none">
                                                            <option value="1">English</option>
                                                            <option value="2">Spain</option>
                                                            <option value="3">Arbic</option>
                                                        </select>
                                                    </span>
                                                </div>
                                                <a href="#" class="dropdown-item">
                                                    <span class="d-flex align-items-center">
                                                        <i class="ph-duotone ph-flag"></i>
                                                        <span>Country</span>
                                                    </span>
                                                </a>
                                                <div class="dropdown-item">
                                                    <span class="d-flex align-items-center">
                                                        <i class="ph-duotone ph-moon"></i>
                                                        <span>Dark mode</span>
                                                    </span>
                                                    <div class="form-check form-switch form-check-reverse m-0">
                                                        <input class="form-check-input f-18" id="dark-mode"
                                                            type="checkbox" onclick="dark_mode()" role="switch">
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <a href="#" class="dropdown-item">
                                                    <span class="d-flex align-items-center">
                                                        <i class="ph-duotone ph-user-circle"></i>
                                                        <span>Edit profile</span>
                                                    </span>
                                                </a>
                                                <a href="#" class="dropdown-item">
                                                    <span class="d-flex align-items-center">
                                                        <i class="ph-duotone ph-star text-warning"></i>
                                                        <span>Upgrade account</span>
                                                        <span
                                                            class="badge bg-light-success border border-success ms-2">NEW</span>
                                                    </span>
                                                </a>
                                                <a href="#" class="dropdown-item">
                                                    <span class="d-flex align-items-center">
                                                        <i class="ph-duotone ph-bell"></i>
                                                        <span>Notifications</span>
                                                    </span>
                                                </a>
                                                <a href="#" class="dropdown-item">
                                                    <span class="d-flex align-items-center">
                                                        <i class="ph-duotone ph-gear-six"></i>
                                                        <span>Settings</span>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                <a href="#" class="dropdown-item">
                                                    <span class="d-flex align-items-center">
                                                        <i class="ph-duotone ph-plus-circle"></i>
                                                        <span>Add account</span>
                                                    </span>
                                                </a>
                                                <a href="#" class="dropdown-item">
                                                    <span class="d-flex align-items-center">
                                                        <i class="ph-duotone ph-power"></i>
                                                        <span>Logout</span>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li> --}}
                    </ul>
                </div>

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user"
                            src="{{ asset('assets/images/avatar-dafault.png') }}" alt="Header Avatar">
                        <span class="d-none d-xl-inline-block ms-1" key="t-henry">
                            @if (auth()->user())
                                {{ auth()->user()->name }}
                            @endif
                        </span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <!-- <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                                      <a class="dropdown-item" href="#"><i class="bx bx-wallet font-size-16 align-middle me-1"></i> <span key="t-my-wallet">My Wallet</span></a> -->
                        @if (auth()->user())
                            <a class="dropdown-item d-block" href="{{ route('userEdit', auth()->user()->id) }}">
                                <!-- <span class="badge bg-success float-end">11</span> -->
                                <i class="bx bx-wrench font-size-16 align-middle me-1"></i>
                                <span key="t-settings">@lang('global.settings')</span>
                            </a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                        <a class="dropdown-item text-danger" href="#" role="button"
                            onclick="
                            event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                            <span key="t-logout">@lang('global.logout')</span>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        @include('layouts.sidebar')
        <!-- Left Sidebar End -->

        <div class="pc-container">
            <div class="pc-content">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Display error message -->
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Display validation errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
            <!-- End Page-content -->




        </div>
        <!-- end main content-->

        <footer class="pc-footer">
            <div class="footer-wrapper container-fluid">
                <div class="row">
                    <div class="col-sm-6 my-1">
                        <p class="m-0">Copyright &copy; {{ date('Y') }} by <a target="_blank"
                                href="https://teamdev.uz">Teamdev.uz</a></a></p>
                    </div>
                    <div class="col-sm-6 ms-auto my-1">
                        <ul class="list-inline footer-link mb-0 justify-content-sm-end d-flex">
                            {{-- <li class="list-inline-item"><a href="../index.html">Home</a></li>
                            <li class="list-inline-item"><a href="https://pcoded.gitbook.io/light-able/"
                                    target="_blank">Documentation</a></li> --}}
                            <li class="list-inline-item"><a href="tel:+998997906699" target="_blank">Support</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    {{-- new --}}
    <!-- [Page Specific JS] start -->
    <script src="{{ asset('assets/new/assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/new/assets/js/plugins/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/new/assets/js/plugins/world.js') }}"></script>
    <script src="{{ asset('assets/new/assets/js/plugins/world-merc.js') }}"></script>
    <script src="{{ asset('assets/new/assets/js/pages/dashboard-default.js') }}"></script>
    <!-- [Page Specific JS] end -->
    <!-- Required Js -->
    <script src="{{ asset('assets/new/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/new/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/new/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/new/assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/new/assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/new/assets/js/plugins/feather.min.js') }}"></script>


    <script>
        layout_change('light');
    </script>

    <script>
        layout_sidebar_change('light');
    </script>

    <script>
        change_box_container('false');
    </script>

    <script>
        layout_caption_change('true');
    </script>

    <script>
        layout_rtl_change('false');
    </script>

    <script>
        preset_change('preset-1');
    </script>


    <div class="offcanvas border-0 pct-offcanvas offcanvas-end" tabindex="-1" id="offcanvas_pc_layout">
        <div class="offcanvas-header justify-content-between">
            <h5 class="offcanvas-title">Settings</h5>
            <button type="button" class="btn btn-icon btn-link-danger" data-bs-dismiss="offcanvas"
                aria-label="Close"><i class="ti ti-x"></i></button>
        </div>
        <div class="pct-body customizer-body">
            <div class="offcanvas-body py-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="pc-dark">
                            <h6 class="mb-1">Theme Mode</h6>
                            <p class="text-muted text-sm">Choose light or dark mode or Auto</p>
                            <div class="row theme-color theme-layout">
                                <div class="col-4">
                                    <div class="d-grid">
                                        <button class="preset-btn btn active" data-value="true"
                                            onclick="layout_change('light');">
                                            <span class="btn-label">Light</span>
                                            <span
                                                class="pc-lay-icon"><span></span><span></span><span></span><span></span></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="d-grid">
                                        <button class="preset-btn btn" data-value="false"
                                            onclick="layout_change('dark');">
                                            <span class="btn-label">Dark</span>
                                            <span
                                                class="pc-lay-icon"><span></span><span></span><span></span><span></span></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="d-grid">
                                        <button class="preset-btn btn" data-value="default"
                                            onclick="layout_change_default();" data-bs-toggle="tooltip"
                                            title="Automatically sets the theme based on user's operating system's color scheme.">
                                            <span class="btn-label">Default</span>
                                            <span class="pc-lay-icon d-flex align-items-center justify-content-center">
                                                <i class="ph-duotone ph-cpu"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h6 class="mb-1">Sidebar Theme</h6>
                        <p class="text-muted text-sm">Choose Sidebar Theme</p>
                        <div class="row theme-color theme-sidebar-color">
                            <div class="col-6">
                                <div class="d-grid">
                                    <button class="preset-btn btn" data-value="true"
                                        onclick="layout_sidebar_change('dark');">
                                        <span class="btn-label">Dark</span>
                                        <span
                                            class="pc-lay-icon"><span></span><span></span><span></span><span></span></span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-grid">
                                    <button class="preset-btn btn active" data-value="false"
                                        onclick="layout_sidebar_change('light');">
                                        <span class="btn-label">Light</span>
                                        <span
                                            class="pc-lay-icon"><span></span><span></span><span></span><span></span></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h6 class="mb-1">Accent color</h6>
                        <p class="text-muted text-sm">Choose your primary theme color</p>
                        <div class="theme-color preset-color">
                            <a href="#!" class="active" data-value="preset-1"><i class="ti ti-check"></i></a>
                            <a href="#!" data-value="preset-2"><i class="ti ti-check"></i></a>
                            <a href="#!" data-value="preset-3"><i class="ti ti-check"></i></a>
                            <a href="#!" data-value="preset-4"><i class="ti ti-check"></i></a>
                            <a href="#!" data-value="preset-5"><i class="ti ti-check"></i></a>
                            <a href="#!" data-value="preset-6"><i class="ti ti-check"></i></a>
                            <a href="#!" data-value="preset-7"><i class="ti ti-check"></i></a>
                            <a href="#!" data-value="preset-8"><i class="ti ti-check"></i></a>
                            <a href="#!" data-value="preset-9"><i class="ti ti-check"></i></a>
                            <a href="#!" data-value="preset-10"><i class="ti ti-check"></i></a>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h6 class="mb-1">Sidebar Caption</h6>
                        <p class="text-muted text-sm">Sidebar Caption Hide/Show</p>
                        <div class="row theme-color theme-nav-caption">
                            <div class="col-6">
                                <div class="d-grid">
                                    <button class="preset-btn btn active" data-value="true"
                                        onclick="layout_caption_change('true');">
                                        <span class="btn-label">Caption Show</span>
                                        <span
                                            class="pc-lay-icon"><span></span><span></span><span><span></span><span></span></span><span></span></span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-grid">
                                    <button class="preset-btn btn" data-value="false"
                                        onclick="layout_caption_change('false');">
                                        <span class="btn-label">Caption Hide</span>
                                        <span
                                            class="pc-lay-icon"><span></span><span></span><span><span></span><span></span></span><span></span></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="pc-rtl">
                            <h6 class="mb-1">Theme Layout</h6>
                            <p class="text-muted text-sm">LTR/RTL</p>
                            <div class="row theme-color theme-direction">
                                <div class="col-6">
                                    <div class="d-grid">
                                        <button class="preset-btn btn active" data-value="false"
                                            onclick="layout_rtl_change('false');">
                                            <span class="btn-label">LTR</span>
                                            <span
                                                class="pc-lay-icon"><span></span><span></span><span></span><span></span></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-grid">
                                        <button class="preset-btn btn" data-value="true"
                                            onclick="layout_rtl_change('true');">
                                            <span class="btn-label">RTL</span>
                                            <span
                                                class="pc-lay-icon"><span></span><span></span><span></span><span></span></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item pc-box-width">
                        <div class="pc-container-width">
                            <h6 class="mb-1">Layout Width</h6>
                            <p class="text-muted text-sm">Choose Full or Container Layout</p>
                            <div class="row theme-color theme-container">
                                <div class="col-6">
                                    <div class="d-grid">
                                        <button class="preset-btn btn active" data-value="false"
                                            onclick="change_box_container('false')">
                                            <span class="btn-label">Full Width</span>
                                            <span
                                                class="pc-lay-icon"><span></span><span></span><span></span><span><span></span></span></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-grid">
                                        <button class="preset-btn btn" data-value="true"
                                            onclick="change_box_container('true')">
                                            <span class="btn-label">Fixed Width</span>
                                            <span
                                                class="pc-lay-icon"><span></span><span></span><span></span><span><span></span></span></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-grid">
                            <button class="btn btn-light-danger" id="layoutreset">Reset Layout</button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.phone2').inputmask('+998 (99) 999-99-99');

            $('#contact').on('focus', function() {
                if ($(this).val().startsWith('+998') === false) {
                    $(this).val('+998 ');
                }
            });

            $('#contact').on('input', function() {
                if ($(this).val().length > 14) {
                    $(this).val($(this).val().substring(0, 14));
                }
            });
        });
    </script>

    {{-- constructor --}}

    {{-- constructor end --}}

    <!-- JAVASCRIPT -->

    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script> --}}
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <!-- Required datatable js -->
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->
    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
    <!-- form advanced init -->
    <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ asset('assets/js/pages/job-list.init.js') }}"></script>
    <script src="{{ asset('assets/js/pages/job-list.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- bootstrap datepicker -->
    <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <!-- dropzone plugin -->
    <script src="{{ asset('assets/libs/dropzone/min/dropzone.min.js') }}"></script>

    {{-- <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>  --}}

    <script>
        $("#reset_form").on('click', function() {
            $('form :input').val('');
            $("form :input[class*='like-operator']").val('like');
            $("div[id*='_pair']").hide();
        });
    </script>

    <script>
        function togglePassword(inputId, toggleIconId) {
            var passwordInput = document.getElementById(inputId);
            var toggleIcon = document.getElementById(toggleIconId);

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("mdi-eye-outline");
                toggleIcon.classList.add("mdi-eye-off-outline");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("mdi-eye-off-outline");
                toggleIcon.classList.add("mdi-eye-outline");
            }
        }
    </script>
    @if (session('_message'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: "{{ session('_type') }}",
                title: "{{ session('_message') }}",
                showConfirmButton: false,
                timer: {{ session('_timer') ?? 5000 }}
            });
        </script>
        @php(message_clear())
    @endif

    
    @yield('scripts')

</body>
