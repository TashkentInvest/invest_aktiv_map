@extends('layouts.app')

@section('content')
    <style>
        .swal2-xl {
            width: 800px;
            /* Adjust width as needed */
            max-width: 90%;
            /* Ensure it's responsive */
        }

        .wizard .steps .current a,
        .wizard .steps .current a:active,
        .wizard .steps .current a:hover {
            background-color: rgba(85, 110, 230, .2);
            color: var(--bs-gray-700);
            display: none !important;
        }

        .accordion-body {
            padding: 0 !important;
        }

        /* .form-control {
            width: 100%;
            padding: 0.75rem !important;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        } */

        div:where(.swal2-container) .swal2-html-container {
            text-align: left !important;
            
        }

        .error_message{
            padding: 5px 0 !important;
        }

        @media(max-width: 774px) {
            .media_text {
                font-size: 15px;
                font-weight: bold
            }

            .table>tbody {
                text-align: left !important;
                font-size: 12px !important;
            }

            tbody,
            td,
            tfoot,
            th,
            thead,
            tr {
                width: 100px !important;
            }

        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Include Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

    <!-- Include Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>

    <div class="row">
        <h2 style="color: red;text-align: center">@lang('global.info_text')</h2>
        <h3 class="text-center media_text">@lang('global.client_title')</h3>
        <div class="m-auto d-flex justify-content-center text-center my-2">
            @if (session('locale') == 'uz')
                <a href="{{ route('changelang', 'ru') }}" class="dropdown-item notify-item language" data-lang="ru">
                    @lang('global.pleaseSelect'):
                    <img src="{{ asset('assets/images/flags/russia.jpg') }}" alt="user-image" class="me-1" height="12">
                    <span class="align-middle">Русский</span>
                </a>
            @else
                <a href="{{ route('changelang', 'uz') }}" class="dropdown-item notify-item language" data-lang="uz">
                    @lang('global.pleaseSelect'):

                    <img src="{{ asset('assets/images/flags/uzbekistan.jpg') }}" alt="user-image" class="me-1"
                        height="12"> <span class="align-middle">O'zbekcha</span>
                </a>
            @endif
        </div>
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <form id='myForm' action="{{ route('Qrcreate') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="created_by_client" value="1">

                        <div id="basic-example">
                            <h3>@lang('global.personal_informations')</h3>
                            <section>

                                <div class="row">
                                    <div class="col-12 col-lg-6 mb-2">
                                        <label for="mijoz_turi" class="col-md-4 col-form-label">@lang('cruds.client.fields.mijoz_turi')</label>
                                        <select class="form-control form-select" name="mijoz_turi" id="mijoz_turi">
                                            <option value="fizik" {{ old('mijoz_turi') == 'fizik' ? 'selected' : '' }}>
                                                @lang('cruds.client.fields.mijoz_turi_fizik')</option>
                                            <option value="yuridik" {{ old('mijoz_turi') == 'yuridik' ? 'selected' : '' }}>
                                                @lang('cruds.client.fields.mijoz_turi_yuridik')</option>
                                        </select>
                                        @error('mijoz_turi')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="col-12 col-lg-6 mb-2">
                                        <label for="category_id" class="col-md-4 col-form-label">@lang('global.category')</label>
                                        <select class="form-control form-select" name="category_id" id="category_id">
                                            @foreach ($categories as $c)
                                                <option value="{{ $c->id }}"
                                                    {{ old('category_id') == $c->id ? 'selected' : '' }}>
                                                    {{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>


                                </div>

                           
                                
                                
                                
                                <div class="row">
                                    {{-- <div class="col-12 col-md-6 col-lg-6 col-xl-4 mb-2">
                                        <label for="last_name" class="col-md-4 col-form-label">@lang('cruds.client.fields.last_name')</label>
                                        <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                                            type="text" name="last_name" id="last_name"
                                            placeholder="@lang('cruds.client.fields.last_name')" value="{{ old('last_name') }}">
                                        @if ($errors->has('last_name'))
                                            <span class="error invalid-feedback">{{ $errors->first('last_name') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-6 col-xl-4 mb-2">
                                        <label for="name" class="col-md-4 col-form-label">@lang('cruds.client.fields.name')</label>
                                        <input class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                                            type="text" name="first_name" id="first_name"
                                            placeholder="@lang('cruds.client.fields.first_name')" value="{{ old('first_name') }}">
                                        @if ($errors->has('first_name'))
                                            <span class="error invalid-feedback">{{ $errors->first('first_name') }}</span>
                                        @endif
                                    </div> --}}

                                    <div class="col-12 col-md-6 col-lg-6 col-xl-4 mb-2">
                                        <label for="last_name" class="col-md-4 col-form-label">@lang('cruds.client.fields.last_name')</label>
                                        <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                                            type="text" name="last_name" id="last_name"
                                            placeholder="@lang('cruds.client.fields.last_name')" value="{{ old('last_name') }}">
                                        <span class="error invalid-feedback" id="error-last_name">{{ $errors->first('last_name') }}</span>
                                    </div>
                                
                                    <div class="col-12 col-md-6 col-lg-6 col-xl-4 mb-2">
                                        <label for="first_name" class="col-md-4 col-form-label">@lang('cruds.client.fields.first_name')</label>
                                        <input class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                                            type="text" name="first_name" id="first_name"
                                            placeholder="@lang('cruds.client.fields.first_name')" value="{{ old('first_name') }}">
                                        <span class="error invalid-feedback" id="error-first_name">{{ $errors->first('first_name') }}</span>
                                    </div>

                                    



                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4 mb-2">
                                        <label for="father_name"
                                            class="col-md-4 col-form-label">@lang('cruds.client.fields.father_name')</label>
                                        <input class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}"
                                            type="text" name="father_name" id="father_name"
                                            placeholder="@lang('cruds.client.fields.father_name')" value="{{ old('father_name') }}">
                                        @if ($errors->has('father_name'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('father_name') }}</span>
                                        @endif
                                    </div>


                                    <div class="col-12 col-md-4 col-lg-6 col-xl-6 mb-2">
                                        <label for="contact" class="col-md-4 col-form-label">@lang('cruds.client.fields.contact')</label>
                                        <input
                                            class="form-control phone2 {{ $errors->has('contact') ? 'is-invalid' : '' }}"
                                            type="text" name="contact" id="contact"
                                            placeholder="+998 (__) ___-__-__" value="{{ old('contact') }}">
                                        @if ($errors->has('contact'))
                                            <span class="error invalid-feedback">{{ $errors->first('contact') }}</span>
                                        @endif
                                    </div>

                                    <script>
                                        $('.phone2').inputmask('+998 (99) 999-99-99');
                                    </script>



                                    <div class="col-12 col-md-4 col-lg-6 col-xl-6 mb-2">
                                        <label for="stir" class="col-md-6 col-form-label">@lang('cruds.company.fields.stir')</label>
                                        <input class="form-control {{ $errors->has('stir') ? 'is-invalid' : '' }}"
                                            type="number" name="stir" id="stir"
                                            placeholder="@lang('cruds.company.fields.stir')" value="{{ old('stir') }}" minlength="9"
                                            maxlength="9">
                                        @if ($errors->has('stir'))
                                            <span class="error invalid-feedback">{{ $errors->first('stir') }}</span>
                                        @endif
                                    </div>

                                </div>
                                {{-- <input type="hidden" name="client_id" value="{{$client->id}}"> --}}


                        </div>

                        <div class="row" id="make_show" style="display: none;">

                            <div class="col-12 col-lg-4 mb-2">
                                <label for="company_name" class="col-md-6 col-form-label">@lang('cruds.company.fields.company_name')</label>
                                <input class="form-control {{ $errors->has('company_name') ? 'is-invalid' : '' }}"
                                    type="text" name="company_name" id="company_name"
                                    placeholder="@lang('cruds.company.fields.company_name')" value="{{ old('company_name') }}">
                                @if ($errors->has('company_name'))
                                    <span
                                        class="error invalid-feedback">{{ $errors->first('company_name') }}</span>
                                @endif
                            </div>

                            <div class="col-12 col-lg-4 mb-2">
                                <label for="raxbar" class="col-md-6 col-form-label">@lang('cruds.company.fields.raxbar') -
                                    @lang('global.client_name')</label>
                                <input class="form-control {{ $errors->has('raxbar') ? 'is-invalid' : '' }}"
                                    type="text" name="raxbar" id="raxbar" placeholder="@lang('cruds.company.fields.raxbar')"
                                    value="{{ old('raxbar') }}">
                                @if ($errors->has('raxbar'))
                                    <span class="error invalid-feedback">{{ $errors->first('raxbar') }}</span>
                                @endif
                            </div>



                            <div class="col-12 col-lg-4 mb-2">
                                <label for="oked" class="col-md-6 col-form-label">@lang('cruds.company.fields.oked')</label>
                                <input class="form-control {{ $errors->has('oked') ? 'is-invalid' : '' }}"
                                    type="number" name="oked" id="oked" placeholder="@lang('cruds.company.fields.oked')"
                                    value="{{ old('oked') }}" minlength="5" maxlength="5">
                                @if ($errors->has('oked'))
                                    <span class="error invalid-feedback">{{ $errors->first('oked') }}</span>
                                @endif
                            </div>

                            <div class="col-12 col-lg-4 mb-2">
                                <label for="bank_service" class="col-md-6 col-form-label">@lang('cruds.company.fields.bank_service')</label>
                                <input class="form-control {{ $errors->has('bank_service') ? 'is-invalid' : '' }}"
                                    type="text" name="bank_service" id="bank_service"
                                    placeholder="@lang('cruds.company.fields.bank_service')" value="{{ old('bank_service') }}">
                                @if ($errors->has('bank_service'))
                                    <span
                                        class="error invalid-feedback">{{ $errors->first('bank_service') }}</span>
                                @endif
                            </div>

                            <div class="col-12 col-lg-4 mb-2">
                                <label for="bank_code" class="col-md-6 col-form-label">@lang('cruds.company.fields.bank_code')</label>
                                <input class="form-control {{ $errors->has('bank_code') ? 'is-invalid' : '' }}"
                                    type="number" name="bank_code" id="bank_code"
                                    placeholder="@lang('cruds.company.fields.bank_code')" value="{{ old('bank_code') }}"
                                    minlength="5" maxlength="5" name="bank_code" id="bank_code">

                                @if ($errors->has('bank_code'))
                                    <span class="error invalid-feedback">{{ $errors->first('bank_code') }}</span>
                                @endif
                            </div>

                            <div class="col-12 col-lg-4 mb-2">
                                <label for="bank_account"
                                    class="col-md-6 col-form-label">@lang('cruds.company.fields.bank_account')</label>
                                <input class="form-control {{ $errors->has('bank_account') ? 'is-invalid' : '' }}"
                                    type="number" name="bank_account" id="bank_account"
                                    placeholder="@lang('cruds.company.fields.bank_account')" value="{{ old('bank_account') }}"
                                    minlength="20" maxlength="20" name="bank_account" id="alloptions">

                                @if ($errors->has('bank_account'))
                                    <span
                                        class="error invalid-feedback">{{ $errors->first('bank_account') }}</span>
                                @endif
                            </div>


                            <div class="col-12 col-lg-12 mb-2">
                                <label for="yuridik_address"
                                    class="col-md-6 col-form-label">@lang('cruds.client.fields.yuridik_address')</label>
                                <input
                                    class="form-control {{ $errors->has('yuridik_address') ? 'is-invalid' : '' }}"
                                    type="text" name="yuridik_address" id="yuridik_address"
                                    placeholder="@lang('cruds.client.fields.yuridik_address')" value="{{ old('yuridik_address') }}">
                                @if ($errors->has('yuridik_address'))
                                    <span
                                        class="error invalid-feedback">{{ $errors->first('yuridik_address') }}</span>
                                @endif
                            </div>

                        </div>
                        <div class="row" id="make_hide">
                            <h3 class="my-2">Shaxsni tasdiqlash malumotlari</h3>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-3 mb-2">
                                <label for="passport_serial" class="col-md-6 col-form-label">@lang('cruds.client.fields.passport_serial')</label>
                                <input class="form-control {{ $errors->has('passport_serial') ? 'is-invalid' : '' }}"
                                    type="text" name="passport_serial" id="passport_serial"
                                    placeholder="@lang('cruds.client.fields.passport_serial')" value="{{ old('passport_serial') }}" minlength="9"
                                    maxlength="10">
                                @if ($errors->has('passport_serial'))
                                    <span class="error invalid-feedback">{{ $errors->first('passport_serial') }}</span>
                                @endif
                            </div>

                            <div class="col-12 col-md-6 col-lg-6 col-xl-3 mb-2">
                                <label for="passport_pinfl" class="col-md-6 col-form-label">@lang('cruds.client.fields.passport_pinfl')</label>
                                <input class="form-control {{ $errors->has('passport_pinfl') ? 'is-invalid' : '' }}"
                                    type="number" name="passport_pinfl" id="passport_pinfl"
                                    placeholder="@lang('cruds.client.fields.passport_pinfl')" value="{{ old('passport_pinfl') }}" minlength="14"
                                    maxlength="14">
                                @if ($errors->has('passport_pinfl'))
                                    <span class="error invalid-feedback">{{ $errors->first('passport_pinfl') }}</span>
                                @endif
                            </div>

                            <div class="col-12 col-md-6 col-lg-6 col-xl-3 mb-2">
                                <label for="passport_date" class="col-md-4 col-form-label">@lang('cruds.client.fields.passport_date')</label>
                                <input class="form-control {{ $errors->has('passport_date') ? 'is-invalid' : '' }}"
                                    type="date" name="passport_date" id="passport_date"
                                    placeholder="@lang('cruds.client.fields.passport_date')" value="{{ old('passport_date') }}">
                                @if ($errors->has('passport_date'))
                                    <span class="error invalid-feedback">{{ $errors->first('passport_date') }}</span>
                                @endif
                            </div>

                            <div class="col-12 col-md-6 col-lg-6 col-xl-3 mb-2">
                                <label for="passport_location" class="col-md-6 col-form-label">@lang('cruds.client.fields.passport_location')</label>
                                <input class="form-control {{ $errors->has('passport_location') ? 'is-invalid' : '' }}"
                                    type="text" name="passport_location" id="passport_location"
                                    placeholder="@lang('cruds.client.fields.passport_location')" value="{{ old('passport_location') }}">
                                @if ($errors->has('passport_location'))
                                    <span class="error invalid-feedback">{{ $errors->first('passport_location') }}</span>
                                @endif
                            </div>

                            <div class="col-12 col-md-6 col-lg-6 col-xl-12 mb-2">
                                <label for="home_address" class="col-md-6 col-form-label">@lang('global.home_address_title')</label>
                                <input class="form-control {{ $errors->has('home_address') ? 'is-invalid' : '' }}"
                                    type="text" name="home_address" id="home_address"
                                    placeholder="@lang('global.home_address')" value="{{ old('home_address') }}">
                                @if ($errors->has('home_address'))
                                    <span class="error invalid-feedback">{{ $errors->first('home_address') }}</span>
                                @endif
                            </div>

                        </div>

                        <script>
                            $(document).ready(function() {
                                $('#myForm').on('keypress', function(e) {
                                    if (e.which === 13) {
                                        e.preventDefault();
                                    }
                                });
                            });
                        </script>

                        <script>
                            $(document).ready(function() {
                                $('#mijoz_turi').on('change', function() {
                                    if (this.value === 'fizik') {
                                        $('#make_hide').show();
                                        $('#make_show').hide();
                                    } else if (this.value === 'yuridik') {
                                        $('#make_hide').hide();
                                        $('#make_show').show();
                                    }
                                }).trigger('change');
                            });
                        </script>







                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button fw-medium collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                        aria-expanded="false" aria-controls="flush-collapseOne">
                                        Объект #0
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse show"
                                    aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body text-muted">
                                        <main class="main_of_objects">

                                            <div class="row">
                                                <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                    <div class="mb-3">
                                                        <label for="notification_num">@lang('cruds.branches.fields.notification_num')</label>
                                                        <input type="text" class="form-control"
                                                            name="accordions[0][notification_num]"
                                                            placeholder="@lang('cruds.branches.fields.notification_num')"
                                                            value="{{ old('accordions.0.notification_num') }}">

                                                        @error('accordions.0.notification_num')
                                                            <span class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>



                                                <!-- New fields -->
                                                <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                    <div class="mb-3">
                                                        <label for="shaxarsozlik_umumiy_xajmi">@lang('global.shaxarsozlik_umumiy_xajmi')</label>
                                                        <input type="number"
                                                            class="form-control shaxarsozlik_umumiy_xajmi"
                                                            name="accordions[0][shaxarsozlik_umumiy_xajmi]"
                                                            placeholder="@lang('global.shaxarsozlik_umumiy_xajmi')"
                                                            value="{{ old('accordions.0.shaxarsozlik_umumiy_xajmi') }}">
                                                        @error('accordions.0.shaxarsozlik_umumiy_xajmi')
                                                            <span class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                    <div class="mb-3">
                                                        <label for="qavatlar_soni_xajmi">@lang('global.qavatlar_soni_xajmi')</label>
                                                        <input type="number" class="form-control qavatlar_soni_xajmi"
                                                            name="accordions[0][qavatlar_soni_xajmi]"
                                                            placeholder="@lang('global.qavatlar_soni_xajmi')"
                                                            value="{{ old('accordions.0.qavatlar_soni_xajmi') }}">
                                                        @error('accordions.0.qavatlar_soni_xajmi')
                                                            <span class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                    <div class="mb-3">
                                                        <label for="avtoturargoh_xajmi">@lang('global.avtoturargoh_xajmi')</label>
                                                        <input type="number" class="form-control avtoturargoh_xajmi"
                                                            name="accordions[0][avtoturargoh_xajmi]"
                                                            placeholder="@lang('global.avtoturargoh_xajmi')"
                                                            value="{{ old('accordions.0.avtoturargoh_xajmi') }}">
                                                        @error('accordions.0.avtoturargoh_xajmi')
                                                            <span class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                    <div class="mb-3">
                                                        <label for="qavat_xona_xajmi">@lang('global.qavat_xona_xajmi')</label>
                                                        <input type="number" class="form-control qavat_xona_xajmi"
                                                            name="accordions[0][qavat_xona_xajmi]"
                                                            placeholder="@lang('global.qavat_xona_xajmi')"
                                                            value="{{ old('accordions.0.qavat_xona_xajmi') }}">
                                                        @error('accordions.0.qavat_xona_xajmi')
                                                            <span class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                    <div class="mb-3">
                                                        <label
                                                            for="umumiy_foydalanishdagi_xajmi">@lang('global.umumiy_foydalanishdagi_xajmi')</label>
                                                        <input type="number"
                                                            class="form-control umumiy_foydalanishdagi_xajmi"
                                                            name="accordions[0][umumiy_foydalanishdagi_xajmi]"
                                                            placeholder="@lang('global.umumiy_foydalanishdagi_xajmi')"
                                                            value="{{ old('accordions.0.umumiy_foydalanishdagi_xajmi') }}">
                                                        @error('accordions.0.umumiy_foydalanishdagi_xajmi')
                                                            <span class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 col-lg-12 col-xl-12">
                                                    <div class="mb-3">
                                                        <label for="branch_location">@lang('cruds.company.fields.branch_location')</label>
                                                        <input type="text" class="form-control branch_location"
                                                            name="accordions[0][branch_location]"
                                                            placeholder="@lang('cruds.company.fields.branch_location')"
                                                            value="{{ old('accordions.0.branch_location') }}">
                                                        @error('accordions.0.branch_location')
                                                            <span class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="mb-3">
                                                        <label for="obyekt_joylashuvi">Obyektning
                                                            joylashuvi</label>
                                                        <select class="form-control select2 form-select"
                                                            name="accordions[0][obyekt_joylashuvi]"
                                                            id="obyekt_joylashuvi">
                                                            <option value="">Obyektning joylashuvi</option>
                                                            <option
                                                                value="Metro bekatidan chiqish joyidan obyekt chegarasig‘acha 200 metr radius oralig‘i hududlardan boshqa hududlarda joylashgan loyihaviy binolar (inshootlar)"
                                                                data-kt="0.6">
                                                                Metro bekatidan chiqish joyidan obyekt
                                                                chegarasig‘acha 200 metr radius oralig‘i hududlardan
                                                                boshqa hududlarda joylashgan loyihaviy binolar
                                                                (inshootlar)
                                                            </option>
                                                            <option
                                                                value="Mazkur bo‘limning 1-qatorida ko‘rsatilmagan boshqa obyektlar"
                                                                data-kt="1">
                                                                Mazkur bo‘limning 1-qatorida ko‘rsatilmagan boshqa
                                                                obyektlar
                                                            </option>
                                                        </select>
                                                        @error('accordions.0.obyekt_joylashuvi')
                                                            <span class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="mb-3">
                                                        <label for="branch_type">@lang('global.loyiha_turi')</label>
                                                        <select class="form-control select2 form-select"
                                                            name="accordions[0][branch_type]" id="branch_type">
                                                            <option value="">@lang('global.loyiha_turi')</option>
                                                            <option
                                                                value="Alohida turgan xususiy ijtimoiy infratuzilma va turizm obyektlari"
                                                                data-kt="0.5">
                                                                Alohida turgan xususiy ijtimoiy infratuzilma va
                                                                turizm obyektlari
                                                            </option>
                                                            <option
                                                                value="Davlat ulushi 50 (ellik) foizdan ortiq bo‘lgan davlat va (yoki) munitsipal mulk negizida amalga oshiriladigan investitsiya loyihalari doirasidagi obyektlar"
                                                                data-kt="0.5">
                                                                Davlat ulushi 50 (ellik) foizdan ortiq bo‘lgan
                                                                davlat va (yoki) munitsipal mulk negizida amalga
                                                                oshiriladigan investitsiya loyihalari doirasidagi
                                                                obyektlar
                                                            </option>
                                                            <option
                                                                value="Ishlab chiqarish korxonalarining umumiy ovqatlanish joylari, sport-sog‘lomlashtirish zallari (xonalari), ofislar va turar joylarni qurish, renovatsiya va rekonstruksiya qilish uchun"
                                                                data-kt="0.5">
                                                                Ishlab chiqarish korxonalarining umumiy ovqatlanish
                                                                joylari, sport-sog‘lomlashtirish zallari (xonalari),
                                                                ofislar va turar joylarni qurish, renovatsiya va
                                                                rekonstruksiya qilish uchun
                                                            </option>
                                                            <option
                                                                value="Omborxonalarni har bir qavati uchun 2 (ikki) metr balandlikdan oshmagan oʻlchamda (omborxonalarining ma’muriy-xo‘jalik majmuasi sifadida foydalaniladigan, alohida turgan kapital binolar, shu jumladan, umumiy ovqatlanish joylari, sport-sog‘lomlashtirish zallari (xonalari), ofislar, turar joylar bundan mustasno)"
                                                                data-kt="0.5">
                                                                Omborxonalarni har bir qavati uchun 2 (ikki) metr
                                                                balandlikdan oshmagan oʻlchamda (omborxonalarining
                                                                ma’muriy-xo‘jalik majmuasi sifadida
                                                                foydalaniladigan, alohida turgan kapital binolar,
                                                                shu jumladan, umumiy ovqatlanish joylari,
                                                                sport-sog‘lomlashtirish zallari (xonalari), ofislar,
                                                                turar joylar bundan mustasno)
                                                            </option>
                                                            <option
                                                                value="Mazkur bo‘limning 1–5-qatorlarida ko‘rsatilmagan boshqa obyektlar"
                                                                data-kt="1">
                                                                Mazkur bo‘limning 1–5-qatorlarida ko‘rsatilmagan
                                                                boshqa obyektlar
                                                            </option>
                                                        </select>
                                                        @error('accordions.0.branch_type')
                                                            <span class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="mb-3">
                                                        <label for="qurilish_turi">@lang('global.qurilish_turi')</label>
                                                        <select class="form-control select2 form-select"
                                                            name="accordions[0][qurilish_turi]" id="qurilish_turi">
                                                            <option value="">@lang('global.qurilish_turi')</option>
                                                            <option value="Yangi kapital qurilish" data-kt="1">
                                                                Yangi kapital qurilish
                                                            </option>
                                                            <option
                                                                value="Obyektni rekonstruksiya qilish (koeffitsiyent obyetkga qo‘shilgan qurilish hajmiga hisoblanadi)"
                                                                data-kt="1">
                                                                Obyektni rekonstruksiya qilish (koeffitsiyent
                                                                obyetkga qo‘shilgan qurilish hajmiga hisoblanadi)
                                                            </option>
                                                            <option
                                                                value="O‘zbekiston Respublikasi Shaharsozlik kodeksiga muvofiq loyiha-smeta hujjatlari ekpertizasi talab etilmaydigan obyektlarini rekonstruksiya qilish"
                                                                data-kt="0">
                                                                O‘zbekiston Respublikasi Shaharsozlik kodeksiga
                                                                muvofiq loyiha-smeta hujjatlari ekpertizasi talab
                                                                etilmaydigan obyektlarini rekonstruksiya qilish
                                                            </option>
                                                            <option
                                                                value="Obyektni qurilish hajmini o‘zgartirmagan holda rekonstruksiya qilish"
                                                                data-kt="0">
                                                                Obyektni qurilish hajmini o‘zgartirmagan holda
                                                                rekonstruksiya qilish
                                                            </option>
                                                        </select>
                                                        @error('accordions.0.qurilish_turi')
                                                            <span class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="mb-3">
                                                        <label for="zona">@lang('global.zona')</label>
                                                        <select id="zona" class="form-control select2 form-select"
                                                            name="accordions[0][zona]">
                                                            <option value="">Zona</option>
                                                            <option value="1" data-kt="1.40">1-zona</option>
                                                            <option value="2" data-kt="1.25">2-zona</option>
                                                            <option value="3" data-kt="1.00">3-zona</option>
                                                            <option value="4" data-kt="0.75">4-zona</option>
                                                            <option value="5" data-kt="0.50">5-zona</option>
                                                        </select>
                                                        @error('accordions.0.zona')
                                                            <span class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                    <div class="mb-3">
                                                        <label for="coefficient">@lang('global.coefficient')</label>
                                                        <input type="text" class="form-control coefficient"
                                                            id="coefficient" name="accordions[0][coefficient]" readonly
                                                            value="1.00">
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                    <div class="mb-3">
                                                        <label for="branch_name">@lang('global.loyiha_nomi')</label>
                                                        <input type="text" class="form-control"
                                                            name="accordions[0][branch_name]"
                                                            value="{{ old('accordions.0.branch_name') }}"
                                                            placeholder="@lang('global.loyiha_nomi')">
                                                        @error('accordions.0.branch_name')
                                                            <span class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>


                                                <script src="{{ asset('assets/js/formula.js') }}"></script>
                                                <!-- End new fields -->
                                            </div>

                                            <div class="row">
                                                <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                                                    <div class="inner-repeater mb-4">
                                                        <div data-repeater-list="inner-group" class="inner mb-3">
                                                            <label for="basicpill-cardno-input">@lang('global.obyekt_boyicha_tolanishi_lozim')</label>
                                                            <input type="number" step="0.00001"
                                                                class="form-control branch_kubmetr" placeholder="( m³ )"
                                                                name="accordions[0][branch_kubmetr]"
                                                                value="{{ old('accordions.0.branch_kubmetr') }}"
                                                                onchange="displayFiveDigitsAfterDecimal(this)" readonly>
                                                            @error('accordions.0.branch_kubmetr')
                                                                <span
                                                                    class="error invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <script>
                                                    function displayFiveDigitsAfterDecimal(inputField) {
                                                        var value = parseFloat(inputField.value);
                                                        var roundedValue = value.toFixed(5);
                                                        inputField.value = roundedValue;
                                                    }
                                                </script>

                                                <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                                                    <div class="mb-3">
                                                        <label
                                                            for="basicpill-card-verification-input">@lang('global.bazaviy_xisoblash_miqdori')</label>
                                                        <input type="number" class="form-control minimum_wage"
                                                            placeholder="@lang('global.bazaviy_xisoblash_miqdori')"
                                                            data-original-value="{{ $data->bazaviy_xisoblash_miqdori ?? 0 }}"
                                                            value="{{ $data->bazaviy_xisoblash_miqdori ?? 0 }}"
                                                            readonly />
                                                    </div>
                                                </div>


                                                <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                                                    <div class="mb-3">
                                                        <label
                                                            for="basicpill-card-verification-input">@lang('global.jami_tolanishi_kerak')</label>
                                                        <input type="text" class="form-control generate_price"
                                                            name="accordions[0][generate_price]"
                                                            value="{{ old('accordions.0.generate_price') }}"
                                                            placeholder="@lang('global.jami_tolanishi_kerak')" readonly>
                                                        @error('accordions.0.generate_price')
                                                            <span class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                                                    <div class="mb-3">
                                                        <label>@lang('global.tolash_turlari')</label>
                                                        <select class="form-select payment-type form-control"
                                                            name="accordions[0][payment_type]">
                                                            <option value="pay_full"
                                                                {{ old('accordions.0.payment_type') == 'pay_full' ? 'selected' : '' }}>
                                                                @lang('global.toliq_xajimda_tolash')</option>
                                                            <option value="pay_bolib"
                                                                {{ old('accordions.0.payment_type') == 'pay_bolib' ? 'selected' : '' }}>
                                                                @lang('global.bolib_tolash')</option>
                                                        </select>
                                                        @error('accordions.0.payment_type')
                                                            <span class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="row">
                                                <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                                                    <div class="mb-3">
                                                        <label for="percentage-input">@lang('global.bolib_tolash_foizi_oldindan')</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control percentage-input"
                                                                name="accordions[0][percentage_input]"
                                                                value="{{ old('accordions.0.percentage_input') }}"
                                                                min="0" max="100">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                        @error('accordions.0.percentage_input')
                                                            <span class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                                                    <div class="mb-3">
                                                        <label for="first_payment_percent_0">@lang('cruds.branches.fields.first_payment_percent')</label>
                                                        <input type="text" class="form-control first_payment_percent"
                                                            name="accordions[0][first_payment_percent]"
                                                            value="{{ old('accordions.0.first_payment_percent') }}"
                                                            id="first_payment_percent_0">
                                                        @error('accordions.0.first_payment_percent')
                                                            <span class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                                                    <div class="mb-3">
                                                        <label for="quarterly-input">@lang('global.bolib_tolash_har_chorakda')</label>
                                                        <input type="number" class="form-control quarterly-input"
                                                            name="accordions[0][installment_quarterly]"
                                                            value="{{ old('accordions.0.installment_quarterly') }}"
                                                            placeholder="@lang('global.bolib_tolash_har_chorakda')" disabled>
                                                        @error('accordions.0.installment_quarterly')
                                                            <span class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                                                    <div class="mb-3">
                                                        <label
                                                            for="calculated-quarterly-payment">@lang('global.quarterly_payment')</label>
                                                        <input type="text"
                                                            class="form-control calculated-quarterly-payment"
                                                            value="{{ old('accordions.0.calculated_quarterly_payment') }}"
                                                            placeholder="@lang('global.quarterly_payment')" readonly>
                                                        @error('accordions.0.calculated_quarterly_payment')
                                                            <span class="error invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- file start --}}
                                            
                                <div class="row" style="align-items: center">
                                  
                                <link rel="stylesheet"
                                href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
                            <style>
                                .file-upload-card {
                                    border: 1px solid #ddd;
                                    border-radius: 8px;
                                    padding: 15px;
                                    margin-bottom: 15px;
                                }

                                .file-list-item {
                                    display: flex;
                                    align-items: center;
                                    padding: 8px 0;
                                    border-bottom: 1px solid #ddd;
                                }

                                .file-list-item:last-child {
                                    border-bottom: none;
                                }

                                .file-icon {
                                    margin-right: 10px;
                                    font-size: 1.2rem;
                                }

                                .file-label {
                                    margin-left: 10px;
                                    font-weight: bold;
                                    color: #555;
                                }

                                .label-document {
                                    color: #007bff;
                                }

                                .label-payment {
                                    color: #28a745;
                                }

                                .label-ruxsatnoma {
                                    color: #ffc107;
                                }

                                .label-kengash {
                                    color: #dc3545;
                                }

                                .delete-checkbox {
                                    margin-left: auto;
                                }
                            </style>
                               <div class="col-12 col-md-6 col-lg-6 col-xl-3 my-2">
                                <div class="file-upload-card">
                                    <label class="col-12 mt-2" for="file">Loyiha xujjati</label>
                                    <input type="file" name="loyiha_xujjati[]" multiple id="loyiha_xujjati" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpeg,.jpg" onchange="validateFileSize(this)">
                                    @if ($errors->has('loyiha_xujjati'))
                                        <span class="error invalid-feedback">{{ $errors->first('loyiha_xujjati') }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-6 col-lg-6 col-xl-3 my-2">
                                <div class="file-upload-card">
                                    <label class="col-12 mt-2" for="file">Qurilish xajmi xaqida ma'lumot</label>
                                    <input type="file" name="qurilish_xajmi[]" multiple id="qurilish_xajmi" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpeg,.jpg" onchange="validateFileSize(this)">
                                    @if ($errors->has('qurilish_xajmi'))
                                        <span class="error invalid-feedback">{{ $errors->first('qurilish_xajmi') }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <script>
                                function validateFileSize(input) {
                                    const maxFileSize = 5 * 1024 * 1024; 
                                    for (let i = 0; i < input.files.length; i++) {
                                        if (input.files[i].size > maxFileSize) {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                text: 'Fayl hajmi 5 MB dan kam bo\'lishi kerak.'
                                            });
                                            input.value = ''; 
                                            return false;
                                        }
                                    }
                                    return true;
                                }

                            </script>
                            
                                </div>
                                        </main>
                                    </div>
                                </div>
                            </div>



                            {{-- <div id="addAccordion" class="btn btn-success mt-3">@lang('global.add_object') + </div> --}}

                            <!-- Confirm Details -->
                        </div>
                        <button class="btn btn-primary mt-3" type="submit">@lang('global.save')</button>
                        <h4 class="text-center my-2">Taklif va e'tirozlar uchun <a target="_blank"
                                href="https://t.me/tashinvestcom">Telegram</a></h4>

                    </form>
                    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        $(document).ready(function() {
                            $('#myForm').submit(function(event) {
                                event.preventDefault();

                                let csrfToken = $('meta[name="csrf-token"]').attr('content');
                                let formData = new FormData(this);
                                formData.append('_token', csrfToken);

                                $.ajax({
                                    url: $(this).attr('action'),
                                    method: $(this).attr('method'),
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken
                                    },
                                    success: function(response) {
                                        let html = `
                                        <table class="table">
                                            <tbody>
                                                <tr><th>Ism</th><td>${formData.get('first_name')}</td></tr>
                                                <tr><th>Familya</th><td>${formData.get('last_name')}</td></tr>
                                                <tr><th>Otasining ismi</th><td>${formData.get('father_name')}</td></tr>
                                                <tr><th>Kontakt</th><td>${formData.get('contact')}</td></tr>
                                        `;

                                            if (formData.get('mijoz_turi') === 'fizik') {
                                                html += `
                                                <tr><th>Passport Seria</th><td>${formData.get('passport_serial')}</td></tr>
                                                <tr><th>Passport PINFL</th><td>${formData.get('passport_pinfl')}</td></tr>
                                                <tr><th>Passport Sana</th><td>${formData.get('passport_date')}</td></tr>
                                                <tr><th>Passport Manzil</th><td>${formData.get('passport_location')}</td></tr>
                                                <tr><th>Doimiy ro\'yxatda turish manzil</th><td>${formData.get('home_address')}</td></tr>
                                            `;
                                            } else {
                                                html += `
                                                <tr><th>Kopmaniya nomi'</th><td>${formData.get('company_name')}</td></
                                                <tr><th>Raxbar</th><td>${formData.get('raxbar')}</td></tr>
                                                <tr><th>Bank Code</th><td>${formData.get('bank_code')}</td></tr>
                                                <tr><th>Bank Service</th><td>${formData.get('bank_service')}</td></tr>
                                                <tr><th>Bank Account</th><td>${formData.get('bank_account')}</td></tr>
                                                <tr><th>STIR</th><td>${formData.get('stir')}</td></tr>
                                                <tr><th>OKED</th><td>${formData.get('oked')}</td></tr>
                                                <tr><th>Yuridik manzil</th><td>${formData.get('yuridik_address')}</td></tr>
                                                <tr><th>Kompaniya joylashuvi</th><td>${formData.get('company_location')}</td></tr>
                                            `;
                                            }
                                            html += `
                                            <tr><th>Shaxarsozlik Umumiy Xajmi</th><td>${formData.get('accordions[0][shaxarsozlik_umumiy_xajmi]')}</td></tr>
                                            <tr><th>Qavatlar Soni Xajmi</th><td>${formData.get('accordions[0][qavatlar_soni_xajmi]')}</td></tr>
                                            <tr><th>Avtoturargoh Xajmi</th><td>${formData.get('accordions[0][avtoturargoh_xajmi]')}</td></tr>
                                            <tr><th>Qavat Xona Xajmi</th><td>${formData.get('accordions[0][qavat_xona_xajmi]')}</td></tr>
                                            <tr><th>Umumiy Foydalanishdagi Xajmi</th><td>${formData.get('accordions[0][umumiy_foydalanishdagi_xajmi]')}</td></tr>
                                            <tr><th>Qurilish Turi</th><td>${formData.get('accordions[0][qurilish_turi]')}</td></tr>
                                            <tr><th>Koeffitsient</th><td>${formData.get('accordions[0][coefficient]')}</td></tr>
                                            <tr><th>Zona</th><td>${formData.get('accordions[0][zona]')}</td></tr>
                                            <tr><th>Obyekt xajmi</th><td>${formData.get('accordions[0][branch_kubmetr]')}</td></tr>
                                            <tr><th>Obyekt turi</th><td>${formData.get('accordions[0][branch_type]')}</td></tr>
                                            <tr><th>Obyekt manzili</th><td>${formData.get('accordions[0][branch_location]')}</td></tr>
                                            <tr><th>Obyekt joylashuvi</th><td>${formData.get('accordions[0][obyekt_joylashuvi]')}</td></tr>
                                            <tr><th>Obyekt nomi</th><td>${formData.get('accordions[0][branch_name]')}</td></tr>
                                            <tr><th>Generate Price</th><td>${formData.get('accordions[0][generate_price]')}</td></tr>
                                            <tr><th>To\'lov turi</th><td>${formData.get('accordions[0][payment_type]')}</td></tr>
                                            <tr><th>Foiz</th><td>${formData.get('accordions[0][percentage_input]')}</td></tr>
                                            <tr><th>Ruxsatnoma raqami</th><td>${formData.get('accordions[0][notification_num]')}</td></tr>
                                            <tr><th>Ruxsatnoma sanasi</th><td>${formData.get('accordions[0][notification_date]')}</td></tr>
                                            <tr><th>Birinchi toʻlov foizi</th><td>${formData.get('accordions[0][first_payment_percent]')}</td></tr>
                                        `;

                                            html += '</tbody></table>';
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Success!',
                                                html: html,
                                                showCancelButton: true,
                                                confirmButtonText: 'Yuborish',
                                                cancelButtonText: 'Ortga',
                                                customClass: {
                                                    popup: 'swal2-xl'
                                                },
                                            }).then(function(result) {
                                                if (result.isConfirmed) {
                                                    if (response.success) {
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Malumot Saqlandi!',
                                                            text: 'Barcha ma\'lumotlar muvaffaqiyatli saqlandi.',
                                                        }).then(function() {
                                                            window.location.reload();
                                                        });
                                                    } else {
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Xatolik!',
                                                            text: 'Maʼlumotlarni saqlashda xatolik yuz berdi.',
                                                        });
                                                    }
                                                }
                                            });
                                        },

                                        error: function(response) {
                                            if (response.status === 422) {
                                                let errors = response.responseJSON.errors;

                                                // Prepare error message as HTML list
                                                let errorMessage = '<ul clas">';
                                                for (let field in errors) {
                                                    errorMessage += `<li class="error_message">${errors[field][0]}</li>`;
                                                }
                                                errorMessage += '</ul>';

                                                // Display errors in a Swal.fire modal
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Tasdiqlash xatosi!',
                                                    html: errorMessage,
                                                    customClass: {
                                                        popup: 'swal2-xl' // Optional: Apply custom styling
                                                    }
                                                });
                                            } else {
                                                // Handle other types of errors
                                                let errorMessage = 'Kutilmagan xatolik yuz berdi. Iltimos keyinroq qayta urinib ko\'ring.';
                                                if (response.responseJSON && response.responseJSON.message) {
                                                    errorMessage = response.responseJSON.message;
                                                }
                                                
                                                // Display generic error message
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Xatolik!',
                                                    text: errorMessage
                                                });
                                            }
                                    }
                                    

                                });
                            });
                        });
                    </script>


                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

        </div>
        <!-- end col -->
    </div>
@endsection


@section('scripts')
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script> --}}
    <script src="{{ asset('assets/libs/jquery-steps/build/jquery.steps.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/pages/form-wizard.init.js') }}"></script> --}}
    <script src="{{ asset('assets/js/pages/form-repeater.int.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery.repeater/jquery.repeater.min.js') }}"></script>
@endsection
