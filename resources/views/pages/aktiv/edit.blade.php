@extends('layouts.admin')

@section('content')
    <h1>Активни таҳрирлаш</h1>

    <form method="POST" action="{{ route('aktivs.update', $aktiv->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row my-3">
            <!-- Left Column -->
            <div class="col-md-6">
                <!-- Form Inputs -->
                <div class="mb-3">
                    <label for="object_name">Объект номи</label>
                    <input class="form-control" type="text" name="object_name" id="object_name"
                        value="{{ old('object_name', $aktiv->object_name) }}">
                    @error('object_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="balance_keeper">Балансда сақловчи</label>
                    <input class="form-control" type="text" name="balance_keeper" id="balance_keeper"
                        value="{{ old('balance_keeper', $aktiv->balance_keeper) }}">
                    @error('balance_keeper')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="location">Мўлжал</label>
                    <input class="form-control" type="text" name="location" id="location"
                        value="{{ old('location', $aktiv->location) }}">
                    @error('location')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="land_area">Ер майдони (кв.м)</label>
                    <input class="form-control" type="number" name="land_area" id="land_area"
                        value="{{ old('land_area', $aktiv->land_area) }}">
                    @error('land_area')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="building_area">Бино майдони (кв.м)</label>
                    <input class="form-control" type="number" name="building_area" id="building_area"
                        value="{{ old('building_area', $aktiv->building_area) }}">
                    @error('building_area')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <label for="gas">Газ</label>
                <select class="form-control form-select mb-3" name="gas" id="gas">
                    <option value="Мавжуд" {{ old('gas', $aktiv->gas) == 'Мавжуд' ? 'selected' : '' }}>Мавжуд</option>
                    <option value="Мавжуд эмас" {{ old('gas', $aktiv->gas) == 'Мавжуд эмас' ? 'selected' : '' }}>Мавжуд
                        эмас</option>
                </select>
                @error('gas')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <label for="water">Сув</label>
                <select class="form-control form-select mb-3" name="water" id="water">
                    <option value="Мавжуд" {{ old('water', $aktiv->water) == 'Мавжуд' ? 'selected' : '' }}>Мавжуд</option>
                    <option value="Мавжуд эмас" {{ old('water', $aktiv->water) == 'Мавжуд эмас' ? 'selected' : '' }}>Мавжуд
                        эмас</option>
                </select>
                @error('water')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <label for="electricity">Электр</label>
                <select class="form-control form-select mb-3" name="electricity" id="electricity">
                    <option value="Мавжуд" {{ old('electricity', $aktiv->electricity) == 'Мавжуд' ? 'selected' : '' }}>
                        Мавжуд</option>
                    <option value="Мавжуд эмас"
                        {{ old('electricity', $aktiv->electricity) == 'Мавжуд эмас' ? 'selected' : '' }}>Мавжуд эмас
                    </option>
                </select>
                @error('electricity')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <div class="mb-3">
                    <label for="additional_info">Қўшимча маълумот</label>
                    <input class="form-control" type="text" name="additional_info" id="additional_info"
                        value="{{ old('additional_info', $aktiv->additional_info) }}">
                    @error('additional_info')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Region Information -->
                <div class="mb-3">
                    <strong>Вилоят номи (Region Name):</strong>
                    {{ $aktiv->subStreet->district->region->name_uz ?? 'Маълумот йўқ' }}
                </div>

                <!-- District Information -->
                <div class="mb-3">
                    <strong>Туман номи (District Name):</strong>
                    {{ $aktiv->subStreet->district->name_uz ?? 'Маълумот йўқ' }}
                </div>
                <!-- SubStreet Information -->
                <div class="mb-3">
                    <strong>Кўча номи (Sub Street Name):</strong>
                    {{ $aktiv->subStreet->name ?? 'Маълумот йўқ' }}
                </div>


                <!-- Include Address Partial -->
                @include('inc.__address')

            </div>

            <!-- Right Column -->
            <div class="col-md-6">
                <!-- File upload field -->
                <div class="mb-3">
                    <label for="files">Қўшимча файллар юклаш</label>
                    <input type="file" class="form-control" name="files[]" id="files" multiple>
                    @error('files.*')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Display Existing Files -->
                <div class="mb-3">
                    <label>Юкланган файллар:</label>
                    @if ($aktiv->files->count())
                        <ul>
                            @foreach ($aktiv->files as $file)
                                <li>
                                    <a href="{{ asset('storage/' . $file->path) }}"
                                        target="_blank">{{ basename($file->path) }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>Файллар мавжуд эмас.</p>
                    @endif
                </div>

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
                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $aktiv->latitude) }}">
                <input type="hidden" name="longitude" id="longitude"
                    value="{{ old('longitude', $aktiv->longitude) }}">

                <!-- Geolocation URL Field -->
                <div class="mb-3">
                    <label for="geolokatsiya">Геолокация (координата)</label>
                    <input class="form-control" type="text" name="geolokatsiya" id="geolokatsiya"
                        value="{{ old('geolokatsiya', $aktiv->geolokatsiya) }}" readonly>
                    @error('geolokatsiya')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success">Янгилаш</button>
    </form>
@endsection

@section('scripts')
    <!-- Include the Google Maps JavaScript API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAnUwWTguBMsDU8UrQ7Re-caVeYCmcHQY&libraries=geometry">
    </script>
    <script>
        let map;
        let marker;

        function initMap() {
            const initialLocation = {
                lat: parseFloat('{{ old('latitude', $aktiv->latitude) }}') || 41.2995,
                lng: parseFloat('{{ old('longitude', $aktiv->longitude) }}') || 69.2401
            };

            map = new google.maps.Map(document.getElementById('map'), {
                center: initialLocation,
                zoom: 15
            });

            if (initialLocation.lat && initialLocation.lng) {
                placeMarker(initialLocation);
            }

            // "Find My Location" button
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
                        },
                        function(error) {
                            console.error('Error occurred. Error code: ' + error.code);
                            console.error('Error message: ' + error.message);
                            alert('Error getting your location: ' + error.message);
                        }
                    );
                } else {
                    alert('Geolocation is not supported by this browser.');
                }
            });

            // Allow user to place marker by clicking on the map
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

            document.getElementById('latitude').value = location.lat();
            document.getElementById('longitude').value = location.lng();

            const googleMapsUrl = `https://www.google.com/maps?q=${location.lat()},${location.lng()}`;
            document.getElementById('geolokatsiya').value = googleMapsUrl;
        }

        window.onload = initMap;
    </script>
@endsection
