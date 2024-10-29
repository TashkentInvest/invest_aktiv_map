@extends('layouts.admin')

@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0)">Search</a></li>
                        <li class="breadcrumb-item" aria-current="page">Search Page</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Search Page</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- [ search-form ] start -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <form action="{{ route('search') }}" method="GET">
                        <div class="row g-3 align-items-center">
                            <div class="col">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ti ti-search"></i></span>
                                    <input type="text" name="query" class="form-control" placeholder="Search a Keyword" value="{{ request('query') }}" required minlength="3">
                                    <select class="form-select" name="filter" aria-label="Filter Select">
                                        <option value="">Choose Filter...</option>
                                        <option value="clients" {{ request('filter') == 'clients' ? 'selected' : '' }}>Clients</option>
                                        <option value="companies" {{ request('filter') == 'companies' ? 'selected' : '' }}>Companies</option>
                                        <option value="orders" {{ request('filter') == 'orders' ? 'selected' : '' }}>Orders</option>
                                        <option value="shartnomas" {{ request('filter') == 'shartnomas' ? 'selected' : '' }}>Shartnomas</option>
                                        <option value="ruxsatnomas" {{ request('filter') == 'ruxsatnomas' ? 'selected' : '' }}>Ruxsatnomas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-grid d-sm-inline-block">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="row align-items-center justify-content-between mb-3">
                        <div class="col-sm-auto">
                            <h5>Search Results</h5>
                        </div>
                        @if (request('filter'))
                            <div class="col-sm-auto">
                                <form action="{{ route('search') }}" method="GET" class="d-inline">
                                    <input type="hidden" name="query" value="{{ request('query') }}">
                                    <select class="form-select" name="sort" onchange="this.form.submit()">
                                        <option value="">Sort By</option>
                                        <option value="hits_high_low" {{ request('sort') == 'hits_high_low' ? 'selected' : '' }}>Hits: High To Low</option>
                                        <option value="hits_low_high" {{ request('sort') == 'hits_low_high' ? 'selected' : '' }}>Hits: Low To High</option>
                                        <option value="popularity" {{ request('sort') == 'popularity' ? 'selected' : '' }}>Popularity</option>
                                        <option value="fresh_arrivals" {{ request('sort') == 'fresh_arrivals' ? 'selected' : '' }}>Fresh Arrivals</option>
                                    </select>
                                </form>
                            </div>
                        @endif
                    </div>
                    <hr class="my-4">

                    @if ($filter === 'clients')
                        @if ($clients->isEmpty())
                            <p class="text-muted">No clients found for your search.</p>
                        @else
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2">
                                @foreach ($clients as $client)
                                    <div class="col">
                                        <div class="card p-3 d-flex flex-row align-items-center justify-content-between shadow-sm border mb-2">
                                            <div>
                                                <h6 class="mb-0">{{ $client->last_name }} {{ $client->first_name }} {{ $client->father_name }}</h6>
                                                <p class="text-sm text-muted mb-0"><i class="ti ti-user me-1"></i>{{ $client->contact }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @elseif ($filter === 'companies')
                        @if ($companies->isEmpty())
                            <p class="text-muted">No companies found for your search.</p>
                        @else
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2">
                                @foreach ($companies as $company)
                                    <div class="col">
                                        <div class="card p-3 d-flex flex-row align-items-center justify-content-between shadow-sm border mb-2">
                                            <div>
                                                <h6 class="mb-0">{{ $company->company_name }}</h6>
                                                <p class="text-sm text-muted mb-0"><i class="ti ti-building me-1"></i>{{ $company->registration_number }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @elseif ($filter === 'orders')
                        @if ($orders->isEmpty())
                            <p class="text-muted">No orders found for your search.</p>
                        @else
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2">
                                @foreach ($orders as $order)
                                    <div class="col">
                                        <div class="card p-3 d-flex flex-row align-items-center justify-content-between shadow-sm border mb-2">
                                            <div>
                                                <h6 class="mb-0">Order #{{ $order->id }}</h6>
                                                <p class="text-sm text-muted mb-0"><i class="ti ti-cart me-1"></i>{{ $order->unique_code }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @elseif ($filter === 'shartnomas')
                        @if ($shartnomas->isEmpty())
                            <p class="text-muted">No shartnomas found for your search.</p>
                        @else
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2">
                                @foreach ($shartnomas as $shartnoma)
                                    <div class="col">
                                        <div class="card p-3 d-flex flex-row align-items-center justify-content-between shadow-sm border mb-2">
                                            <div>
                                                <h6 class="mb-0">Shartnoma #{{ $shartnoma->id }} - {{ $shartnoma->shartnoma_raqami }}</h6>
                                                @if ($shartnoma->branch)
                                                    <p class="text-sm text-muted mb-0"><i class="ti ti-building me-1"></i>Branch Code: {{ $shartnoma->branch->substreet->district->code ?? 'N/A' }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @elseif ($filter === 'ruxsatnomas')
                        @if ($ruxsatnomas->isEmpty())
                            <p class="text-muted">No ruxsatnomas found for your search.</p>
                        @else
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2">
                                @foreach ($ruxsatnomas as $ruxsatnoma)
                                    <div class="col">
                                        <div class="card p-3 d-flex flex-row align-items-center justify-content-between shadow-sm border mb-2">
                                            <div>
                                                <h6 class="mb-0">Ruxsatnoma #{{ $ruxsatnoma->id }}</h6>
                                                <p class="text-sm text-muted mb-0"><i class="ti ti-doc me-1"></i>Document Code: {{ $ruxsatnoma->ruxsat_etuvchi_hujjat_raqami }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <p class="text-muted">Please select a filter to see results.</p>
                    @endif

                </div>
            </div>
        </div>
        <!-- [ search-form ] end -->
    </div>
    <!-- [ Main Content ] end -->
@endsection
