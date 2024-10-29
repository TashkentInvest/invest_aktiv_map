@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0)">Subyektlar</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Excel Data</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Excel Data</h2>
                        <a class="btn btn-primary btn-lg" href="{{ route('excel.import-export') }}">Export or Import</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .page-header {
            background-color: #f8f9fa;
            padding: 20px;
            border-bottom: 1px solid #dee2e6;
        }

        .page-header-title h2 {
            font-size: 1.5rem;
            color: #343a40;
        }

        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 1rem;
        }

        .breadcrumb-item a {
            color: #007bff;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #6c757d;
        }

        .btn-primary {
            border-radius: 0.375rem;
            padding: 0.5rem 1.5rem;
            font-size: 1rem;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 1rem;
            background-color: #ffffff;
        }

        .table thead th {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
            font-weight: bold;
        }

        .table tbody td {
            padding: 0.75rem;
            vertical-align: middle;
            border-top: 1px solid #dee2e6;
            text-align: right;
        }

        .table .due {
            background-color: #ffeb3b;
            color: #212529;
        }

        .table .paid {
            background-color: #c8e6c9;
            color: #212529;
        }

        .table .not-paid {
            background-color: #ffcdd2;
            color: #212529;
        }

        .table .delayed {
            background-color: #ffdddd;
            color: #a94442;
        }

        .table .on-time {
            background-color: #d4edda;
            color: #155724;
        }

        .table td:first-child {
            text-align: center;
            font-weight: bold;
        }

        .table th, .table td {
            border: 1px solid #dee2e6;
        }

        .table th {
            padding: 1rem;
            background-color: #f0f0f0;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table td {
            text-align: center;
        }
    </style>

    <div class="row">
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover tbl-product" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>INN</th>
                                    <th>PINFL</th>
                                    <th>FIO / Company Name</th>
                                    <th>Mijoz Turi</th>
                                    <th>Shartnoma Raqami</th>
                                    <th>Shartnoma Sanasi</th>
                                    <th>Payment Deadline</th>
                                    <th>Umumiy Xajm</th>
                                    <th>Kvartal Soni</th>
                                    <th>Tuman Code</th>
                                    <th>Tuman</th>
                                    <th>Avans</th>
                                    <th>Jami Tolov</th>
                                    <th>Result</th>
                                    @if($branches->count() > 0 && !empty($branches->first()->payment_dates))
                                        @foreach ($branches->first()->payment_dates as $date)
                                            <th>{{ $date }}</th>
                                        @endforeach
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($branches as $branch)
                                <tr>
                                    <td>{{ $branch->client->id ?? 'N/A' }}</td>
                                    <td>{{ $branch->client->stir ?? 'N/A' }}</td>
                                    <td>{{ $branch->client->pinfl ?? 'N/A' }}</td>
                                    <td>
                                        @if ($branch->client->mijoz_turi == 'yuridik')
                                            {{ $branch->client->company->company_name ?? 'N/A' }}
                                        @else
                                            {{ $branch->client->first_name ?? 'N/A' }}
                                            {{ $branch->client->last_name ?? '' }}
                                            {{ $branch->client->father_name ?? '' }}
                                        @endif
                                    </td>
                                    <td>{{ $branch->client->mijoz_turi ?? 'N/A' }}</td>
                                    <td>{{ $branch->shartnoma->shartnoma_raqami ?? 'N/A' }}</td>
                    
                                    <td>
                                        @if ($branch->shartnoma && $branch->shartnoma->shartnoma_sanasi)
                                            {{ $branch->shartnoma->shartnoma_sanasi->format('d-m-Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                    
                                    <td>
                                        @if ($branch->shartnoma && $branch->shartnoma->tolovGrafigi && $branch->shartnoma->tolovGrafigi->payment_deadline)
                                            {{ $branch->shartnoma->tolovGrafigi->payment_deadline->format('d-m-Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                    
                                    <td>{{ number_format($branch->loyihaHajmiMalumotnoma->branch_kubmetr ?? 0, 2, '.', ',') }}</td>
                                    <td>{{ $branch->shartnoma->tolovGrafigi->installment_quarterly ?? 'N/A' }}</td>
                                    <td>{{ $branch->subStreet->code ?? 'N/A' }}</td>
                                    <td>{{ $branch->subStreet->name_uz ?? 'N/A' }}</td>
                                    <td>
                                        {{ number_format($branch->shartnoma->tolovGrafigi->first_payment_percent ?? 0, 0, '', ' ') }}
                                    </td>
                                    <td>
                                        {{ number_format($branch->shartnoma->tolovGrafigi->generate_price ?? 0, 0, '', ' ') }}
                                    </td>
                                    <td>{{ number_format($branch->result, 0, '', ' ') }}</td>

                                    @if (!empty($branch->payment_dates))
                                        @foreach ($branch->payment_dates as $index => $date)
                                            @php
                                                $statusClass = 'on-time'; // default to on-time
                                                $amountPaid = $branch->payment_amount[$index] ?? 0;

                                                if (isset($branch->payment_status[$index])) {
                                                    switch ($branch->payment_status[$index]) {
                                                        case 'due':
                                                            $statusClass = 'due';
                                                            break;
                                                        case 'paid':
                                                            $statusClass = 'paid';
                                                            break;
                                                        case 'not-paid':
                                                            $statusClass = 'not-paid';
                                                            break;
                                                        case 'delayed':
                                                            $statusClass = 'delayed';
                                                            break;
                                                    }
                                                }
                                            @endphp
                                            <td class="{{ $statusClass }}">
                                                @if ($amountPaid > 0)
                                                    {{ number_format($amountPaid, 0, '', ' ') }}
                                                @else
                                                    0
                                                @endif
                                            </td>
                                        @endforeach
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    {!! $branches->links() !!}
                </div>
            </div> 
        </div>
    </div>
@endsection
