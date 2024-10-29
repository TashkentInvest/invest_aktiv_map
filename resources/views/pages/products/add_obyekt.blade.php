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
                        <li class="breadcrumb-item" aria-current="page">Obeykt qoshish</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Obeykt qoshish</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="d-print-none mt-4">
            <div class="float-end">
                {{-- <a href="javascript:window.print()" class="btn btn btn-success waves-effect waves-light me-1"><i
                        class="fa fa-print"></i></a> --}}
                <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal_subyektAdd"
                    class="btn btn-primary">Subyekt Tanlash</button>

                <div class="btn-group dropend">
                    <button type="button" class="btn btn-primary dropdown-toggle show" data-bs-toggle="dropdown"
                        aria-expanded="true">
                        Subyekt yaratish
                    </button>
                    <div class="dropdown-menu" data-popper-placement="right-start">
                        <a href="{{ route('subyekt_fizik_for_obyekt') }}" class="dropdown-item">Jismoniy shaxs</a>
                        <a href="{{ route('subyekt_yuridik_for_obyekt') }}" class="dropdown-item"
                            class="dropdown-item">Yuridik shaxs</a>
                    </div>
                </div>
            </div>
        </div>


        <!-- Edit Modal -->
        <div class="modal fade" id="exampleModal_subyektAdd" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            {{-- {{ $construction->{'name_' . app()->getLocale()} }} --}}
                            Subyekt qo'shish
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 col-lg-12 mb-2">
                                    <label for="unique_code" class="col-md-4 col-form-label">Subyekt Kodi</label>
                                    <input type="text" class="form-control" name="unique_code" id="unique_code"
                                        placeholder="Search by code, name, company, etc.">
                                    @error('unique_code')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <table class="table table-bordered" id="client_table">
                                        <thead>
                                            <tr>
                                                <th>Unique Code</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Stir</th>
                                                <th>Company Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Results will be appended here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <script>
                                $('#unique_code').on('input', function() {
                                    var query = $(this).val().toLowerCase(); // Convert query to lowercase
                                    var clientTableBody = $('#client_table tbody');

                                    if (query.length >= 3) { // Check if the query length is at least 3 characters
                                        $.ajax({
                                            url: '{{ route('search-client') }}',
                                            type: 'GET',
                                            data: {
                                                query: query
                                            },
                                            dataType: 'json',
                                            success: function(data) {
                                                clientTableBody.empty();
                                                if (data.length > 0) {
                                                    data.forEach(function(client) {

                                                        clientTableBody.append(
                                                            '<tr>' +
                                                            '<td>' + client.unique_code + '</td>' +
                                                            '<td>' + client.first_name + '</td>' +
                                                            '<td>' + client.last_name + '</td>' +
                                                            '<td>' + client.stir + '</td>' +
                                                            '<td>' + (client.company_name || '') + '</td>' +
                                                            '<td><button type="button" class="btn btn-primary select-client" data-id="' +
                                                            client.id + '" data-name="' + client.first_name + ' ' +
                                                            client.last_name + '" data-stir="' + client.stir +
                                                            '" data-company-name="' + (client.company_name || '') +
                                                            '">Select</button></td>' +
                                                            '</tr>'
                                                        );
                                                    });
                                                } else {
                                                    clientTableBody.append('<tr><td colspan="5">No clients found</td></tr>');
                                                }
                                            }
                                        });
                                    } else {
                                        clientTableBody.empty().append('<tr><td colspan="5">No clients found</td></tr>');
                                    }
                                });

                                $(document).on('click', '.select-client', function() {
                                    var clientId = $(this).data('id');
                                    var clientName = $(this).data('name');
                                    var stir = $(this).data('stir');
                                    var companyName = $(this).data('company-name');

                                    $('#client_id').val(clientId);
                                    $('#client_name').val(clientName);


                                    console.log($(this).data())
                                    $('.stir').val(stir || '');
                                    $('.company_name').val(companyName || 'N/A');



                                    // Close the modal
                                    $('#clientModal').modal('hide');
                                });
                            </script>


                        </div>


                        <div class="modal-footer d-flex">
                            <button type="button" class="btn btn-primary"
                                data-bs-dismiss="modal">@lang('global.submit')</button>
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">@lang('global.cancel')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Edit Modal end --}}
    </div>


    <div class="container">
        <form method="POST" action="{{ route('obyekt_create') }}">
            @csrf
            <div class="row">
                <div class="col-12 col-md-12 col-lg-6 col-xl-4">
                    <div class="mb-3">
                        <label for="client_id" class="col-md-4 col-form-label">Subyekt</label>
                        <select class="form-control form-select" name="client_id" id="client_id">
                            <option value="">Subyektni tanlang</option>
                            @foreach ($clients as $c)
                                <option value="{{ $c->id }}"
                                    {{ old('client_id') == $c->id || $selectedClientId == $c->id ? 'selected' : '' }}>
                                    {{ $c->first_name }} {{ $c->last_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-6 col-xl-4">
                    <div class="mb-3">
                        <label for="stir" class="col-md-4 col-form-label">STIR</label>
                        <input type="text" class="form-control stir" name="stir" id="stir">
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-6 col-xl-4">
                    <div class="mb-3">
                        <label for="company_name" class="col-md-4 col-form-label">Kompanya nomi</label>
                        <input type="text" class="form-control company_name" name="company_name" id="company_name">
                    </div>
                </div>



            </div>
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
                                        <option value="{{ $rux_tur->id }}">
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
                                <input class="form-control" type="text" name="ruxsat_raqami" id="ruxsat_raqami"
                                    value="{{ old('ruxsat_raqami') }}">
                            </div>
                      

                            <div class="mb-3">
                                <label for="ruxsat_sanasi">Рухсат этувчи хужжат санаси</label>
                                <input class="form-control" type="date" name="ruxsat_sanasi" id="ruxsat_sanasi"
                                    value="{{ old('ruxsat_sanasi') }}">
                            </div>
                         

                            <div class="mb-3">
                                <label for="ruxsatnoma_kim_tamonidan_id">Рухсат этувчи хужжат ким томонидан
                                    берилган</label>
                                <select class="form-control form_select_cof form-select"
                                    name="ruxsatnoma_kim_tamonidan_id" id="ruxsatnoma_kim_tamonidan_id">
                                    <option value="">Танланг</option>
                                    @foreach ($ruxsatnoma_kim_tamonidan as $rux_kim)
                                        <option value="{{ $rux_kim->id }}">
                                            {{ $rux_kim->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ruxsatnoma_turi')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                    
                            <div class="mb-3">
                                <label for="kadastr_raqami">Кадастр рақами</label>
                                <input class="form-control" type="text" name="kadastr_raqami" id="kadastr_raqami"
                                    value="{{ old('kadastr_raqami') }}" pattern="(\d{2}:\d{2}:\d{2}:\d{2}:\d{2}:\d{4})"
                                    title="Format: 11:04:42:01:03:0136" placeholder="11:04:42:01:03:0136" required>
                                <small id="kadastrHelp" class="form-text text-muted">
                                    Please enter the cadastral number in the format: 11:04:42:01:03:0136
                                </small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="ruxsatnoma_berilgan_ish_turi_id">Рухсатнома берилган иш тури</label>
                                <select class="form-control form_select_cof form-select"
                                    name="ruxsatnoma_berilgan_ish_turi_id" id="ruxsatnoma_berilgan_ish_turi_id">
                                    <option value="">Танланг</option>
                                    @foreach ($ruxsatnoma_berilgan_ish_turi as $rux_ber)
                                        <option value="{{ $rux_ber->id }}">
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
                                    value="{{ old('bino_qurilish_hajmi') }}">
                            </div>
                            <div class="mb-3">
                                <label for="ruxsatdan_tashqari_yuqori_hajm">Рухсатдан ташқари юқори ҳажм (куб.м)</label>
                                <input class="form-control qavatlar_soni_xajmi" type="number" step="any"
                                    name="ruxsatdan_tashqari_yuqori_hajm" id="ruxsatdan_tashqari_yuqori_hajm"
                                    value="{{ old('ruxsatdan_tashqari_yuqori_hajm') }}">
                            </div>
                            <div class="mb-3">
                                <label for="bino_avtoturargoh_qismi_hajmi">Бинонинг автотураргоҳ қисми ҳажми
                                    (куб.м)</label>
                                <input class="form-control avtoturargoh_xajmi" type="number" step="any"
                                    name="binoning_avtoturargoh_qismi_hajmi" id="bino_avtoturargoh_qismi_hajmi"
                                    value="{{ old('bino_avtoturargoh_qismi_hajmi') }}">
                            </div>
                            <div class="mb-3">
                                <label for="bino_texnik_honalar_hajmi">Бинонинг техник қақатлар, хоналар ҳажми
                                    (куб.м)</label>
                                <input class="form-control qavat_xona_xajmi" type="number" step="any"
                                    name="binoning_texnik_qavatlar_xonalar_hajmi" id="bino_texnik_honalar_hajmi"
                                    value="{{ old('bino_texnik_honalar_hajmi') }}">
                            </div>
                            <div class="mb-3">
                                <label for="turar_joy_binosi_foyda_hajmi">Турар жой биносининг умумий фойдаланишдаги қисми
                                    ҳажми (куб.м)</label>
                                <input class="form-control umumiy_foydalanishdagi_xajmi" type="number" step="any"
                                    name="turar_joy_binosining_umumiy_foydalanishdagi_qismi_hajmi"
                                    id="turar_joy_binosi_foyda_hajmi" value="{{ old('turar_joy_binosi_foyda_hajmi') }}">
                            </div>


                            <div class="mb-3">
                                <label for="kt_id">Қурилиш тури</label>
                                <select class="form-control form_select_cof form-select" name="kt_id" id="kt_id">
                                    <option value="">Qurilish turi</option>
                                    @foreach ($kts as $kt)
                                    <option value="{{ $kt->id }}" {{ old('kt_id') == $kt->id ? 'selected' : '' }}>
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
                                        <option value="{{ $ko->id }}" 
                                            {{ old('ko_id') == $ko->id ? 'selected' : '' }} 
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
                                <select class="form-control form_select_cof form-select" name="kz_id" id="hududiy_zona">
                                    <option value="">Xududiy zona</option>
                                    @foreach ($kzs as $kz)
                                        <option value="{{ $kz->id }}" 
                                            {{ old('kz_id') == $kz->id ? 'selected' : '' }} 
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
                                <select class="form-control form_select_cof form-select" name="kj_id" id="obyekt_joylashuvi">
                                    <option value="">Obyektning joylashuvi</option>
                                    @foreach ($kjs as $kj)
                                        <option value="{{ $kj->id }}" 
                                            {{ old('kj_id') == $kj->id ? 'selected' : '' }} 
                                            data-kt="{{ $kj->coefficient }}">
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
                                <input class="form-control" type="text" name="obyekt_nomi"
                                    id="obyekt_nomi" value="{{ old('obyekt_nomi') }}">
                            </div>


                            <div class="mb-3">
                                <label for="qoshimcha_malumot">Қўшимча маълумот</label>
                                <input class="form-control" type="text" name="qoshimcha_malumot"
                                    id="qoshimcha_malumot" value="{{ old('qoshimcha_malumot') }}">
                            </div>
                            <div class="mb-3">
                                <label for="geolokatsiya">Геолокация (координата)</label>
                                <input class="form-control" type="text" name="geolokatsiya" id="geolokatsiya"
                                    value="{{ old('geolokatsiya') }}">
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
