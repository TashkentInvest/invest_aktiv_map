@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">API @lang('cruds.userManagement.title')</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #007bff;">@lang('global.home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('api-userIndex') }}" style="color: #007bff;">API @lang('cruds.user.title')</a></li>
                    <li class="breadcrumb-item active">@lang('global.edit')</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- Main content -->

<div class="row">
    <div class="col-lg-8 offset-lg-2 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('global.edit')</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <form action="{{ route('api-userUpdate',$user->id) }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="col-form-label">Имя пользователя</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" placeholder="Имя пользователя" value="{{ old('name',$user->name) }}" required>
                        @if($errors->has('name'))
                            <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="token_valid_period" class="col-form-label">Срок действия токена</label>
                        <input class="form-control {{ $errors->has('token_valid_period') ? 'is-invalid':'' }}" type="number" max="999999" min="1" name="token_valid_period" id="token_valid_period" placeholder="Срок действия токена" value="{{ old('token_valid_period',$user->token_valid_period) }}">
                        @if($errors->has('token_valid_period'))
                            <span class="error invalid-feedback">{{ $errors->first('token_valid_period') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">@lang('cruds.user.fields.password')</label>
                        <div class="input-group auth-pass-inputgroup">
                            <input id="password" type="password" class="form-control {{ $errors->has('password') ? 'is-invalid': '' }}" name="password" required placeholder="@lang('cruds.user.fields.password')" aria-label="Password" aria-describedby="password-addon">
                            <button class="btn btn-light " type="button" onclick="togglePassword('password', 'toggle-icon-1')">
                                <i id="toggle-icon-1" class="mdi mdi-eye-outline"></i>
                            </button>
                        </div>
                        @if($errors->has('password'))
                            <span class="error invalid-feedback">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">@lang('global.login_password_confirmation')</label>
                        <div class="input-group auth-pass-inputgroup">
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="@lang('global.login_password_confirmation')" aria-label="Password" aria-describedby="password-addon">
                            <button class="btn btn-light " type="button" onclick="togglePassword('password_confirmation', 'toggle-icon-2')">
                                <i id="toggle-icon-2" class="mdi mdi-eye-outline"></i>
                            </button>
                        </div>
                        @if($errors->has('password_confirmation'))
                            <span class="error invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success waves-effect waves-light float-right">@lang('global.save')</button>
                        <a href="{{ route('api-userIndex') }}" class="btn btn-light waves-effect float-left">@lang('global.cancel')</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection