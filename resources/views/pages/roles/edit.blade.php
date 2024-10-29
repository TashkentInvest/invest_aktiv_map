@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/libs/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">@lang('cruds.role.title')</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #007bff;">@lang('global.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('roleIndex') }}" style="color: #007bff;">@lang('cruds.role.title')</a></li>
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

                    <form action="{{ route('roleUpdate',$role->id) }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="col-md-2 col-form-label">@lang('cruds.role.fields.name')</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" placeholder="@lang('cruds.role.fields.name')" value="{{ old('name',$role->name) }}" required>
                            @if($errors->has('name') || 1)
                                <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <select multiple="multiple" name="permissions[]" size="30" class="duallistbox" aria-multiselectable="true">
                                @foreach($permissions as $permission)
                                    <option value="{{ $permission->name }}" {{ ($role->hasPermissionTo($permission->name)) ? "selected":'' }}>{{ $permission->name   }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="col-md-2 col-form-label">@lang('cruds.role.fields.title')</label>
                            <input class="form-control" name="title" type="text" id="title" placeholder="@lang('cruds.role.fields.title')" value="{{ old('title',$role->title) }}">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success waves-effect waves-light float-right">@lang('global.save')</button>
                            <a href="{{ route('roleIndex') }}" class="btn btn-light waves-effect float-left">@lang('global.cancel')</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
<script src="{{ asset('assets/libs/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
<script>
    var demo2 = $('.duallistbox').bootstrapDualListbox({
        nonSelectedListLabel: 'Не разрешено',
        selectedListLabel: 'Разрешено',
        preserveSelectionOnMove: 'moved',
        moveOnSelect: true,
    });
</script>
@endsection