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
                        <li class="breadcrumb-item" aria-current="page">Obeykt o'zgartirish</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Obeykt o'zgartirish</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <form method="POST" action="{{ route('obyekt_update', $branch->id) }}">
            @csrf
            @method('PUT')

            <input type="hidden" name="client_id" value="{{ $branch->client->id }}">
            <div class="row my-3">
                <!-- Ariza -->
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>Рухсатнома</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="ruxsatnoma_turi_id">Рухсатнома тури</label>
                                <select class="form-control form_select_cof form-select" name="ruxsatnoma_turi_id"
                                    id="ruxsatnoma_turi_id">
                                    <option value="">Танланг</option>
                                    @foreach ($ruxsatnoma_turi as $rux_tur)
                                        <option value="{{ $rux_tur->id }}"
                                            {{ $rux_tur->id == old('ruxsatnoma_turi_id', $branch->ruxsatnoma_id) ? 'selected' : '' }}>
                                            {{ $rux_tur->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ruxsatnoma_turi')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="ruxsat_raqami">Рухсат этувчи хужжат рақами</label>
                                <input class="form-control" type="text" name="ruxsat_raqami" id="ruxsat_raqami" value="{{ old('ruxsat_raqami', $branch->ruxsatnoma->ruxsat_etuvchi_hujjat_raqami) }}">
                            </div>

                            <div class="mb-3">
                                <label for="ruxsat_sanasi">Рухсат этувчи хужжат санаси</label>
                                <input class="form-control" type="date" name="ruxsat_sanasi" id="ruxsat_sanasi" value="{{ old('ruxsat_sanasi', $branch->ruxsatnoma->ruxsat_etuvchi_hujjat_sanasi) }}">
                            </div>

                            <div class="mb-3">
                                <label for="ruxsatnoma_kim_tamonidan_id">Рухсат этувчи хужжат ким томонидан берилган</label>
                                <select class="form-control form_select_cof form-select" name="ruxsatnoma_kim_tamonidan_id" id="ruxsatnoma_kim_tamonidan_id">
                                    <option value="">Танланг</option>
                                    @foreach ($ruxsatnoma_kim_tamonidan as $rux_kim)
                                        <option value="{{ $rux_kim->id }}" {{ $rux_kim->id == old('ruxsatnoma_kim_tamonidan_id', $branch->ruxsatnoma->ruxsatnomaKimTamonidan->id ?? null) ? 'selected' : '' }}>
                                            {{ $rux_kim->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ruxsatnoma_kim_tamonidan_id')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="kadastr_raqami">Кадастр рақами</label>
                                <input class="form-control" type="text" name="kadastr_raqami" id="kadastr_raqami"
                                    value="{{ old('kadastr_raqami',$branch->ruxsatnoma->kadastr_raqami) }}" pattern="(\d{2}:\d{2}:\d{2}:\d{2}:\d{2}:\d{4})"
                                    title="Format: 11:04:42:01:03:0136" placeholder="11:04:42:01:03:0136" required>
                                <small id="kadastrHelp" class="form-text text-muted">
                                    Please enter the cadastral number in the format: 11:04:42:01:03:0136
                                </small>
                            </div>

                            <div class="mb-3">
                                <label for="ruxsatnoma_berilgan_ish_turi_id">Рухсатнома берилган иш тури</label>
                                <select class="form-control form_select_cof form-select" name="ruxsatnoma_berilgan_ish_turi_id" id="ruxsatnoma_berilgan_ish_turi_id">
                                    <option value="">Танланг</option>
                                    @foreach ($ruxsatnoma_berilgan_ish_turi as $rux_ber)
                                        <option value="{{ $rux_ber->id }}" {{ $rux_ber->id == old('ruxsatnoma_berilgan_ish_turi_id', $branch->ruxsatnoma->ruxsatnomaBerilganIshTuri->id ?? null) ? 'selected' : '' }}>
                                            {{ $rux_ber->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ruxsatnoma_berilgan_ish_turi_id')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                        </div>


                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5>Субъект манзили</h5>
                        </div>
                        <div class="card-body">
    
                            <div class="mb-3">
                                <p>
                                    {{ $branch->substreet && 
                                        $branch->substreet->district && 
                                        $branch->substreet->district->region
                                         ? $branch->substreet->district->region->name_uz
                                         : 'N/A' }}
                                     {{ $branch->substreet && 
                                        $branch->substreet->district
                                         ? $branch->substreet->district->name_uz
                                         : 'N/A' }}
                                     {{ $branch->substreet && 
                                        $branch->substreet->district && 
                                        $branch->substreet->district->street
                                         ? $branch->substreet->district->street->name
                                         : 'N/A' }}
                                     {{ $branch->substreet 
                                         ? $branch->substreet->name 
                                         : 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @include('inc.__address')

                </div>

                <!-- Ruxsatnoma -->
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
                                    value="{{ old('binoning_qurilish_hajmi', $branch->loyihaHajmiMalumotnoma->binoning_qurilish_hajmi ?? '') }}">
                                @error('binoning_qurilish_hajmi')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="ruxsatdan_tashqari_yuqori_hajm">Рухсатдан ташқари юқори ҳажм (куб.м)</label>
                                <input class="form-control qavatlar_soni_xajmi" type="number" step="any"
                                    name="ruxsatdan_tashqari_yuqori_hajm" id="ruxsatdan_tashqari_yuqori_hajm"
                                    value="{{ old('ruxsatdan_tashqari_yuqori_hajm', $branch->loyihaHajmiMalumotnoma->ruxsatdan_tashqari_yuqori_hajm ?? '') }}">
                                @error('ruxsatdan_tashqari_yuqori_hajm')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="bino_avtoturargoh_qismi_hajmi">Бинонинг автотураргоҳ қисми ҳажми (куб.м)</label>
                                <input class="form-control avtoturargoh_xajmi" type="number" step="any"
                                    name="binoning_avtoturargoh_qismi_hajmi" id="bino_avtoturargoh_qismi_hajmi"
                                    value="{{ old('binoning_avtoturargoh_qismi_hajmi', $branch->loyihaHajmiMalumotnoma->binoning_avtoturargoh_qismi_hajmi ?? '') }}">
                                @error('binoning_avtoturargoh_qismi_hajmi')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="bino_texnik_honalar_hajmi">Бинонинг техник қақатлар, хоналар ҳажми (куб.м)</label>
                                <input class="form-control qavat_xona_xajmi" type="number" step="any"
                                    name="binoning_texnik_qavatlar_xonalar_hajmi" id="bino_texnik_honalar_hajmi"
                                    value="{{ old('binoning_texnik_qavatlar_xonalar_hajmi', $branch->loyihaHajmiMalumotnoma->binoning_texnik_qavatlar_xonalar_hajmi ?? '') }}">
                                @error('binoning_texnik_qavatlar_xonalar_hajmi')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="turar_joy_binosi_foyda_hajmi">Турар жой биносининг умумий фойдаланишдаги қисми ҳажми (куб.м)</label>
                                <input class="form-control umumiy_foydalanishdagi_xajmi" type="number" step="any"
                                    name="turar_joy_binosining_umumiy_foydalanishdagi_qismi_hajmi" id="turar_joy_binosi_foyda_hajmi"
                                    value="{{ old('turar_joy_binosi_foyda_hajmi', $branch->loyihaHajmiMalumotnoma->turar_joy_binosining_umumiy_foydalanishdagi_qismi_hajmi ?? '') }}">
                                @error('turar_joy_binosi_foyda_hajmi')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            


                            <div class="mb-3">
                                <label for="kt_id">Қурилиш тури</label>
                                <select class="form-control form_select_cof form-select" name="kt_id" id="kt_id">
                                    <option value="">Qurilish turi</option>
                                    @foreach ($kts as $kt)
                                        <option value="{{ $kt->id }}" {{ $kt->id == old('kt_id', $branch->kt_id) ? 'selected' : '' }} data-kt="{{ $kt->coefficient }}">
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
                                <select class="form-control form_select_cof form-select" name="ko_id" id="obyekt_turi">
                                    <option value="">Obyekt turi</option>
                                    @foreach ($kos as $ko)
                                        <option value="{{ $ko->id }}" {{ $ko->id == old('ko_id', $branch->ko_id) ? 'selected' : '' }} data-kt="{{ $ko->coefficient }}">
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
                                <select class="form-control form_select_cof form-select" name="kz_id" id="hududiy_zona">
                                    <option value="">Xududiy zona</option>
                                    @foreach ($kzs as $kz)
                                        <option value="{{ $kz->id }}" {{ $kz->id == old('kz_id', $branch->kz_id) ? 'selected' : '' }} data-kt="{{ $kz->coefficient }}">
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
                                <select class="form-control form_select_cof form-select" name="kj_id" id="obyekt_joylashuvi">
                                    <option value="">Obyektning joylashuvi</option>
                                    @foreach ($kjs as $kj)
                                        <option value="{{ $kj->id }}" {{ $kj->id == old('kj_id', $branch->kj_id) ? 'selected' : '' }} data-kt="{{ $kj->coefficient }}">
                                            {{ $kj->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kj_id')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="obyekt_nomi">Объект номи</label>
                                <input class="form-control" type="text" name="obyekt_nomi" id="obyekt_nomi"
                                    value="{{ old('obyekt_nomi', $branch->loyihaHajmiMalumotnoma->obyekt_nomi ?? '') }}">
                                @error('obyekt_nomi')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="qoshimcha_malumot">Қўшимча маълумот</label>
                                <input class="form-control" type="text" name="qoshimcha_malumot" id="qoshimcha_malumot"
                                    value="{{ old('qoshimcha_malumot', $branch->loyihaHajmiMalumotnoma->qoshimcha_malumot ?? '') }}">
                                @error('qoshimcha_malumot')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            @include('inc.__select_map')
                            
                            <div class="mb-3">
                                <label for="geolokatsiya">Зона</label>
                                <input type="text" class="form-control" name="zone_name" value="{{old('zone_name', $branch->loyihaHajmiMalumotnoma->zone_name ?? '')}}" id="zone_name">
                                @error('zone_name')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                                <label for="geolokatsiya">Геолокация (координата)</label>
                                <input class="form-control" type="text" name="geolokatsiya" id="geolokatsiya"
                                    value="{{ old('geolokatsiya', $branch->loyihaHajmiMalumotnoma->geolokatsiya ?? '') }}">
                                @error('geolokatsiya')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror

                                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $branch->loyihaHajmiMalumotnoma->latitude) }}">
                                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $branch->loyihaHajmiMalumotnoma->longitude) }}">
                            </div>
                            
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>Лойиха хужжатлари</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="kompleks">Комплекс (Бош режа, қаватлар режаси ва хк)</label>
                                <input class="form-control" type="text" name="kompleks" id="kompleks"
                                    value="{{ old('kompleks') }}">
                            </div>
                            <div class="mb-3">
                                <label for="loiyha_hajmi_haqida">Лойиҳа ҳажми ҳақида маълумотнома (шаблон)</label>
                                <input class="form-control" type="text" name="loiyha_hajmi_haqida"
                                    id="loiyha_hajmi_haqida" value="{{ old('loiyha_hajmi_haqida') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
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
                        <input type="text" class="form-control coefficient" id="coefficient" name="coefficient"
                            readonly value="1.00">
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
        </div>
    </div>

    <div class="col-sm-12">
        <div class="card">
            <div class="card-body text-end btn-page">
                <button type="submit" class="btn btn-primary mb-0">Yuborish</button>
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
