@extends('layouts.admin')

@section('content')
    <div class="pc-content">
        <!-- [ Breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="">Asosiy sahifa</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0)">E-commerce</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Ариза
                            </li>
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
        <!-- [ Breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Client Profile ] start -->
            <div class="col-sm-12">
                <div class="card bg-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 me-2">
                                <h3 class="text-white">
                                    @if ($item->branch)
                                        @if ($item->branch->action == 'created')
                                            Ushbu Ariza <span class="text-warning">{{ $item->branch->user->name }}</span>
                                            tomonidan yaratildi
                                        @elseif ($item->branch->action == 'updated')
                                            Ushbu Ariza <span class="text-warning">{{ $item->branch->user->name }}</span>
                                            tomonidan o'zgartirildi
                                        @elseif ($item->branch->action == 'deleted')
                                            Ushbu Ariza <span class="text-warning">{{ $item->branch->user->name }}</span>
                                            tomonidan o'chirildi
                                        @else
                                            Ushbu Ariza uchun action ma'lum emas
                                        @endif
                                    @endif
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($item->branch)
                    <div class="row mt-4">
                        <div class="col-lg-5 col-xxl-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Шахсий Маълумотлар</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>ФИО:</strong>
                                        {{ $item->branch->client ? $item->branch->client->last_name . ' ' . $item->branch->client->first_name . ' ' . $item->branch->client->father_name : 'N/A' }}
                                    </p>
                                    <p><strong>Email:</strong> {{ $item->branch->client->email ?? 'N/A' }}</p>
                                    <p><strong>Алоқа учун рақам:</strong> {{ $item->branch->client->contact ?? 'N/A' }}</p>
                                    <p><strong>Тугилган сана:</strong>
                                        {{-- {{ $item->branch->client->birth_date->format('d-m-Y') ?? 'N/A' }}</p> --}}
                                    <p><strong>Манзил:</strong>
                                        {{ $item->branch->client->substreet &&
                                        $item->branch->client->substreet->district &&
                                        $item->branch->client->substreet->district->region
                                            ? $item->branch->client->substreet->district->region->name_uz
                                            : 'N/A' }}
                                        {{ $item->branch->client->substreet && $item->branch->client->substreet->district
                                            ? $item->branch->client->substreet->district->name_uz
                                            : 'N/A' }}
                                        {{ $item->branch->client->substreet &&
                                        $item->branch->client->substreet->district &&
                                        $item->branch->client->substreet->district->street
                                            ? $item->branch->client->substreet->district->street->name
                                            : 'N/A' }}
                                        {{ $item->branch->client->substreet ? $item->branch->client->substreet->name : 'N/A' }}
                                    </p>
                                </div>
                            </div>

                            @if ($item->client->mijoz_turi == 'yuridik')
                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h5>Компания Маълумотлари</h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Company Name:</strong>
                                            {{ $item->branch->company->company_name ?? 'N/A' }}
                                        </p>
                                        <p><strong>OKED:</strong> {{ $item->branch->company->oked ?? 'N/A' }}</p>
                                        <p><strong>Kompanya manzili:</strong>

                                            {{ $item->branch->client->company->substreet &&
                                            $item->branch->client->company->substreet->district &&
                                            $item->branch->client->company->substreet->district->region
                                                ? $item->branch->client->company->substreet->district->region->name_uz
                                                : 'N/A' }}
                                            {{ $item->branch->client->company->substreet && $item->branch->client->company->substreet->district
                                                ? $item->branch->client->company->substreet->district->name_uz
                                                : 'N/A' }}
                                            {{ $item->branch->client->company->substreet &&
                                            $item->branch->client->company->substreet->district &&
                                            $item->branch->client->company->substreet->district->street
                                                ? $item->branch->client->company->substreet->district->street->name
                                                : 'N/A' }}
                                            {{ $item->branch->client->company->substreet ? $item->branch->client->company->substreet->name : 'N/A' }}
                                        </p>
                                        <p><strong>Bank:</strong> {{ $item->branch->company->bank->name ?? 'N/A' }}</p>
                                        <p><strong>Entity Form:</strong>
                                            {{ $item->branch->company->subyekt_shakli->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-lg-7 col-xxl-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Объект Маълумотлари</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>Объект Манзили:</strong>
                                        {{ $item->branch->substreet && $item->branch->substreet->district && $item->branch->substreet->district->region
                                            ? $item->branch->substreet->district->region->name_uz
                                            : 'N/A' }}
                                        {{ $item->branch->substreet && $item->branch->substreet->district
                                            ? $item->branch->substreet->district->name_uz
                                            : 'N/A' }}
                                        {{ $item->branch->substreet && $item->branch->substreet->district && $item->branch->substreet->district->street
                                            ? $item->branch->substreet->district->street->name
                                            : 'N/A' }}
                                        {{ $item->branch->substreet ? $item->branch->substreet->name : 'N/A' }}
                                    </p>


                                    <p><strong>Объект Кўча коди:</strong> {{ $item->branch->substreet->code ?? 'N/A' }}</p>
                                    <p><strong>Рухсатнома рақами:</strong>
                                        {{ $item->branch->ruxsatnoma->ruxsat_etuvchi_hujjat_raqami ?? 'N/A' }}</p>
                                    <p><strong>Рухсатнома санаси:</strong>
                                        {{ $item->branch->ruxsatnoma->ruxsat_etuvchi_hujjat_sanasi ?? 'N/A' }}</p>
                                    </p>
                                    <p><strong>Кадастр рақами:</strong>
                                        {{ $item->branch->ruxsatnoma->kadastr_raqami ?? 'N/A' }}</p>
                                    <p><strong>Binoning Qurilish Hajmi:</strong>
                                        {{ $item->branch->loyihaHajmiMalumotnoma->binoning_qurilish_hajmi ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card mt-4">
                    <div class="card-body text-center">
                        <div class="btn-group">
                            <button class="btn btn-outline-secondary" data-bs-toggle="modal"
                                data-bs-target="#rejectModal">Рад этиш</button>
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#approveModal">Тасдиқлаш</button>
                            <a class="btn btn-outline-secondary" href="{{ route('orderArxiv', $item->id) }}">Архивни
                                кўриш</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Client Profile ] end -->
        </div>
        <!-- [ Main Content ] end -->
        <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approveModalLabel">Тасдиқлаш жарайони</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Ҳақиқатан ҳам бу амални тасдиқламоқчимисиз?
                    </div>
                    <div class="modal-footer">
                        <form method="POST" action="{{ route('order.approve.item', $item->id) }}">
                            @csrf
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ортга</button>
                            <button type="submit" class="btn btn-success">Тасдиқлаш</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reject Modal -->
        <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel">Рад қилиш</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('order.reject.item', $item->id) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="rejectionReason" class="form-label">Рад қилишнинг сабаби</label>
                                <textarea class="form-control" id="rejectionReason" name="comment" rows="3" required>{{ $item->comment ?? '' }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="rejectionCategory" class="form-label">Рад қилиш сабабини танланг</label>
                                <select class="form-select" id="rejectionCategory" name="order_atkaz_id" required>
                                    <option value="" selected>Сабабни танланг</option>
                                    @foreach ($orderAtkaz as $oatkaz)
                                        @if ($oatkaz->status == 1)
                                            <option value="{{ $oatkaz->id }}"
                                                {{ $oatkaz->id == old('order_atkaz_id', $item->order_atkaz_id) ? 'selected' : '' }}>
                                                {{ $oatkaz->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ортга</button>
                                <button type="submit" class="btn btn-danger">Рад қилиш</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script src="{{ asset('assets/libs/admin-resources/rwd-table/rwd-table.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/table-responsive.init.js') }}"></script>
    @endsection
