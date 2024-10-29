@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Кўчалар</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #007bff;">@lang('global.home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('bankIndex') }}" style="color: #007bff;">Кўчалар</a></li>
                    <li class="breadcrumb-item active">@lang('global.add')</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-8 offset-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('global.add')</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form action="{{ route('bankCreate') }}" method="post">
                    @csrf

                    <div class="form-group">
                        <div class="row">
                       
                            <div class="col-12 col-lg-6 mb-2">
                                <label class="col-form-label">@lang('global.name_as') уз</label>

                                <input type="text" name="name" class="form-control" 
                                value="{{ old('name') }}" placeholder="Название " required>
                            </div>

                            <div class="col-12 col-lg-6 mb-2">
                                <label class="col-form-label">Код</label>

                                <input type="text" name="code" class="form-control" 
                                value="{{ old('code') }}" placeholder="Название " required>
                            </div>

                            <div class="col-12 col-lg-12 mb-2">
                                <label class="col-form-label">Коммент</label>

                                <input type="text" name="comment" class="form-control" 
                                value="{{ old('comment') }}" placeholder="Название " required>
                                
                            </div>
                        </div>
                        <div class="rows">
                            @include('inc.__address')

                        </div>
                    </div>

                    <div class="form-group ">
                        <button type="submit" class="btn btn-success waves-effect waves-light float-right">@lang('global.save')</button>
                        <a href="{{ route('bankIndex') }}" class="btn btn-light waves-effect float-left">@lang('global.cancel')</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection