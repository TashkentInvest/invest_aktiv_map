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
                    <li class="breadcrumb-item active">@lang('cruds.regions_districts.districts.title')</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('cruds.regions_districts.regions.title')</h3>
                <a href="{{ route('districtAdd') }}" class="btn btn-sm btn-success waves-effect waves-light float-right">
                    <span class="fas fa-plus-circle"></span>
                    @lang('global.add')
                </a>
            </div>
            <div class="card-body">
                <!-- Data table -->
                <table id="datatable" class="table table-bordered dt-responsive  w-100">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>@lang('cruds.regions_districts.regions.name_uz')</th>
                        <th>@lang('cruds.regions_districts.regions.name_ru')</th>
                        <th>@lang('cruds.regions_districts.regions.name_uz')</th>
                        <th>@lang('cruds.regions_districts.regions.name_ru')</th>
                        <th>Code</th>
                        <th class="w-25">@lang('global.actions')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($districts as $district)
                        <tr>
                            <td>{{ $district->id }}</td>
                            <td>{{ $district->name_uz }}</td>
                            <td>{{ $district->name_ru }}</td>
                            <td>{{ $district->region->name_uz }}</td>
                            <td>{{ $district->region->name_ru }}</td>
                            <td>{{ $district->code }}</td>
                            <td class="text-center">
                                <form action="{{ route('districtDestroy', $district->id) }}" method="post">
                                    @csrf
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                        <a href="{{ route('districtEdit', $district->id) }}" class="btn btn-primary">@lang('global.edit')</a>
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button onclick="if (confirm('Вы уверены?')) { this.form.submit() }" 
                                            type="button" class="btn btn-danger">@lang('global.delete')</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection