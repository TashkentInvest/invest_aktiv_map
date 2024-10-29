@extends('layouts.app')

@section('content')
<div class="col-md-8 col-lg-6 col-xl-5">
    <div class="card overflow-hidden">
        <div class="bg-primary bg-soft">
            <div class="row">
                <div class="col-7">
                    <div class="text-primary p-4">
                        <h5 class="text-primary"> {{ __('Reset Password') }}</h5>
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
                @if (session('status'))
                    <div class="alert alert-success text-center mb-4" role="alert">
                    {{ session('status') }}
                    </div>
                @endif
                <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="useremail" class="form-label">{{ __('E-Mail Address') }}</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="useremail" name="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">{{ __('Send Password Reset Link') }}</button>
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