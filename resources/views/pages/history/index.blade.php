


@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">@lang('cruds.history.title')</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #007bff;">@lang('global.home')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('cruds.history.title')</li>
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
                                <th scope="col">Client ID</th>
                                <th scope="col">Company</th>
                                <th scope="col">INN</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Address</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clientHistories as $client)
                            <tr>
                                <td>{{ $client->id }}</td>
                                @if ($client->mijoz_turi == 'fizik')
                                    <td>{{ $client->last_name }} {{ $client->first_name }} {{ $client->father_name }}</td>
                                @else
                                    <td>{{ $client->company->company_name ?? '' }} </td>
                                @endif
                                <td>{{ $client->company->stir }}</td>
                                <td>{{ $client->last_name }}</td>
                                <td>{{ $client->contact }}</td>
                                @if ($client->mijoz_turi == 'fizik')
                                    <td>{{ $client->address->home_address ?? '' }}</td>
                                @else
                                    <td>{{ $client->address->yuridik_address ?? '' }} </td>
                                @endif
                                <td>
                                    <a href="{{ route('history.show', $client->id) }}" class="btn btn-primary btn-sm">View Details</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex">

                        {!! $clientHistories->links() !!}

                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
