@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">@lang('cruds.history.title') - 103 </h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #007bff;">@lang('global.home')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('cruds.history.title') - 103 </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card-body {
            overflow-x: scroll !important;
        }

        .highlight-diff {
            background-color: #ffdddd;
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('cruds.history.title')</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">@lang('global.id')</th>
                                <th scope="col">@lang('cruds.user.title')</th>
                                <th scope="col">@lang('cruds.company.title')</th>
                                <th scope="col">@lang('cruds.company.fields.stir')</th>
                                <th scope="col">@lang('global.contact')</th>
                                <th scope="col">@lang('global.created_at')</th>
                                <th>@lang('global.status')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($confirmations as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td style="font-weight: bold; color: #007bff;">
                                        {{ $item->user->name }} | <span style="font-weight: normal; color: #6c757d;">{{ $item->user->email }}</span>
                                    </td>

                                    @if ($item->client->type == 'fizik')
                                        <td>{{ $item->client->last_name }} {{ $item->client->first_name }} {{ $item->client->father_name }}</td>
                                    @else
                                        <td>{{ $item->client->company->company_name ?? '' }}</td>
                                    @endif
                                    
                                    <td>{{ $item->client->company->stir ?? '' }}</td>
                                    <td>{{ $item->client->contact }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <button
                                            class="btn btn-sm text-light rounded {{ $item->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $item->status == 1 ? 'Confirmed' : 'Not confirmed' }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex">
                        {!! $confirmations->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
