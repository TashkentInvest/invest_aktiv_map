@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Банклар</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #007bff;">@lang('global.home')</a></li>
                    <li class="breadcrumb-item active">Банклар</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Банклар</h3>
                <a href="{{ route('bankAdd') }}" class="btn btn-sm btn-success waves-effect waves-light float-right">
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
                        <th>Номи</th>
                        <th>Код</th>
                        <th>Коммент</th>
                        <th>Manzil @lang('cruds.regions_districts.regions.name_uz')</th>
                        <th class="w-25">@lang('global.actions')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($banks as $bank)
                        <tr>
                            <td>{{ $bank->id }}</td>
                         
                            <td>{{ $bank->name }}</td>
                            <td>{{ $bank->code }}</td>
                            <td>{{ $bank->comment }}</td>
                            <td>
                                {{ $bank->substreet &&
                                    $bank->substreet->district &&
                                    $bank->substreet->district->region
                                        ? $bank->substreet->district->region->name_uz
                                        : 'N/A' }}
                                    {{ $bank->substreet && $bank->substreet->district
                                        ? $bank->substreet->district->name_uz
                                        : 'N/A' }}
                                    {{ $bank->substreet &&
                                    $bank->substreet->district &&
                                    $bank->substreet->district->street
                                        ? $bank->substreet->district->street->name
                                        : 'N/A' }}
                                    {{ $bank->substreet ? $bank->substreet->name : 'N/A' }}
                            </td>
                            
                            <td class="text-center">
                                <form action="{{ route('bankDestroy', $bank->id) }}" method="post">
                                    @csrf
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                        <a href="{{ route('bankEdit', $bank->id) }}" class="btn btn-primary">@lang('global.edit')</a>
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