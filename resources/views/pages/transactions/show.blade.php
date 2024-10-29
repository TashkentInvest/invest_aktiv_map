@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">@lang('cruds.transaction.fields.show')</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #007bff;">@lang('global.home')</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('transactions.index') }}"
                                style="color: #007bff;">@lang('cruds.transaction.fields.show')</a></li>
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
                        <h5 class="mb-0 card-title flex-grow-1">@lang('cruds.transaction.fields.show')</h5>
                        <div class="flex-shrink-0">
                            <a href="{{ route('import') }}" class="btn btn-primary">@lang('global.import_data')</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <tbody>
                                <tr>
                                    <th scope="row">№ Док</th>
                                    <td colspan="2">{{ $transaction->document_number }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">ВО</th>
                                    <td colspan="2">{{ $transaction->operation_code }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Наименование получателя</th>
                                    <td colspan="2">{{ $transaction->recipient_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Инн</th>
                                    <td colspan="2">{{ $transaction->recipient_inn }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">МФО</th>
                                    <td colspan="2">{{ $transaction->recipient_mfo }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Расчетный счет</th>
                                    <td colspan="2">{{ $transaction->recipient_account }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Дата платежа</th>
                                    <td colspan="2">{{ $transaction->payment_date }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Назначение платежа</th>
                                    <td colspan="2">{{ $transaction->payment_description }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Дебит</th>
                                    <td colspan="2">{{ $transaction->debit }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Кредит</th>
                                    <td colspan="2">{{ $transaction->credit }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Наименование плательщика</th>
                                    <td colspan="2">{{ $transaction->payer_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Инн</th>
                                    <td colspan="2">{{ $transaction->payer_inn }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">МФО</th>
                                    <td colspan="2">{{ $transaction->payer_mfo }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Банк плательщика</th>
                                    <td colspan="2">{{ $transaction->payer_bank }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Расчетный счет</th>
                                    <td colspan="2">{{ $transaction->payer_account }}</td>
                                </tr>

                                @if (isset($payerUser))
                                    @if ($payerUser->payer_inn == $payerUser->stir)
                                        <tr>
                                            <th>@lang('global.company_name')</td>
                                            <td>{{ $payerUser->company_name }}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('cruds.client.fields.mijoz_turi')</th>
                                            @if ($payerUser->mijoz_turi == 'fizik')
                                                <td>@lang('cruds.client.fields.mijoz_turi_fizik')</td>
                                            @else
                                                <td> @lang('cruds.client.fields.mijoz_turi_yuridik')</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th>@lang('global.fio')</th>
                                            <td>{{ $payerUser->last_name }} {{ $payerUser->first_name }} {{ $payerUser->father_name }}</td>
                                        </tr>
                        
                                        <tr>
                                            <th>@lang('global.contact')</th>
                                            <td>{{ $payerUser->contact }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('global.inn')</th>
                                            <td>{{ $payerUser->stir }}</td>
                                        </tr>
                                    @endif
                                @endif
                                <tr>
                                    <th scope="row">@lang('global.created_at')</th>
                                    <td colspan="2">{{ $transaction->created_at }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">@lang('global.updated_at')</th>
                                    <td colspan="2">{{ $transaction->updated_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--end row-->
                </div>
            </div><!--end card-->
        </div><!--end col-->
    </div><!--end row-->
@endsection

@push('styles')
    <style>
        .table th {
            background-color: #f8f9fa;
            text-align: left;
        }

        .table th,
        .table td {
            vertical-align: middle;
            padding: 0.75rem;
        }
    </style>
@endpush
