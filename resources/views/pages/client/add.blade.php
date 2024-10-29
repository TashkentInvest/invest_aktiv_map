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
                        <li class="breadcrumb-item active">@lang('global.add')</li>
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
                    <h3 class="card-title">@lang('global.add')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('clientCreate') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-lg-12 mb-2">
                                    <label for="mijoz_turi" class="col-md-4 col-form-label">@lang('cruds.client.fields.mijoz_turi')</label>
                                    <select class="form-control" name="mijoz_turi" id="mijoz_turi">
                                        <option value="fizik">@lang('cruds.client.fields.mijoz_turi_fizik')</option>
                                        <option value="yuridik">@lang('cruds.client.fields.mijoz_turi_yuridik')</option>
                                    </select>
                                    @if ($errors->has('mijoz_turi'))
                                        <span class="error invalid-feedback">{{ $errors->first('mijoz_turi') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id="additionalFieldsFizik" style="display: none;">
                            <div class="row">
                                <div class="col-12 col-lg-4 mb-2">
                                    <label for="name" class="col-md-4 col-form-label">@lang('cruds.client.fields.name')</label>
                                    <input class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                                        type="text" name="first_name" id="first_name" placeholder="@lang('cruds.client.fields.first_name')"
                                        value="{{ old('first_name') }}">
                                    @if ($errors->has('first_name'))
                                        <span class="error invalid-feedback">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>

                                <div class="col-12 col-lg-4 mb-2">
                                    <label for="last_name" class="col-md-4 col-form-label">@lang('cruds.client.fields.last_name')</label>
                                    <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                                        type="text" name="last_name" id="last_name" placeholder="@lang('cruds.client.fields.last_name')"
                                        value="{{ old('last_name') }}">
                                    @if ($errors->has('last_name'))
                                        <span class="error invalid-feedback">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>

                                <div class="col-12 col-lg-4 mb-2">
                                    <label for="father_name" class="col-md-4 col-form-label">@lang('cruds.client.fields.father_name')</label>
                                    <input class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}"
                                        type="text" name="father_name" id="father_name" placeholder="@lang('cruds.client.fields.father_name')"
                                        value="{{ old('father_name') }}">
                                    @if ($errors->has('father_name'))
                                        <span class="error invalid-feedback">{{ $errors->first('father_name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id="additionalFieldsYuridik" style="display: none;">
                            <div class="row">
                                <div class="col-12 col-lg-6 mb-2">
                                    <label for="passport_serial" class="col-md-4 col-form-label">@lang('cruds.client.fields.passport_serial')</label>
                                    <input class="form-control {{ $errors->has('passport_serial') ? 'is-invalid' : '' }}"
                                        type="text" name="passport_serial" id="passport_serial"
                                        placeholder="@lang('cruds.client.fields.passport_serial')" value="{{ old('passport_serial') }}">
                                    @if ($errors->has('passport_serial'))
                                        <span class="error invalid-feedback">{{ $errors->first('passport_serial') }}</span>
                                    @endif
                                </div>

                                <div class="col-12 col-lg-6 mb-2">
                                    <label for="passport_pinfl" class="col-md-4 col-form-label">@lang('cruds.client.fields.passport_pinfl')</label>
                                    <input class="form-control {{ $errors->has('passport_pinfl') ? 'is-invalid' : '' }}"
                                        type="text" name="passport_pinfl" id="passport_pinfl"
                                        placeholder="@lang('cruds.client.fields.passport_pinfl')" value="{{ old('passport_pinfl') }}">
                                    @if ($errors->has('passport_pinfl'))
                                        <span class="error invalid-feedback">{{ $errors->first('passport_pinfl') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-lg-6 mb-2">
                                    <label for="yuridik_address" class="col-md-4 col-form-label">@lang('cruds.client.fields.yuridik_address')</label>
                                    <input class="form-control {{ $errors->has('yuridik_address') ? 'is-invalid' : '' }}"
                                        type="text" name="yuridik_address" id="yuridik_address"
                                        placeholder="@lang('cruds.client.fields.yuridik_address')" value="{{ old('yuridik_address') }}">
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
                                        placeholder="@lang('cruds.client.fields.yuridik_rekvizid')" value="{{ old('yuridik_rekvizid') }}">
                                    @if ($errors->has('yuridik_rekvizid'))
                                        <span
                                            class="error invalid-feedback">{{ $errors->first('yuridik_rekvizid') }}</span>
                                    @endif
                                </div>

                                <div class="col-12 col-lg-6 mb-2">
                                    <label for="name" class="col-md-4 col-form-label">@lang('cruds.client.fields.contact')</label>
                                    <input class="form-control {{ $errors->has('contact') ? 'is-invalid' : '' }}"
                                        type="text" name="contact" id="contact" placeholder="@lang('cruds.client.fields.contact')"
                                        value="{{ old('contact') }}">
                                    @if ($errors->has('contact'))
                                        <span class="error invalid-feedback">{{ $errors->first('contact') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var mijozTuri = document.getElementById('mijoz_turi');
                                var additionalFieldsFizik = document.getElementById('additionalFieldsFizik');
                                var additionalFieldsYuridik = document.getElementById('additionalFieldsYuridik');

                                function toggleFields() {
                                    if (mijozTuri.value === 'fizik') {
                                        // Show fizik fields
                                        additionalFieldsFizik.style.display = 'block';
                                        additionalFieldsFizik.querySelectorAll('input').forEach(function(input) {
                                            input.required = true;
                                        });

                                        // Hide yuridik fields
                                        additionalFieldsYuridik.style.display = 'none';
                                        additionalFieldsYuridik.querySelectorAll('input').forEach(function(input) {
                                            input.required = false;
                                        });
                                    } else {
                                        // Show yuridik fields
                                        additionalFieldsYuridik.style.display = 'block';
                                        additionalFieldsYuridik.querySelectorAll('input').forEach(function(input) {
                                            input.required = true;
                                        });

                                        // Hide fizik fields
                                        additionalFieldsFizik.style.display = 'none';
                                        additionalFieldsFizik.querySelectorAll('input').forEach(function(input) {
                                            input.required = false;
                                        });
                                    }
                                }

                                // Trigger the function on page load and on change
                                toggleFields();
                                mijozTuri.addEventListener('change', toggleFields);
                            });
                        </script>

                        <div class="mb-3">
                            <div class="form-group">
                                <button type="submit"
                                    class="btn btn-success waves-effect waves-light float-right">@lang('global.save')</button>
                                <a href="{{ route('clientIndex') }}"
                                    class="btn btn-light waves-effect float-left">@lang('global.cancel')</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
