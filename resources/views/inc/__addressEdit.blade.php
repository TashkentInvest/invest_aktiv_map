<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address Form</title>
    <!-- Include your CSS and other assets here -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7-beta.0/jquery.inputmask.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
</head>
<body>
    <div class="card mb-3">
        <div class="card-header">
            <h5>Манзил маълумотлари (Address Information)</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong>Вилоят номи (Region Name):</strong>
                {{ $aktiv->subStreet->district->region->name_uz ?? 'Маълумот йўқ' }}
            </div>
            <div class="mb-3">
                <strong>Туман номи (District Name):</strong>
                {{ $aktiv->subStreet->district->name_uz ?? 'Маълумот йўқ' }}
            </div>
            <div class="mb-3">
                <strong>Мфй номи (MFY Name):</strong>
                {{ $aktiv->street->name ?? 'Маълумот йўқ' }}
            </div>
            <div class="mb-3">
                <strong>Кўча номи (Sub Street Name):</strong>
                {{ $aktiv->subStreet->name ?? 'Маълумот йўқ' }}
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <h5>Манзилни озгартириш (Edit Address)</h5>
        </div>
        <div class="card-body">
           
                <div class="mb-3">
                    <label for="region_id">Худуд</label>
                    <select class="form-control region_id select2" name="region_id" id="region_id">
                        <option value="">Худудни танланг</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region->id }}" {{ $region->id == old('region_id', optional($aktiv->subStreet->district->region)->id) ? 'selected' : '' }}>
                                {{ $region->name_uz }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="district_id">Район</label>
                    <select class="form-control district_id select2" name="district_id" id="district_id">
                        <option value="">Туманни танланг</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="street_id" class="me-2">Мфй</label>
                    <div class="d-flex align-items-end">
                        <select class="form-control street_id select2" name="street_id" id="street_id">
                            <option value="">Мфй ни танланг</option>
                        </select>
                        <button type="button" class="btn btn-primary ms-2" id="add_street_btn" title="Мфй қошиш">+</button>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="substreet_id" class="me-2">Кўча</label>
                    <div class="d-flex align-items-end">
                        <select class="form-control sub_street_id select2" name="sub_street_id" id="substreet_id">
                            <option value="">Кўчани танланг</option>
                        </select>
                        <button type="button" class="btn btn-primary ms-2" id="add_substreet_btn" title="Кўча қошиш">+</button>
                    </div>
                </div>
        </div>
    </div>

    <!-- Include jQuery and Select2 JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>
    <!-- Include Inputmask JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7-beta.0/jquery.inputmask.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();

            function fetchDistricts(regionId, selectedDistrictId = null) {
                console.log('Fetching districts for region ID:', regionId);
                $.ajax({
                    url: "{{ route('getDistricts') }}",
                    type: "GET",
                    data: { region_id: regionId },
                    success: function(data) {
                        console.log('Districts fetched:', data);
                        $('.district_id').empty().append('<option value="">Туманни танланг</option>');
                        $.each(data, function(key, value) {
                            $('.district_id').append('<option value="' + key + '">' + value + '</option>');
                        });
                        if (selectedDistrictId) {
                            $('.district_id').val(selectedDistrictId).trigger('change');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching districts:', error);
                    }
                });
            }

            function fetchStreets(districtId, selectedStreetId = null) {
                console.log('Fetching streets for district ID:', districtId);
                $.ajax({
                    url: "{{ route('getStreets') }}",
                    type: "GET",
                    data: { district_id: districtId },
                    success: function(data) {
                        console.log('Streets fetched:', data);
                        $('.street_id').empty().append('<option value="">Мфй ни танланг</option>');
                        $.each(data, function(key, value) {
                            $('.street_id').append('<option value="' + key + '">' + value + '</option>');
                        });
                        if (selectedStreetId) {
                            $('.street_id').val(selectedStreetId).trigger('change');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching streets:', error);
                    }
                });
            }

            function fetchSubStreets(streetId, selectedSubStreetId = null) {
                console.log('Fetching substreets for street ID:', streetId);
                $.ajax({
                    url: "{{ route('getSubStreets') }}",
                    type: "GET",
                    data: { street_id: streetId },
                    success: function(data) {
                        console.log('Substreets fetched:', data);
                        $('.sub_street_id').empty().append('<option value="">Кўчани танланг</option>');
                        if (data.length > 0) {
                            $.each(data, function(key, value) {
                                $('.sub_street_id').append('<option value="' + key + '">' + value + '</option>');
                            });
                        } else {
                            $('.sub_street_id').append('<option value="">Маълумот йўқ</option>');
                        }
                        if (selectedSubStreetId) {
                            $('.sub_street_id').val(selectedSubStreetId);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching substreets:', error);
                    }
                });
            }

            // Update Districts based on selected Region
            $('.region_id').change(function() {
                var regionId = $(this).val();
                if (regionId) {
                    fetchDistricts(regionId);
                } else {
                    $('.district_id').empty().append('<option value="">Туманни танланг</option>');
                    $('.street_id').empty().append('<option value="">Мфй ни танланг</option>');
                    $('.sub_street_id').empty().append('<option value="">Кўчани танланг</option>');
                }
            });

            // Update Streets based on selected District
            $('.district_id').change(function() {
                var districtId = $(this).val();
                if (districtId) {
                    fetchStreets(districtId);
                } else {
                    $('.street_id').empty().append('<option value="">Мфй ни танланг</option>');
                    $('.sub_street_id').empty().append('<option value="">Кўчани танланг</option>');
                }
            });

            // Update SubStreets based on selected Street
            $('.street_id').change(function() {
                var streetId = $(this).val();
                if (streetId) {
                    fetchSubStreets(streetId);
                } else {
                    $('.sub_street_id').empty().append('<option value="">Кўчани танланг</option>');
                }
            });

            // Add Street Button Click Event
            $('#add_street_btn').click(function() {
                var districtId = $('#district_id').val();
                if (!districtId) {
                    alert('Выберите район сначала');
                    return;
                }
                var newStreetName = prompt('Введите название новой улицы:');
                if (newStreetName) {
                    $.ajax({
                        url: "{{ route('create.streets') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            district_id: districtId,
                            street_name: newStreetName
                        },
                        success: function(response) {
                            console.log('Street added:', response);
                            $('.street_id').append('<option value="' + response.id + '">' + response.name + '</option>');
                            $('.street_id').val(response.id).trigger('change');
                            alert('Улица успешно добавлена: ' + response.name);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error adding street:', error);
                            alert('Ошибка при добавлении улицы. Пожалуйста, попробуйте снова.');
                        }
                    });
                }
            });

            // Add SubStreet Button Click Event
            $('#add_substreet_btn').click(function() {
                var streetId = $('#street_id').val();
                if (!streetId) {
                    alert('Выберите улицу сначала');
                    return;
                }
                var newSubStreetName = prompt('Введите название новой подулицы:');
                if (newSubStreetName) {
                    $.ajax({
                        url: "{{ route('create.substreets') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            street_id: streetId,
                            sub_street_name: newSubStreetName
                        },
                        success: function(response) {
                            console.log('SubStreet added:', response);
                            $('.sub_street_id').append('<option value="' + response.id + '">' + response.name + '</option>');
                            $('.sub_street_id').val(response.id);
                            alert('Подулица успешно добавлена: ' + response.name);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error adding substreet:', error);
                            alert('Ошибка при добавлении подулицы. Пожалуйста, попробуйте снова.');
                        }
                    });
                }
            });

            // Pre-populate districts, streets, and substreets if region and district are already selected
            var selectedRegionId = "{{ old('region_id', optional($aktiv->subStreet->district->region)->id) }}";
            var selectedDistrictId = "{{ old('district_id', optional($aktiv->subStreet->district)->id) }}";
            var selectedStreetId = "{{ old('street_id', $aktiv->street_id) }}";
            var selectedSubStreetId = "{{ old('sub_street_id', $aktiv->sub_street_id) }}";

            if (selectedRegionId) {
                fetchDistricts(selectedRegionId, selectedDistrictId);
            }
            if (selectedDistrictId) {
                fetchStreets(selectedDistrictId, selectedStreetId);
            }
            if (selectedStreetId) {
                fetchSubStreets(selectedStreetId, selectedSubStreetId);
            }
        });
    </script>
</body>
</html>