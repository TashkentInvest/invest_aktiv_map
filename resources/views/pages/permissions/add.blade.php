@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">@lang('cruds.permission.title')</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #007bff;">@lang('global.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('permissionIndex') }}" style="color: #007bff;">@lang('cruds.permission.title')</a></li>
                        <li class="breadcrumb-item active">@lang('global.add')</li>
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
                    <h3 class="card-title">@lang('global.add')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <form action="{{ route('permissionCreate') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="col-md-2 col-form-label">@lang('cruds.permission.fields.name')</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" placeholder="@lang('cruds.permission.fields.name')" value="{{ old('name') }}" required>
                            @if($errors->has('name') || 1)
                                <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="title" class="col-md-2 col-form-label">@lang('cruds.permission.fields.title')</label>
                            <input class="form-control" name="title" type="text" id="title" placeholder="@lang('cruds.permission.fields.title')" value="{{ old('title') }}">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success waves-effect waves-light float-right">@lang('global.save')</button>
                            <a href="{{ route('permissionIndex') }}" class="btn btn-light waves-effect float-left">@lang('global.cancel')</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
