@extends('layouts.admin')

@section('content')
    <h1>Янги Актив Яратиш</h1>

    <!-- Camera Modal -->
    <div class="modal fade" id="cameraModal" tabindex="-1" aria-labelledby="cameraModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Расм олиш</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Ёпиш"></button>
                </div>
                <div class="modal-body">
                    <video id="cameraPreview" width="100%" autoplay></video>
                    <canvas id="snapshotCanvas" style="display:none;"></canvas>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="captureButton">Расм олиш</button>
                    <button type="button" class="btn btn-primary" id="saveButton" data-bs-dismiss="modal"
                        disabled>Сақлаш</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Form -->
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
                <!-- File Upload Fields -->
                <div class="mb-3">
                    <label class="text-danger">Файлларни юклаш (Камида 4 та расм мажбурий)</label>
                </div>

                <div id="fileInputsContainer">
                    @for ($i = 1; $i <= 4; $i++)
                        <div class="mb-3" id="fileInput{{ $i }}">
                            <label for="file{{ $i }}">Файл {{ $i }}</label>
                            <div class="input-group">
                                <input type="file" class="form-control" name="files[]" id="file{{ $i }}"
                                    accept="image/*" required>
                                <button type="button" class="btn btn-secondary"
                                    onclick="openCameraModal('file{{ $i }}')">📷</button>
                            </div>
                        </div>
                    @endfor
                </div>

                <!-- Error Message Display -->
                <div id="file-error" class="text-danger mb-3"></div>

                <!-- Container for Additional File Inputs -->
                <div id="file-upload-container"></div>

                <!-- Add New File Button -->
                <button type="button" class="btn btn-secondary mb-3" id="add-file-btn">Янги файл қўшиш</button>

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
    <!-- Include Google Maps Script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAnUwWTguBMsDU8UrQ7Re-caVeYCmcHQY&libraries=geometry">
    </script>    <!-- Include Bootstrap JS for Modal -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript Code -->
    <script>
        // Global Variables
        let fileInputCount = 4; // Initial number of file inputs
        let activeFileInput;
        let videoStream;

        // Open Camera Modal Function
        function openCameraModal(fileInputId) {
            activeFileInput = document.getElementById(fileInputId);
            const cameraModal = new bootstrap.Modal(document.getElementById('cameraModal'), {});
            cameraModal.show();

            // Access the user's camera
            navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'environment'
                    }
                })
                .then(stream => {
                    videoStream = stream;
                    document.getElementById('cameraPreview').srcObject = stream;
                })
                .catch(error => {
                    console.error("Camera access error:", error);
                    alert('Камерага кириш мумкин эмас: ' + error.message);
                });
        }

        // Capture Button Event
        document.getElementById('captureButton').addEventListener('click', () => {
            const video = document.getElementById('cameraPreview');
            const canvas = document.getElementById('snapshotCanvas');
            const context = canvas.getContext('2d');

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Stop the video stream after capturing
            videoStream.getTracks().forEach(track => track.stop());

            document.getElementById('saveButton').disabled = false; // Enable save button
        });

        // Save Button Event
        document.getElementById('saveButton').addEventListener('click', () => {
            const canvas = document.getElementById('snapshotCanvas');
            canvas.toBlob(blob => {
                const file = new File([blob], 'snapshot.jpg', {
                    type: 'image/jpeg'
                });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                activeFileInput.files = dataTransfer.files;
            });

            // Clear the video preview
            document.getElementById('cameraPreview').srcObject = null;
            document.getElementById('saveButton').disabled = true; // Disable save button
        });

        // Function to Add New File Input
        document.getElementById('add-file-btn').addEventListener('click', () => {
            fileInputCount++;
            const container = document.getElementById('file-upload-container');
            const newDiv = document.createElement('div');
            newDiv.classList.add('mb-3');
            const label = document.createElement('label');
            label.textContent = `Қўшимча файл ${fileInputCount}`;
            const inputGroup = document.createElement('div');
            inputGroup.classList.add('input-group');
            const input = document.createElement('input');
            input.type = 'file';
            input.name = 'files[]';
            input.classList.add('form-control');
            input.accept = 'image/*';
            input.id = 'file' + fileInputCount;
            input.required = true;
            input.addEventListener('change', validateFiles);
            const button = document.createElement('button');
            button.type = 'button';
            button.classList.add('btn', 'btn-secondary');
            button.textContent = '📷';
            button.addEventListener('click', function() {
                openCameraModal(input.id);
            });
            inputGroup.appendChild(input);
            inputGroup.appendChild(button);
            newDiv.appendChild(label);
            newDiv.appendChild(inputGroup);
            container.appendChild(newDiv);
            validateFiles();
        });

        // Function to Validate Files
        function validateFiles() {
            const submitBtn = document.getElementById('submit-btn');
            const errorDiv = document.getElementById('file-error');
            const fileInputs = document.querySelectorAll('input[type="file"][name="files[]"]');

            let totalFiles = 0;
            fileInputs.forEach(input => {
                if (input.files.length > 0) {
                    totalFiles += input.files.length;
                }
            });

            if (totalFiles < 4) {
                let filesNeeded = 4 - totalFiles;
                errorDiv.textContent = filesNeeded === 4 ?
                    'Сиз ҳеч қандай файл юкламадингиз.' :
                    `Сиз яна ${filesNeeded} та файл юклашингиз керак.`;
                submitBtn.disabled = true;
            } else {
                errorDiv.textContent = '';
                submitBtn.disabled = false;
            }
        }

        // Initial Validation
        validateFiles();

        // Event Listeners for Initial File Inputs
        for (let i = 1; i <= fileInputCount; i++) {
            document.getElementById('file' + i).addEventListener('change', validateFiles);
        }

        // Form Submission Event
        document.getElementById('aktiv-form').addEventListener('submit', function(event) {
            validateFiles();
            if (document.getElementById('submit-btn').disabled) {
                event.preventDefault();
            } else {
                document.getElementById('submit-btn').disabled = true;
                document.getElementById('submit-btn').innerText = 'Юкланмоқда...';
            }
        });

        // Initialize Google Map
        function initMap() {
            const mapOptions = {
                center: {
                    lat: 41.2995,
                    lng: 69.2401
                }, // Default center (Tashkent, Uzbekistan)
                zoom: 10,
            };

            const map = new google.maps.Map(document.getElementById('map'), mapOptions);
            let marker;
            const infoWindow = new google.maps.InfoWindow();

            // Event Listener for "Find My Location" Button
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

            // Map Click Event to Place Marker
            map.addListener('click', function(event) {
                placeMarker(event.latLng);
            });

            // Function to Place Marker on Map
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
        }

        // Initialize Map on DOM Content Loaded
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
        });
    </script>
@endsection
