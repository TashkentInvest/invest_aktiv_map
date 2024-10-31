@extends('layouts.admin')

@section('content')
    <h1 class="mb-4">Объект маълумотлари (Детали объекта)</h1>

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
                <strong>Кўча номи (Sub Street Name):</strong> {{ $aktiv->subStreet->name ?? 'Маълумот йўқ' }}
            </div>
        </div>
    </div>

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
                <strong>Геолокация (Ссылка на геолокацию):</strong> <a href="{{ $aktiv->geolokatsiya }}"
                    target="_blank">{{ $aktiv->geolokatsiya }}</a>
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
            // Initialize GLightbox
            const lightbox = GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: true,
                zoomable: true,
                autoplayVideos: true
            });

            // Initialize Google Maps
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
        });
    </script>

    <!-- Include the Google Maps JavaScript API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAnUwWTguBMsDU8UrQ7Re-caVeYCmcHQY&libraries=geometry">
    </script>
@endsection
