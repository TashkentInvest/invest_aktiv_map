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
                            <a href="javascript: void(0)">Obyektlar</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Obyekt
                        </li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Obyekt</h2>
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
                                @if ($branch->action == 'created')
                                    Ushbu Obyekt <span class="text-warning">{{ $branch->user->name }}</span> tomonidan yaratildi
                                @elseif ($branch->action == 'updated')
                                    Ushbu Obyekt <span class="text-warning">{{ $branch->user->name }}</span> tomonidan o'zgartirildi
                                @elseif ($branch->action == 'deleted')
                                    Ushbu Obyekt <span class="text-warning">{{ $branch->user->name }}</span> tomonidan o'chirildi
                                @else
                                    Ushbu Obyekt uchun action ma'lum emas
                                @endif
                        
                            </h3>

                             
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-xxl-3">
                    <div class="card">
                        <div class="card-header">
                            <h5>Shaxsiy Ma'lumotlar</h5>
                        </div>
                        <div class="card-body position-relative">
                            <div class="d-inline-flex align-items-center justify-content-between w-100 mb-3">
                                <p class="mb-0 text-muted me-1">Email</p>
                                <p class="mb-0"></p>
                            </div>
                           
                          
                        </div>
                    </div>

                        <!-- Individual-specific Info -->
                        <div class="card">
                            <div class="card-header">
                                <h5>Pasport Ma'lumotlari</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">PINFL: {{ $client->passport->passport_pinfl ?? 'Mavjud emas' }}</p>
                                
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5>Uy Manzili</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">
                                    @if($branch->substreet ?? null)
                                    {{ $branch->substreet &&
                                        $branch->substreet->street &&
                                        $branch->substreet->street->district &&
                                        $branch->substreet->street->district->region
                                            ? $branch->substreet->street->district->region->name_uz
                                            : 'N/A' }}
                                        {{ $branch->substreet && $branch->substreet->street && $branch->substreet->street->district
                                            ? $branch->substreet->street->district->name_uz
                                            : 'N/A' }}
                                        {{ $branch->substreet && $branch->substreet->street ? $branch->substreet->street->name : 'N/A' }}
                                        {{ $branch->substreet ? $branch->substreet->name : 'N/A' }}
                                        @endif
                                </p>
                            </div>
                        </div>
                        <!-- Company-specific Info -->
                     

                  

                    <div class="card">
                        <div class="card-body text-center btn-page">
                            <div class="btn btn-outline-secondary">Bekor qilish</div>
                            <div class="btn btn-primary">Profilni Yangilash</div>
                            <a class="btn btn-outline-secondary" href="{{route('branchArxiv', $branch->id)}}">Arxivni ko'rish</a>

                        </div>
                    </div>
                </div>

                <div class="col-lg-7 col-xxl-9">
                    <div class="tab-content" id="user-set-tabContent">
                        <div class="tab-pane fade show active" id="user-set-profile" role="tabpanel" aria-labelledby="user-set-profile-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Qo'shimcha ma'lumotlar</h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">
                                        {{ $branch->about_me }}
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
