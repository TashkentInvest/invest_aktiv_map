@extends('layouts.app')

@section('content')
    <div class="container-fluid h-100 d-flex justify-content-center align-items-center">
        <div class="col-md-8 col-lg-6 col-xl-4">
            <div class="card shadow-lg border-0 rounded-5 mt-3 overflow-hidden">
                <div class="card-header bg-gradient text-white text-center py-3 position-relative"
                    style="background: linear-gradient(135deg, #0057b8, #1d75e2);">
                    <div class="row justify-content-center mb-4">
                        <div class="col-12 text-center">
                            <img src="https://toshkentinvest.uz/assets/frontend/tild6238-3031-4265-a564-343037346231/tic_logo_blue.png"
                                alt="ToshkentInvest Logo" class="img-fluid" style="max-width: 220px; height: auto; object-fit: contain;">
                        </div>
                    </div>
                    <h3 class="fw-bold text-white mb-3" style="font-size: 1.8rem; text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.3);color:#0057b8 !important">Хуш келибсиз, илтимос, шахсий кабинетингизга киринг.</h3>
                    <div class="position-absolute top-0 end-0 mt-3 me-3">
                        {{-- <a href="{{ route('home') }}">
                            <img src="https://api-portal.gov.uz/uploads/b7824a9f-ebbc-80ea-06df-4dada0642929_media_.png"
                                alt="Uzbekistan Emblem" class="img-fluid" style="max-height: 60px;">
                        </a> --}}
                    </div>
                </div>
                <div class="card-body bg-white rounded-bottom-5 p-5">

                    <form method="POST" action="{{ route('login') }}" class="px-1">
                        @csrf
                        <div class="form-floating mb-4">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                placeholder="Электрон почта" style="height: 50px; font-size: 1rem;">
                            <label for="email">Электрон почта</label>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-4 position-relative">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password" placeholder="Пароль" style="height: 50px; font-size: 1rem;">
                            <label for="password">Пароль</label>
                            <button class="btn btn-outline-secondary position-absolute end-0 top-50 translate-middle-y me-3"
                                type="button" id="togglePassword" style="border-radius: 30px; background-color: #ffffff;">
                                <i class="mdi mdi-eye-outline"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="remember-check" name="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember-check">
                                Эслаб қолиш
                            </label>
                        </div>
                        <div class="d-grid gap-3">
                            <button class="btn btn-primary btn-lg" type="submit">Кириш</button>
                        </div>
                        {{-- @if (Route::has('password.request'))
                            <div class="text-center mt-3">
                                <a href="{{ route('password.request') }}" class="text-muted">@lang('global.forgot_password')</a>
                            </div>
                        @endif --}}
                        @guest
                            @if (Route::has('register'))
                                <div class="text-center mt-3">
                                    <p>@lang('global.login_registr') <a href="{{ route('register') }}"
                                            class="fw-medium text-primary">@lang('global.register')</a></p>
                                </div>
                            @endif
                        @endguest
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
        });
    </script>

    <style>
        body{
            overflow: hidden !important;
        }
    </style>
@endsection
