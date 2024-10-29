<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAnUwWTguBMsDU8UrQ7Re-caVeYCmcHQY&libraries=geometry"></script>
    <style>
        #map {
            height: 500px;
            width: 100%;
        }

        .legend {
            background-color: white;
            padding: 10px;
            margin: 10px;
            font-size: 14px;
        }

        .legend h5 {
            margin-bottom: 10px;
        }

        .color-box {
            width: 20px;
            height: 20px;
            display: inline-block;
            margin-right: 10px;
        }
    </style>
    <title>Map with Persistent Polygons</title>
</head>
<body>
    <h1>Керакли зонани танланг</h1>
    <form method="POST" id="zone-form">
        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $latitude) }}">
        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $longitude) }}">
        <input type="hidden" name="zone_name" id="zone_name" value="{{ old('zone_name', $zone_name) }}">
        <input type="hidden" name="geolokatsiya" id="geolokatsiya" value="{{ old('geolokatsiya', $geolokatsiya) }}">
        <div id="map"></div>
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
    <div class="legend">
        <h5>SHARTLI BELGILAR:</h5>
        <div><div class="color-box" style="background-color: #f79e66;"></div> 1-hudud</div>
        <div><div class="color-box" style="background-color: #f0d29a;"></div> 2-hudud</div>
        <div><div class="color-box" style="background-color: #91c29b;"></div> 3-hudud</div>
        <div><div class="color-box" style="background-color: #9798f3;"></div> 4-hudud</div>
        <div><div class="color-box" style="background-color: #c498c7;"></div> 5-hudud</div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let map;
        let marker;
        const polygons = [];

        function initMap() {
            const mapOptions = {
                center: { lat: 41.2995, lng: 69.2401 },
                zoom: 10,
            };

            map = new google.maps.Map(document.getElementById('map'), mapOptions);

            const savedLat = parseFloat(document.getElementById('latitude').value);
            const savedLng = parseFloat(document.getElementById('longitude').value);

            if (!isNaN(savedLat) && !isNaN(savedLng)) {
                const savedLocation = { lat: savedLat, lng: savedLng };
                placeMarker(savedLocation);
            }

            const kmlUrl = "{{ asset('assets/zona.kml') }}";

            fetch(kmlUrl)
                .then(response => response.text())
                .then(kmlText => {
                    const parser = new DOMParser();
                    const xmlDoc = parser.parseFromString(kmlText, 'application/xml');
                    const placemarks = xmlDoc.getElementsByTagName('Placemark');

                    const colors = {
                        '1-zona': '#f79e66',
                        '2-zona': '#f0d29a',
                        '3-zona': '#91c29b',
                        '4-zona': '#9798f3',
                        '5-zona': '#c498c7',
                        'Shahar_chegarasi': 'black',
                        'Tuman_chegarasi': 'grey'
                    };

                    Array.from(placemarks).forEach(placemark => {
                        const name = placemark.getElementsByTagName('SimpleData')[3]?.textContent.trim();
                        const coordinatesText = placemark.getElementsByTagName('coordinates')[0]?.textContent.trim();
                        const color = colors[name] || 'grey';

                        if (coordinatesText) {
                            const coordinates = coordinatesText.split(' ').map(coord => {
                                const [lng, lat] = coord.split(',').map(Number);
                                return { lat, lng };
                            });

                            const polygon = new google.maps.Polygon({
                                paths: coordinates,
                                strokeColor: color,
                                strokeOpacity: 0.8,
                                strokeWeight: 2,
                                fillColor: color,
                                fillOpacity: 0.35,
                                map: map
                            });

                            polygons.push({ polygon, name });

                            polygon.addListener('click', function(event) {
                                placeMarker(event.latLng, name);
                            });
                        }
                    });

                    const savedZoneName = document.getElementById('zone_name').value;
                    if (savedZoneName) {
                        highlightSelectedZone(savedZoneName);
                    }
                })
                .catch(error => console.error('Error loading KML:', error));

            map.addListener('click', function(event) {
                placeMarker(event.latLng);

                let selectedZone = null;
                polygons.forEach(({ polygon, name }) => {
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

            const googleMapsUrl = `https://www.google.com/maps?q=${location.lat()},${location.lng()}`;
            document.getElementById('geolokatsiya').value = googleMapsUrl;

            if (zoneName) {
                document.getElementById('zone_name').value = zoneName;
            }
        }

        function highlightSelectedZone(zoneName) {
            polygons.forEach(({ polygon, name }) => {
                if (name === zoneName) {
                    polygon.setOptions({ fillOpacity: 0.6 });
                }
            });
        }

        window.onload = initMap;
    </script>
</body>
</html>
