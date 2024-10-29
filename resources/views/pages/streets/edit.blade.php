@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">@lang('cruds.regions_districts.districts.title')</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #007bff;">@lang('global.home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('streetIndex') }}" style="color: #007bff;">@lang('cruds.regions_districts.districts.title')</a></li>
                    <li class="breadcrumb-item active">@lang('global.edit')</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<!-- Main content -->
<div class="row">
    <div class="col-8 offset-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('global.edit')</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form action="{{ route('streetUpdate', $street->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-lg-12 mb-2">
                                <label class="col-form-label">@lang('cruds.regions_districts.districts.title')</label>
                                <select class="form-control select2" style="width: 100%;" name="district_id" required>
                                    <option value="" disabled selected>@lang('cruds.regions_districts.districts.select_region')</option>
                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}" {{ $district->id == old('district_id', $street->district_id ?? '') ? 'selected' : '' }}>{{ $district->name_uz }}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                          
                            <div class="col-12 col-lg-6 mb-2">
                                <label class="col-form-label">@lang('global.name_as') уз</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') ?? $street->name }}" placeholder="Название" required>
                            </div>
                            <div class="col-12 col-lg-6 mb-2">
                                <label class="col-form-label">@lang('global.name_as') ру</label>

                                <input type="text" name="name_ru" class="form-control" 
                                value="{{ old('name_ru',  $street->name_ru ?? '') }}" placeholder="Название " required>
                            </div>
                            {{--  --}}
                            <div class="col-12 col-lg-6 mb-2">
                                <label class="col-form-label">Тури</label>

                                <input type="text" name="type" class="form-control" 
                                value="{{ old('type',$street->type ?? '') }}" placeholder="Название " required>
                            </div>

                            <div class="col-12 col-lg-6 mb-2">
                                <label class="col-form-label">Код</label>

                                <input type="text" name="code" class="form-control" 
                                value="{{ old('code', $street->code ?? '') }}" placeholder="Название " required>
                            </div>

                            <div class="col-12 col-lg-12 mb-2">
                                <label class="col-form-label">Коммент</label>

                                <input type="text" name="comment" class="form-control" 
                                value="{{ old('comment', $street->comment ?? '') }}" placeholder="Название " required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <button type="submit" class="btn btn-success waves-effect waves-light float-right">@lang('global.save')</button>
                        <a href="{{ route('streetIndex') }}" class="btn btn-light waves-effect float-left">@lang('global.cancel')</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
