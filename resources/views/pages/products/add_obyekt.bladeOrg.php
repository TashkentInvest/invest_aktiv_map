@extends('layouts.admin')
@section('content')

    <style>
        .modal-body {
            overflow-y: auto !important;
        }
        #hide_me{
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
                        <button data-bs-toggle="modal" data-bs-target="#exampleModal_FizikAdd"
                            class="dropdown-item">Jismoniy shaxs</button>
                        <button data-bs-toggle="modal" data-bs-target="#exampleModal_YuridikAdd" class="dropdown-item"
                            class="dropdown-item">Yuridik shaxs</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- fizik modal --}}
        <div class="modal fade" id="exampleModal_FizikAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Jismoniy shaxs qo'shish
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="myForm" action="{{ route('obyekt_create_fizik_client') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            @include('inc.__fizik_subyekt')
                        </div>
                        <div class="modal-footer d-flex">
                            <button type="submit" class="btn btn-primary">@lang('global.submit')</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('global.cancel')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- fizik modal end --}}

        {{-- yuridik modal --}}
        <div class="modal fade" id="exampleModal_YuridikAdd" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            {{-- {{ $construction->{'name_' . app()->getLocale()} }} --}}
                            Yuridik shaxs qo'shish
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form>

                        <div class="modal-body">

                            <form id='myForm' action="{{ route('obyekt_create_yuridik_client') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @include('inc.__yurik_subyekt')
                            </form>


                        </div>
                        <div class="modal-footer d-flex">
                            <button type="submit" class="btn btn-primary">@lang('global.submit')</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('global.cancel')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- yuridik modal end --}}

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
                                    <input type="text" class="form-control" name="unique_code" id="unique_code" placeholder="Search by code, name, company, etc.">
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
                                            data: { query: query },
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
                                                            '<td><button type="button" class="btn btn-primary select-client" data-id="' + client.id + '" data-name="' + client.first_name + ' ' + client.last_name + '">Select</button></td>' +
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
                            
                                    $('#client_id').val(clientId);
                                    $('#client_name').val(clientName);
                            
                                    // Close the modal
                                    $('#clientModal').modal('hide');
                                });
                            </script>
                            
                            
                        </div>
                        
                        
                        <div class="modal-footer d-flex">
                            <button type="button" class="btn btn-primary"  data-bs-dismiss="modal">@lang('global.submit')</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('global.cancel')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Edit Modal end --}}
    </div>

    <div class="row">
        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
            <div class="mb-3">
                <label for="client_id" class="col-md-4 col-form-label">@lang('global.category')</label>
                <select class="form-control form-select" name="client_id" id="client_id">
                    <option value="">Select Client</option>
                    @foreach ($clients as $c)
                        <option value="{{ $c->id }}" {{ (old('client_id') == $c->id || $selectedClientId == $c->id) ? 'selected' : '' }}>
                            {{ $c->first_name }} {{ $c->last_name }}
                        </option>
                    @endforeach
                </select>
                @error('client_id')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
            <div class="mb-3">
                <label for="stir" class="col-md-4 col-form-label">STIR</label>
                <input type="text" class="form-control" name="stir" id="stir" readonly>
            </div>
        </div>
        
        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
            <div class="mb-3">
                <label for="company_name" class="col-md-4 col-form-label">Company Name</label>
                <input type="text" class="form-control" name="company_name" id="company_name" readonly>
            </div>
        </div>

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
                            if (data.error) {
                                $('#stir').val('');
                                $('#company_name').val('Client not found');
                            } else {
                                $('#stir').val(data.stir || 'N/A');
                                $('#company_name').val(data.company_name || 'N/A');
                            }
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
        </script>
        
        
    </div>

    <div class="container">
        <div class="row my-3">
    
            <!-- Ariza -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5>Ариза</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="ariza_no">Рухсатнома учун берилган ариза №</label>
                            <input class="form-control" type="text" name="ariza_no" id="ariza_no" value="{{ old('ariza_no') }}">
                        </div>
                        <div class="mb-3">
                            <label for="ariza_sanasi">Рухсатнома учун берилган ариза санаси</label>
                            <input class="form-control" type="date" name="ariza_sanasi" id="ariza_sanasi" value="{{ old('ariza_sanasi') }}">
                        </div>
                        <div class="mb-3">
                            <label for="ruxsat_etuvchi_nom">Рухсат этувчи хужжат номи</label>
                            <input class="form-control" type="text" name="ruxsat_etuvchi_nom" id="ruxsat_etuvchi_nom" value="{{ old('ruxsat_etuvchi_nom') }}">
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        <h5>Рухсатнома</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="ruxsatnoma_turi">Рухсатнома тури</label>
                            <input class="form-control" type="text" name="ruxsatnoma_turi" id="ruxsatnoma_turi" value="{{ old('ruxsatnoma_turi') }}">
                        </div>
                        <div class="mb-3">
                            <label for="ruxsat_etuvchi">Рухсат этувчи хужжат ким томонидан берилган</label>
                            <input class="form-control" type="text" name="ruxsat_etuvchi" id="ruxsat_etuvchi" value="{{ old('ruxsat_etuvchi') }}">
                        </div>
                        <div class="mb-3">
                            <label for="ruxsat_sanasi">Рухсат этувчи хужжат санаси</label>
                            <input class="form-control" type="date" name="ruxsat_sanasi" id="ruxsat_sanasi" value="{{ old('ruxsat_sanasi') }}">
                        </div>
                        <div class="mb-3">
                            <label for="ruxsat_raqami">Рухсат этувчи хужжат рақами</label>
                            <input class="form-control" type="text" name="ruxsat_raqami" id="ruxsat_raqami" value="{{ old('ruxsat_raqami') }}">
                        </div>
                        <div class="mb-3">
                            <label for="obyekt_tumani">Объект жойлашган тумани</label>
                            <input class="form-control" type="text" name="obyekt_tumani" id="obyekt_tumani" value="{{ old('obyekt_tumani') }}">
                        </div>
                        <div class="mb-3">
                            <label for="obyekt_manzili">Объект манзили</label>
                            <input class="form-control" type="text" name="obyekt_manzili" id="obyekt_manzili" value="{{ old('obyekt_manzili') }}">
                        </div>
                        <div class="mb-3">
                            <label for="kadastr_raqami">Кадастр рақами</label>
                            <input class="form-control" type="text" name="kadastr_raqami" id="kadastr_raqami" value="{{ old('kadastr_raqami') }}">
                        </div>
                        <div class="mb-3">
                            <label for="ish_turi">Рухсатнома берилган иш тури</label>
                            <input class="form-control" type="text" name="ish_turi" id="ish_turi" value="{{ old('ish_turi') }}">
                        </div>
                    </div>
                </div>
              
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
                            <input class="form-control shaxarsozlik_umumiy_xajmi" type="text" name="bino_qurilish_hajmi" id="bino_qurilish_hajmi" value="{{ old('bino_qurilish_hajmi') }}">
                        </div>
                        <div class="mb-3">
                            <label for="ruxsatdan_tashqari_yuqori_hajm">Рухсатдан ташқари юқори ҳажм (куб.м)</label>
                            <input class="form-control qavatlar_soni_xajmi" type="text" name="ruxsatdan_tashqari_yuqori_hajm" id="ruxsatdan_tashqari_yuqori_hajm" value="{{ old('ruxsatdan_tashqari_yuqori_hajm') }}">
                        </div>
                        <div class="mb-3">
                            <label for="bino_avtoturargoh_qismi_hajmi">Бинонинг автотураргоҳ қисми ҳажми (куб.м)</label>
                            <input class="form-control avtoturargoh_xajmi" type="text" name="bino_avtoturargoh_qismi_hajmi" id="bino_avtoturargoh_qismi_hajmi" value="{{ old('bino_avtoturargoh_qismi_hajmi') }}">
                        </div>
                        <div class="mb-3">
                            <label for="bino_texnik_honalar_hajmi">Бинонинг техник қақатлар, хоналар ҳажми (куб.м)</label>
                            <input class="form-control qavat_xona_xajmi" type="text" name="bino_texnik_honalar_hajmi" id="bino_texnik_honalar_hajmi" value="{{ old('bino_texnik_honalar_hajmi') }}">
                        </div>
                        <div class="mb-3">
                            <label for="turar_joy_binosi_foyda_hajmi">Турар жой биносининг умумий фойдаланишдаги қисми ҳажми (куб.м)</label>
                            <input class="form-control umumiy_foydalanishdagi_xajmi" type="text" name="turar_joy_binosi_foyda_hajmi" id="turar_joy_binosi_foyda_hajmi" value="{{ old('turar_joy_binosi_foyda_hajmi') }}">
                        </div>

                   
                        <div class="mb-3">
                            <label for="qurilish_turi">Қурилиш тури</label>
                            <select class="form-control form_select_cof form-select" name="qurilish_turi" id="qurilish_turi">
                                <option value="">Qurilish turi</option>
                                @foreach ($kts as $kt)
                                <option value="{{ $kt->id }}" data-kt="{{ $kt->coefficient }}">
                                    {{ $kt->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('qurilish_turi')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                       

                        <div class="mb-3">
                            <label for="obyekt_turi">Объект тури</label>
                            <select class="form-control form_select_cof form-select" name="obyekt_turi" id="obyekt_turi">
                                <option value="">Obyekt turi</option>
                                @foreach ($kos as $ko)
                                <option value="{{ $ko->id }}" data-kt="{{ $ko->coefficient }}">
                                    {{ $ko->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('obyekt_turi')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                      
                        <div class="mb-3">
                            <label for="hududiy_zona">Ҳудудий зона</label>
                            <select class="form-control form_select_cof form-select" name="hududiy_zona" id="hududiy_zona">
                                <option value="">Xududiy zona</option>
                                @foreach ($kzs as $kz)
                                <option value="{{ $kz->id }}" data-kt="{{ $kz->coefficient }}">
                                    {{ $kz->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('obyekt_joylashuvi')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="obyekt_joylashuvi">Объект жойлашуви</label>
                            <select class="form-control form_select_cof form-select" name="obyekt_joylashuvi" id="obyekt_joylashuvi">
                                <option value="">Obyektning joylashuvi</option>
                                @foreach ($kjs as $kj)
                                <option value="{{ $kj->id }}" data-kt="{{ $kj->coefficient }}">
                                    {{ $kj->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('obyekt_joylashuvi')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="qoshimcha_malumot">Қўшимча маълумот</label>
                            <input class="form-control" type="text" name="qoshimcha_malumot" id="qoshimcha_malumot" value="{{ old('qoshimcha_malumot') }}">
                        </div>
                        <div class="mb-3">
                            <label for="geolokatsiya">Геолокация (координата)</label>
                            <input class="form-control" type="text" name="geolokatsiya" id="geolokatsiya" value="{{ old('geolokatsiya') }}">
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
                            <input class="form-control" type="text" name="kompleks" id="kompleks" value="{{ old('kompleks') }}">
                        </div>
                        <div class="mb-3">
                            <label for="loiyha_hajmi_haqida">Лойиҳа ҳажми ҳақида маълумотнома (шаблон)</label>
                            <input class="form-control" type="text" name="loiyha_hajmi_haqida" id="loiyha_hajmi_haqida" value="{{ old('loiyha_hajmi_haqida') }}">
                        </div>
                    </div>
                </div>
            </div>
    
         
    
        </div>
    </div>
    
    

    <div class="row">
          
        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
            <div class="mb-3">
                <label for="contract_apt">@lang('global.ruxsatnoma_raqami')</label>
                <input type="text" class="form-control" name="contract_apt"
                    placeholder="@lang('global.ruxsatnoma_raqami')" value="{{ old('contract_apt') }}">
                @error('contract_apt')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
            <div class="mb-3">
                <label for="contract_date">@lang('global.sanasi')</label>
                <input class="form-control" type="date" name="contract_date"
                    value="{{ old('contract_date') }}">
                @error('contract_date')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6 col-xl-3">
            <div class="mb-3">
                <label for="notification_num">@lang('cruds.branches.fields.notification_num')</label>
                <input type="text" class="form-control" name="notification_num"
                    placeholder="@lang('cruds.branches.fields.notification_num')" value="{{ old('notification_num') }}">

                @error('notification_num')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6 col-xl-3">
            <div class="mb-3">
                <label for="notification_date">@lang('cruds.branches.fields.notification_date')</label>
                <input type="date" class="form-control" name="notification_date"
                    placeholder="@lang('cruds.branches.fields.notification_date')" value="{{ old('notification_date') }}">
                @error('notification_date')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6 col-xl-3">
            <div class="mb-3">
                <label for="insurance_policy">@lang('cruds.branches.fields.insurance_policy')</label>
                <input type="text" class="form-control" name="insurance_policy"
                    placeholder="@lang('cruds.branches.fields.insurance_policy')" value="{{ old('insurance_policy') }}">
                @error('insurance_policy')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6 col-xl-3">
            <div class="mb-3">
                <label for="bank_guarantee">@lang('cruds.branches.fields.bank_guarantee')</label>
                <input type="text" class="form-control" name="bank_guarantee"
                    placeholder="@lang('cruds.branches.fields.bank_guarantee')" value="{{ old('bank_guarantee') }}">
                @error('bank_guarantee')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
            <div class="mb-3">
                <label for="application_number">@lang('cruds.branches.fields.application_number')</label>
                <input type="text" class="form-control" name="application_number"
                    placeholder="@lang('cruds.branches.fields.application_number')" value="{{ old('application_number') }}">
                @error('application_number')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
            <div class="mb-3">
                <label for="payed_sum">@lang('cruds.branches.fields.payed_sum')</label>
                <input type="text" class="form-control" name="payed_sum"
                    placeholder="@lang('cruds.branches.fields.payed_sum')" value="{{ old('payed_sum') }}">
                @error('payed_sum')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
            <div class="mb-3">
                <label for="payed_date">@lang('cruds.branches.fields.payed_date')</label>
                <input type="date" class="form-control" name="payed_date"
                    placeholder="@lang('cruds.branches.fields.payed_date')" value="{{ old('payed_date') }}">
                @error('payed_date')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">


        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
            <div class="mb-3">
                <label for="branch_name">@lang('global.loyiha_nomi')</label>
                <input type="text" class="form-control" name="branch_name"
                    value="{{ old('branch_name') }}" placeholder="@lang('global.loyiha_nomi')">
                @error('branch_name')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <!-- New fields -->
        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
            <div class="mb-3">
                <label for="shaxarsozlik_umumiy_xajmi">@lang('global.shaxarsozlik_umumiy_xajmi')</label>
                <input type="number" class="form-control shaxarsozlik_umumiy_xajmi"
                    name="shaxarsozlik_umumiy_xajmi" placeholder="@lang('global.shaxarsozlik_umumiy_xajmi')"
                    value="{{ old('shaxarsozlik_umumiy_xajmi') }}" step="0.01">
                @error('shaxarsozlik_umumiy_xajmi')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
            <div class="mb-3">
                <label for="qavatlar_soni_xajmi">@lang('global.qavatlar_soni_xajmi')</label>
                <input type="number" class="form-control qavatlar_soni_xajmi" name="qavatlar_soni_xajmi"
                    placeholder="@lang('global.qavatlar_soni_xajmi')" value="{{ old('qavatlar_soni_xajmi') }}"
                    step="0.01">
                @error('qavatlar_soni_xajmi')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
            <div class="mb-3">
                <label for="avtoturargoh_xajmi">@lang('global.avtoturargoh_xajmi')</label>
                <input type="number" class="form-control avtoturargoh_xajmi" name="avtoturargoh_xajmi"
                    placeholder="@lang('global.avtoturargoh_xajmi')" value="{{ old('avtoturargoh_xajmi') }}"
                    step="0.01">
                @error('avtoturargoh_xajmi')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
            <div class="mb-3">
                <label for="qavat_xona_xajmi">@lang('global.qavat_xona_xajmi')</label>
                <input type="number" class="form-control qavat_xona_xajmi" name="qavat_xona_xajmi"
                    placeholder="@lang('global.qavat_xona_xajmi')" value="{{ old('qavat_xona_xajmi') }}" step="0.01">
                @error('qavat_xona_xajmi')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
            <div class="mb-3">
                <label for="umumiy_foydalanishdagi_xajmi">@lang('global.umumiy_foydalanishdagi_xajmi')</label>
                <input type="number" class="form-control umumiy_foydalanishdagi_xajmi"
                    name="umumiy_foydalanishdagi_xajmi" placeholder="@lang('global.umumiy_foydalanishdagi_xajmi')"
                    value="{{ old('umumiy_foydalanishdagi_xajmi') }}" step="0.01">
                @error('umumiy_foydalanishdagi_xajmi')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-12 col-xl-12">
            <div class="mb-3">
                <label for="branch_location">@lang('cruds.company.fields.branch_location')</label>
                <input type="text" class="form-control branch_location" name="branch_location"
                    placeholder="@lang('cruds.company.fields.branch_location')" value="{{ old('branch_location') }}">
                @error('branch_location')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-12 col-xl-12">
            <div class="mb-3">
                <label for="branch_type_text">@lang('cruds.company.fields.branch_type') text</label>
                <input type="text" class="form-control branch_type_text" name="branch_type_text"
                    placeholder="@lang('cruds.company.fields.branch_type') text" value="{{ old('branch_type_text') }}">
                @error('branch_type_text')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="mb-3">
                <label for="obyekt_joylashuvi">Obyektning
                    joylashuvi</label>
                <select class="form-control form_select_cof form-select" name="obyekt_joylashuvi"
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
                    <option value="Mazkur bo‘limning 1-qatorida ko‘rsatilmagan boshqa obyektlar" data-kt="1">
                        Mazkur bo‘limning 1-qatorida ko‘rsatilmagan boshqa
                        obyektlar
                    </option>
                </select>
                @error('obyekt_joylashuvi')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="mb-3">
                <label for="branch_type">@lang('global.loyiha_turi')</label>
                <select class="form-control form_select_cof form-select" name="branch_type"
                    id="branch_type">
                    <option value="">@lang('global.loyiha_turi')</option>
                    <option value="Alohida turgan xususiy ijtimoiy infratuzilma va turizm obyektlari" data-kt="0.5">
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
                    <option value="Mazkur bo‘limning 1–5-qatorlarida ko‘rsatilmagan boshqa obyektlar" data-kt="1">
                        Mazkur bo‘limning 1–5-qatorlarida ko‘rsatilmagan
                        boshqa obyektlar
                    </option>
                </select>
                @error('branch_type')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="mb-3">
                <label for="qurilish_turi">@lang('global.qurilish_turi')</label>
                <select class="form-control form_select_cof form-select" name="qurilish_turi"
                    id="qurilish_turi">
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
                    <option value="Obyektni qurilish hajmini o‘zgartirmagan holda rekonstruksiya qilish" data-kt="0">
                        Obyektni qurilish hajmini o‘zgartirmagan holda
                        rekonstruksiya qilish
                    </option>
                </select>
                @error('qurilish_turi')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="mb-3">
                <label for="zona">@lang('global.zona')</label>
                <select id="zona" class="form-control form_select_cof form-select" name="zona">
                    <option value="">Zona</option>
                    <option value="1" data-kt="1.40">1-zona</option>
                    <option value="2" data-kt="1.25">2-zona</option>
                    <option value="3" data-kt="1.00">3-zona</option>
                    <option value="4" data-kt="0.75">4-zona</option>
                    <option value="5" data-kt="0.50">5-zona</option>
                </select>
                @error('zona')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
            <div class="mb-3">
                <label for="coefficient">@lang('global.coefficient')</label>
                <input type="text" class="form-control coefficient" id="coefficient"
                    name="coefficient" readonly value="1.00">
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
            <div class="mb-3">
                <label for="branch_name">@lang('global.loyiha_nomi')</label>
                <input type="text" class="form-control" name="branch_name"
                    value="{{ old('branch_name') }}" placeholder="@lang('global.loyiha_nomi')">
                @error('branch_name')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>


    



        <!-- End new fields -->
        <div class="col-12 col-md-6 col-lg-6 col-xl-3">
            <div class="inner-repeater mb-4">
                <div data-repeater-list="inner-group" class="inner mb-3">
                    <label for="basicpill-cardno-input">@lang('global.obyekt_boyicha_tolanishi_lozim')</label>
                    <input type="number" step="0.00001" class="form-control branch_kubmetr" placeholder="( m³ )"
                        name="branch_kubmetr" value="{{ old('branch_kubmetr') }}"
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
        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
            <div class="mb-3">
                <label for="basicpill-card-verification-input">@lang('global.bazaviy_xisoblash_miqdori')</label>
                <input type="number" class="form-control minimum_wage" placeholder="@lang('global.bazaviy_xisoblash_miqdori')"
                    value="{{ old('minimum_wage', '340000') }}" step="0.01" name="minimum_wage">

                @error('minimum_wage')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
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
        <div class="col-12 col-md-6 col-lg-6 col-xl-4">
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
        <div class="col-12 col-md-6 col-lg-6 col-xl-4">
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
        <div class="col-12 col-md-6 col-lg-6 col-xl-4">
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
                    name="first_payment_percent" value="{{ old('first_payment_percent') }}"
                    id="first_payment_percent_0">
                @error('first_payment_percent')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>


        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
            <div class="mb-3">
                <label for="calculated-quarterly-payment">@lang('global.quarterly_payment')</label>
                <input type="text" class="form-control calculated-quarterly-payment"
                    value="{{ old('calculated_quarterly_payment') }}" placeholder="@lang('global.quarterly_payment')"
                    readonly disabled>
                @error('calculated_quarterly_payment')
                    <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

    </div>

    <div class="col-sm-12">
        <div class="card">
            <div class="card-body text-end btn-page">
                <button type="submit" class="btn btn-primary mb-0">Yuborish</button>
                {{-- <button class="btn btn-outline-secondary mb-0">Qaytadan</button> --}}
            </div>
        </div>
    </div>

    <script src="{{asset('assets/new/js/new_149_formula.js')}}"></script>
@endsection
