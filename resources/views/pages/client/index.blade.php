@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">@lang('cruds.client.title')</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #007bff;">@lang('global.home')</a></li>
                    <li class="breadcrumb-item active">@lang('cruds.client.title')</li>
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
                <h3 class="card-title">@lang('cruds.client.title_singular')</h3>
                @can('client.add')
                <a href="{{ route('clientAdd') }}" class="btn btn-success waves-effect waves-light float-right">
                    <span class="fas fa-plus-circle"></span>
                    @lang('global.add')
                </a>
                @endcan
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- Data table -->
                <table id="datatable" class="table table-bordered  w-100">
                    <thead>
                        <tr>
                            <th>@lang('cruds.client.fields.id')</th>
                            <th>@lang('cruds.client.fields.first_name')</th>
                            <th>@lang('cruds.client.fields.contact')</th>
                            <th class="w-25">@lang('global.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @dump($clients) --}}
                        @foreach($clients as $client)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $client->first_name }}</td>
                            <td>{{ $client->contact }}</td>
                            <td class="text-center">
                                @can('client.delete')
                                <form action="{{ route('clientDestroy',$client->id) }}" method="post">
                                    @csrf
                                    <div class="btn-group">
                                        @can('client.edit')
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal_{{ $client->id }}" class="btn btn-success btn-sm">
                                            {{-- <i class="bx bxs-show" style="font-size:16px;"></i> --}}
                                            @lang('global.view')
                                        </button>
                                        <a href="{{ route('clientFizikEdit',$client->id) }}" type="button" class="btn btn-sm btn-info waves-effect waves-light"> @lang('global.edit')</a>
                                        @endcan
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" onclick="if (confirm('Вы уверены?')) { this.form.submit() } "> @lang('global.delete')</button>
                                       
                                    </div>
                                </form>

                                <div class="modal fade" id="exampleModal_{{ $client->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ $client->{'name_' . $locale } }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-start">@lang('cruds.client.fields.first_name'):</td>
                                                            <td>
                                                                <b>{{ $client->first_name }}</b>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-start">@lang('cruds.client.fields.last_name'):</td>
                                                            <td>
                                                                <b>{{ $client->last_name }}</b>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-start">@lang('cruds.client.fields.father_name'):</td>
                                                            <td>
                                                                <b>{{ $client->father_name }}</b>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-start">@lang('cruds.client.fields.contact'):</td>
                                                            <td>
                                                                <b>{{ $client->contact }}</b>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-start">@lang('cruds.client.fields.passport_serial'):</td>
                                                            <td>
                                                                <b>{{ $client->passport_serial }}</b>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-start">@lang('cruds.client.fields.passport_pinfl'):</td>
                                                            <td>
                                                                <b>{{ $client->passport_pinfl }}</b>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-start">@lang('cruds.client.fields.yuridik_address'):</td>
                                                            <td>
                                                                <b>{{ $client->yuridik_address }}</b>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-start">@lang('cruds.client.fields.yuridik_rekvizid'):</td>
                                                            <td>
                                                                <b>{{ $client->yuridik_rekvizid }}</b>
                                                            </td>
                                                        </tr>
                                                        {{-- <tr>
                                                            <td class="text-start">@lang('cruds.client.fields.region_id'):</td>
                                                            <td>
                                                                <b>{{ $client->region->{'name_' . $locale } }}</b>
                                                            </td>
                                                        </tr> --}}

                                                        <tr>
                                                            <td colspan="2">@lang('cruds.client.fields.description_uz'):</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                @if(!is_null($client->text_uz))
                                                                    <b>{{ $client->text_uz }}</b>
                                                                @else
                                                                    @lang('global.empty')
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">@lang('cruds.client.fields.description_ru'):</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                @if(!is_null($client->text_ru))
                                                                    <b>{{ $client->text_uz }}</b>
                                                                @else
                                                                    @lang('global.empty')
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('global.closed')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endcan
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
<!-- /.row -->
<!-- /.content -->
@endsection