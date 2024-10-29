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
                                <a href="javascript: void(0)">Subyektlar</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Subyekt
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Subyekt</h2>
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
                                    {{-- @dd($client) --}}
                                    @if ($client->action == 'created')
                                        Ushbu Subyekt <span class="text-warning">{{ $client->user->name }}</span> tomonidan
                                        yaratildi
                                    @elseif ($client->action == 'updated')
                                        Ushbu Subyekt <span class="text-warning">{{ $client->user->name }}</span> tomonidan
                                        o'zgartirildi
                                    @elseif ($client->action == 'deleted')
                                        Ushbu Subyekt <span class="text-warning">{{ $client->user->name }}</span> tomonidan
                                        o'chirildi
                                    @else
                                        Ushbu Subyekt uchun action ma'lum emas
                                    @endif

                                </h3>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5 col-xxl-5">
                        <div class="card">
                            <div class="card-header">
                                <h5>Shaxsiy Ma'lumotlar</h5>
                            </div>
                            <div class="card-body position-relative">
                                <div class="d-inline-flex align-items-center justify-content-between w-100 mb-3">
                                    <p class="mb-0 text-muted me-1">Email</p>
                                    <p class="mb-0">{{ $client->email }}</p>
                                </div>
                                <div class="d-inline-flex align-items-center justify-content-between w-100 mb-3">
                                    <p class="mb-0 text-muted me-1">To'liq Ism</p>
                                    <p class="mb-0">{{ $client->last_name }} {{ $client->first_name }}
                                        {{ $client->middle_name ?? '' }}</p>
                                </div>
                                <div class="d-inline-flex align-items-center justify-content-between w-100 mb-3">
                                    <p class="mb-0 text-muted me-1">Aloqa</p>
                                    <p class="mb-0">{{ $client->contact }}</p>
                                </div>

                                <div class="d-inline-flex align-items-center justify-content-between w-100 mb-3">
                                    <p class="mb-0 text-muted me-1">STIR</p>
                                    <p class="mb-0">{{ $client->stir }}</p>
                                </div>


                            </div>
                        </div>

                        @if ($client->mijoz_turi == 'fizik')
                            <!-- Individual-specific Info -->
                            <div class="card">
                                <div class="card-header">
                                    <h5>Pasport Ma'lumotlari</h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">PINFL: {{ $client->passport->passport_pinfl ?? 'Mavjud emas' }}</p>
                                    <p class="mb-0">Seriya: {{ $client->passport->passport_series ?? 'Mavjud emas' }}</p>
                                    <p class="mb-0">Berilgan Sana:
                                        {{ $client->passport->passport_date ? date('d-m-Y', strtotime($client->passport->passport_date)) : 'Mavjud emas' }}
                                    </p>
                                    <p class="mb-0">Berilgan Joy:
                                        {{ $client->passport->passport_location ?? 'Mavjud emas' }}</p>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h5>Uy Manzili</h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">
                                        {{ $client->substreet && $client->substreet->district && $client->substreet->district->region
                                            ? $client->substreet->district->region->name_uz
                                            : 'N/A' }}
                                        {{ $client->substreet && $client->substreet->district ? $client->substreet->district->name_uz : 'N/A' }}
                                        {{ $client->substreet && $client->substreet->district && $client->substreet->district->street
                                            ? $client->substreet->district->street->name
                                            : 'N/A' }}
                                        {{ $client->substreet ? $client->substreet->name : 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        @else
                            <!-- Company-specific Info -->
                            <div class="card">
                                <div class="card-header">
                                    <h5>Kompaniya Ma'lumotlari</h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">Kompaniya Nomi: {{ $client->company->name ?? 'Mavjud emas' }}</p>
                                    <p class="mb-0">Yuridik Manzil:
                                        {{ $client->company->substreet &&
                                        $client->company->substreet->district &&
                                        $client->company->substreet->district->region
                                            ? $client->company->substreet->district->region->name_uz
                                            : 'N/A' }}
                                        {{ $client->company->substreet && $client->company->substreet->district
                                            ? $client->company->substreet->district->name_uz
                                            : 'N/A' }}
                                        {{ $client->company->substreet &&
                                        $client->company->substreet->district &&
                                        $client->company->substreet->district->street
                                            ? $client->company->substreet->district->street->name
                                            : 'N/A' }}
                                        {{ $client->company->substreet ? $client->company->substreet->name : 'N/A' }}
                                    </p>
                                    <p class="mb-0">OKED: {{ $client->company->oked ?? 'Mavjud emas' }}</p>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h5>Bank Ma'lumotlari</h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">Bank Nomi: {{ $client->company->bank->name ?? 'Mavjud emas' }}</p>
                                    <p class="mb-0">Bank Kodi: {{ $client->company->bank->code ?? 'Mavjud emas' }}</p>
                                    <p class="mb-0">Bank Manzili:
                                        {{ $client->company->bank->substreet &&
                                        $client->company->bank->substreet->district &&
                                        $client->company->bank->substreet->district->region
                                            ? $client->company->bank->substreet->district->region->name_uz
                                            : 'N/A' }}
                                        {{ $client->company->bank->substreet && $client->company->bank->substreet->district
                                            ? $client->company->bank->substreet->district->name_uz
                                            : 'N/A' }}
                                        {{ $client->company->bank->substreet &&
                                        $client->company->bank->substreet->district &&
                                        $client->company->bank->substreet->district->street
                                            ? $client->company->bank->substreet->district->street->name
                                            : 'N/A' }}
                                        {{ $client->company->bank->substreet ? $client->company->bank->substreet->name : 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        <div class="card">
                            <div class="card-body text-center btn-page">
                                <a href="{{ route('clientIndex') }}" class="btn btn-outline-secondary">Ortga</a>

                                @if ($client->mijoz_turi)
                                    <a href="{{ route('clientFizikEdit', $client->id) }}" class="btn btn-primary">Profilni
                                        Yangilash</a>
                                @else
                                    <a href="{{ route('clientFizikEdit', $client->id) }}" class="btn btn-primary">Profilni
                                        Yangilash</a>
                                @endif
                                {{-- <div class="btn btn-primary">Profilni Yangilash</div> --}}
                                <a class="btn btn-outline-secondary" href="{{ route('clientArxiv', $client->id) }}">Arxivni
                                    ko'rish</a>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7 col-xxl-7">
                        <div class="tab-content" id="user-set-tabContent">
                            <div class="tab-pane fade show active" id="user-set-profile" role="tabpanel"
                                aria-labelledby="user-set-profile-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Qo'shimcha ma'lumotlar</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0">
                                            {{ $client->about_me }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Add other tabs if needed -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Client Profile ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/libs/admin-resources/rwd-table/rwd-table.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/table-responsive.init.js') }}"></script>
@endsection
