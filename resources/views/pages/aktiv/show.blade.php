@extends('layouts.admin')

@section('content')
    <h1 class="mb-4">Объект маълумотлари (Детали объекта)</h1>

    <!-- General Information -->
    <div class="card shadow-sm p-4 mb-4">
        <h5 class="card-title text-primary">Общая информация</h5>
        <div class="card-body">
            <div class="mb-3">
                <strong>Объект номи (Название объекта):</strong> {{ $aktiv->object_name }}
            </div>
            <div class="mb-3">
                <strong>Балансда сақловчи (Балансодержатель):</strong> {{ $aktiv->balance_keeper }}
            </div>
            <div class="mb-3">
                <strong>Мўлжал (Местоположение):</strong> {{ $aktiv->location }}
            </div>
        </div>
    </div>

    <!-- Location Information -->
    <div class="card shadow-sm p-4 mb-4">
        <h5 class="card-title text-primary">Расположение</h5>
        <div class="card-body">
            <div class="mb-3">
                <strong>Вилоят номи (Region Name):</strong>
                {{ $aktiv->subStreet->district->region->name_uz ?? 'Маълумот йўқ' }}
            </div>
            <div class="mb-3">
                <strong>Туман номи (District Name):</strong> {{ $aktiv->subStreet->district->name_uz ?? 'Маълумот йўқ' }}
            </div>
            <div class="mb-3">
                <strong>Мфй номи (Sub Street Name):</strong> {{ $aktiv->subStreet->name ?? 'Маълумот йўқ' }}
            </div>
            <div class="mb-3">
                <strong>Кўча номи (Street Name):</strong> {{ $aktiv->street->name ?? 'Маълумот йўқ' }}
            </div>
        </div>
    </div>

    <!-- Technical Information -->
    <div class="card shadow-sm p-4 mb-4">
        <h5 class="card-title text-primary">Техническая информация</h5>
        <div class="card-body">
            <div class="mb-3">
                <strong>Ер майдони (Площадь земли) (кв.м):</strong> {{ $aktiv->land_area }}
            </div>
            <div class="mb-3">
                <strong>Бино майдони (Площадь здания) (кв.м):</strong> {{ $aktiv->building_area }}
            </div>
            <div class="mb-3">
                <strong>Газ (Газ):</strong> {{ $aktiv->gas }}
            </div>
            <div class="mb-3">
                <strong>Сув (Вода):</strong> {{ $aktiv->water }}
            </div>
            <div class="mb-3">
                <strong>Электр (Электричество):</strong> {{ $aktiv->electricity }}
            </div>
            <div class="mb-3">
                <strong>Қўшимча маълумот (Дополнительная информация):</strong> {{ $aktiv->additional_info }}
            </div>
            <div class="mb-3">
                <strong>Кадастр рақами (Кадастровый номер):</strong> {{ $aktiv->kadastr_raqami }}
            </div>
            <div class="mb-3">
                <strong>Геолокация (Ссылка на геолокацию):</strong>
                <a href="{{ $aktiv->geolokatsiya }}" target="_blank">{{ $aktiv->geolokatsiya }}</a>
            </div>
        </div>
    </div>

    <!-- Display Files -->
    <div class="card shadow-sm p-4 mb-4">
        <h5 class="card-title text-primary">Юкланган файллар (Загруженные файлы)</h5>
        <div class="card-body">
            @if ($aktiv->files->count())
                <div class="row">
                    @foreach ($aktiv->files as $file)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <a href="{{ asset('storage/' . $file->path) }}" class="glightbox"
                                    data-gallery="aktiv-gallery" data-title="{{ $aktiv->object_name }}"
                                    data-description="{{ $aktiv->additional_info }}">
                                    <img src="{{ asset('storage/' . $file->path) }}" class="card-img-top" alt="Image">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">Файллар мавжуд эмас (Нет загруженных файлов).</p>
            @endif
        </div>
    </div>

    <!-- Map Section -->
    <div class="card shadow-sm p-4 mb-4">
        <h5 class="card-title text-primary">Геолокация на карте</h5>
        <div id="map" style="height: 500px; width: 100%;"></div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('aktivs.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Рўйхатга қайтиш (Вернуться к списку)
        </a>
        @if (auth()->user()->roles[0]->name != 'Manager')
            <a href="{{ route('aktivs.edit', $aktiv->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Объектни таҳрирлаш (Редактировать объект)
            </a>
        @endif
    </div>
@endsection

@section('styles')
    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

    <style>
        .card {
            border: none;
            border-radius: 10px;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .mb-3 strong {
            color: #333;
            font-weight: 500;
        }

        .btn-secondary,
        .btn-primary {
            transition: background-color 0.2s ease, transform 0.2s;
        }

        .btn-secondary:hover,
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
    </style>
@endsection

@section('scripts')
    <!-- Include GLightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

    <!-- Initialize GLightbox and Google Maps -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentAktiv = @json($aktiv);
            const aktivs = @json($aktivs);
            const defaultImage = 'https://cdn.dribbble.com/users/1651691/screenshots/5336717/404_v2.png';

            let map;
            let infoWindow;

            function initMap() {
                const aktivLatitude = parseFloat(currentAktiv.latitude);
                const aktivLongitude = parseFloat(currentAktiv.longitude);

                const mapOptions = {
                    center: {
                        lat: aktivLatitude,
                        lng: aktivLongitude
                    },
                    zoom: 15,
                };

                map = new google.maps.Map(document.getElementById('map'), mapOptions);
                infoWindow = new google.maps.InfoWindow();

                const currentAktivPosition = {
                    lat: aktivLatitude,
                    lng: aktivLongitude
                };

                const currentAktivMarker = new google.maps.Marker({
                    position: currentAktivPosition,
                    map: map,
                    title: currentAktiv.object_name,
                    icon: {
                        url: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png',
                        scaledSize: new google.maps.Size(50, 50)
                    }
                });

                currentAktivMarker.addListener('click', function() {
                    openInfoWindow(currentAktiv, currentAktivMarker);
                });

                aktivs.forEach(function(a) {
                    if (a.latitude && a.longitude) {
                        const position = {
                            lat: parseFloat(a.latitude),
                            lng: parseFloat(a.longitude)
                        };

                        const aktivMarker = new google.maps.Marker({
                            position: position,
                            map: map,
                            title: a.object_name,
                            icon: 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png'
                        });

                        aktivMarker.addListener('click', function() {
                            openInfoWindow(a, aktivMarker);
                        });
                    }
                });
            }

            function openInfoWindow(aktiv, marker) {
                const mainImagePath = aktiv.files && aktiv.files.length > 0 ?
                    `/storage/${aktiv.files[0].path}` : defaultImage;

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

    <!-- Include the Google Maps JavaScript API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAnUwWTguBMsDU8UrQ7Re-caVeYCmcHQY&libraries=geometry">
    </script>
@endsection
