@extends('layouts.admin')
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0)">E-commerce</a></li>
                        <li class="breadcrumb-item" aria-current="page">Ариза</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Ариза</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-body">

                    <div class="text-end p-sm-4 pb-sm-2">
                        {{-- <a href="{{ route('clientAdd') }}" class="btn btn-primary"> <i class="ti ti-plus f-18"></i> Add
                            Product
                        </a> --}}
                        <!-- Default dropend button -->


                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover tbl-product" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    <th>Буюртма рақами</th>
                                    <th>Буюртма санаси</th>
                                    <th>Субъект номи</th>
                                    <th>Статус</th>
                                    {{-- <th>Объект номи</th> --}}
                                    <th style="width: 100px;">@lang('global.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $item)
                                    <tr>
                                        <td>{{ $item->unique_code }}</td>
                                        <td>{{ $item->created_at->format('d-m-Y') }}</td>

                                        @if ($item->client->mijoz_turi)
                                            <td>{{ $item->client->last_name }} {{ $item->client->first_name }}
                                                {{ $item->client->father_name }}</td>
                                        @else
                                            <td>{{ $item->client->company->company_name }}</td>
                                        @endif
                                        <td>
                                            @if ($item->status == 0)
                                            <span class="badge bg-light-warning">Жараёнда</span>

                                            @elseif ($item->status == 1)
                                            <span class="badge bg-light-success">Тасдиқланди</span>

                                            @else
                                            <span class="badge bg-light-danger">Рад этилди</span>
                                            @endif

                                        </td>

                                        {{-- <td>{{ $item->branch }}</td> --}}

                                        <td class="text-center">
                                            <div class="prod-action-links">
                                                <ul class="list-inline me-auto mb-0">
                                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                        title="View">
                                                        <a href="{{ route('orders.show', $item->id) }}"
                                                            class="avtar avtar-xs btn-link-secondary btn-pc-default">
                                                            <i class="ti ti-eye f-18"></i>
                                                        </a>
                                                    </li>
                                                    @if ($item->status == 1)
                                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                        title="Shartnoma yaratish">
                                                        <a href="{{ route('shartnoma.add', $item->id) }}"
                                                            class="avtar avtar-xs btn-link-success btn-pc-default">
                                                            <i class="ti ti-edit-circle f-18"></i>
                                                        </a>
                                                    </li>
                                                    @endif
                                                 
                                                </ul>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $orders->links() !!}

                    </div>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
@endsection
