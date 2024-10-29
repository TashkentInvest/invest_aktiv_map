@extends('layouts.admin')

@section('content')
    <h1>Объект маълумотлари (Детали объекта)</h1>

    <div class="mb-3">
        <strong>Объект номи (Название объекта):</strong> {{ $aktiv->object_name }}
    </div>

    <div class="mb-3">
        <strong>Балансда сақловчи (Балансодержатель):</strong> {{ $aktiv->balance_keeper }}
    </div>

    <div class="mb-3">
        <strong>Мўлжал (Местоположение):</strong> {{ $aktiv->location }}
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

    <!-- Display Files -->
    <div class="mb-3">
        <strong>Юкланган файллар (Загруженные файлы):</strong>
        @if ($aktiv->files->count())
            <ul>
                @foreach ($aktiv->files as $file)
                    <li>
                        <a href="{{ asset('storage/' . $file->path) }}" target="_blank">{{ basename($file->path) }}</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Файллар мавжуд эмас (Нет загруженных файлов).</p>
        @endif
    </div>

    <!-- Map -->
    <div id="map" style="height: 500px; width: 100%;"></div>

    <!-- Back Button -->
    <a href="{{ route('aktivs.index') }}" class="btn btn-secondary mt-3">Рўйхатга қайтиш (Вернуться к списку)</a>
    <a href="{{ route('aktivs.edit', $aktiv->id) }}" class="btn btn-primary mt-3">Объектни таҳрирлаш (Редактировать
        объект)</a>
@endsection

@section('scripts')
    <!-- Include the Google Maps JavaScript API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAnUwWTguBMsDU8UrQ7Re-caVeYCmcHQY&libraries=geometry">
    </script>
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
