@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">@lang('cruds.client.title')</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #007bff;">@lang('global.home')</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('clientIndex') }}"
                                style="color: #007bff;">@lang('cruds.client.title')</a></li>
                        <li class="breadcrumb-item active">@lang('global.edit')</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- Main content -->


    <div class="row">
        <div class="col-lg-8 offset-lg-2 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('global.edit')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <form action="{{ route('clientUpdate', $client->id) }}" method="post">
                        @csrf

                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-lg-4 mb-2">
                                    <label for="name" class="col-md-4 col-form-label">@lang('cruds.client.fields.name')</label>
                                    <input class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                                        type="text" name="first_name" id="first_name" placeholder="@lang('cruds.client.fields.first_name')"
                                        value="{{ old('first_name', $client->first_name) }}" required>
                                    @if ($errors->has('first_name'))
                                        <span class="error invalid-feedback">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>

                                <div class="col-12 col-lg-4 mb-2">
                                    <label for="last_name" class="col-md-4 col-form-label">@lang('cruds.client.fields.last_name')</label>
                                    <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                                        type="text" name="last_name" id="last_name" placeholder="@lang('cruds.client.fields.last_name')"
                                        value="{{ old('last_name', $client->last_name) }}" required>
                                    @if ($errors->has('last_name'))
                                        <span class="error invalid-feedback">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>

                                <div class="col-12 col-lg-4 mb-2">
                                    <label for="father_name" class="col-md-4 col-form-label">@lang('cruds.client.fields.father_name')</label>
                                    <input class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}"
                                        type="text" name="father_name" id="father_name" placeholder="@lang('cruds.client.fields.father_name')"
                                        value="{{ old('father_name', $client->father_name) }}" required>
                                    @if ($errors->has('father_name'))
                                        <span class="error invalid-feedback">{{ $errors->first('father_name') }}</span>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-lg-6 mb-2">
                                    <label for="name" class="col-md-4 col-form-label">@lang('cruds.client.fields.contact')</label>
                                    <input class="form-control {{ $errors->has('contact') ? 'is-invalid' : '' }}"
                                        type="text" name="contact" id="contact" placeholder="@lang('cruds.client.fields.contact')"
                                        value="{{ old('contact', $client->contact) }}" required>
                                    @if ($errors->has('contact'))
                                        <span class="error invalid-feedback">{{ $errors->first('contact') }}</span>
                                    @endif
                                </div>

                                <div class="col-12 col-lg-6 mb-2">
                                    <label for="email" class="col-md-4 col-form-label">@lang('cruds.client.fields.mijoz_turi')</label>
                                    <select class="form-control" name="mijoz_turi" id="mijoz_turi">
                                        <option value="fizik"
                                            {{ old('mijoz_turi', isset($client) && $client->mijoz_turi == 'fizik' ? 'selected' : '') }}>
                                            @lang('cruds.client.fields.mijoz_turi_fizik')</option>
                                        <option value="yuridik"
                                            {{ old('mijoz_turi', isset($client) && $client->mijoz_turi == 'yuridik' ? 'selected' : '') }}>
                                            @lang('cruds.client.fields.mijoz_turi_yuridik')</option>
                                    </select>
                                    @if ($errors->has('email'))
                                        <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="form-group" id="additionalFields" style="display: none;">
                            <div class="row">
                                <div class="col-12 col-lg-6 mb-2">
                                    <label for="name" class="col-md-4 col-form-label">@lang('cruds.client.fields.passport_serial')</label>
                                    <input class="form-control {{ $errors->has('passport_serial') ? 'is-invalid' : '' }}"
                                        type="text" name="passport_serial" id="passport_serial"
                                        placeholder="@lang('cruds.client.fields.passport_serial')"
                                        value="{{ old('passport_serial', $client->passport_serial) }}" required>
                                    @if ($errors->has('passport_serial'))
                                        <span class="error invalid-feedback">{{ $errors->first('passport_serial') }}</span>
                                    @endif
                                </div>

                                <div class="col-12 col-lg-6 mb-2">
                                    <label for="passport_pinfl" class="col-md-4 col-form-label">@lang('cruds.client.fields.passport_pinfl')</label>
                                    <input class="form-control {{ $errors->has('passport_pinfl') ? 'is-invalid' : '' }}"
                                        type="text" name="passport_pinfl" id="passport_pinfl"
                                        placeholder="@lang('cruds.client.fields.passport_pinfl')"
                                        value="{{ old('passport_pinfl', $client->passport_pinfl) }}" required>
                                    @if ($errors->has('passport_pinfl'))
                                        <span class="error invalid-feedback">{{ $errors->first('passport_pinfl') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6 mb-2">
                                    <label for="name" class="col-md-4 col-form-label">@lang('cruds.client.fields.yuridik_address')</label>
                                    <input class="form-control {{ $errors->has('yuridik_address') ? 'is-invalid' : '' }}"
                                        type="text" name="yuridik_address" id="yuridik_address"
                                        placeholder="@lang('cruds.client.fields.yuridik_address')"
                                        value="{{ old('yuridik_address', $client->yuridik_address) }}" required>
                                    @if ($errors->has('yuridik_address'))
                                        <span
                                            class="error invalid-feedback">{{ $errors->first('yuridik_address') }}</span>
                                    @endif
                                </div>

                                <div class="col-12 col-lg-6 mb-2">
                                    <label for="yuridik_rekvizid"
                                        class="col-md-4 col-form-label">@lang('cruds.client.fields.yuridik_rekvizid')</label>
                                    <input class="form-control {{ $errors->has('yuridik_rekvizid') ? 'is-invalid' : '' }}"
                                        type="text" name="yuridik_rekvizid" id="yuridik_rekvizid"
                                        placeholder="@lang('cruds.client.fields.yuridik_rekvizid')"
                                        value="{{ old('yuridik_rekvizid', $client->rekvizid) }}" required>
                                    @if ($errors->has('yuridik_rekvizid'))
                                        <span
                                            class="error invalid-feedback">{{ $errors->first('yuridik_rekvizid') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var mijozTuri = document.getElementById('mijoz_turi');
                                var additionalFields = document.getElementById('additionalFields');

                                mijozTuri.addEventListener('change', function() {
                                    if (mijozTuri.value === 'yuridik') {
                                        additionalFields.style.display = 'block';
                                        document.getElementById('passport_serial').required = true;
                                        document.getElementById('passport_pinfl').required = true;
                                        document.getElementById('yuridik_address').required = true;
                                        document.getElementById('yuridik_rekvizid').required = true;
                                    } else {
                                        additionalFields.style.display = 'none';
                                        document.getElementById('passport_serial').required = false;
                                        document.getElementById('passport_pinfl').required = false;
                                        document.getElementById('yuridik_address').required = false;
                                        document.getElementById('yuridik_rekvizid').required = false;
                                    }
                                });

                                mijozTuri.dispatchEvent(new Event('change'));
                            });
                        </script>




                        <div class="form-group">
                            <button type="submit"
                                class="btn btn-success waves-effect waves-light float-right">@lang('global.save')</button>
                            <a href="{{ route('clientIndex') }}"
                                class="btn btn-light waves-effect float-left">@lang('global.cancel')</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
