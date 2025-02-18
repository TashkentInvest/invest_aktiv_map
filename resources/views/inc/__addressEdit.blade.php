<div class="card mb-3">
    <div class="card-header">
        <h5>Манзилни озгартириш</h5>
    </div>
    <div class="card-body row">
        <div class="col-lg-6 col-md-12 col-12 mb-3">
            <label for="region_id">Худуд</label>
            <select class="form-control region_id select2" name="region_id" id="region_id"
                required>
                <option value="" disabled selected>Худудни танланг</option>
                @foreach ($regions as $region)
                    <option value="{{ $region->id }}"
                        {{ $region->id == old('region_id', optional($aktiv->subStreet->district->region)->id) ? 'selected' : '' }}>
                        {{ $region->name_uz }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-lg-6 col-md-12 col-12 mb-3">
            <label for="district_id">Туман</label>
            <select class="form-control district_id select2" name="district_id" id="district_id"
                required>
                <option value="" disabled selected>Туманни танланг</option>
                @foreach ($districts as $district)
                    <option value="{{ $district->id }}"
                        {{ $district->id == old('district_id', optional($aktiv->subStreet->district)->id) ? 'selected' : '' }}>
                        {{ $district->name_uz }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-lg-6 col-md-12 col-12 mb-3">
            <label for="street_id" class="me-2">Мфй (Majburiy)<span></span></label>
            <div class="d-flex align-items-end">
                <select class="form-control street_id select2" name="street_id" id="street_id"
                    required>
                    <option value="" disabled selected>Мфй ни танланг</option>
                    @foreach ($streets as $street)
                        <option value="{{ $street->id }}"
                            {{ $street->id == old('street_id', $aktiv->street_id) ? 'selected' : '' }}>
                            {{ $street->name }}
                        </option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-primary ms-2" id="add_street_btn"
                    title="Мфй қошиш">+</button>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-12 mb-3">
            <label for="substreet_id" class="me-2">Кўча (Majburiy)<span></span></label>
            <div class="d-flex align-items-end">
                <select class="form-control sub_street_id select2" name="sub_street_id"
                    id="substreet_id" required>
                    <option value="" disabled selected>Кўчани танланг</option>
                    @foreach ($substreets as $substreet)
                        <option value="{{ $substreet->id }}"
                            {{ $substreet->id == old('sub_street_id', $aktiv->sub_street_id) ? 'selected' : '' }}>
                            {{ $substreet->name }}
                        </option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-primary ms-2" id="add_substreet_btn"
                    title="Кўча қошиш">+</button>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="mb-3">
                <label for="home_number" class="me-2">Уй рақами (Мажбурий эмас)</label>
                <div class="d-flex align-items-end">
                    <input class="form-control" name="home_number" type="text"
                        id="home_number" value="{{ old('home_number', $aktiv->home_number) }}" />
                </div>
                <span class="text-danger error-message" id="home_number_error"></span>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="apartment_number" class="me-2">Квартира рақами (Мажбурий
                    эмас)</label>
                <div class="d-flex align-items-end">
                    <input class="form-control" name="apartment_number" type="text"
                        value="{{ old('apartment_number', $aktiv->apartment_number) }}"
                        id="apartment_number" />
                </div>
                <span class="text-danger error-message" id="apartment_number_error"></span>
            </div>
        </div>
    </div>
</div>

<style>
    .select2 {
        width: 100% !important;
    }
</style>

<script>
    $(document).ready(function() {
        $('.select2').select2();

        function fetchDistricts(regionId, selectedDistrictId = null) {
            $.ajax({
                url: "{{ route('getDistricts') }}",
                type: "GET",
                data: {
                    region_id: regionId
                },
                success: function(data) {
                    $('.district_id').empty().append(
                        '<option value="" disabled selected>Туманни танланг</option>');
                    $.each(data, function(key, value) {
                        $('.district_id').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                    if (selectedDistrictId) {
                        $('.district_id').val(selectedDistrictId).trigger('change');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching District:', error);
                }
            });
        }

        function fetchStreets(districtId, selectedStreetId = null) {
            $.ajax({
                url: "{{ route('getStreets') }}",
                type: "GET",
                data: {
                    district_id: districtId
                },
                success: function(data) {
                    $('.street_id').empty().append(
                        '<option value="" disabled selected>Мфй ни танланг</option>');
                    $.each(data, function(key, value) {
                        $('.street_id').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                    if (selectedStreetId) {
                        setTimeout(function() {
                            $('.street_id').val(selectedStreetId).trigger('change');
                        }, 500); // Adding a delay to ensure the data is fully loaded
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching streets:', error);
                }
            });
        }

        function fetchSubStreets(districtId, selectedSubStreetId = null) {
            $.ajax({
                url: "{{ route('getSubStreets') }}",
                type: "GET",
                data: {
                    district_id: districtId
                },
                success: function(data) {
                    $('.sub_street_id').empty().append(
                        '<option value="" disabled selected>Кўчани танланг</option>');
                    $.each(data, function(key, value) {
                        $('.sub_street_id').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                    if (selectedSubStreetId) {
                        setTimeout(function() {
                            $('.sub_street_id').val(selectedSubStreetId).trigger('change');
                        }, 500); // Adding a delay to ensure the data is fully loaded
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching substreets:', error);
                }
            });
        }

        // Initialize selections if data exists
        // var selectedRegionId = "{{ old('region_id', optional($aktiv->subStreet->district->region)->id) }}";
        // var selectedDistrictId = "{{ old('district_id', optional($aktiv->subStreet->district)->id) }}";
        // var selectedStreetId = "{{ old('street_id', $aktiv->street_id) }}";
        // var selectedSubStreetId = "{{ old('sub_street_id', $aktiv->sub_street_id) }}";

        // if (selectedRegionId) {
        //     fetchDistricts(selectedRegionId, selectedDistrictId);
        // }
        // if (selectedDistrictId) {
        //     fetchStreets(selectedDistrictId, selectedStreetId);
        // }
        // if (selectedDistrictId) {
        //     fetchSubStreets(selectedDistrictId, selectedSubStreetId);
        // }

        // Update Districts based on Region change
        $('.region_id').change(function() {
            var regionId = $(this).val();
            fetchDistricts(regionId);
        });

        // Update Streets and SubStreets based on District change
        $('.district_id').change(function() {
            var districtId = $(this).val();
            fetchStreets(districtId);
            fetchSubStreets(districtId);
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
                        $('.street_id').append('<option value="' + response.id + '">' +
                            response.name + '</option>');
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
            var districtId = $('#district_id').val();
            if (!districtId) {
                alert('Выберите район сначала');
                return;
            }
            var newSubStreetName = prompt('Введите название новой подулицы:');
            if (newSubStreetName) {
                $.ajax({
                    url: "{{ route('create.substreets') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        district_id: districtId,
                        sub_street_name: newSubStreetName
                    },
                    success: function(response) {
                        $('.sub_street_id').append('<option value="' + response.id + '">' +
                            response.name + '</option>');
                        $('.sub_street_id').val(response.id);
                        alert('Подулица успешно добавлена: ' + response.name);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error adding substreet:', error);
                        alert(
                            'Ошибка при добавлении подулицы. Пожалуйста, попробуйте снова.'
                        );
                    }
                });
            }
        });
    });
</script>
