<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAnUwWTguBMsDU8UrQ7Re-caVeYCmcHQY&libraries=geometry">
</script>
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
<h1>Керакли зонани танланг</h1>
<div id="map"></div>
<div class="legend">
    <h5>SHARTLI BELGILAR:</h5>
    <div>
        <div class="color-box" style="background-color: #f58964;"></div> 1-hudud
    </div>
    <div>
        <div class="color-box" style="background-color: #f0d29a;"></div> 2-hudud
    </div>
    <div>
        <div class="color-box" style="background-color: #91c29b;"></div> 3-hudud
    </div>
    <div>
        <div class="color-box" style="background-color: #9798f3;"></div> 4-hudud
    </div>
    <div>
        <div class="color-box" style="background-color: #c498c7;"></div> 5-hudud
    </div>
    {{-- <div><div class="color-box" style="background-color: black;"></div> Shahar chegarasi</div>
            <div><div class="color-box" style="background-color: grey;"></div> Tuman chegarasi</div> --}}
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

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

        // KML File URL (adjust path as needed)
        const kmlUrl = "{{ asset('assets/zona.kml') }}";

        fetch(kmlUrl)
            .then(response => response.text())
            .then(kmlText => {
                const parser = new DOMParser();
                const xmlDoc = parser.parseFromString(kmlText, 'application/xml');
                const placemarks = xmlDoc.getElementsByTagName('Placemark');

                // Assign colors to specific zones
                const colors = {
                    '1-zona': 'red',
                    '2-zona': 'orange',
                    '3-zona': 'green',
                    '4-zona': 'blue',
                    '5-zona': 'purple',
                    'Shahar_chegarasi': 'black',
                    'Tuman_chegarasi': 'grey'
                };

                // Store the polygons with '1-zona' being the last
                const sortedPolygons = Array.from(placemarks).sort((a, b) => {
                    const nameA = a.getElementsByTagName('SimpleData')[3]?.textContent.trim();
                    const nameB = b.getElementsByTagName('SimpleData')[3]?.textContent.trim();

                    // Ensure '1-zona' is processed last for z-index control
                    if (nameA === '1-zona') return 1;
                    if (nameB === '1-zona') return -1;
                    return 0;
                });

                sortedPolygons.forEach(placemark => {
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
                            zIndex: name === '1-zona' ? 100 : 1 // Higher zIndex for '1-zona'
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

        // Place marker if latitude and longitude values are provided
        const latitude = parseFloat(document.getElementById('latitude').value);
        const longitude = parseFloat(document.getElementById('longitude').value);
        if (!isNaN(latitude) && !isNaN(longitude)) {
            const initialLocation = {
                lat: latitude,
                lng: longitude
            };
            placeMarker(initialLocation);
            map.setCenter(initialLocation);
            map.setZoom(15); // Optional: Adjust zoom level to fit the marker
        }
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

    window.onload = initMap;
</script>
