<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address Form</title>
    <!-- Include your CSS and other assets here -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2 .select2-container .select2-container--default .select2-container--below{
            width: 100% !important;
        }
    </style>
</head>
<body>
    <div class="card mb-3">
        <div class="card-header">
            <h5>Манзилни озгартириш</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="region_id">Худуд</label>
                <select class="form-control region_id select2" name="region_id" id="region_id">
                    <option value="">Худудни танланг</option>
                    @foreach ($regions as $region)
                        <option value="{{ $region->id }}" {{ $region->id == old('region_id', $bank->substreet->street->district->region_id ?? '') ? 'selected' : '' }}>
                            {{ $region->name_uz }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="district_id">Район</label>
                <select class="form-control district_id select2" name="district_id" id="district_id">
                    <option value="">Туманни танланг</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}" {{ $district->id == old('district_id', $bank->substreet->street->district_id ?? '') ? 'selected' : '' }}>
                            {{ $district->name_uz }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="street_id" class="me-2">Мфй</label>
                <div class="d-flex align-items-end">
                    <select class="form-control street_id select2" name="street_id" id="street_id">
                        <option value="">Мфй ни танланг</option>
                        @foreach ($streets as $street)
                            <option value="{{ $street->id }}" {{ $street->id == old('street_id', $bank->substreet->street_id ?? '') ? 'selected' : '' }}>
                                {{ $street->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-primary ms-2" id="add_street_btn" title="Мфй қошиш">+</button>
                </div>
            </div>

            <div class="mb-3">
                <label for="substreet_id" class="me-2">Кўча</label>
                <div class="d-flex align-items-end">
                    <select class="form-control sub_street_id select2" name="sub_street_id" id="substreet_id">
                        <option value="">Кўчани танланг</option>
                        @foreach ($substreets as $substreet)
                            <option value="{{ $substreet->id }}" {{ $substreet->id == old('sub_street_id', $bank->sub_street_id ?? '') ? 'selected' : '' }}>
                                {{ $substreet->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-primary ms-2" id="add_substreet_btn" title="Кўча қошиш">+</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery and Select2 JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();

            // Update Districts based on selected Region
            $('.region_id').change(function() {
                var regionId = $(this).val();
                if (regionId) {
                    $.ajax({
                        url: "{{ route('get.Obdistricts') }}",
                        type: "GET",
                        data: { region_id: regionId },
                        success: function(data) {
                            $('.district_id').empty().append('<option value="">Туманни танланг</option>');
                            $.each(data, function(key, value) {
                                $('.district_id').append('<option value="' + key + '">' + value + '</option>');
                            });
                            // Reset dependent fields
                            $('.street_id').empty().append('<option value="">Мфй ни танланг</option>');
                            $('.sub_street_id').empty().append('<option value="">Кўчани танланг</option>');
                        }
                    });
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
                    $.ajax({
                        url: "{{ route('get.Obstreets') }}",
                        type: "GET",
                        data: { district_id: districtId },
                        success: function(data) {
                            $('.street_id').empty().append('<option value="">Мфй ни танланг</option>');
                            $.each(data, function(key, value) {
                                $('.street_id').append('<option value="' + key + '">' + value + '</option>');
                            });
                            // Reset dependent field
                            $('.sub_street_id').empty().append('<option value="">Кўчани танланг</option>');
                        }
                    });
                } else {
                    $('.street_id').empty().append('<option value="">Мфй ни танланг</option>');
                    $('.sub_street_id').empty().append('<option value="">Кўчани танланг</option>');
                }
            });

            // Update SubStreets based on selected Street
            $('.street_id').change(function() {
                var streetId = $(this).val();
                if (streetId) {
                    $.ajax({
                        url: "{{ route('get.Obsubstreets') }}",
                        type: "GET",
                        data: { street_id: streetId },
                        success: function(data) {
                            $('.sub_street_id').empty().append('<option value="">Кўчани танланг</option>');
                            $.each(data, function(key, value) {
                                $('.sub_street_id').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    });
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
                        url: "{{ route('create.street') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            district_id: districtId,
                            street_name: newStreetName
                        },
                        success: function(response) {
                            $('.street_id').append('<option value="' + response.id + '">' + response.name + '</option>');
                            $('.street_id').val(response.id);
                            alert('Улица успешно добавлена: ' + response.name);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
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
                        url: "{{ route('create.substreet') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            street_id: streetId,
                            sub_street_name: newSubStreetName
                        },
                        success: function(response) {
                            $('.sub_street_id').append('<option value="' + response.id + '">' + response.name + '</option>');
                            $('.sub_street_id').val(response.id);
                            alert('Подулица успешно добавлена: ' + response.name);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            alert('Ошибка при добавлении подулицы. Пожалуйста, попробуйте снова.');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
