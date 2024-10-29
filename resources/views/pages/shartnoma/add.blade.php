@extends('layouts.admin')
@section('content')
    <style>
        .modal-body {
            overflow-y: auto !important;
        }

        #hide_me {
            display: none !important;
        }
    </style>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0)">E-commerce</a></li>
                        <li class="breadcrumb-item" aria-current="page">Shartnoma qo'shish</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Shartnoma qo'shish</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="container">

        <div class="row my-3">
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5>Лойиха ҳажми хақида маълумотнома</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="bino_qurilish_hajmi">Бинонинг қурилиш ҳажми, (куб.м)</label>
                            <input class="form-control shaxarsozlik_umumiy_xajmi" type="number" step="any"
                                name="binoning_qurilish_hajmi" id="bino_qurilish_hajmi"
                                value="{{ old('binoning_qurilish_hajmi', $branch->loyihaHajmiMalumotnoma->binoning_qurilish_hajmi) }}" disabled readonly>
                        </div>
                        <div class="mb-3">
                            <label for="ruxsatdan_tashqari_yuqori_hajm">Рухсатдан ташқари юқори ҳажм (куб.м)</label>
                            <input class="form-control qavatlar_soni_xajmi" type="number" step="any"
                                name="ruxsatdan_tashqari_yuqori_hajm" id="ruxsatdan_tashqari_yuqori_hajm"
                                value="{{ old('ruxsatdan_tashqari_yuqori_hajm', $branch->loyihaHajmiMalumotnoma->ruxsatdan_tashqari_yuqori_hajm) }}" disabled readonly>
                        </div>
                        <div class="mb-3">
                            <label for="bino_avtoturargoh_qismi_hajmi">Бинонинг автотураргоҳ қисми ҳажми (куб.м)</label>
                            <input class="form-control avtoturargoh_xajmi" type="number" step="any"
                                name="binoning_avtoturargoh_qismi_hajmi" id="bino_avtoturargoh_qismi_hajmi"
                                value="{{ old('binoning_avtoturargoh_qismi_hajmi', $branch->loyihaHajmiMalumotnoma->binoning_avtoturargoh_qismi_hajmi) }}" disabled readonly>
                        </div>
                        <div class="mb-3">
                            <label for="bino_texnik_honalar_hajmi">Бинонинг техник қақатлар, хоналар ҳажми (куб.м)</label>
                            <input class="form-control qavat_xona_xajmi" type="number" step="any"
                                name="binoning_texnik_qavatlar_xonalar_hajmi" id="bino_texnik_honalar_hajmi"
                                value="{{ old('binoning_texnik_qavatlar_xonalar_hajmi', $branch->loyihaHajmiMalumotnoma->binoning_texnik_qavatlar_xonalar_hajmi) }}" disabled readonly>
                        </div>
                        <div class="mb-3">
                            <label for="turar_joy_binosi_foyda_hajmi">Турар жой биносининг умумий фойдаланишдаги қисми ҳажми
                                (куб.м)</label>
                            <input class="form-control umumiy_foydalanishdagi_xajmi" type="number" step="any"
                                name="turar_joy_binosining_umumiy_foydalanishdagi_qismi_hajmi"
                                id="turar_joy_binosi_foyda_hajmi"
                                value="{{ old('turar_joy_binosining_umumiy_foydalanishdagi_qismi_hajmi', $branch->loyihaHajmiMalumotnoma->turar_joy_binosining_umumiy_foydalanishdagi_qismi_hajmi) }}" disabled readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5>Лойиха ҳажми хақида маълумотнома</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="kt_id">Қурилиш тури</label>
                            <select class="form-control form_select_cof form-select" name="kt_id" id="kt_id" disabled readonly>
                                <option value="" >Qurilish turi</option>
                                @foreach ($kts as $kt)
                                    <option value="{{ $kt->id }}"
                                        {{ old('kt_id', $branch->kt_id) == $kt->id ? 'selected' : '' }}
                                        data-kt="{{ $kt->coefficient }}">
                                        {{ $kt->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kt_id')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="ko_id">Объект тури</label>
                            <select disabled readonly class="form-control form_select_cof form-select" name="ko_id" id="obyekt_turi">
                                <option value="">Obyekt turi</option>
                                @foreach ($kos as $ko)
                                    <option  value="{{ $ko->id }}"
                                        {{ old('ko_id', $branch->ko_id) == $ko->id ? 'selected' : '' }}
                                        data-kt="{{ $ko->coefficient }}">
                                        {{ $ko->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ko_id')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kz_id">Ҳудудий зона</label>
                            <select disabled readonly class="form-control form_select_cof form-select" name="kz_id" id="hududiy_zona">
                                <option value="">Xududiy zona</option>
                                @foreach ($kzs as $kz)
                                    <option value="{{ $kz->id }}"
                                        {{ old('kz_id', $branch->kz_id) == $kz->id ? 'selected' : '' }}
                                        data-kt="{{ $kz->coefficient }}">
                                        {{ $kz->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kz_id')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kj_id">Объект жойлашуви</label>
                            <select disabled readonly class="form-control form_select_cof form-select" name="kj_id" id="obyekt_joylashuvi">
                                <option value="">Obyektning joylashuvi</option>
                                @foreach ($kjs as $kj)
                                    <option value="{{ $kj->id }}"
                                        {{ old('kj_id', $branch->kj_id) == $kj->id ? 'selected' : '' }}
                                        data-kt="{{ $kj->coefficient }}">
                                        {{ $kj->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kj_id')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <form method="POST" action="{{ route('shartnoma_create') }}">
            @csrf
            <input type="hidden" name="branch_id" value="{{ $branch->id }}"> 


            <div class="card">
                <div class="card-header">
                    <h5>Формула</h5>
                </div>
                <div class="card-body">
                    <div class="row">

                        <!-- End new fields -->
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="mb-3">
                                <label for="coefficient">@lang('global.coefficient')</label>
                                <input type="text" class="form-control coefficient" id="coefficient"
                                    name="coefficient" readonly value="1.00">
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="inner-repeater mb-4">
                                <div data-repeater-list="inner-group" class="inner mb-3">
                                    <label for="basicpill-cardno-input">@lang('global.obyekt_boyicha_tolanishi_lozim')</label>
                                    <input type="number" step="0.00001" class="form-control branch_kubmetr"
                                        placeholder="( m³ )" name="branch_kubmetr" value="{{ old('branch_kubmetr') }}"
                                        onchange="displayFiveDigitsAfterDecimal(this)">
                                    @error('branch_kubmetr')
                                        <span class="error invalid-feedback">{{ $message }}</span>
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
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="mb-3">
                                <label for="basicpill-card-verification-input">@lang('global.bazaviy_xisoblash_miqdori')</label>
                                <input type="number" class="form-control minimum_wage" placeholder="@lang('global.bazaviy_xisoblash_miqdori')"
                                    value="{{ old('minimum_wage', '340000') }}" step="0.01" name="minimum_wage">

                                @error('minimum_wage')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="mb-3">
                                <label for="basicpill-card-verification-input">@lang('global.jami_tolanishi_kerak')</label>
                                <input type="text" class="form-control generate_price" name="generate_price"
                                    value="{{ old('generate_price') }}" placeholder="@lang('global.jami_tolanishi_kerak')" readonly>
                                @error('generate_price')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="shartnoma_raqami">Shartnoma raqami</label>
                                <input type="text" name="shartnoma_raqami" id="shartnoma_raqami" class="form-control" placeholder="Автоматический"
                                    readonly>
                                @error('shartnoma_raqami')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="shartnoma_sanasi">Shartnoma Sanasi</label>
                                <input type="date" name="shartnoma_sanasi" id="shartnoma_sanasi" class="form-control"
                                    required>
                                @error('shartnoma_sanasi')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="payment_deadline">To'lov Muddati</label>
                                <input type="date" name="payment_deadline" id="payment_deadline"
                                    class="form-control">
                                @error('payment_deadline')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 col-xl-12">
                            <div class="mb-3">
                                <label>@lang('global.tolash_turlari')</label>
                                <select class="payment-type form-control form-select" name="payment_type">
                                    <option value="pay_full" {{ old('payment_type') == 'pay_full' ? 'selected' : '' }}>
                                        @lang('global.toliq_xajimda_tolash')</option>
                                    <option value="pay_bolib" {{ old('payment_type') == 'pay_bolib' ? 'selected' : '' }}>
                                        @lang('global.bolib_tolash')</option>
                                </select>
                                @error('payment_type')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="mb-3">
                                <label for="percentage-input">@lang('global.bolib_tolash_foizi_oldindan')</label>
                                <div class="input-group">
                                    <input type="number" class="form-control percentage-input" name="percentage_input"
                                        value="{{ old('percentage_input') }}" min="0" max="100"
                                        step="0.01">
                                    <span class="input-group-text">%</span>
                                </div>
                                @error('percentage_input')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="mb-3">
                                <label for="quarterly-input">@lang('global.bolib_tolash_har_chorakda')</label>
                                <input type="number" class="form-control quarterly-input" name="installment_quarterly"
                                    value="{{ old('installment_quarterly') }}" placeholder="@lang('global.bolib_tolash_har_chorakda')" disabled
                                    step="0.01">
                                @error('installment_quarterly')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="mb-3">
                                <label for="first_payment_percent_0">@lang('cruds.branches.fields.first_payment_percent')</label>
                                <input type="text" class="form-control first_payment_percent"
                                    name="first_payment_percent" value="{{ old('first_payment_percent') }}" readonly
                                    id="first_payment_percent_0">
                                @error('first_payment_percent')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="mb-3">
                                <label for="calculated-quarterly-payment">@lang('global.quarterly_payment')</label>
                                <input name="calculated_quarterly_payment" type="text" class="form-control calculated-quarterly-payment"
                                    value="{{ old('calculated_quarterly_payment') }}" placeholder="@lang('global.quarterly_payment')"
                                    readonly>
                                @error('calculated_quarterly_payment')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body text-end btn-page">
                            <button type="submit" class="btn btn-primary mb-0">Yuborish</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>

        <script src="{{ asset('assets/new/js/new_149_formula.js') }}"></script>
        <script>
            $('#client_id').on('change', function() {
                var clientId = $(this).val();
                console.log("Selected Client ID:", clientId);

                if (clientId) {
                    $.ajax({
                        url: '{{ route('get-client-details', '') }}/' + clientId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            console.log("Response Data:", data);
                            console.log("Stir:", data.stir);
                            $('.stir').val(data.stir || '');
                            $('.company_name').val(data.company_name || 'N/A');
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", status, error);
                            $('#stir').val('');
                            $('#company_name').val('Error fetching details');
                        }
                    });
                } else {
                    $('#stir').val('');
                    $('#company_name').val('');
                }
            });

            document.getElementById('kadastr_raqami').addEventListener('input', function(e) {
                let value = e.target.value.replace(/[^0-9]/g, '');
                let formattedValue = '';

                if (value.length > 0) formattedValue += value.substring(0, 2);
                if (value.length > 2) formattedValue += ':' + value.substring(2, 4);
                if (value.length > 4) formattedValue += ':' + value.substring(4, 6);
                if (value.length > 6) formattedValue += ':' + value.substring(6, 8);
                if (value.length > 8) formattedValue += ':' + value.substring(8, 10);
                if (value.length > 10) formattedValue += ':' + value.substring(10, 14);

                e.target.value = formattedValue;
            });
        </script>
    @endsection
