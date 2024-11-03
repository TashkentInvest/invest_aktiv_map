@extends('layouts.admin')

@section('content')
    <h1>Янги Актив Яратиш</h1>

    <form method="POST" action="{{ route('aktivs.store') }}" enctype="multipart/form-data" id="aktiv-form">
        @csrf

        <input type="hidden" name="user_id" value="{{ auth()->user()->id ?? 1 }}">
        <div class="row my-3">
            <!-- Left Column -->
            <div class="col-md-6">
                <!-- Form Inputs -->
                <div class="mb-3">
                    <label for="object_name">Объект номи</label>
                    <input class="form-control" type="text" name="object_name" id="object_name"
                        value="{{ old('object_name') }}">
                    @error('object_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="balance_keeper">Балансда сақловчи</label>
                    <input class="form-control" type="text" name="balance_keeper" id="balance_keeper"
                        value="{{ old('balance_keeper') }}">
                    @error('balance_keeper')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="location">Мўлжал</label>
                    <input class="form-control" type="text" name="location" id="location" value="{{ old('location') }}">
                    @error('location')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="land_area">Ер майдони (кв.м)</label>
                    <input class="form-control" type="number" name="land_area" id="land_area"
                        value="{{ old('land_area') }}">
                    @error('land_area')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="building_area">Бино майдони (кв.м)</label>
                    <input class="form-control" type="number" name="building_area" id="building_area"
                        value="{{ old('building_area') }}">
                    @error('building_area')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <label for="gas">Газ</label>
                <select class="form-control form-select mb-3" name="gas" id="gas">
                    <option value="Мавжуд" {{ old('gas') == 'Мавжуд' ? 'selected' : '' }}>Мавжуд</option>
                    <option value="Мавжуд эмас" {{ old('gas') == 'Мавжуд эмас' ? 'selected' : '' }}>Мавжуд эмас</option>
                </select>
                @error('gas')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <label for="water">Сув</label>
                <select class="form-control form-select mb-3" name="water" id="water">
                    <option value="Мавжуд" {{ old('water') == 'Мавжуд' ? 'selected' : '' }}>Мавжуд</option>
                    <option value="Мавжуд эмас" {{ old('water') == 'Мавжуд эмас' ? 'selected' : '' }}>Мавжуд эмас</option>
                </select>
                @error('water')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <label for="electricity">Электр</label>
                <select class="form-control form-select mb-3" name="electricity" id="electricity">
                    <option value="Мавжуд" {{ old('electricity') == 'Мавжуд' ? 'selected' : '' }}>Мавжуд</option>
                    <option value="Мавжуд эмас" {{ old('electricity') == 'Мавжуд эмас' ? 'selected' : '' }}>Мавжуд эмас
                    </option>
                </select>
                @error('electricity')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <div class="mb-3">
                    <label for="additional_info">Қўшимча маълумот</label>
                    <input class="form-control" type="text" name="additional_info" id="additional_info"
                        value="{{ old('additional_info') }}">
                    @error('additional_info')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                @include('inc.__address')
            </div>
            <!-- Right Column -->
            <div class="col-md-6">
                <!-- File upload fields -->
                <div class="mb-3">
                    <label class="text-danger">Файлларни юклаш (Камида 4 та расм мажбурий !!!)</label>
                </div>
                <div class="mb-3">
                    <label for="file1">Биринчи файл</label>
                    <input type="file" class="form-control" name="files[]" id="file1" required>
                </div>
                <div class="mb-3">
                    <label for="file2">Иккинчи файл</label>
                    <input type="file" class="form-control" name="files[]" id="file2" required>
                </div>
                <div class="mb-3">
                    <label for="file3">Учинчи файл</label>
                    <input type="file" class="form-control" name="files[]" id="file3" required>
                </div>
                <div class="mb-3">
                    <label for="file4">Тўртинчи файл</label>
                    <input type="file" class="form-control" name="files[]" id="file4" required>
                </div>

                <!-- Error message display -->
                <div id="file-error" class="text-danger mb-3"></div>

                <!-- Container to hold additional file inputs -->
                <div id="file-upload-container"></div>

                <button type="button" class="btn btn-secondary mb-3" onclick="addFileInput()">Янги файл қўшиш</button>

                <!-- Map Section -->
                <div class="mb-3">
                    <button id="find-my-location" type="button" class="btn btn-primary mb-3">Менинг жойлашувимни
                        топиш</button>
                    <div id="map" style="height: 500px; width: 100%;"></div>
                    @error('latitude')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    @error('longitude')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Hidden Fields for Coordinates -->
                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">

                <!-- Geolocation URL Field -->
                <div class="mb-3">
                    <label for="geolokatsiya">Геолокация (координата)</label>
                    <input class="form-control" type="text" name="geolokatsiya" id="geolokatsiya" readonly required
                        value="{{ old('geolokatsiya') }}">
                    @error('geolokatsiya')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success" id="submit-btn">Сақлаш</button>
    </form>
@endsection

@section('scripts')
    <!-- Include Google Maps script and initialization code -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAnUwWTguBMsDU8UrQ7Re-caVeYCmcHQY&libraries=geometry">
    </script>
    <!-- Place the JavaScript code at the end, inside the 'scripts' section -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let aktivs = @json($aktivs);
            let map;
            let marker;
            let infoWindow;
    
            function validateFiles() {
                const submitBtn = document.getElementById('submit-btn');
                const errorDiv = document.getElementById('file-error');
                const fileInputs = document.querySelectorAll('input[type="file"][name="files[]"]');
    
                let totalFiles = 0;
                fileInputs.forEach(input => {
                    totalFiles += input.files.length;
                });
    
                if (totalFiles < 4) {
                    let filesNeeded = 4 - totalFiles;
                    errorDiv.textContent = filesNeeded === 4 
                        ? 'Сиз ҳеч қандай файл юкламадингиз.' 
                        : `Сиз янги ${filesNeeded} та файл юклашингиз керак.`;
                    submitBtn.disabled = true;
                } else {
                    errorDiv.textContent = '';
                    submitBtn.disabled = false;
                }
            }
    
            function addFileInput() {
                const container = document.getElementById('file-upload-container');
                const newDiv = document.createElement('div');
                newDiv.classList.add('mb-3');
                const label = document.createElement('label');
                label.textContent = `Қўшимча файл ${container.children.length + 5}`;
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('name', 'files[]');
                input.setAttribute('class', 'form-control');
                input.addEventListener('change', validateFiles);
                newDiv.appendChild(label);
                newDiv.appendChild(input);
                container.appendChild(newDiv);
            }
    
            document.getElementById('submit-btn').disabled = true;
            document.getElementById('file1').addEventListener('change', validateFiles);
            document.getElementById('file2').addEventListener('change', validateFiles);
            document.getElementById('file3').addEventListener('change', validateFiles);
            document.getElementById('file4').addEventListener('change', validateFiles);
            validateFiles();
    
            document.getElementById('aktiv-form').addEventListener('submit', function(event) {
                validateFiles();
                if (document.getElementById('submit-btn').disabled) {
                    event.preventDefault();
                } else {
                    document.getElementById('submit-btn').disabled = true;
                    document.getElementById('submit-btn').innerText = 'Юкланмоқда...';
                }
            });
    
            function initMap() {
                const mapOptions = {
                    center: { lat: 41.2995, lng: 69.2401 },
                    zoom: 10,
                };
    
                map = new google.maps.Map(document.getElementById('map'), mapOptions);
                infoWindow = new google.maps.InfoWindow();
    
                aktivs.forEach(function(aktiv) {
                    if (aktiv.latitude && aktiv.longitude) {
                        const position = {
                            lat: parseFloat(aktiv.latitude),
                            lng: parseFloat(aktiv.longitude)
                        };
    
                        const aktivMarker = new google.maps.Marker({
                            position: position,
                            map: map,
                            title: aktiv.object_name,
                            icon: 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png' // Yellow marker icon
                        });
    
                        aktivMarker.addListener('click', function() {
                            openInfoWindow(aktiv, aktivMarker);
                        });
                    }
                });
    
                document.getElementById('find-my-location').addEventListener('click', function() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            function(position) {
                                const userLocation = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude
                                };
    
                                map.setCenter(userLocation);
                                map.setZoom(15);
                                placeMarker(userLocation);
    
                                document.getElementById('latitude').value = userLocation.lat;
                                document.getElementById('longitude').value = userLocation.lng;
                                document.getElementById('geolokatsiya').value =
                                    `https://www.google.com/maps?q=${userLocation.lat},${userLocation.lng}`;
                            },
                            function(error) {
                                console.error('Error occurred. Error code: ' + error.code);
                                alert('Жойлашувингиз аниқланмади: ' + error.message);
                            }
                        );
                    } else {
                        alert('Жойлашувни аниқлаш браузерингиз томонидан қўлланилмайди.');
                    }
                });
    
                map.addListener('click', function(event) {
                    placeMarker(event.latLng);
                });
            }
    
            function placeMarker(location) {
                if (marker) {
                    marker.setMap(null);
                }
    
                marker = new google.maps.Marker({
                    position: location,
                    map: map
                });
    
                const lat = typeof location.lat === "function" ? location.lat() : location.lat;
                const lng = typeof location.lng === "function" ? location.lng() : location.lng;
    
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                document.getElementById('geolokatsiya').value = `https://www.google.com/maps?q=${lat},${lng}`;
            }
    
            function openInfoWindow(aktiv, marker) {
                const mainImagePath = aktiv.files && aktiv.files.length > 0 
                    ? `/storage/${aktiv.files[0].path}` 
                    : 'https://cdn.dribbble.com/users/1651691/screenshots/5336717/404_v2.png';
    
                const contentString = `
                    <div style="width:250px;">
                        <h5>${aktiv.object_name}</h5>
                        <img src="${mainImagePath}" alt="Marker Image" style="width:100%;height:auto;"/>
                        <p><strong>Балансда сақловчи:</strong> ${aktiv.balance_keeper || 'N/A'}</p>
                        <p><strong>Мўлжал:</strong> ${aktiv.location || 'N/A'}</p>
                        <p><strong>Ер майдони (кв.м):</strong> ${aktiv.land_area || 'N/A'}</p>
                        <p><strong>Бино майдони (кв.м):</strong> ${aktiv.building_area || 'N/A'}</p>
                        <p><strong>Газ:</strong> ${aktiv.gas || 'N/A'}</p>
                        <p><strong>Сув:</strong> ${aktiv.water || 'N/A'}</p>
                        <p><strong>Электр:</strong> ${aktiv.electricity || 'N/A'}</p>
                        <p><strong>Қўшимча маълумот:</strong> ${aktiv.additional_info || 'N/A'}</p>
                        <p><strong>Қарта:</strong> <a href="${aktiv.geolokatsiya || '#'}" target="_blank">${aktiv.geolokatsiya || 'N/A'}</a></p>
                    </div>
                `;
    
                infoWindow.setContent(contentString);
                infoWindow.open(map, marker);
            }
    
            initMap();
        });
    </script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Bootstrap CSS and JS (if not already included in your layout) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
