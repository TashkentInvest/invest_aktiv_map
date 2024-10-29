@extends('layouts.admin')
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0)">E-commerce</a></li>
                        <li class="breadcrumb-item" aria-current="page">Subyektlar</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Subyektlar</h2>
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
                            <div class="btn-group dropend">
                                <button type="button" class="btn btn-primary dropdown-toggle show"
                                    data-bs-toggle="dropdown" aria-expanded="true">
                                 Subyekt yaratish
                                </button>
                                <div class="dropdown-menu"
                                    data-popper-placement="right-start">
                                    <a class="dropdown-item" href="{{ route('clientFizikAdd') }}">Jismoniy shaxs</a>
                                    <a class="dropdown-item" href="{{route('clientYuridikAdd')}}">Yuridik shaxs</a>
                                </div>
                            </div>
                       
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover tbl-product" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    <th>@lang('global.id')</th>
                                    <th style="width: 350px">@lang('global.client_name') || @lang('cruds.company.fields.company_name')</th>
                                    <th>@lang('cruds.company.fields.stir')</th>
                                  
                                    {{-- <th>@lang('cruds.branches.fields.apz_number')</th> --}}
                                    <th>@lang('global.category')</th>
                                    <th>@lang('cruds.client.fields.contact')</th>
                                    <th>@lang('global.status')</th>
                                    <th>Subyekt Kod</th>
                                  
    
                                    <th style="width: 100px;">@lang('global.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $item)
                                    <tr>
                                        <td class="{{ $item->files->isNotEmpty() ? '' : 'bg-secondary text-light' }}">
                                            {{ $item->id }}</td>
                                        @if ($item->mijoz_turi == 'fizik')
                                            <td>{{ $item->last_name }} {{ $item->first_name }} {{ $item->father_name }}</td>
                                        @else
                                            <td>{{ $item->company->company_name ?? '' }} </td>
                                        @endif
                                        <td>{{ $item->stir ?? '' }} </td>
                                       
                                    
                                        <td>{{ $item->category->name ?? '' }} </td>
                                        <td>{{ $item->contact ?? '' }}</td>
    
                                       
                                        <td class="text-center">
                                            <i class="ph-duotone ph-check-circle text-success f-24" data-bs-toggle="tooltip"
                                                data-bs-title="success"></i>
                                        </td>
                                        <td>{{$item->unique_code}}</td>
                                        <td class="text-center">
                                            <div class="prod-action-links">
                                                <ul class="list-inline me-auto mb-0">
                                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="View">
                                                        <a href="{{ route('clientDetails', $item->id) }}" class="avtar avtar-xs btn-link-secondary btn-pc-default">
                                                            <i class="ti ti-eye f-18"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Edit">
                                                        <a href="{{ route('clientFizikEdit', $item->id) }}" class="avtar avtar-xs btn-link-success btn-pc-default">
                                                            <i class="ti ti-edit-circle f-18"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Delete">
                                                        <form action="{{ route('clientDestroy', $item->id) }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" onclick="return confirm('Вы уверены?')" class="avtar avtar-xs btn-link-danger btn-pc-default">
                                                                <i class="ti ti-trash f-18"></i>
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $clients->links() !!}

                    </div>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
@endsection
