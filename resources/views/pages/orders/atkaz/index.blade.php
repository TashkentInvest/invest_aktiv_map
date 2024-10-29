@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Order Atkaz</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #007bff;">@lang('global.home')</a>
                        </li>
                        <li class="breadcrumb-item active">Order Atkaz</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Order Atkaz</h3>
                    <a href="{{ route('orderAtkazAdd') }}"
                        class="btn btn-sm btn-success waves-effect waves-light float-right">
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
                                <th>Номи ru</th>
                                <th>Коммент</th>
                                <th>Статус</th>
                                <th class="w-25">@lang('global.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderAtkaz as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>

                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->name_ru }}</td>
                                    <td>{{ $item->comment }}</td>
                                    <td>
                                        @if ($item->status == 1)
                                            Ariza
                                        @elseif ($item->status == 2)
                                            Shartnoma
                                        @else
                                            N/A
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <form action="{{ route('orderAtkazDestroy', $item->id) }}" method="post">
                                            @csrf
                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                <a href="{{ route('orderAtkazEdit', $item->id) }}"
                                                    class="btn btn-primary">@lang('global.edit')</a>
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
