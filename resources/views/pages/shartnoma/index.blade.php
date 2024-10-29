@extends('layouts.admin')
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0)">E-commerce</a></li>
                        <li class="breadcrumb-item" aria-current="page">Шартнома</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Шартнома</h2>
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
                                    {{-- <th>Шартнома Коди</th> --}}
                                    <th>Шартнома рақами</th>
                                    <th>Шартнома санаси</th>
                                    {{-- <th>Буюртма рақами</th>
                                    <th>Буюртма санаси</th> --}}
                                    <th>Субъект номи</th>
                                    {{-- <th>Ариза Статуси</th> --}}
                                    <th>Шартнома Статуси</th>
                                    {{-- <th>Объект номи</th> --}}
                                    <th style="width: 100px;">@lang('global.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($branches as $item)
                                    <tr>
                                        {{-- <td>{{ $item->shartnoma->shartnoma_rasmiylashtirish_uchun->unique_code ?? 'Коди мавжуд емас' }}</td> --}}
                                        <td>{{ $item->shartnoma->shartnoma_raqami ?? 'Рақам мавжуд емас' }}</td>
                                        <td>
                                            @if ($item && $item->shartnoma && $item->shartnoma->shartnoma_sanasi)
                                                {{ $item->shartnoma->shartnoma_sanasi->format('d-m-Y') }}
                                            @else
                                                Сана мавжуд емас
                                            @endif
                                        </td>
                                        {{-- <td>{{ $item->unique_code }}</td>
                                        <td>{{ $item->created_at->format('d-m-Y') }}</td> --}}

                                        @if ($item->client->mijoz_turi)
                                            <td>{{ $item->client->last_name }} {{ $item->client->first_name }}
                                                {{ $item->client->father_name }}</td>
                                        @else
                                            <td>{{ $item->client->company->company_name }}</td>
                                        @endif
{{-- 
                                        <td>
                                            @if ($item->status == 0)
                                                <span class="badge bg-light-warning">Жараёнда</span>
                                            @elseif ($item->status == 1)
                                                <span class="badge bg-light-success">Тасдиқланди</span>
                                            @endif

                                        </td> --}}

                                        @if ($item->shartnoma)
                                            <td>
                                                @if ($item->shartnoma->status == 0)
                                                    <span class="badge bg-light-warning">Жараёнда</span>
                                                @elseif ($item->shartnoma->status == 1)
                                                    @if ($item->shartnoma->shartnoma_rasmiylashtirish_uchun->status == 3)
                                                        <span class="badge bg-light-success">И.О Тасдиқлади</span>
                                                    @elseif($item->shartnoma->shartnoma_rasmiylashtirish_uchun->status == 2)
                                                        <span class="badge bg-light-danger">Рад қилинди</span>
                                                    @else
                                                        <span class="badge bg-light-success">Рўйхатга олинди</span>
                                                    @endif
                                                @endif

                                            </td>
                                        @else
                                            <td>
                                                <span class="badge bg-light-warning">Жараёнда</span>

                                            </td>
                                        @endif



                                        <td class="text-center">
                                            <div class="prod-action-links">
                                                <ul class="list-inline me-auto mb-0">


                                                    {{-- 
                                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                        title="fakt payment">
                                                        <a href="{{ route('fact_payments.create', $item->id) }}"
                                                            class="avtar avtar-xs btn-link-secondary btn-pc-default">
                                                            <i class="ti ti-eye f-18"></i>
                                                        </a>
                                                    </li> --}}

                                                    @if ($item->shartnoma)
                                                        @if ($item->shartnoma->status == 1)
                                                            <li class="list-inline-item align-bottom"
                                                                data-bs-toggle="tooltip" title="Shartnoma chop etish">
                                                                <a href="{{ route('test.word', $item->id) }}"
                                                                    class="avtar avtar-xs btn-link-secondary btn-pc-default">
                                                                    <i class="ti ti-eye f-18"></i>
                                                                </a>
                                                            </li>

                                                            <li class="list-inline-item align-bottom"
                                                                data-bs-toggle="tooltip" title="Grafik">
                                                                <a href="{{ route('grafik.show', $item->id) }}"
                                                                    class="avtar avtar-xs btn-link-secondary btn-pc-default">
                                                                    <i class="ti ti-eye f-18"></i>
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endif
                                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                        title="View">
                                                        <a href="{{ route('shartnoma.show', $item->id) }}"
                                                            class="avtar avtar-xs btn-link-secondary btn-pc-default">
                                                            <i class="ti ti-eye f-18"></i>
                                                        </a>
                                                    </li>
                                                    @if (!$item->shartnoma)
                                                        <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                            title="Shartnoma uchun ma'lumot kiritish">
                                                            <a href="{{ route('shartnoma.add', $item->id) }}"
                                                                class="avtar avtar-xs btn-link-success btn-pc-default">
                                                                <i class="ti ti-edit-circle f-18"></i>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    {{-- <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                        title="Delete">
                                                        <form action="{{ route('clientDestroy', $item->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" onclick="return confirm('Вы уверены?')"
                                                                class="avtar avtar-xs btn-link-danger btn-pc-default">
                                                                <i class="ti ti-trash f-18"></i>
                                                            </button>
                                                        </form>
                                                    </li> --}}
                                                </ul>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $branches->links() !!}

                    </div>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
@endsection
