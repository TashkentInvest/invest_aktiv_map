@extends('layouts.admin')

@section('content')
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAnUwWTguBMsDU8UrQ7Re-caVeYCmcHQ&libraries=geometry">
    </script> --}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAnUwWTguBMsDU8UrQ7Re-caVeYCmcHQY&libraries=geometry"></script>


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

        <div class="mb-3">
            <label for="object_name" class="form-label">Object Name</label>
            <input type="text" class="form-control" name="object_name" id="object_name" value="{{ old('object_name') }}">
            @error('object_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Repeat similar blocks for other fields -->
        <div class="mb-3">
            <label for="balance_keeper" class="form-label">Balance Keeper</label>
            <input type="text" class="form-control" name="balance_keeper" id="balance_keeper"
                value="{{ old('balance_keeper') }}">
            @error('balance_keeper')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Add all other input fields accordingly -->

        <div class="mb-3">
            <label for="gas" class="form-label">Gas</label>
            <select class="form-select" name="gas" id="gas">
                <option value="Available" {{ old('gas') == 'Available' ? 'selected' : '' }}>Available</option>
                <option value="Not Available" {{ old('gas') == 'Not Available' ? 'selected' : '' }}>Not Available</option>
            </select>
            @error('gas')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Similarly for water and electricity -->

        <div class="mb-3">
            <label for="additional_info" class="form-label">Additional Info</label>
            <textarea class="form-control" name="additional_info" id="additional_info">{{ old('additional_info') }}</textarea>
            @error('additional_info')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- File Upload -->
        <div class="mb-3">
            <label for="files" class="form-label">Upload Files</label>
            <input type="file" class="form-control" name="files[]" id="files" multiple>
            @error('files.*')
                <div class="text-danger">{{ $message }}</div>
            @enderror
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
