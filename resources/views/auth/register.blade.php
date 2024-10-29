@extends('layouts.app')

@section('content')
<div class="col-md-8 col-lg-6 col-xl-5">
    <div class="card overflow-hidden">
        <div class="bg-primary bg-soft">
            <div class="row">
                <div class="col-7">
                    <div class="text-primary p-4">
                        <h5 class="text-primary">@lang('global.register')</h5>
                        <p>@lang('global.register_desc')</p>
                    </div>
                </div>
                <div class="col-5 align-self-end">
                    <img src="{{ asset('assets/images/profile-img.png') }}" alt="" class="img-fluid">
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div>
                <a href="{{ route('home') }}">
                    <div class="avatar-md profile-user-wid mb-4">
                        <span class="avatar-title rounded-circle bg-light">
                            <img src="{{ asset('assets/images/logo.svg') }}" alt="" class="rounded-circle" height="34">
                        </span>
                    </div>
                </a>
            </div>
            <div class="p-2">
                <form class="needs-validation" novalidate method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">@lang('global.first_name') @lang('global.last_name')</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="@lang('global.first_name') @lang('global.last_name')">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="useremail" class="form-label">@lang('global.login_email')</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="useremail" placeholder="@lang('global.login_email')" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">@lang('global.login_password')</label>
                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="@lang('global.login_password')" name="password" required autocomplete="new-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">@lang('global.login_password_confirmation')</label>
                        <input type="password" id="password-confirm" class="form-control" placeholder="@lang('global.login_password_confirmation')" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="mt-4 d-grid">
                        <button class="btn btn-primary waves-effect waves-light" type="submit">@lang('global.register')</button>
                    </div>

                    @guest
                        <div class="mt-4 text-center">
                            <p>@lang('global.login_desc') <a href="{{ route('login') }}" class="fw-medium text-primary">@lang('global.login')</a> </p>
                            <!-- <p class="mb-0">By registering you agree to the Skote <a href="#" class="text-primary">Terms of Use</a></p>
                            <p>© <script>
                                document.write(new Date().getFullYear())
                            </script> Skote. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p> -->
                        </div>
                    @endguest
                </form>
            </div>

        </div>
    </div>
</div>
@endsection