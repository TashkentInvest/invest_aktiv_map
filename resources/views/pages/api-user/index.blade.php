@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">API-@lang('cruds.user.title')</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #007bff;">@lang('global.home')</a></li>
                    <li class="breadcrumb-item active">API-@lang('cruds.user.title')</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<!-- Main content -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('cruds.user.title_singular')</h3>
                @can('user.add')
                <a href="{{ route('api-userAdd') }}" class="btn btn-sm btn-success waves-effect waves-light float-right">
                    <span class="fas fa-plus-circle"></span>
                    @lang('global.add')
                </a>
                @endcan
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- Data table -->
                <table id="datatable" class="table table-bordered dt-responsive  w-100">
                    <thead>
                        <tr class="text-center">
                            <th>Username</th>
                            <th>Password</th>
                            <th>Valid period</th>
                            <th>Created by</th>
                            <th>Tokens</th>
                            <th>Activate</th>
                            <th style="width: 10px">@lang('global.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="text-center">
                            <td>
                                @can('passport.view')<i class="fa fa-eye" onmousedown="showPassword({{ $user->id }})" onmouseup="hidePassword({{ $user->id }})"></i>@endcan
                                {{ $user->name }}
                            </td>
                            <td>
                                <span style="display: block" id="hidden_{{ $user->id }}">*****</span>
                                @can('password.view')<span style="display: none" id="password_{{ $user->id }}">{{ $user->password }}</span>@endcan
                            </td>
                            <td>{{ $user->token_valid_period }}</td>
                            <td>{{ $user->creator->name ?? '-' }}</td>
                            <td>{{ $user->tokens->count() ?? 0 }}</td>
                            <td class="text-center">
                                <i style="cursor: pointer" id="api_user_{{ $user->id }}" class="fas {{ $user->is_active ? "fa-check-circle text-success":"fa-times-circle text-danger" }}" @can('api-user.edit') onclick="toggle_api_user({{ $user->id }})" @endcan></i>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('api-userDestroy',$user->id) }}" method="post">
                                    @csrf
                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                        @can('api-user.edit')
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('global.details')">
                                            <a href="{{ route('api-userShow',$user->id) }}" class="btn btn-soft-primary">
                                            <i class="bx bxs-show" style="font-size:16px;"></i>
                                            </a>
                                        </li>
                                        @endcan
                                        @can('api-user.edit')
                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('global.edit')">
                                                <a href="{{ route('api-userEdit',$user->id) }}" class="btn btn-soft-info">
                                                    <i class="bx bxs-edit" style="font-size:16px;"></i>
                                                </a>
                                            </li>
                                        @endcan
                                        <input name="_method" type="hidden" value="DELETE">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('global.delete')">
                                            <button  onclick="if (confirm('Вы уверены?')) { this.form.submit() }" type="button" data-bs-toggle="modal" class="btn btn-soft-danger">
                                                <i class="bx bxs-trash" style="font-size: 16px;"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.content -->
@endsection
@section('scripts')
<script>
    function showPassword(id) {
        $("#hidden_" + id).hide();
        $("#password_" + id).show();
    }

    function hidePassword(id) {
        $("#hidden_" + id).show();
        $("#password_" + id).hide();
    }

    function toggle_api_user(id) {
        $.ajax({
            url: "/api/api-user/toggle-status/" + id,
            type: "POST",
            data: {
                _token: '{!! auth()->user()->password !!}'
            },
            success: function(result) {
                if (result.is_active == 1) {
                    $("#api_user_" + id).attr('class', "fas fa-check-circle text-success");
                } else {
                    $("#api_user_" + id).attr('class', "fas fa-times-circle text-danger");
                }
            },
            error: function(errorMessage) {
                console.log(errorMessage)
            }
        });
    }
</script>
@endsection