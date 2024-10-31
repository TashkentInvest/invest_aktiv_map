@extends('layouts.admin')

@section('content')
    <h1>Янги Актив Яратиш</h1>

    <form method="POST" action="{{ route('aktivs.store') }}" enctype="multipart/form-data">
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
                <!-- File upload field -->
                <div class="mb-3">
                    <label for="files" class="text-danger">Upload Files (Minimum 4)</label>
                    <input type="file" class="form-control" name="files[]" id="files" multiple required
                        onchange="validateFiles()">
                    <div id="file-error" class="text-danger"></div>
                </div>

                <!-- Container to hold additional file inputs -->
                <div id="file-upload-container"></div>

                <button type="button" onclick="addFileInput()">Add More Files</button>

                <script>
                    document.getElementById('files').addEventListener('change', validateFiles);

                    function validateFiles() {
                        const fileInput = document.getElementById('files');
                        const submitBtn = document.getElementById('submit-btn');
                        const errorDiv = document.getElementById('file-error');

                        // Count the files selected in the main file input and any additional inputs
                        let totalFiles = fileInput.files.length;
                        const additionalFileInputs = document.querySelectorAll('#file-upload-container input[type="file"]');
                        additionalFileInputs.forEach(input => {
                            totalFiles += input.files.length;
                        });

                        // Validate minimum file requirement
                        if (totalFiles < 4) {
                            errorDiv.textContent = 'Please upload at least 4 files.';
                            submitBtn.disabled = true;
                        } else {
                            errorDiv.textContent = '';
                            submitBtn.disabled = false;
                        }
                    }

                    function addFileInput() {
                        const container = document.getElementById('file-upload-container');
                        const newInput = document.createElement('input');
                        newInput.setAttribute('type', 'file');
                        newInput.setAttribute('name', 'files[]');
                        newInput.setAttribute('class', 'form-control mt-2');
                        newInput.setAttribute('onchange', 'validateFiles()'); // Add onchange event for validation
                        container.appendChild(newInput);
                    }

                    // Disable submit button initially if fewer than 4 files are selected
                    document.getElementById('submit-btn').disabled = true;
                </script>

                <!-- Map Section -->
                <div class="mb-3">
                    <button id="find-my-location" type="button" class="btn btn-primary mb-3">Find My Location</button>
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

        <script>
            document.querySelector('form').addEventListener('submit', function() {
                document.getElementById('submit-btn').disabled = true;
                document.getElementById('submit-btn').innerText = 'Юкланмоқда...';
            });
        </script>
    </form>
@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAnUwWTguBMsDU8UrQ7Re-caVeYCmcHQY&libraries=geometry">
    </script>
    <script>
        let map;
        let marker;

        function initMap() {
            const mapOptions = {
                center: {
                    lat: 41.2995,
                    lng: 69.2401
                },
                zoom: 10,
            };

            map = new google.maps.Map(document.getElementById('map'), mapOptions);

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

                            // Set latitude, longitude, and geolocation URL in the input fields
                            document.getElementById('latitude').value = userLocation.lat;
                            document.getElementById('longitude').value = userLocation.lng;
                            document.getElementById('geolokatsiya').value =
                                `https://www.google.com/maps?q=${userLocation.lat},${userLocation.lng}`;
                        },
                        function(error) {
                            console.error('Error occurred. Error code: ' + error.code);
                            alert('Error getting your location: ' + error.message);
                        }
                    );
                } else {
                    alert('Geolocation is not supported by this browser.');
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

        window.onload = initMap;
    </script>
@endsection
