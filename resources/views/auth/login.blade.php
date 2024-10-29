@extends('layouts.app')

@section('content')
<div class="col-md-8 col-lg-6 col-xl-5">
    <div class="card overflow-hidden">
        <div class="bg-primary bg-soft">
            <div class="row">
                <div class="col-7">
                    <div class="text-primary p-4">
                        <h5 class="text-primary">@lang('global.login')</h5>
                        <p>@lang('global.login_desc_wel')</p>
                    </div>
                </div>
                <div class="col-5 align-self-end">
                    <img src="{{ asset('assets/images/profile-img.png') }}" alt="" class="img-fluid">
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="auth-logo">
                <a href="{{ route('home') }}" class="auth-logo-dark">
                    <div class="avatar-md profile-user-wid mb-4">
                        <span class="avatar-title rounded-circle bg-light">
                            <img src="{{ asset('assets/images/logo.svg') }}" alt="" class="rounded-circle" height="34">
                        </span>
                    </div>
                </a>
            </div>
            <div class="p-2">
                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">@lang('global.login_email')</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="@lang('global.login_email')">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">@lang('global.login_password')</label>
                        <div class="input-group auth-pass-inputgroup">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="@lang('global.login_password')" aria-label="Password" aria-describedby="password-addon">
                            <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember-check" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember-check">
                            @lang('global.remember_me')
                        </label>
                    </div>

                    <div class="mt-3 d-grid">
                        <button class="btn btn-primary waves-effect waves-light" type="submit">@lang('global.login')</button>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="mt-4 text-center">
                            <a href="{{ route('password.request') }}" class="text-muted"><i class="mdi mdi-lock me-1"></i> @lang('global.forgot_password')</a>
                        </div>
                    @endif
                    @guest
                        @if (Route::has('register'))
                        <div class="mt-2 text-center">
                            <p>@lang('global.login_registr') <a href="{{ route('register') }}" class="fw-medium text-primary"> @lang('global.register') </a> </p>
                        </div>
                        @endif
                    @endguest
                </form>
            </div>

        </div>
    </div>
</div>
@endsection