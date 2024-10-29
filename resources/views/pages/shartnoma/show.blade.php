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
                                Shartnoma
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Shartnoma</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Contract Details ] start -->
            <div class="col-sm-12">
                <div class="card bg-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 me-2">
                                <h3 class="text-white">
                                    @if ($item->action == 'created')
                                        Ushbu Shartnoma <span class="text-warning">{{ $item->user->name }}</span>
                                        tomonidan yaratildi
                                    @elseif ($item->action == 'updated')
                                        Ushbu Shartnoma <span class="text-warning">{{ $item->user->name }}</span>
                                        tomonidan o'zgartirildi
                                    @elseif ($item->action == 'deleted')
                                        Ushbu Shartnoma <span class="text-warning">{{ $item->user->name }}</span>
                                        tomonidan o'chirildi
                                    @else
                                        Ushbu Shartnoma uchun action ma'lum emas
                                    @endif
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-lg-5 col-xxl-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Shaxsiy Ma'lumotlar</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>FIO:</strong>
                                    {{ $item->client ? $item->client->last_name . ' ' . $item->client->first_name . ' ' . $item->client->father_name : 'N/A' }}
                                </p>
                                <p><strong>Email:</strong> {{ $item->client->email ?? 'N/A' }}</p>
                                <p><strong>Contact:</strong> {{ $item->client->contact ?? 'N/A' }}</p>
                                <p><strong>Birth Date:</strong> {{ $item->client->birth_date ?? 'N/A' }}</p>
                                <p><strong>Address:</strong>                                 
                                
                                    {{ $item->client->substreet && 
                                        $item->client->substreet->district && 
                                        $item->client->substreet->district->region
                                         ? $item->client->substreet->district->region->name_uz
                                         : 'N/A' }}
                                     {{ $item->client->substreet && 
                                        $item->client->substreet->district
                                         ? $item->client->substreet->district->name_uz
                                         : 'N/A' }}
                                     {{ $item->client->substreet && 
                                        $item->client->substreet->district && 
                                        $item->client->substreet->district->street
                                         ? $item->client->substreet->district->street->name
                                         : 'N/A' }}
                                     {{ $item->client->substreet 
                                         ? $item->client->substreet->name 
                                         : 'N/A' }}
                                
                                </p>
                            </div>
                        </div>

                        @if ($item->client->mijoz_turi == 'yuridik')
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h5>Компания Маълумотлари</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>Номи:</strong> {{ $item->client->company->company_name ?? 'N/A' }}
                                    </p>
                                    <p><strong>ОКЕД:</strong> {{ $item->client->company->oked ?? 'N/A' }}</p>
                                    <p><strong>Манзил:</strong> {{ $item->client->company->substreet->name ?? 'N/A' }}</p>
                                    <p><strong>Банк:</strong> {{ $item->client->company->bank->name ?? 'N/A' }}</p>
                                   
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
                                <p><strong>Объект Кўча номи:</strong>
                                
                                    {{ $item->substreet && 
                                        $item->substreet->district && 
                                        $item->substreet->district->region
                                         ? $item->substreet->district->region->name_uz
                                         : 'N/A' }}
                                     {{ $item->substreet && 
                                        $item->substreet->district
                                         ? $item->substreet->district->name_uz
                                         : 'N/A' }}
                                     {{ $item->substreet && 
                                        $item->substreet->district && 
                                        $item->substreet->district->street
                                         ? $item->substreet->district->street->name
                                         : 'N/A' }}
                                     {{ $item->substreet 
                                         ? $item->substreet->name 
                                         : 'N/A' }}
                                </p>
                                <p><strong>Объект Кўча коди:</strong> {{ $item->substreet->code ?? 'N/A' }}</p>
                                <p><strong>Рухсатнома рақами:</strong>
                                    {{ $item->ruxsatnoma->ruxsat_etuvchi_hujjat_raqami ?? 'N/A' }}</p>
                                <p><strong>Рухсатнома санаси:</strong>
                                    {{ $item->ruxsatnoma->ruxsat_etuvchi_hujjat_sanasi ?? 'N/A' }}</p>
                                <p><strong>Кадастр рақами:</strong>
                                    {{ $item->ruxsatnoma->kadastr_raqami ?? 'N/A' }}</p>
                                <p><strong>Binoning Qurilish Hajmi:</strong>
                                    {{ $item->loyihaHajmiMalumotnoma->binoning_qurilish_hajmi ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body text-center">
                        <div class="btn-group">
                            <button class="btn btn-outline-secondary" data-bs-toggle="modal"
                                data-bs-target="#rejectModal">Rad qilish</button>
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#approveModal">Tasdiqlash</button>
                            <a class="btn btn-outline-secondary" href="{{ route('orderArxiv', $item->id) }}">Arxivni
                                ko'rish</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Contract Details ] end -->
        </div>
        <!-- [ Main Content ] end -->

        <!-- Approve Modal -->
        <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approveModalLabel">Tasdiqlash jarayoni</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Ushbu shartnoma Kompaniya raxbari I.O tamonidan tasdiqlandimi ?
                    </div>
                    <div class="modal-footer">
                        <form method="POST" action="{{ route('shartnoma.approve.item', $item->id) }}">
                            @csrf
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ortga</button>
                            <button type="submit" class="btn btn-success">Tasdiqlash</button>
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
                        <h5 class="modal-title" id="rejectModalLabel">Rad qilish</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('shartnoma.reject.item', $item->id) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="rejectionReason" class="form-label">Rad qilishning sababi</label>
                                <textarea class="form-control" id="rejectionReason" name="comment" rows="3" required>{{ $item->comment ?? '' }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="rejectionCategory" class="form-label">Rad qilish sababini tanlang</label>
                                <select class="form-select" id="rejectionCategory" name="order_atkaz_id" required>
                                    <option value="" selected>Sababni tanlang</option>
                                    @foreach ($orderAtkaz as $oatkaz)
                                        @if ($oatkaz->status == 2)
                                            <option value="{{ $oatkaz->id }}"
                                                {{ $oatkaz->id == old('order_atkaz_id', $item->order_atkaz_id) ? 'selected' : '' }}>
                                                {{ $oatkaz->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ortga</button>
                                <button type="submit" class="btn btn-danger">Rad qilish</button>
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
