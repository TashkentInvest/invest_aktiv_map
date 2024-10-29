@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">@lang('cruds.setting.about_company')</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #007bff;">@lang('global.home')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('cruds.setting.about_company')</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="d-flex">
                            <div class="company_img index">
                                @if ($about->image)
                                    <img src="{{ url('/') }}/images/{{ $about->image }}" alt="image_about">
                                @else
                                    <img src="{{ asset('assets/images/no-image.png') }}" alt="image_about">
                                @endif
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="fw-semibold">{{ $about->{'name_' . $locale} }}</h5>
                                <!-- <ul class="list-unstyled hstack gap-2 mb-0">
                                    <li>
                                        <i class="bx bx-building-house"></i> <span class="text-muted">Themesbrand</span>
                                    </li>
                                    <li>
                                        <i class="bx bx-map"></i> <span class="text-muted">California</span>
                                    </li>
                                </ul> -->
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('settingEdit') }}" class="btn btn-soft-danger btn-hover w-100 rounded">
                                <i class="bx bx-edit-alt"></i>
                                @lang('global.edit')
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="fw-semibold mb-3">@lang('cruds.setting.about.description')</h5>
                    <p class="text-muted">
                        {{ $about->{'text_' . $locale} }}
                    </p>

                    <div class="mt-4">
                        <ul class="list-inline mb-0">
                            <!-- <li class="list-inline-item mt-1">
                                Share this job:
                            </li> -->
                            @if (!is_null($about->link_name_1) && !is_null($about->link_1))
                                <li class="list-inline-item mt-1">
                                    <a href="{{ $about->link_1 }}" target="_blank"
                                        class="btn btn-outline-primary btn-hover">
                                        <i class="uil uil-facebook-f"></i>
                                        {{ $about->link_name_1 }}
                                    </a>
                                </li>
                            @endif

                            @if (!is_null($about->link_name_2) && !is_null($about->link_2))
                                <li class="list-inline-item mt-1">
                                    <a href="{{ $about->link_2 }}" target="_blank"
                                        class="btn btn-outline-primary btn-hover">
                                        <i class="uil uil-google"></i>
                                        {{ $about->link_name_2 }}
                                    </a>
                                </li>
                            @endif
                            <!-- <li class="list-inline-item mt-1">
                                <a href="javascript:void(0)" class="btn btn-outline-success btn-hover"><i class="uil uil-linkedin-alt"></i> linkedin</a>
                            </li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div><!--end col-->
    </div>
@endsection
