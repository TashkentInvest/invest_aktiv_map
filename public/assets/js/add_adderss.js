$(document).ready(function() {
    $('.region_id').change(function() {
        var regionId = $(this).val();
        if (regionId) {
            $.ajax({
                url: "{{ route('get.Obdistricts') }}",
                type: "GET",
                data: {
                    region_id: regionId
                },
                success: function(data) {
                    $('.district_id').empty();
                    $('.district_id').append('<option value="">Выберите район</option>');
                    $.each(data, function(key, value) {
                        $('.district_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                    $('.street_id').empty();
                    $('.sub_street_id').empty();
                }
            });
        } else {
            $('.district_id').empty();
            $('.street_id').empty();
            $('.sub_street_id').empty();
        }
    });

    $('.district_id').change(function() {
        var districtId = $(this).val();
        if (districtId) {
            $.ajax({
                url: "{{ route('get.Obstreets') }}",
                type: "GET",
                data: {
                    district_id: districtId
                },
                success: function(data) {
                    $('.street_id').empty();
                    $('.sub_street_id').empty();
                    $('.street_id').append('<option value="">Выберите улицу</option>');
                    $.each(data, function(key, value) {
                        $('.street_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        } else {
            $('.street_id').empty();
            $('.sub_street_id').empty();
        }
    });

    $('.street_id').change(function() {
        var streetId = $(this).val();
        if (streetId) {
            $.ajax({
                url: "{{ route('get.Obsubstreets') }}",
                type: "GET",
                data: {
                    street_id: streetId
                },
                success: function(data) {
                    $('.sub_street_id').empty();
                    $('.sub_street_id').append('<option value="">Выберите подулицу</option>');
                    $.each(data, function(key, value) {
                        $('.sub_street_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        } else {
            $('.sub_street_id').empty();
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
                    _token: '{{ csrf_token() }}', // CSRF token
                    district_id: districtId,
                    street_name: newStreetName
                },
                success: function(response) {
                    $('.street_id').append('<option value="' + response.id + '">' + response.name + '</option>');
                    $('.street_id').val(response.id); // Select the newly added street
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
                    _token: '{{ csrf_token() }}', // CSRF token
                    street_id: streetId,
                    sub_street_name: newSubStreetName
                },
                success: function(response) {
                    $('.sub_street_id').append('<option value="' + response.id + '">' + response.name + '</option>');
                    $('.sub_street_id').val(response.id); // Select the newly added substreet
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