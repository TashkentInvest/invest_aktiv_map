@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">@lang('cruds.transaction.title')</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #007bff;">@lang('global.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('transactions.payers') }}" style="color: #007bff;">@lang('cruds.transaction.title')</a></li>
                        <li class="breadcrumb-item active">@lang('global.add')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 card-title flex-grow-1">@lang('cruds.transaction.fields.payers')</h5>
                        <div class="flex-shrink-0">
                            <a href="{{ route('import') }}" class="btn btn-primary">@lang('global.import_data')</a>
                        </div>
                    </div>
                </div>
                <div class="card-body border-bottom">
                    <form action="{{ route('transactions.payers') }}" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="@lang('global.search')" name="search" value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">@lang('global.search')</button>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">@lang('global.company_name')</th>
                                    <th scope="col" style="width: 200px;">Назначение платежа</th>
                                    <th scope="col">Дата платежа</th>
                                    <th scope="col">Инн</th>
                                    <th scope="col">@lang('cruds.transaction.fields.credit')</th>
                                    <th scope="col">@lang('global.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->company_name ?? '' }}</td>
                                        <td style="width: 200px;">{{ $transaction->payment_description ?? '' }}</td>
                                        <td>{{ $transaction->payment_date ?? '' }}</td>
                                        <td>{{ $transaction->payer_inn ?? '' }}</td>
                                        <td>{{ $transaction->credit ?? '' }}</td>
                                        <td>
                                            <ul class="list-unstyled hstack gap-1 mb-0">
                                                <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="View">
                                                    <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-sm btn-soft-primary">
                                                        <i class="mdi mdi-eye-outline"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex" style="justify-content: space-between">
                        {{ $transactions->appends(['search' => request()->input('search')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }

        .table th {
            background-color: #f8f9fa;
        }

        .btn-soft-primary {
            background-color: #d1e7dd;
            border-color: #badbcc;
            color: #0f5132;
        }

        .btn-soft-primary:hover {
            background-color: #badbcc;
            border-color: #a5cfbb;
            color: #0f5132;
        }

        .card-body.border-bottom {
            border-bottom: 1px solid #e9ecef !important;
        }
    </style>
@endpush
