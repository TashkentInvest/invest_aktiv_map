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
        <!-- Display success message -->

        <form method="POST" action="{{ route('obyekt_create') }}">
            @csrf


            <div class="row my-3">

                <!-- Ariza -->
                <div class="col-md-6">


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
                                <label for="object_name">Объект номи</label>
                                <input class="form-control shaxarsozlik_umumiy_xajmi" type="text" name="object_name"
                                    id="object_name" value="{{ old('object_name') }}">
                            </div>

                            <div class="mb-3">
                                <label for="balance_keeper">Балансда сақловчи</label>
                                <input class="form-control qavatlar_soni_xajmi" type="text" name="balance_keeper"
                                    id="balance_keeper" value="{{ old('balance_keeper') }}">
                            </div>

                            <div class="mb-3">
                                <label for="location">Мўлжал</label>
                                <input class="form-control avtoturargoh_xajmi" type="text" name="location" id="location"
                                    value="{{ old('location') }}">
                            </div>

                            <div class="mb-3">
                                <label for="land_area">Ер майдони (кв.м)</label>
                                <input class="form-control qavat_xona_xajmi" type="number" name="land_area" id="land_area"
                                    value="{{ old('land_area') }}">
                            </div>

                            <div class="mb-3">
                                <label for="building_area">Бино майдони
                                    (кв.м)</label>
                                <input class="form-control umumiy_foydalanishdagi_xajmi" type="text" name="building_area"
                                    id="building_area" value="{{ old('building_area') }}">
                            </div>

           
                            <label for="gas">Газ</label>
                            <select class="form-control form-select mb-3" name="gas" id="gas">
                                <option value="">
                                    Мавжуд
                                </option>
                                <option value="">
                                    Мавжуд эмас
                                </option>
                            </select>

                            <label for="Сув">Сув</label>
                            <select class="form-control form-select mb-3" name="water" id="water">
                                <option value="">
                                    Мавжуд
                                </option>
                                <option value="">
                                    Мавжуд эмас
                                </option>
                            </select>

                            <label for="Электр">Электр</label>
                            <select class="form-control form-select mb-3" name="electricity" id="electricity">
                                <option value="">
                                    Мавжуд
                                </option>
                                <option value="">
                                    Мавжуд эмас
                                </option>
                            </select>

                            <div class="mb-3">
                                <label for="water">Қўшимча маълумот</label>
                                <input class="form-control" type="text" name="additional_info" id="additional_info"
                                    value="{{ old('additional_info') }}">
                            </div>

                            <!-- Button to open the map modal -->
                            @include('inc.__select_map')

                            <!-- Form Inputs for Coordinates -->
                            <div class="mb-3">
                                <label for="geolokatsiya">Зона</label>
                                <input type="text" class="form-control" name="zone_name"
                                    value="{{ old('zone_name') }}" id="zone_name">
                                <label for="geolokatsiya">Геолокация (координата)</label>
                                <input class="form-control" type="text" name="geolokatsiya" id="geolokatsiya"
                                    value="{{ old('geolokatsiya') }}">
                                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">

                            </div>

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
