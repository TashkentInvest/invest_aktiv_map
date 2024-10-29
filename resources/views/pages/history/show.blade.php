@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">@lang('cruds.history.title')</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #007bff;">@lang('global.home')</a></li>
                    <li class="breadcrumb-item active">@lang('cruds.history.title')</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('Client Information')</h3>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <strong>@lang('ID'):</strong> {{ $client->id }}<br>
                    <strong>@lang('Name'):</strong> {{ $client->first_name }} {{ $client->last_name }}
                </div>

                @foreach ([
                    'clientHistories' => 'Client Histories',
                    'fileHistories' => 'File Histories',
                    'addressHistories' => 'Address Histories',
                    'passportHistories' => 'Passport Histories',
                    'companyHistories' => 'Company Histories',
                    'branchHistories' => 'Branch Histories',
                ] as $historyKey => $historyTitle)
                    @if ($$historyKey->isNotEmpty())
                        <div class="mb-4">
                            <h4 class="mb-3 font-size-16">{{ $historyTitle }}</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 25%;">@lang('Changed By')</th>
                                            <th style="width: 50%;">@lang('Old Value')</th>
                                            <th style="width: 25%;">@lang('Timestamp')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $previousHistory = null;
                                        @endphp
                                        @foreach ($$historyKey as $history)
                                            <tr>
                                                <td>{{ $history->user_id ? App\Models\User::find($history->user_id)->name ?? 'Unknown User' : 'Unknown User' }}</td>
                                                <td>
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach ($history->getAttributes() as $key => $value)
                                                            @php
                                                                $changedClass = '';
                                                                if ($previousHistory && $previousHistory->$key !== $history->$key) {
                                                                    $changedClass = 'font-weight-bold text-danger';
                                                                }
                                                            @endphp
                                                            <li class="{{ $changedClass }}">
                                                                <strong>{{ $key }}:</strong>
                                                                {{ $value }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>{{ $history->created_at }}</td>
                                            </tr>
                                            @php
                                                $previousHistory = $history;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- Pagination links --}}
                                <div class="d-flex justify-content-center">
                                    {{ $$historyKey->links() }}
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-muted">No {{ $historyTitle }} found.</p>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0,0,0,.05);
    }

    .font-weight-bold {
        font-weight: bold; 
    }

    .text-danger {
        color: #dc3545; 
    }
</style>

@endsection
