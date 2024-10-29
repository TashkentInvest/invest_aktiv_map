@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">@lang('cruds.branches.title') Edit</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #007bff;">@lang('global.home')</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('clientIndex') }}"
                                style="color: #007bff;">@lang('cruds.branches.title') Edit</a></li>
                        <li class="breadcrumb-item active">@lang('global.add')</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('clientUpdate', ['id' => $client->id]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div id="vertical-example" class="vertical-wizard wizard clearfix vertical">
                            <h3>@lang('global.personal_informations')</h3>
                            <section>

                                <div class="row">
                                    <div class="col-12 col-lg-4 col-xl-4 mb-2">
                                        <label for="mijoz_turi">@lang('cruds.client.fields.mijoz_turi')</label>
                                        <select class="form-control" name="mijoz_turi" id="mijoz_turi">
                                            <option value="fizik"
                                                {{ old('mijoz_turi', $client->mijoz_turi) == 'fizik' ? 'selected' : '' }}>
                                                @lang('cruds.client.fields.mijoz_turi_fizik')</option>
                                            <option value="yuridik"
                                                {{ old('mijoz_turi', $client->mijoz_turi) == 'yuridik' ? 'selected' : '' }}>
                                                @lang('cruds.client.fields.mijoz_turi_yuridik')</option>
                                        </select>
                                        @if ($errors->has('mijoz_turi'))
                                            <span class="error invalid-feedback">{{ $errors->first('mijoz_turi') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-12 col-lg-4 col-xl-4 mb-2">
                                        <label for="category_id">@lang('global.category')</label>
                                        <select class="form-control" name="category_id" id="category_id">
                                            @foreach ($categories as $c)
                                                <option value="{{ $c->id }}"
                                                    {{ old('category_id', $client->category_id) == $c->id ? 'selected' : '' }}>
                                                    {{ $c->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category_id'))
                                            <span class="error invalid-feedback">{{ $errors->first('category_id') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-4 col-xl-4 mb-2">
                                        <label for="stir">@lang('cruds.company.fields.stir')</label>
                                        <input class="form-control {{ $errors->has('stir') ? 'is-invalid' : '' }}"
                                            type="number" name="stir" id="stir" placeholder="@lang('cruds.company.fields.stir')"
                                            value="{{ old('stir', $client->company->stir ?? '') }}" minlength="9"
                                            maxlength="9">
                                        @if ($errors->has('stir'))
                                            <span class="error invalid-feedback">{{ $errors->first('stir') }}</span>
                                        @endif
                                    </div>

                                </div>


                                <div class="row" id="make_show" style="display: none;">

                                    <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                        <div class="mb-3">
                                            <label for="company_name">@lang('global.company_name')</label>
                                            <input type="text" class="form-control" name="company_name"
                                                value="{{ old('company_name', $client->company->company_name ?? '') }}"
                                                placeholder="@lang('global.loyiha_nomi')">
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                        <label for="raxbar">@lang('cruds.company.fields.raxbar') -
                                            @lang('global.client_name')</label>
                                        <input class="form-control {{ $errors->has('raxbar') ? 'is-invalid' : '' }}"
                                            type="text" name="raxbar" id="raxbar" placeholder="@lang('cruds.company.fields.raxbar')"
                                            value="{{ old('raxbar', $client->company->raxbar ?? '') }}">
                                        @if ($errors->has('raxbar'))
                                            <span class="error invalid-feedback">{{ $errors->first('raxbar') }}</span>
                                        @endif
                                    </div>


                                    <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                        <label for="oked">@lang('cruds.company.fields.oked')</label>
                                        <input class="form-control {{ $errors->has('oked') ? 'is-invalid' : '' }}"
                                            type="number" name="oked" id="oked" placeholder="@lang('cruds.company.fields.oked')"
                                            value="{{ old('oked', $client->company->oked ?? '') }}" minlength="5"
                                            maxlength="5">
                                        @if ($errors->has('oked'))
                                            <span class="error invalid-feedback">{{ $errors->first('oked') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                                        <label for="bank_service">@lang('cruds.company.fields.bank_service')</label>
                                        <input class="form-control {{ $errors->has('bank_service') ? 'is-invalid' : '' }}"
                                            type="text" name="bank_service" id="bank_service"
                                            placeholder="@lang('cruds.company.fields.bank_service')"
                                            value="{{ old('bank_service', $client->company->bank_service ?? '') }}">
                                        @if ($errors->has('bank_service'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('bank_service') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-4 col-xl-4 mb-2">
                                        <label for="bank_code">@lang('cruds.company.fields.bank_code')</label>
                                        <input class="form-control {{ $errors->has('bank_code') ? 'is-invalid' : '' }}"
                                            type="number" name="bank_code" id="bank_code" placeholder="@lang('cruds.company.fields.bank_code')"
                                            value="{{ old('bank_code', $client->company->bank_code ?? '') }}" minlength="5"
                                            maxlength="5" name="bank_code" id="bank_code">

                                        @if ($errors->has('bank_code'))
                                            <span class="error invalid-feedback">{{ $errors->first('bank_code') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-4 col-xl-4 mb-2">
                                        <label for="bank_account">@lang('cruds.company.fields.bank_account')</label>
                                        <input class="form-control {{ $errors->has('bank_account') ? 'is-invalid' : '' }}"
                                            type="number" name="bank_account" id="bank_account"
                                            placeholder="@lang('cruds.company.fields.bank_account')"
                                            value="{{ old('bank_account', $client->company->bank_account ?? '') }}"
                                            minlength="20" maxlength="20" name="bank_account" id="alloptions">

                                        @if ($errors->has('bank_account'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('bank_account') }}</span>
                                        @endif
                                    </div>


                                    <div class="col-12 col-md-6 col-lg-4 col-xl-4 mb-2">
                                        <label for="yuridik_address">@lang('cruds.client.fields.yuridik_address')</label>
                                        <input
                                            class="form-control {{ $errors->has('yuridik_address') ? 'is-invalid' : '' }}"
                                            type="text" name="yuridik_address" id="yuridik_address"
                                            placeholder="@lang('cruds.client.fields.yuridik_address')"
                                            value="{{ old('yuridik_address', $client->address->yuridik_address ?? '') }}">
                                        @if ($errors->has('yuridik_address'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('yuridik_address') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6 col-xl-3 mb-2">
                                        <label for="last_name">@lang('cruds.client.fields.last_name')</label>
                                        <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                                            type="text" name="last_name" id="last_name"
                                            placeholder="@lang('cruds.client.fields.last_name')"
                                            value="{{ old('last_name', $client->last_name) }}">
                                        @if ($errors->has('last_name'))
                                            <span class="error invalid-feedback">{{ $errors->first('last_name') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-6 col-xl-3 mb-2">
                                        <label for="name">@lang('cruds.client.fields.name')</label>
                                        <input class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                                            type="text" name="first_name" id="first_name"
                                            placeholder="@lang('cruds.client.fields.first_name')"
                                            value="{{ old('first_name', $client->first_name) }}">
                                        @if ($errors->has('first_name'))
                                            <span class="error invalid-feedback">{{ $errors->first('first_name') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-6 col-xl-3 mb-2">
                                        <label for="father_name">@lang('cruds.client.fields.father_name')</label>
                                        <input class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}"
                                            type="text" name="father_name" id="father_name"
                                            placeholder="@lang('cruds.client.fields.father_name')"
                                            value="{{ old('father_name', $client->father_name) }}">
                                        @if ($errors->has('father_name'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('father_name') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-6 col-xl-3 mb-2">
                                        <label for="contact">@lang('cruds.client.fields.contact')</label>
                                        <input class="form-control {{ $errors->has('contact') ? 'is-invalid' : '' }}"
                                            type="text" name="contact" id="contact"
                                            placeholder="@lang('cruds.client.fields.contact')"
                                            value="{{ old('contact', $client->contact) }}">
                                        @if ($errors->has('contact'))
                                            <span class="error invalid-feedback">{{ $errors->first('contact') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row" id="make_hide">

                                    <div class="col-12 col-md-6 col-lg-6 col-xl-3 mb-2">
                                        <label for="passport_serial">@lang('cruds.client.fields.passport_serial')</label>
                                        <input
                                            class="form-control {{ $errors->has('passport_serial') ? 'is-invalid' : '' }}"
                                            type="text" name="passport_serial" id="passport_serial"
                                            placeholder="@lang('cruds.client.fields.passport_serial')"
                                            value="{{ old('passport_serial', $client->passport->passport_serial ?? '') }}"
                                            minlength="9" maxlength="10">
                                        @if ($errors->has('passport_serial'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('passport_serial') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-6 col-xl-3 mb-2">
                                        <label for="passport_pinfl">@lang('cruds.client.fields.passport_pinfl')</label>
                                        <input
                                            class="form-control {{ $errors->has('passport_pinfl') ? 'is-invalid' : '' }}"
                                            type="number" name="passport_pinfl" id="passport_pinfl"
                                            placeholder="@lang('cruds.client.fields.passport_pinfl')"
                                            value="{{ old('passport_pinfl', $client->passport->passport_pinfl ?? '') }}"
                                            minlength="14" maxlength="14">
                                        @if ($errors->has('passport_pinfl'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('passport_pinfl') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-6 col-xl-3 mb-2">
                                        <label for="passport_date">@lang('cruds.client.fields.passport_date')</label>
                                        <input
                                            class="form-control {{ $errors->has('passport_date') ? 'is-invalid' : '' }}"
                                            type="date" name="passport_date" id="passport_date"
                                            placeholder="@lang('cruds.client.fields.passport_date')"
                                            value="{{ old('passport_date', $client->passport->passport_date ?? '') }}">
                                        @if ($errors->has('passport_date'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('passport_date') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-6 col-xl-3 mb-2">
                                        <label for="passport_location">@lang('cruds.client.fields.passport_location')</label>
                                        <input
                                            class="form-control {{ $errors->has('passport_location') ? 'is-invalid' : '' }}"
                                            type="text" name="passport_location" id="passport_location"
                                            placeholder="@lang('cruds.client.fields.passport_location')"
                                            value="{{ old('passport_location', $client->passport->passport_location ?? '') }}">
                                        @if ($errors->has('passport_location'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('passport_location') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-6 col-xl-3 mb-2">
                                        <label for="home_address">@lang('global.home_address')</label>
                                        <input class="form-control {{ $errors->has('home_address') ? 'is-invalid' : '' }}"
                                            type="text" name="home_address" id="home_address"
                                            placeholder="@lang('global.home_address')"
                                            value="{{ old('home_address', $client->address->home_address ?? '') }}">
                                        @if ($errors->has('home_address'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('home_address') }}</span>
                                        @endif
                                    </div>


                                    <div class="col-12 col-md-6 col-lg-6 col-xl-3 mb-2">
                                        <label for="is_passport_id">Is passport
                                            ID?</label>
                                        <input type="checkbox" name="passport_type" id="is_passport_id" value="1">
                                    </div>

                                </div>

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

                                <div class="row" style="align-items: center">
                                    <div class="col-12 col-md-12 col-lg-12 col-xl-12 mb-2">
                                        <label for="client_description">@lang('cruds.client.fields.client_description')</label>
                                        <textarea id="textarea" name="client_description"
                                            class="form-control {{ $errors->has('client_description') ? 'is-invalid' : '' }}" rows="3"
                                            placeholder="@lang('cruds.client.fields.client_description')">{{ old('client_description', $client->client_description ?? '') }}</textarea>
                                        @if ($errors->has('client_description'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('client_description') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-6 col-xl-3 my-2">
                                        <div class="file-upload-card">
                                            <label class="col-12 mt-2" for="file"> Document</label>
                                            <input type="file" name="document[]" multiple>
                                            @if ($errors->has('document'))
                                                <span
                                                    class="error invalid-feedback">{{ $errors->first('document') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-6 col-xl-3 my-2">
                                        <div class="file-upload-card">
                                            <label class="col-12 mt-2" for="file">Paymnet</label>
                                            <input type="file" name="document_payment[]" multiple>
                                            @if ($errors->has('document_payment'))
                                                <span
                                                    class="error invalid-feedback">{{ $errors->first('document_payment') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-6 col-xl-3 my-2">
                                        <div class="file-upload-card">
                                            <label class="col-12 mt-2" for="file">Ruxsatnoma</label>
                                            <input type="file" name="document_ruxsatnoma[]" multiple>
                                            @if ($errors->has('document_ruxsatnoma'))
                                                <span
                                                    class="error invalid-feedback">{{ $errors->first('document_ruxsatnoma') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-6 col-xl-3 my-2">
                                        <div class="file-upload-card">
                                            <label class="col-12 mt-2" for="file">Kengash</label>
                                            <input type="file" name="document_kengash[]" multiple>
                                            @if ($errors->has('document_kengash'))
                                                <span
                                                    class="error invalid-feedback">{{ $errors->first('document_kengash') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-6 col-xl-3 my-2">
                                        <div class="file-upload-card">
                                            <label class="col-12 mt-2" for="file"> Loyiha xujjati</label>
                                            <input type="file" name="loyiha_xujjati[]" multiple>
                                            @if ($errors->has('loyiha_xujjati'))
                                                <span
                                                    class="error invalid-feedback">{{ $errors->first('loyiha_xujjati') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-6 col-xl-3 my-2">
                                        <div class="file-upload-card">
                                            <label class="col-12 mt-2" for="file">Qurilish xajmi xaqida ma'lumot</label>
                                            <input type="file" name="qurilish_xajmi[]" multiple>
                                            @if ($errors->has('qurilish_xajmi'))
                                                <span
                                                    class="error invalid-feedback">{{ $errors->first('qurilish_xajmi') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-4">
                                    <h5>@lang('global.uploaded_files')</h5>
                                    <div class="file-list">
                                        @foreach ($files as $file)
                                            <div class="file-list-item">
                                                <i class="fas fa-file-alt file-icon"></i>
                                                <a target="_blank" class="py-2 my-2" href="{{ asset($file->path) }}">
                                                    {{ basename($file->path) }}
                                                </a>
                                                <span
                                                    class="file-label {{ strpos($file->path, 'documents/') !== false
                                                        ? 'label-document'
                                                        : (strpos($file->path, 'payment/') !== false
                                                            ? 'label-document'
                                                            : (strpos($file->path, 'ruxsatnoma/') !== false
                                                                ? 'label-document'
                                                                : (strpos($file->path, 'kengash/') !== false
                                                                    ? 'label-document'
                                                                    : ''))) }}">
                                                    {{   strpos($file->path, 'documents/') !== false
                                                    ? 'Document'
                                                    : (strpos($file->path, 'payment/') !== false
                                                        ? 'Payment'
                                                        : (strpos($file->path, 'ruxsatnoma/') !== false
                                                            ? 'Ruxsatnoma'
                                                            : (strpos($file->path, 'kengash/') !== false
                                                                ? 'Kengash'
                                                                : (strpos($file->path, 'loyiha_xujjati/') !== false
                                                                    ? 'Loyiha Xujjati'
                                                                    : (strpos($file->path, 'qurilish_xajmi/') !== false
                                                                        ? 'Qurilish Xajmi'
                                                                        : ''))))) }}
                                                </span>
                                                @can('client.delete')
                                                    <div class="delete-checkbox">
                                                        <label>
                                                            <input type="checkbox" name="delete_files[]"
                                                                value="{{ $file->id }}">
                                                            Delete
                                                        </label>
                                                    </div>
                                                @endcan
                                            </div>
                                        @endforeach
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

                            </section>


                            <h3>@lang('global.object')</h3>
                            <section>
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    @foreach ($client->branches as $branchIndex => $b)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-heading{{ $branchIndex }}">
                                                <button class="accordion-button fw-medium collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#flush-collapse{{ $branchIndex }}"
                                                    aria-expanded="false"
                                                    aria-controls="flush-collapse{{ $branchIndex }}">
                                                    Accordion Item #{{ $branchIndex }}
                                                </button>
                                            </h2>
                                            <input type="hidden" name="accordions[{{ $branchIndex }}][id]"
                                                value="{{ $b->id }}">

                                            <div id="flush-collapse{{ $branchIndex }}"
                                                class="accordion-collapse collapse show"
                                                aria-labelledby="flush-heading{{ $branchIndex }}"
                                                data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body text-muted">
                                                    <main class="main_of_objects">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                                <div class="mb-3">
                                                                    <label for="contract_apt">@lang('global.ruxsatnoma_raqami')</label>
                                                                    <input type="text" class="form-control"
                                                                        name="accordions[{{ $branchIndex }}][contract_apt]"
                                                                        value="{{ old('accordions.' . $branchIndex . '.contract_apt', $b->contract_apt) }}"
                                                                        placeholder="@lang('global.ruxsatnoma_raqami')">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                                <div class="mb-3">
                                                                    <label for="contract_date">@lang('global.sanasi')</label>
                                                                    <input class="form-control" type="date"
                                                                        name="accordions[{{ $branchIndex }}][contract_date]"
                                                                        value="{{ old('accordions.' . $branchIndex . '.contract_date', $b->contract_date) }}">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="notification_num">@lang('cruds.branches.fields.notification_num')</label>
                                                                    <input type="text" class="form-control"
                                                                        name="accordions[{{ $branchIndex }}][notification_num]"
                                                                        value="{{ old('accordions.' . $branchIndex . '.notification_num', $b->notification_num) }}"
                                                                        placeholder="@lang('cruds.branches.fields.notification_num')">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="notification_date">@lang('cruds.branches.fields.notification_date')</label>
                                                                    <input type="date" class="form-control"
                                                                        name="accordions[{{ $branchIndex }}][notification_date]"
                                                                        value="{{ old('accordions.' . $branchIndex . '.notification_date', $b->notification_date) }}"
                                                                        placeholder="@lang('cruds.branches.fields.notification_date')">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="insurance_policy">@lang('cruds.branches.fields.insurance_policy')</label>
                                                                    <input type="text" class="form-control"
                                                                        name="accordions[{{ $branchIndex }}][insurance_policy]"
                                                                        value="{{ old('accordions.' . $branchIndex . '.insurance_policy', $b->insurance_policy) }}"
                                                                        placeholder="@lang('cruds.branches.fields.insurance_policy')">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                                                                <div class="mb-3">
                                                                    <label for="bank_guarantee">@lang('cruds.branches.fields.bank_guarantee')</label>
                                                                    <input type="text" class="form-control"
                                                                        name="accordions[{{ $branchIndex }}][bank_guarantee]"
                                                                        value="{{ old('accordions.' . $branchIndex . '.bank_guarantee', $b->bank_guarantee) }}"
                                                                        placeholder="@lang('cruds.branches.fields.bank_guarantee')">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 ">
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="application_number">@lang('cruds.branches.fields.application_number')</label>
                                                                    <input type="text" class="form-control"
                                                                        name="accordions[{{ $branchIndex }}][application_number]"
                                                                        value="{{ old('accordions.' . $branchIndex . '.application_number', $b->application_number) }}"
                                                                        placeholder="@lang('cruds.branches.fields.application_number')">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 ">
                                                                <div class="mb-3">

                                                                    <label
                                                                        for="payedSum_{{ $branchIndex }}">@lang('cruds.branches.fields.payed_sum')</label>
                                                                    <input type="text" class="form-control payedSum"
                                                                        id="payedSum_{{ $branchIndex }}"
                                                                        name="accordions[{{ $branchIndex }}][payed_sum]"
                                                                        value="{{ old('accordions.' . $branchIndex . '.payed_sum', $b->payed_sum) }}"
                                                                        placeholder="@lang('cruds.branches.fields.payed_sum')">

                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 ">
                                                                <div class="mb-3">
                                                                    <label for="payed_date">@lang('cruds.branches.fields.payed_date')</label>
                                                                    <input type="date" class="form-control"
                                                                        name="accordions[{{ $branchIndex }}][payed_date]"
                                                                        value="{{ old('accordions.' . $branchIndex . '.payed_date', $b->payed_date) }}"
                                                                        placeholder="@lang('cruds.branches.fields.payed_date')">
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 ">
                                                                <div class="mb-3">
                                                                    <label for="branch_type_text">@lang('cruds.company.fields.branch_type') text</label>
                                                                    <input type="text" class="form-control"
                                                                        name="accordions[{{ $branchIndex }}][branch_type_text]"
                                                                        value="{{ old('accordions.' . $branchIndex . '.branch_type_text', $b->branch_type_text) }}"
                                                                        placeholder="@lang('cruds.company.fields.branch_type')">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">


                                                            <!-- New fields -->
                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="shaxarsozlik_umumiy_xajmi">@lang('global.shaxarsozlik_umumiy_xajmi')</label>
                                                                    <input type="number"
                                                                        class="form-control shaxarsozlik_umumiy_xajmi"
                                                                        name="accordions[{{ $branchIndex }}][shaxarsozlik_umumiy_xajmi]"
                                                                        placeholder="@lang('global.shaxarsozlik_umumiy_xajmi')"
                                                                        value="{{ old('accordions.' . $branchIndex . '.shaxarsozlik_umumiy_xajmi', $b->shaxarsozlik_umumiy_xajmi) }}"
                                                                        step="0.01">
                                                                    @error('accordions.' . $branchIndex .
                                                                        '.shaxarsozlik_umumiy_xajmi')
                                                                        <span
                                                                            class="error invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="qavatlar_soni_xajmi">@lang('global.qavatlar_soni_xajmi')</label>
                                                                    <input type="number"
                                                                        class="form-control qavatlar_soni_xajmi"
                                                                        name="accordions[{{ $branchIndex }}][qavatlar_soni_xajmi]"
                                                                        placeholder="@lang('global.qavatlar_soni_xajmi')"
                                                                        value="{{ old('accordions.' . $branchIndex . '.qavatlar_soni_xajmi', $b->qavatlar_soni_xajmi) }}"
                                                                        step="0.01">
                                                                    @error('accordions.' . $branchIndex .
                                                                        '.qavatlar_soni_xajmi')
                                                                        <span
                                                                            class="error invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>


                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="avtoturargoh_xajmi">@lang('global.avtoturargoh_xajmi')</label>
                                                                    <input type="number"
                                                                        class="form-control avtoturargoh_xajmi"
                                                                        name="accordions[{{ $branchIndex }}][avtoturargoh_xajmi]"
                                                                        placeholder="@lang('global.avtoturargoh_xajmi')"
                                                                        value="{{ old('accordions.' . $branchIndex . '.avtoturargoh_xajmi', $b->avtoturargoh_xajmi) }}"
                                                                        step="0.01">
                                                                    @error('accordions.' . $branchIndex .
                                                                        '.avtoturargoh_xajmi')
                                                                        <span
                                                                            class="error invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="qavat_xona_xajmi">@lang('global.qavat_xona_xajmi')</label>
                                                                    <input type="number"
                                                                        class="form-control qavat_xona_xajmi"
                                                                        name="accordions[{{ $branchIndex }}][qavat_xona_xajmi]"
                                                                        placeholder="@lang('global.qavat_xona_xajmi')"
                                                                        value="{{ old('accordions.' . $branchIndex . '.qavat_xona_xajmi', $b->qavat_xona_xajmi) }}"
                                                                        step="0.01">
                                                                    @error('accordions.' . $branchIndex .
                                                                        '.qavat_xona_xajmi')
                                                                        <span
                                                                            class="error invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="umumiy_foydalanishdagi_xajmi">@lang('global.umumiy_foydalanishdagi_xajmi')</label>
                                                                    <input type="number"
                                                                        class="form-control umumiy_foydalanishdagi_xajmi"
                                                                        name="accordions[{{ $branchIndex }}][umumiy_foydalanishdagi_xajmi]"
                                                                        placeholder="@lang('global.umumiy_foydalanishdagi_xajmi')"
                                                                        value="{{ old('accordions.' . $branchIndex . '.umumiy_foydalanishdagi_xajmi', $b->umumiy_foydalanishdagi_xajmi) }}"
                                                                        step="0.01">
                                                                    @error('accordions.' . $branchIndex .
                                                                        '.umumiy_foydalanishdagi_xajmi')
                                                                        <span
                                                                            class="error invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-6 col-lg-12 col-xl-12">
                                                                <div class="mb-3">
                                                                    <label for="branch_location">@lang('cruds.company.fields.branch_location')</label>
                                                                    <input type="text"
                                                                        class="form-control branch_location"
                                                                        name="accordions[{{ $branchIndex }}][branch_location]"
                                                                        placeholder="@lang('cruds.company.fields.branch_location')"
                                                                        value="{{ old('accordions.' . $branchIndex . '.branch_location', $b->branch_location) }}">
                                                                    @error('accordions.' . $branchIndex .
                                                                        '.branch_location')
                                                                        <span
                                                                            class="error invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>


                                                            <div class="col-12 col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="obyekt_joylashuvi">Obyektning
                                                                        joylashuvi</label>
                                                                    <select
                                                                        class="form-control form_select_cof form-select"
                                                                        name="accordions[{{ $branchIndex }}][obyekt_joylashuvi]"
                                                                        id="obyekt_joylashuvi">
                                                                        <option value="">Obyektning joylashuvi
                                                                        </option>
                                                                        <option
                                                                            value="Metro bekatidan chiqish joyidan obyekt chegarasig‘acha 200 metr radius oralig‘i hududlardan boshqa hududlarda joylashgan loyihaviy binolar (inshootlar)"
                                                                            data-kt="0.6"
                                                                            {{ old('accordions.' . $branchIndex . '.obyekt_joylashuvi', $b->obyekt_joylashuvi) == 'Metro bekatidan chiqish joyidan obyekt chegarasig‘acha 200 metr radius oralig‘i hududlardan boshqa hududlarda joylashgan loyihaviy binolar (inshootlar)' ? 'selected' : '' }}>
                                                                            Metro bekatidan chiqish joyidan obyekt
                                                                            chegarasig‘acha 200 metr radius oralig‘i
                                                                            hududlardan
                                                                            boshqa hududlarda joylashgan loyihaviy binolar
                                                                            (inshootlar)
                                                                        </option>
                                                                        <option
                                                                            value="Mazkur bo‘limning 1-qatorida ko‘rsatilmagan boshqa obyektlar"
                                                                            data-kt="1"
                                                                            {{ old('accordions.' . $branchIndex . '.obyekt_joylashuvi', $b->obyekt_joylashuvi) == 'Mazkur bo‘limning 1-qatorida ko‘rsatilmagan boshqa obyektlar' ? 'selected' : '' }}>
                                                                            Mazkur bo‘limning 1-qatorida ko‘rsatilmagan
                                                                            boshqa obyektlar
                                                                        </option>
                                                                    </select>
                                                                    @error('accordions.' . $branchIndex .
                                                                        '.obyekt_joylashuvi')
                                                                        <span
                                                                            class="error invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="branch_type">@lang('global.loyiha_turi')</label>
                                                                    <select
                                                                        class="form-control form_select_cof form-select"
                                                                        name="accordions[{{ $branchIndex }}][branch_type]"
                                                                        id="branch_type">
                                                                        <option value="">@lang('global.loyiha_turi')</option>
                                                                        <option
                                                                            value="Alohida turgan xususiy ijtimoiy infratuzilma va turizm obyektlari"
                                                                            data-kt="0.5"
                                                                            {{ old('accordions.' . $branchIndex . '.branch_type', $b->branch_type) == 'Alohida turgan xususiy ijtimoiy infratuzilma va turizm obyektlari' ? 'selected' : '' }}>
                                                                            Alohida turgan xususiy ijtimoiy infratuzilma va
                                                                            turizm obyektlari
                                                                        </option>
                                                                        <option
                                                                            value="Davlat ulushi 50 (ellik) foizdan ortiq bo‘lgan davlat va (yoki) munitsipal mulk negizida amalga oshiriladigan investitsiya loyihalari doirasidagi obyektlar"
                                                                            data-kt="0.5"
                                                                            {{ old('accordions.' . $branchIndex . '.branch_type', $b->branch_type) == 'Davlat ulushi 50 (ellik) foizdan ortiq bo‘lgan davlat va (yoki) munitsipal mulk negizida amalga oshiriladigan investitsiya loyihalari doirasidagi obyektlar' ? 'selected' : '' }}>
                                                                            Davlat ulushi 50 (ellik) foizdan ortiq bo‘lgan
                                                                            davlat va (yoki) munitsipal mulk negizida amalga
                                                                            oshiriladigan investitsiya loyihalari
                                                                            doirasidagi obyektlar
                                                                        </option>
                                                                        <option
                                                                            value="Ishlab chiqarish korxonalarining umumiy ovqatlanish joylari, sport-sog‘lomlashtirish zallari (xonalari), ofislar va turar joylarni qurish, renovatsiya va rekonstruksiya qilish uchun"
                                                                            data-kt="0.5"
                                                                            {{ old('accordions.' . $branchIndex . '.branch_type', $b->branch_type) == 'Ishlab chiqarish korxonalarining umumiy ovqatlanish joylari, sport-sog‘lomlashtirish zallari (xonalari), ofislar va turar joylarni qurish, renovatsiya va rekonstruksiya qilish uchun' ? 'selected' : '' }}>
                                                                            Ishlab chiqarish korxonalarining umumiy
                                                                            ovqatlanish joylari, sport-sog‘lomlashtirish
                                                                            zallari (xonalari), ofislar va turar joylarni
                                                                            qurish, renovatsiya va rekonstruksiya qilish
                                                                            uchun
                                                                        </option>
                                                                        <option
                                                                            value="Omborxonalarni har bir qavati uchun 2 (ikki) metr balandlikdan oshmagan oʻlchamda (omborxonalarining ma’muriy-xo‘jalik majmuasi sifadida foydalaniladigan, alohida turgan kapital binolar, shu jumladan, umumiy ovqatlanish joylari, sport-sog‘lomlashtirish zallari (xonalari), ofislar, turar joylar bundan mustasno)"
                                                                            data-kt="0.5"
                                                                            {{ old('accordions.' . $branchIndex . '.branch_type', $b->branch_type) == 'Omborxonalarni har bir qavati uchun 2 (ikki) metr balandlikdan oshmagan oʻlchamda (omborxonalarining ma’muriy-xo‘jalik majmuasi sifadida foydalaniladigan, alohida turgan kapital binolar, shu jumladan, umumiy ovqatlanish joylari, sport-sog‘lomlashtirish zallari (xonalari), ofislar, turar joylar bundan mustasno' ? 'selected' : '' }}>
                                                                            Omborxonalarni har bir qavati uchun 2 (ikki)
                                                                            metr balandlikdan oshmagan oʻlchamda
                                                                            (omborxonalarining ma’muriy-xo‘jalik majmuasi
                                                                            sifadida foydalaniladigan, alohida turgan
                                                                            kapital binolar, shu jumladan, umumiy
                                                                            ovqatlanish joylari, sport-sog‘lomlashtirish
                                                                            zallari (xonalari), ofislar, turar joylar bundan
                                                                            mustasno)
                                                                        </option>
                                                                        <option
                                                                            value="Mazkur bo‘limning 1–5-qatorlarida ko‘rsatilmagan boshqa obyektlar"
                                                                            data-kt="1"
                                                                            {{ old('accordions.' . $branchIndex . '.branch_type', $b->branch_type) == 'Mazkur bo‘limning 1–5-qatorlarida ko‘rsatilmagan boshqa obyektlar' ? 'selected' : '' }}>
                                                                            Mazkur bo‘limning 1–5-qatorlarida ko‘rsatilmagan
                                                                            boshqa obyektlar
                                                                        </option>
                                                                    </select>
                                                                    @error('accordions.' . $branchIndex . '.branch_type')
                                                                        <span
                                                                            class="error invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="qurilish_turi">@lang('global.qurilish_turi')</label>
                                                                    <select
                                                                        class="form-control form_select_cof form-select"
                                                                        name="accordions[{{ $branchIndex }}][qurilish_turi]"
                                                                        id="qurilish_turi">
                                                                        <option value="">@lang('global.qurilish_turi')</option>
                                                                        <option value="Yangi kapital qurilish"
                                                                            data-kt="1"
                                                                            {{ old('accordions.' . $branchIndex . '.qurilish_turi', $b->qurilish_turi) == 'Yangi kapital qurilish' ? 'selected' : '' }}>
                                                                            Yangi kapital qurilish
                                                                        </option>
                                                                        <option
                                                                            value="Obyektni rekonstruksiya qilish (koeffitsiyent obyetkga qo‘shilgan qurilish hajmiga hisoblanadi)"
                                                                            data-kt="1"
                                                                            {{ old('accordions.' . $branchIndex . '.qurilish_turi', $b->qurilish_turi) == 'Obyektni rekonstruksiya qilish (koeffitsiyent obyetkga qo‘shilgan qurilish hajmiga hisoblanadi)' ? 'selected' : '' }}>
                                                                            Obyektni rekonstruksiya qilish (koeffitsiyent
                                                                            obyetkga qo‘shilgan qurilish hajmiga
                                                                            hisoblanadi)
                                                                        </option>
                                                                        <option
                                                                            value="O‘zbekiston Respublikasi Shaharsozlik kodeksiga muvofiq loyiha-smeta hujjatlari ekpertizasi talab etilmaydigan obyektlarini rekonstruksiya qilish"
                                                                            data-kt="0"
                                                                            {{ old('accordions.' . $branchIndex . '.qurilish_turi', $b->qurilish_turi) == 'O‘zbekiston Respublikasi Shaharsozlik kodeksiga muvofiq loyiha-smeta hujjatlari ekpertizasi talab etilmaydigan obyektlarini rekonstruksiya qilish' ? 'selected' : '' }}>
                                                                            O‘zbekiston Respublikasi Shaharsozlik kodeksiga
                                                                            muvofiq loyiha-smeta hujjatlari ekpertizasi
                                                                            talab etilmaydigan obyektlarini rekonstruksiya
                                                                            qilish
                                                                        </option>
                                                                        <option
                                                                            value="Obyektni qurilish hajmini o‘zgartirmagan holda rekonstruksiya qilish"
                                                                            data-kt="0"
                                                                            {{ old('accordions.' . $branchIndex . '.qurilish_turi', $b->qurilish_turi) == 'Obyektni qurilish hajmini o‘zgartirmagan holda rekonstruksiya qilish' ? 'selected' : '' }}>
                                                                            Obyektni qurilish hajmini o‘zgartirmagan holda
                                                                            rekonstruksiya qilish
                                                                        </option>
                                                                    </select>
                                                                    @error('accordions.' . $branchIndex . '.qurilish_turi')
                                                                        <span
                                                                            class="error invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="zona">@lang('global.zona')</label>
                                                                    <select id="zona"
                                                                        class="form-control form_select_cof form-select"
                                                                        name="accordions[{{ $branchIndex }}][zona]">
                                                                        <option value="">Zona</option>
                                                                        <option value="1" data-kt="1.40"
                                                                            {{ old('accordions.' . $branchIndex . '.zona', $b->zona) == '1' ? 'selected' : '' }}>
                                                                            1-zona</option>
                                                                        <option value="2" data-kt="1.25"
                                                                            {{ old('accordions.' . $branchIndex . '.zona', $b->zona) == '2' ? 'selected' : '' }}>
                                                                            2-zona</option>
                                                                        <option value="3" data-kt="1.00"
                                                                            {{ old('accordions.' . $branchIndex . '.zona', $b->zona) == '3' ? 'selected' : '' }}>
                                                                            3-zona</option>
                                                                        <option value="4" data-kt="0.75"
                                                                            {{ old('accordions.' . $branchIndex . '.zona', $b->zona) == '4' ? 'selected' : '' }}>
                                                                            4-zona</option>
                                                                        <option value="5" data-kt="0.50"
                                                                            {{ old('accordions.' . $branchIndex . '.zona', $b->zona) == '5' ? 'selected' : '' }}>
                                                                            5-zona</option>
                                                                    </select>
                                                                    @error('accordions.' . $branchIndex . '.zona')
                                                                        <span
                                                                            class="error invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                                <div class="mb-3">
                                                                    <label for="coefficient">@lang('global.coefficient')</label>
                                                                    <input type="text" class="form-control coefficient"
                                                                        id="coefficient"
                                                                        name="accordions[{{ $branchIndex }}][coefficient]"
                                                                        readonly value="1.00">
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                                <div class="mb-3">
                                                                    <label for="branch_name">@lang('global.loyiha_nomi')</label>
                                                                    <input type="text" class="form-control"
                                                                        name="accordions[{{ $branchIndex }}][branch_name]"
                                                                        value="{{ old('accordions.' . $branchIndex . '.branch_name') }}"
                                                                        placeholder="@lang('global.loyiha_nomi')">
                                                                    @error('accordions.' . $branchIndex . '.branch_name')
                                                                        <span
                                                                            class="error invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>


                                                            <script>
                                                                $(document).ready(function() {
                                                                    let accordionCount = 1;

                                                                    // Function to add a new accordion item
                                                                    $('#addAccordion').on('click', function() {
                                                                        let accordion = $('.accordion-item').first().clone();
                                                                        let newId = 'flush-collapse' + accordionCount;
                                                                        accordion.find('.accordion-collapse').attr('id', newId);
                                                                        accordion.find('.accordion-button').attr('data-bs-target', '#' + newId);
                                                                        accordion.find('.accordion-header').attr('id', 'flush-heading' + accordionCount);
                                                                        accordion.find('.accordion-button').attr('aria-controls', newId);
                                                                        accordion.find('.accordion-button').text('Объект #' + accordionCount);

                                                                        // Update input, select, and textarea names and ids
                                                                        accordion.find('input, select, textarea').each(function() {
                                                                            let name = $(this).attr('name');
                                                                            if (name) {
                                                                                let newName = name.replace(/\[0\]/, '[' + accordionCount + ']');
                                                                                $(this).attr('name', newName);
                                                                            }
                                                                            $(this).val('');
                                                                            $(this).attr('id', name + '-' + accordionCount);
                                                                        });

                                                                        // Update table and schedule ids
                                                                        let tableId = 'payment-table-' + accordionCount;
                                                                        let scheduleId = 'payment-schedule-' + accordionCount;
                                                                        let quarterlyTableId = 'quarterly-table-' + accordionCount;
                                                                        let quarterlyScheduleId = 'quarterly-schedule-' + accordionCount;

                                                                        accordion.find('.payment-table').attr('id', tableId);
                                                                        accordion.find('.payment-schedule').attr('id', scheduleId);
                                                                        accordion.find('.quarterly-table').attr('id', quarterlyTableId);
                                                                        accordion.find('.quarterly-payment-schedule').attr('id', quarterlyScheduleId);

                                                                        accordion.appendTo('#accordionFlushExample');
                                                                        accordionCount++;

                                                                        // Reset values and trigger changes
                                                                        accordion.find('.generate_price').val('');
                                                                        accordion.find('.payment-type').val('pay_full').trigger('change');
                                                                        accordion.find('.percentage-input').val('0').prop('disabled', true);
                                                                        accordion.find('.quarterly-input').val('').prop('disabled', true);
                                                                        accordion.find('.calculated-quarterly-payment').val('');
                                                                        accordion.find('.payment-schedule').empty();
                                                                        accordion.find('.quarterly-payment-schedule').empty();
                                                                        accordion.find('.total-quarterly-payment').text('0.00');

                                                                        // Initial calculation for the new accordion item
                                                                        calculateGeneratePrice(accordion.find('.accordion-body'));
                                                                    });

                                                                    // Function to calculate and update prices
                                                                    function calculateGeneratePrice(parentAccordion) {
                                                                        let shaxarsozlik_umumiy_xajmi = parseFloat(parentAccordion.find('.shaxarsozlik_umumiy_xajmi')
                                                                            .val()) || 0;
                                                                        let qavatlar_soni_xajmi = parseFloat(parentAccordion.find('.qavatlar_soni_xajmi').val()) || 0;
                                                                        let avtoturargoh_xajmi = parseFloat(parentAccordion.find('.avtoturargoh_xajmi').val()) || 0;
                                                                        let umumiy_foydalanishdagi_xajmi = parseFloat(parentAccordion.find('.umumiy_foydalanishdagi_xajmi')
                                                                            .val()) || 0;
                                                                        let qavat_xona_xajmi = parseFloat(parentAccordion.find('.qavat_xona_xajmi').val()) || 0;

                                                                        let companyKubmetr = (shaxarsozlik_umumiy_xajmi + qavatlar_soni_xajmi) - (avtoturargoh_xajmi +
                                                                            umumiy_foydalanishdagi_xajmi + qavat_xona_xajmi);
                                                                        parentAccordion.find('.branch_kubmetr').val(companyKubmetr.toFixed(2));

                                                                        let minimumWage = parseFloat(parentAccordion.find('.minimum_wage').val()) ||
                                                                            340000; // Default or original value
                                                                        let coefficient = parseFloat(parentAccordion.find('.coefficient').val()) || 1;

                                                                        let adjustedMinimumWage = 340000 * coefficient;
                                                                        // let adjustedMinimumWage = minimumWage * coefficient;
                                                                        parentAccordion.find('.minimum_wage').val(adjustedMinimumWage.toFixed(2));

                                                                        let generatePrice = companyKubmetr * adjustedMinimumWage;
                                                                        parentAccordion.find('.generate_price').val(generatePrice.toFixed(2));

                                                                        let percentageInput = parseFloat(parentAccordion.find('.percentage-input').val()) || 0;
                                                                        let quarterlyInput = parseInt(parentAccordion.find('.quarterly-input').val()) || 0;

                                                                        // Separate the calculation for first_payment_percent
                                                                        if (!isNaN(generatePrice)) {
                                                                            let z = (generatePrice * percentageInput) / 100;
                                                                            parentAccordion.find('.first_payment_percent').val(z.toFixed(2));

                                                                            if (!isNaN(percentageInput) && !isNaN(quarterlyInput) && quarterlyInput > 0) {
                                                                                let n = generatePrice - z;
                                                                                let y = n / quarterlyInput;
                                                                                parentAccordion.find('.calculated-quarterly-payment').val(y.toFixed(2));
                                                                                updateQuarterlyPaymentSchedule(parentAccordion, y, quarterlyInput);
                                                                            } else {
                                                                                parentAccordion.find('.calculated-quarterly-payment').val('');
                                                                                updateQuarterlyPaymentSchedule(parentAccordion, '', '');
                                                                            }

                                                                            updatePaymentSchedule(parentAccordion, generatePrice);
                                                                        }
                                                                    }

                                                                    // Function to update payment schedule
                                                                    function updatePaymentSchedule(parentAccordion, generatePrice) {
                                                                        let paymentSchedule = parentAccordion.find('.payment-schedule');
                                                                        paymentSchedule.empty();
                                                                        let percentages = [0, 10, 20, 30, 40, 50];
                                                                        percentages.forEach(percentage => {
                                                                            let z = Math.round((generatePrice * percentage) / 100);
                                                                            let n = generatePrice - z;
                                                                            let quarterlyInput = parentAccordion.find('.quarterly-input').val();
                                                                            let y = quarterlyInput ? Math.round((n / quarterlyInput)) : "N/A";
                                                                            paymentSchedule.append(
                                                                                `<tr>
                                                                                <td>${percentage}%</td>
                                                                                <td>${Math.round(z)}</td>
                                                                                <td>${y}</td>
                                                                            </tr>`
                                                                            );
                                                                        });
                                                                    }

                                                                    // Function to update quarterly payment schedule
                                                                    function updateQuarterlyPaymentSchedule(parentAccordion, quarterlyPayment, quarterlyInput) {
                                                                        let quarterlySchedule = parentAccordion.find('.quarterly-payment-schedule');
                                                                        quarterlySchedule.empty();
                                                                        if (quarterlyPayment && quarterlyInput) {
                                                                            for (let i = 1; i <= quarterlyInput; i++) {
                                                                                quarterlySchedule.append(
                                                                                    `<tr>
                                                                                    <td>${i}</td>
                                                                                    <td>${quarterlyPayment.toFixed(2)}</td>
                                                                                </tr>`
                                                                                );
                                                                            }
                                                                        }
                                                                    }

                                                                    // Event listener for input changes
                                                                    $(document).on('input change',
                                                                        '.branch_kubmetr, .minimum_wage, .shaxarsozlik_umumiy_xajmi, .qavatlar_soni_xajmi, .avtoturargoh_xajmi, .umumiy_foydalanishdagi_xajmi, .qavat_xona_xajmi, .obyekt_joylashuvi, .branch_type, .qurilish_turi, .zona',
                                                                        function() {
                                                                            let parentAccordion = $(this).closest('.accordion-body');
                                                                            calculateGeneratePrice(parentAccordion);
                                                                        });

                                                                    // Event listener for percentage-input changes
                                                                    $(document).on('input change', '.percentage-input', function() {
                                                                        let parentAccordion = $(this).closest('.accordion-body');
                                                                        calculateGeneratePrice(parentAccordion);
                                                                    });

                                                                    // Event listener for quarterly-input changes
                                                                    $(document).on('input change', '.quarterly-input', function() {
                                                                        let parentAccordion = $(this).closest('.accordion-body');
                                                                        let quarterlyInput = parseInt($(this).val()) || 0;
                                                                        let generatePrice = parseFloat(parentAccordion.find('.generate_price').val()) || 0;
                                                                        let percentageInput = parseFloat(parentAccordion.find('.percentage-input').val()) || 0;
                                                                        let z = (generatePrice * percentageInput) / 100;

                                                                        if (!isNaN(generatePrice) && !isNaN(percentageInput) && quarterlyInput > 0) {
                                                                            let n = generatePrice - z;
                                                                            let y = n / quarterlyInput;
                                                                            parentAccordion.find('.calculated-quarterly-payment').val(y.toFixed(2));
                                                                            updateQuarterlyPaymentSchedule(parentAccordion, y, quarterlyInput);
                                                                        } else {
                                                                            parentAccordion.find('.calculated-quarterly-payment').val('');
                                                                            updateQuarterlyPaymentSchedule(parentAccordion, '', '');
                                                                        }
                                                                    });

                                                                    // Event listener for payment type changes
                                                                    $(document).on('change', '.payment-type', function() {
                                                                        let parentAccordion = $(this).closest('.accordion-body');
                                                                        let paymentType = $(this).val();
                                                                        let percentageInput = parentAccordion.find('.percentage-input');
                                                                        let quarterlyInput = parentAccordion.find('.quarterly-input');

                                                                        if (paymentType === 'pay_full') {
                                                                            percentageInput.val(100).prop('disabled', true);
                                                                            quarterlyInput.val('').prop('disabled', true);
                                                                            parentAccordion.find('.calculated-quarterly-payment').val('N/A');
                                                                            parentAccordion.find('.payment-schedule').empty();
                                                                            parentAccordion.find('.quarterly-payment-schedule').empty();
                                                                        } else {
                                                                            percentageInput.prop('disabled', false);
                                                                            quarterlyInput.prop('disabled', false);
                                                                        }

                                                                        calculateGeneratePrice(parentAccordion);
                                                                    });

                                                                    // Event listener for coefficient changes
                                                                    $(document).on('input change', '.coefficient', function() {
                                                                        let parentAccordion = $(this).closest('.accordion-body');
                                                                        calculateGeneratePrice(parentAccordion);
                                                                    });

                                                                    // Function to calculate the coefficient and update it in the accordion items
                                                                    function calculateCoefficient() {
                                                                        var coefficient = 1;
                                                                        var totalKts = [];
                                                                        var selectElements = document.querySelectorAll('.form_select_cof');

                                                                        selectElements.forEach(function(select) {
                                                                            Array.from(select.selectedOptions).forEach(function(option) {
                                                                                var kt = parseFloat(option.dataset.kt);
                                                                                if (!isNaN(kt)) {
                                                                                    totalKts.push(kt);
                                                                                }
                                                                            });
                                                                        });

                                                                        if (totalKts.includes(0)) {
                                                                            coefficient = 0;
                                                                        } else if (totalKts.length === 0) {
                                                                            coefficient = 1;
                                                                        } else {
                                                                            totalKts.forEach(function(kt) {
                                                                                coefficient *= kt;
                                                                            });

                                                                            // Apply the limits
                                                                            if (coefficient < 0.50) {
                                                                                coefficient = 0.50;
                                                                            } else if (coefficient > 2.00) {
                                                                                coefficient = 2.00;
                                                                            }
                                                                        }

                                                                        document.querySelectorAll('.coefficient').forEach(function(coefficientInput) {
                                                                            coefficientInput.value = coefficient.toFixed(2);
                                                                        });

                                                                        document.querySelectorAll('.accordion-body').forEach(function(parentAccordion) {
                                                                            calculateGeneratePrice($(parentAccordion));
                                                                        });
                                                                    }


                                                                    $('.form_select_cof').on('change', calculateCoefficient);

                                                                    // Initial coefficient calculation
                                                                    calculateCoefficient();
                                                                });
                                                            </script>

                                                            <!-- End new fields -->




                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 ">
                                                                <div class="inner-repeater mb-4">
                                                                    <div data-repeater-list="inner-group"
                                                                        class="inner mb-3">
                                                                        <label
                                                                            for="basicpill-cardno-input">@lang('global.obyekt_boyicha_tolanishi_lozim')</label>
                                                                        <input type="number"
                                                                            class="form-control branch_kubmetr"
                                                                            step="0.00001" placeholder="( m³ )"
                                                                            value="{{ old('accordions.' . $branchIndex . '.branch_kubmetr', $b->branch_kubmetr) }}"
                                                                            name="accordions[{{ $branchIndex }}][branch_kubmetr]"
                                                                            onchange="displayFiveDigitsAfterDecimal(this)">
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


                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 ">
                                                                <div class="inner-repeater mb-4">
                                                                    <div data-repeater-list="inner-group"
                                                                        class="inner mb-3">
                                                                        <label
                                                                            for="basicpill-cardno-input">@lang('global.loyiha_nomi')</label>
                                                                        <input type="text"
                                                                            class="form-control branch_name"
                                                                            placeholder="@lang('global.loyiha_nomi')"
                                                                            value="{{ old('accordions.' . $branchIndex . '.branch_name', $b->branch_name) }}"
                                                                            name="accordions[{{ $branchIndex }}][branch_name]">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 ">
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="basicpill-card-verification-input">@lang('global.bazaviy_xisoblash_miqdori')</label>
                                                                    <input type="number"
                                                                        class="form-control minimum_wage"
                                                                        placeholder="@lang('global.bazaviy_xisoblash_miqdori')" value="340000"
                                                                        name="accordions[{{ $branchIndex }}][minimum_wage]">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 ">
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="basicpill-card-verification-input">@lang('global.jami_tolanishi_kerak')</label>
                                                                    <input type="text"
                                                                        class="form-control generate_price"
                                                                        name="accordions[{{ $branchIndex }}][generate_price]"
                                                                        value="{{ old('accordions.' . $branchIndex . '.generate_price', $b->generate_price) }}"
                                                                        placeholder="@lang('global.jami_tolanishi_kerak')">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 ">
                                                                <div class="mb-3">
                                                                    <label>@lang('global.tolash_turlari')</label>
                                                                    <select class="form-select payment-type form-control"
                                                                        id="payment_type"
                                                                        name="accordions[{{ $branchIndex }}][payment_type]">
                                                                        <option value="pay_full"
                                                                            {{ $b->payment_type == 'pay_full' ? 'selected' : '' }}>
                                                                            @lang('global.toliq_xajimda_tolash')</option>
                                                                        <option value="pay_bolib"
                                                                            {{ $b->payment_type == 'pay_bolib' ? 'selected' : '' }}>
                                                                            @lang('global.bolib_tolash')</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 ">
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="percentage-input">@lang('global.bolib_tolash_foizi_oldindan')</label>
                                                                    <div class="input-group">
                                                                        <input type="number"
                                                                            class="form-control percentage-input"
                                                                            name="accordions[{{ $branchIndex }}][percentage_input]"
                                                                            value="{{ old('accordions.' . $branchIndex . '.percentage_input', $b->percentage_input) }}"
                                                                            min="0" max="100">
                                                                        <span class="input-group-text">%</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 ">
                                                                <div class="inner-repeater mb-4">
                                                                    <div data-repeater-list="inner-group"
                                                                        class="inner mb-3">
                                                                        <label
                                                                            for="basicpill-cardno-input">@lang('cruds.branches.fields.first_payment_percent')
                                                                        </label>
                                                                        <input type="number"
                                                                            class="form-control first_payment_percent"
                                                                            step="0.00001" placeholder="( m³ )"
                                                                            value="{{ old('accordions.' . $branchIndex . '.first_payment_percent', $b->first_payment_percent) }}"
                                                                            name="accordions[{{ $branchIndex }}][first_payment_percent]"
                                                                            onchange="displayFiveDigitsAfterDecimal(this)">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 ">
                                                                <div class="mb-3">
                                                                    <label for="quarterly-input">@lang('global.bolib_tolash_har_chorakda')</label>
                                                                    <div class="input-group">
                                                                        <input type="number"
                                                                            class="form-control quarterly-input"
                                                                            name="accordions[{{ $branchIndex }}][quarterly_input]"
                                                                            value="{{ old('accordions.' . $branchIndex . '.quarterly_input', $b->quarterly_input) }}"
                                                                            min="0" step="0.01">
                                                                        <span class="input-group-text"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            {{--  --}}

                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 ">
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="calculated-quarterly-payment">@lang('global.quarterly_payment')</label>
                                                                    <div class="input-group">
                                                                        <input type="number"
                                                                            class="form-control calculated-quarterly-payment"
                                                                            name="accordions[{{ $branchIndex }}][calculated_quarterly_payment]"
                                                                            value="{{ old('accordions.' . $branchIndex . '.calculated_quarterly_payment', $b->calculated_quarterly_payment) }}"
                                                                            step="0.01" min="0">
                                                                        <span class="input-group-text"></span>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>

                                                    </main>
                                                    <button type="button"
                                                        class="removeAccordion btn btn-danger mt-3">@lang('global.delete_object')</button>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button id="addAccordion" type="button" class="btn btn-primary text-light ">@lang('global.add_object')</button>
                            </section>

                            {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}


                            <h3>@lang('global.confirmation')</h3>
                            <section>
                                <div class="row justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="text-center">
                                            <div class="mb-4">
                                                <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                                            </div>
                                            <div>
                                                <h5>@lang('global.confirmation')</h5>
                                                <p class="text-muted">Barcha kiritgan malumotlaringiz to'grimi ? </p>

                                                <button type="submit" class="btn btn-primary">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                        </div>
                    </form>
                </div>
                <!-- end card body -->
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-steps/build/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-wizard.init.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-repeater.int.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery.repeater/jquery.repeater.min.js') }}"></script>
@endsection
