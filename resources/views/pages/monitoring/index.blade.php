@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0)">E-commerce</a></li>
                        <li class="breadcrumb-item" aria-current="page">Monitoring</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Monitoring</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-8">
            <div class="row g-3 mb-3">
                <div class="col-md-6 col-lg-4">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="mb-2 d-flex align-items-center justify-content-between gap-1">
                                <h6 class="mb-0">Total</h6>
                                <p class="mb-0 text-muted d-flex align-items-center gap-1">
                                    <svg class="pc-icon text-success wid-15 hei-15">
                                        <use xlink:href="#custom-arrow-up"></use>
                                    </svg>
                                    70.5%
                                </p>
                            </div>
                            <div class="row g-2 align-items-center">
                                <div class="col-6">
                                    <h5 class="mb-2 mt-3">$7,825</h5>
                                    <div class="d-flex align-items-center gap-1">
                                        <h5 class="mb-0">9</h5>
                                        <p class="mb-0 text-muted d-flex align-items-center gap-2">invoices</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div id="total-invoice-1-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="d-flex mb-2 align-items-center justify-content-between gap-1">
                                <h6 class="mb-0">Paid</h6>
                                <p class="mb-0 text-muted d-flex align-items-center gap-1">
                                    <svg class="pc-icon text-warning wid-15 hei-15">
                                        <use xlink:href="#custom-arrow-down"></use>
                                    </svg>
                                    -8.73%
                                </p>
                            </div>
                            <div class="row g-2 align-items-center">
                                <div class="col-6">
                                    <h5 class="mb-2 mt-3">£5678.09</h5>
                                    <div class="d-flex align-items-center gap-1">
                                        <h5 class="mb-0">5</h5>
                                        <p class="mb-0 text-muted d-flex align-items-center gap-2">invoices</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div id="total-invoice-2-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="mb-2 d-flex align-items-center justify-content-between gap-1">
                                <h6 class="mb-0">Overdue</h6>
                                <p class="mb-0 text-muted d-flex align-items-center gap-1">
                                    <svg class="pc-icon text-danger wid-15 hei-15">
                                        <use xlink:href="#custom-arrow-down"></use>
                                    </svg>
                                    -4.73%
                                </p>
                            </div>
                            <div class="row g-2 align-items-center">
                                <div class="col-6">
                                    <h5 class="mb-2 mt-3">£5678.09</h5>
                                    <div class="d-flex align-items-center gap-1">
                                        <h5 class="mb-0">5</h5>
                                        <p class="mb-0 text-muted d-flex align-items-center gap-2">invoices</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div id="total-invoice-3-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar bg-white bg-opacity-10 text-white">
                                <i class="ph-duotone ph-user-plus f-22"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-white mb-1 d-flex align-items-center gap-2">Total Receivables <i
                                    data-feather="alert-circle"></i></p>
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="text-white mb-0 d-flex align-items-center gap-2">Current <span
                                        class="fw-medium f-16">109.1k</span> </p>
                                <p class="text-white mb-0 d-flex align-items-center gap-2">Overdue <span
                                        class="fw-medium f-16">62k</span> </p>
                            </div>
                        </div>
                    </div>
                    <h4 class="text-white mt-3 mb-1">$43,078</h4>
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 me-3">
                            <div class="progress bg-light-warning" style="height: 7px">
                                <div class="progress-bar bg-warning" style="width: 90%"></div>
                            </div>
                        </div>
                        <div class="flex-shrink-0 text-end wid-30">
                            <p class="text-white mb-0">90%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-body">
                    <div class="text-end p-sm-4 pb-sm-2">
                        <div class="btn-group dropend">
                            <button type="button" class="btn btn-primary dropdown-toggle show" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                Yaratish
                            </button>
                            <div class="dropdown-menu" data-popper-placement="right-start">
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#createApzModal">Apz Yaratish</a>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#createKengashModal">Kengash Yaratish</a>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#createExpertizaModal">Ekspertiza Yaratish</a>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#createDaknGasnModal">ДАҚН (ГАСН) Yaratish</a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover tbl-product" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    <th>Shartnoma</th>
                                    <th>Apz</th>
                                    <th>Kengash</th>
                                    <th>Ekspertiza</th>
                                    <th>ДАҚН (ГАСН)</th>
                                    <th style="width: 100px;">Harakatlar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($monitorings as $monitoring)
                                    <tr>
                                        <td>{{ $monitoring->shartnoma_raqami ?? '' }} / {{ $monitoring->shartnoma_sanasi ? $monitoring->shartnoma_sanasi->format('d-m-Y') : 'N/A' }}

                                        <td>{{ $monitoring->artMaLumotlari->art_raqami ?? '' }} / {{ $monitoring->artMaLumotlari ? $monitoring->artMaLumotlari->art_sanasi->format('d-m-Y') : 'N/A'  }} </td>
                                        <td>{{ $monitoring->kengashXulosasi->xulosa_raqami ?? '' }} / {{$monitoring->kengashXulosasi ? $monitoring->kengashXulosasi->xulosa_sanasi->format('d-m-Y') : 'N/A'   }}</td>
                                        <td>{{ $monitoring->ekspertizaXulosasi->ekspertiza_xulosa_raqami ?? '' }} / {{$monitoring->ekspertizaXulosasi ? $monitoring->ekspertizaXulosasi->ekspertiza_xulosa_sanasi->format('d-m-Y') : 'N/A'   }}</td>
                                        <td>{{ $monitoring->daknGasnInspection->ariza_raqami ?? '' }} / {{ $monitoring->daknGasnInspection ? $monitoring->daknGasnInspection->ariza_sanasi->format('d-m-Y') : 'N/A'  }}</td>
                                      
                                        <td>
                                            <div class="prod-action-links">
                                                <ul class="list-inline me-auto mb-0">
                                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                        title="View">
                                                        <a href="{{ route('monitoring.show', $monitoring->id) }}"
                                                            class="avtar avtar-xs btn-link-secondary btn-pc-default">
                                                            <i class="ti ti-eye f-18"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                        title="Edit">
                                                        <a href="{{ route('monitoring.edit', $monitoring->id) }}"
                                                            class="avtar avtar-xs btn-link-success btn-pc-default">
                                                            <i class="ti ti-edit-circle f-18"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                        title="Delete">
                                                        <form action="{{ route('monitoring.destroy', $monitoring->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" onclick="return confirm('Вы уверены?')"
                                                                class="avtar avtar-xs btn-link-danger btn-pc-default">
                                                                <i class="ti ti-trash f-18"></i>
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>

                                           @include('inc.__monitoring_actions')
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $monitorings->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
