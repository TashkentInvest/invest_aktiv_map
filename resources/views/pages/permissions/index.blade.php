@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">@lang('cruds.permission.title')</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #007bff;">@lang('global.home')</a></li>
                    <li class="breadcrumb-item active">@lang('cruds.permission.title')</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<!-- Main content -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('cruds.permission.title_singular')</h3>
                @can('permission.add')
                <a href="{{ route('permissionAdd') }}" class="btn btn-sm btn-success waves-effect waves-light float-right">
                    <span class="fas fa-plus-circle"></span>
                    @lang('global.add')
                </a>
                @endcan
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                        <tr>
                            <th>@lang('cruds.permission.fields.id')</th>
                            <th>@lang('cruds.permission.fields.name')</th>
                            <th>@lang('cruds.permission.fields.title')</th>
                            <th>@lang('cruds.permission.fields.roles')</th>
                            <th class="w-25">@lang('global.actions')</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $permission->id }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->title }}</td>
                            <td>
                                @foreach($permission->roles as $role)
                                <span class="badge badge-soft-success">{{ $role->name }} </span>
                                @endforeach
                            </td>
                            <td class="text-center">
                                @can('permission.delete')
                                <form action="{{ route('permissionDestroy',$permission->id) }}" method="post">
                                    @csrf
                                    <div class="btn-group">
                                        @can('permission.edit')
                                        <a href="{{ route('permissionEdit',$permission->id) }}" type="button" class="btn btn-sm btn-info waves-effect waves-light"> @lang('global.edit')</a>
                                        @endcan
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button type="button" class="btn btn-danger waves-effect btn-sm waves-light" onclick="if (confirm('Вы уверены?')) {this.form.submit()}"> @lang('global.delete')</button>
                                    </div>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.content -->
@endsection