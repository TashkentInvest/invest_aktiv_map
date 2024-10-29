@extends('layouts.admin')

@section('content')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAnUwWTguBMsDU8UrQ7Re-caVeYCmcHQ&libraries=geometry">
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAnUwWTguBMsDU8UrQ7Re-caVeYCmcHQY&libraries=geometry">
    </script>


    <script>
        let map;
        let marker; // To store the marker reference
        const polygons = [];

        function initMap() {
            const mapOptions = {
                center: {
                    lat: 41.2995,
                    lng: 69.2401
                }, // Centered on Tashkent
                zoom: 10,
            };

            map = new google.maps.Map(document.getElementById('map'), mapOptions);

            // KML File URL
            const kmlUrl = "{{ asset('assets/zona.kml') }}";

            // Load KML and parse polygons
            fetch(kmlUrl)
                .then(response => response.text())
                .then(kmlText => {
                    const parser = new DOMParser();
                    const xmlDoc = parser.parseFromString(kmlText, 'application/xml');
                    const placemarks = xmlDoc.getElementsByTagName('Placemark');

                    const colors = {
                        '1-zona': '#f58964',
                        '2-zona': '#f0d29a',
                        '3-zona': '#91c29b',
                        '4-zona': '#9798f3',
                        '5-zona': '#c498c7',
                        'Shahar_chegarasi': 'black',
                        'Tuman_chegarasi': 'grey'
                    };

                    Array.from(placemarks).forEach(placemark => {
                        const name = placemark.getElementsByTagName('SimpleData')[3]?.textContent.trim();
                        const coordinatesText = placemark.getElementsByTagName('coordinates')[0]?.textContent
                            .trim();
                        const color = colors[name] || 'grey';

                        if (coordinatesText) {
                            const coordinates = coordinatesText.split(' ').map(coord => {
                                const [lng, lat] = coord.split(',').map(Number);
                                return {
                                    lat,
                                    lng
                                };
                            });

                            const polygon = new google.maps.Polygon({
                                paths: coordinates,
                                strokeColor: color,
                                strokeOpacity: 0.8,
                                strokeWeight: 2,
                                fillColor: color,
                                fillOpacity: 0.35,
                                map: map,
                                zIndex: name === '1-zona' ? 100 : 1
                            });

                            polygons.push({
                                polygon,
                                name
                            });

                            polygon.addListener('click', function(event) {
                                placeMarker(event.latLng, name);
                            });
                        }
                    });
                })
                .catch(error => console.error('Error loading KML:', error));

            map.addListener('click', function(event) {
                placeMarker(event.latLng);

                let selectedZone = null;
                polygons.forEach(({
                    polygon,
                    name
                }) => {
                    if (google.maps.geometry.poly.containsLocation(event.latLng, polygon)) {
                        selectedZone = name;
                    }
                });

                if (selectedZone) {
                    document.getElementById('zone_name').value = selectedZone;
                    alert(`You clicked inside zone: ${selectedZone}`);
                } else {
                    alert(`No zone selected. Coordinates: Lat ${event.latLng.lat()}, Lng ${event.latLng.lng()}`);
                }
            });

            // "Find My Location" button
            document.getElementById('find-my-location').addEventListener('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        map.setCenter(userLocation);
                        map.setZoom(15);
                        placeMarker(userLocation);

                        let selectedZone = null;
                        polygons.forEach(({
                            polygon,
                            name
                        }) => {
                            if (google.maps.geometry.poly.containsLocation(new google.maps.LatLng(
                                    userLocation.lat, userLocation.lng), polygon)) {
                                selectedZone = name;
                            }
                        });

                        if (selectedZone) {
                            document.getElementById('zone_name').value = selectedZone;
                            alert(`You are in zone: ${selectedZone}`);
                        } else {
                            alert(
                                `No zone selected. Coordinates: Lat ${userLocation.lat()}, Lng ${userLocation.lng}`
                            );
                        }
                    }, function(error) {
                        console.error('Error occurred. Error code: ' + error.code);
                        alert('Error getting your location.');
                    });
                } else {
                    alert('Geolocation is not supported by this browser.');
                }
            });
        }

        function placeMarker(location, zoneName = null) {
            if (marker) {
                marker.setMap(null);
            }

            marker = new google.maps.Marker({
                position: location,
                map: map
            });

            document.getElementById('latitude').value = location.lat();
            document.getElementById('longitude').value = location.lng();

            if (zoneName) {
                document.getElementById('zone_name').value = zoneName;
            }
        }

        window.onload = initMap;
    </script>

    <h1>Create New Aktiv</h1>

    <form method="POST" action="{{ route('aktivs.store') }}" enctype="multipart/form-data">
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


                        <!-- File upload field -->
                        <div class="mb-3">
                            <label for="files">Upload Files</label>
                            <input type="file" class="form-control" name="files[]" id="files" multiple>
                        </div>

                        <!-- Button to open the map modal -->
                        <!-- Map Section -->
                        <div class="mb-3">
                            <button id="find-my-location" type="button" class="btn btn-primary mb-3">Find My
                                Location</button>
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
                            <input class="form-control" type="text" name="geolokatsiya" id="geolokatsiya"
                                value="{{ old('geolokatsiya') }}">
                            @error('geolokatsiya')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

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
                                }, // Centered on Tashkent
                                zoom: 10,
                            };

                            map = new google.maps.Map(document.getElementById('map'), mapOptions);

                            // "Find My Location" button
                            document.getElementById('find-my-location').addEventListener('click', function() {
                                if (navigator.geolocation) {
                                    navigator.geolocation.getCurrentPosition(function(position) {
                                        const userLocation = {
                                            lat: position.coords.latitude,
                                            lng: position.coords.longitude
                                        };
                                        map.setCenter(userLocation);
                                        map.setZoom(15);
                                        placeMarker(userLocation);
                                    }, function(error) {
                                        console.error('Error occurred. Error code: ' + error.code);
                                        alert('Error getting your location.');
                                    });
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
                </div>
            </div>

        </div>
        </div>

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

        <!-- Zone Name -->
        <div class="mb-3">
            <label for="zone_name" class="form-label">Zone Name</label>
            <input type="text" class="form-control" name="zone_name" id="zone_name" value="{{ old('zone_name') }}">
            @error('zone_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
@endsection
