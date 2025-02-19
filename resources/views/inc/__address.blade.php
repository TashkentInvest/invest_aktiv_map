<div class="card mb-3">
    <div class="card-header">
        <h5>Манзил</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="region_id">Худуд</label>
                    <select class="form-control region_id select2" name="region_id" id="region_id">
                        <option value="">Худудни танланг</option>
                        @foreach ($regions as $region)
                            {{-- <option value="{{ $region->id == 1 }}" selected>{{ $region->name_uz }}</option> --}}
                            <option value="{{ $region->id }}">{{ $region->name_uz }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger error-message" id="region_id_error"></span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="district_id">Район</label>
                    <select class="form-control district_id select2" name="district_id" id="district_id">
                        <option value="">Туманни танланг</option>
                    </select>
                    <span class="text-danger error-message" id="district_id_error"></span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="street_id" class="me-2">Мфй</label>
                    <div class="d-flex align-items-end">
                        <select class="form-control street_id select2" name="street_id" id="street_id" required>
                            <option value="">Мфй ни танланг</option>
                        </select>
                        <button type="button" class="btn btn-primary ms-2" id="add_street_btn"
                            title="Мфй қошиш">+</button>
                    </div>
                    <span class="text-danger error-message" id="street_id_error"></span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="sub_street_id" class="me-2">Кўча</label>
                    <div class="d-flex align-items-end">
                        <select class="form-control sub_street_id select2" name="sub_street_id" id="sub_street_id"
                            required>
                            <option value="">Кўчани танланг</option>
                        </select>
                        <button type="button" class="btn btn-primary ms-2" id="add_substreet_btn"
                            title="Кўча қошиш">+</button>
                    </div>
                    <span class="text-danger error-message" id="sub_street_id_error"></span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="home_number" class="me-2">Уй рақами (Мажбурий эмас)</label>
                    <div class="d-flex align-items-end">
                        <input class="form-control" name="home_number" type="text" id="home_number" />
                    </div>
                    <span class="text-danger error-message" id="home_number_error"></span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="apartment_number" class="me-2">Квартира рақами (Мажбурий эмас)</label>
                    <div class="d-flex align-items-end">
                        <input class="form-control" name="apartment_number" type="text" id="apartment_number" />
                    </div>
                    <span class="text-danger error-message" id="apartment_number_error"></span>
                </div>
            </div>




        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
// alert('ok');
        // Initialize select2
        $('.select2').select2();

        // When a region is selected
        $('#region_id').change(function() {
            // alert(data);

            var regionId = $(this).val();
            if (regionId) {
                $.ajax({
                    url: "{{ route('get.Obdistricts') }}",
                    type: "GET",
                    data: {
                        region_id: regionId
                    },
                    success: function(data) {
                        $('#district_id').empty().append(
                            '<option value="">Туманни танланг</option>');
                        $.each(data, function(key, value) {
                            $('#district_id').append('<option value="' + key +
                                '">' + value + '</option>');
                        });
                        $('#street_id').empty().append(
                            '<option value="">Мфй ни танланг</option>');
                        $('#sub_street_id').empty().append(
                            '<option value="">Кўчани танланг</option>');
                    }
                });
            } else {
                $('#district_id').empty().append('<option value="">Туманни танланг</option>');
                $('#street_id').empty().append('<option value="">Мфй ни танланг</option>');
                $('#sub_street_id').empty().append('<option value="">Кўчани танланг</option>');
            }
        });

        // When a district is selected
        $('#district_id').change(function() {
            var districtId = $(this).val();
            if (districtId) {
                $.ajax({
                    url: "{{ route('get.Obstreets') }}",
                    type: "GET",
                    data: {
                        district_id: districtId
                    },
                    success: function(data) {
                        $('#street_id').empty().append(
                            '<option value="">Мфй ни танланг</option>');
                        $.each(data, function(key, value) {
                            $('#street_id').append('<option value="' + key + '">' +
                                value + '</option>');
                        });

                        // Update sub-streets for the selected district
                        $.ajax({
                            url: "{{ route('get.Obsubstreets') }}",
                            type: "GET",
                            data: {
                                district_id: districtId
                            },
                            success: function(substreets) {
                                $('#sub_street_id').empty().append(
                                    '<option value="">Кўчани танланг</option>'
                                );
                                $.each(substreets, function(key, value) {
                                    $('#sub_street_id').append(
                                        '<option value="' + key +
                                        '">' + value + '</option>');
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching sub-streets:',
                                    error);
                                $('#sub_street_id').empty().append(
                                    '<option value="">Кўчани танланг</option>'
                                );
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching streets:', error);
                        $('#street_id').empty().append(
                            '<option value="">Мфй ни танланг</option>');
                        $('#sub_street_id').empty().append(
                            '<option value="">Кўчани танланг</option>');
                    }
                });
            } else {
                $('#street_id').empty().append('<option value="">Мфй ни танланг</option>');
                $('#sub_street_id').empty().append('<option value="">Кўчани танланг</option>');
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
                        $('#street_id').append('<option value="' + response.id + '">' +
                            response.name + '</option>');
                        $('#street_id').val(response.id).trigger('change');
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
                    url: "{{ route('create.substreet') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        district_id: districtId,
                        sub_street_name: newSubStreetName
                    },
                    success: function(response) {
                        $('#sub_street_id').append('<option value="' + response.id + '">' +
                            response.name + '</option>');
                        $('#sub_street_id').val(response.id).trigger('change');
                        alert('Подулица успешно добавлена: ' + response.name);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error adding sub-street:', error);
                        alert(
                            'Ошибка при добавлении подулицы. Пожалуйста, попробуйте снова.'
                        );
                    }
                });
            }
        });
    });
</script>
