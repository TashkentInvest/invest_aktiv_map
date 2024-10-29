@extends('layouts.app')

@section('content')
    <h1>Aktiv Details</h1>

    <div class="mb-3">
        <strong>Object Name:</strong> {{ $aktiv->object_name }}
    </div>

    <!-- Display other fields similarly -->

    <!-- Display Files -->
    <div class="mb-3">
        <strong>Uploaded Files:</strong>
        @if($aktiv->files->count())
            <ul>
                @foreach($aktiv->files as $file)
                    <li>
                        <a href="{{ asset('storage/' . $file->path) }}" target="_blank">{{ basename($file->path) }}</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No files uploaded.</p>
        @endif
    </div>

    <!-- Map -->
    <div id="map" style="height: 500px; width: 100%;"></div>
@endsection

@section('scripts')
    <!-- Include the Google Maps JavaScript API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>

    <script>
        function initMap() {
            const location = {
                lat: parseFloat('{{ $aktiv->latitude }}'),
                lng: parseFloat('{{ $aktiv->longitude }}')
            };

            const map = new google.maps.Map(document.getElementById('map'), {
            center: location,
                zoom: 15
            });

            const marker = new google.maps.Marker({
                position: location,
                map: map
            });
        }

        window.onload = initMap;
    </script>
@endsection
