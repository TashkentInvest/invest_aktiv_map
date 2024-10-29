@extends('layouts.app')

@section('content')
    <h1>Edit Aktiv</h1>

    <form method="POST" action="{{ route('aktivs.update', $aktiv) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Pre-fill the form fields with existing data -->
        <div class="mb-3">
            <label for="object_name" class="form-label">Object Name</label>
            <input type="text" class="form-control" name="object_name" id="object_name" value="{{ old('object_name', $aktiv->object_name) }}">
            @error('object_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Repeat similar blocks for other fields -->

        <!-- File Upload -->
        <div class="mb-3">
            <label for="files" class="form-label">Upload Additional Files</label>
            <input type="file" class="form-control" name="files[]" id="files" multiple>
            @error('files.*')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Existing Files -->
        <div class="mb-3">
            <label class="form-label">Existing Files:</label>
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

        <!-- Map Section -->
        <div class="mb-3">
            <button id="find-my-location" type="button" class="btn btn-primary mb-3">Find My Location</button>
            <div id="map" style="height: 500px; width: 100%;"></div>
        </div>

        <!-- Hidden Fields for Coordinates -->
        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $aktiv->latitude) }}">
        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $aktiv->longitude) }}">

        <!-- Zone Name -->
        <div class="mb-3">
            <label for="zone_name" class="form-label">Zone Name</label>
            <input type="text" class="form-control" name="zone_name" id="zone_name" value="{{ old('zone_name', $aktiv->zone_name) }}">
            @error('zone_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success">Update</button>
    </form>
@endsection

@section('scripts')
    <!-- Include the Google Maps JavaScript API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=geometry"></script>

    <script>
        // Similar JavaScript code as in create view, but initialize map with existing coordinates
        let map;
        let marker;
        const polygons = [];

        function initMap() {
            const initialLocation = {
                lat: parseFloat('{{ old('latitude', $aktiv->latitude) }}') || 41.2995,
                lng: parseFloat('{{ old('longitude', $aktiv->longitude) }}') || 69.2401
            };

            map = new google.maps.Map(document.getElementById('map'), {
                center: initialLocation,
                zoom: 10
            });

            if (!isNaN(initialLocation.lat) && !isNaN(initialLocation.lng)) {
                placeMarker(initialLocation, '{{ old('zone_name', $aktiv->zone_name) }}');
                map.setCenter(initialLocation);
                map.setZoom(15);
            }

            // Load KML and polygons as before
            // Add event listeners as before
        }

        // Rest of the JavaScript code as in create view

        window.onload = initMap;
    </script>
@endsection
