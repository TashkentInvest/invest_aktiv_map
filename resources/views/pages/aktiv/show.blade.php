@extends('layouts.admin')

@section('content')
    <h1 class="mb-4">Объект маълумотлари (Детали объекта)</h1>

    <!-- General Information -->
    <div class="card shadow-sm p-4 mb-4">
        <h5 class="card-title text-primary">Общая информация</h5>
        <div class="card-body">


            <div class="mb-3">
                {{ $aktiv->user->name ?? 'No Name' }}<br>
                <small class="text-muted">{{ $aktiv->user->email ?? 'No Email' }}</small>
            </div>

            <div class="mb-3">
                <strong>Мулк Тури :</strong> {{ $aktiv->building_type ?? 'Мавжуд Эмас' }}
            </div>

            <div class="mb-3">
                <strong>Объект номи (Название объекта):</strong> {{ $aktiv->object_name }}
            </div>

            <div class="mb-3">
                <strong>Балансда сақловчи (Балансодержатель):</strong> {{ $aktiv->balance_keeper }}
            </div>
            <div class="mb-3">
                <strong>Мўлжал (Местоположение):</strong> {{ $aktiv->location }}
            </div>

            <div class="mb-3">
                <strong>Яратилган сана:</strong> {{ $aktiv->created_at }}
            </div>

            <div class="mb-3">
                <strong>Тахрирланган сана:</strong> {{ $aktiv->updated_at }}
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
                <strong>Мфй номи (MFY Name):</strong> {{ $aktiv->street->name ?? 'Маълумот йўқ' }}
            </div>
            <div class="mb-3">
                <strong>Кўча номи (Sub Street Name):</strong> {{ $aktiv->subStreet->name ?? 'Маълумот йўқ' }}
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
                <!-- Swiper Container -->
                <div class="swiper-container" style="overflow: hidden !important">
                    <div class="swiper-wrapper">
                        @foreach ($aktiv->files as $file)
                            <div class="swiper-slide">
                                @if (strtolower(pathinfo($file->path, PATHINFO_EXTENSION)) === 'heic')
                                    <!-- HEIC images will be converted using HEIC2ANY -->
                                    <img data-heic="{{ asset('storage/' . $file->path) }}" class="heic-image"
                                        alt="Image">
                                @else
                                    <!-- Display non-HEIC images directly -->
                                    <a href="{{ asset('storage/' . $file->path) }}" class="glightbox"
                                        data-gallery="aktiv-gallery" data-title="{{ $aktiv->object_name }}"
                                        data-description="{{ $aktiv->additional_info }}">
                                        <img src="{{ asset('storage/' . $file->path) }}" alt="Image">
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <!-- Add Pagination and Navigation -->
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            @else
                <p class="text-muted">Файллар мавжуд эмас (Нет загруженных файлов).</p>
            @endif
        </div>
    </div>

    <div class="card shadow-sm p-4 mb-4">
        <h5 class="card-title text-primary">Юкланган ҳужжатлар (Загруженные документы)</h5>
        <div class="card-body">
            @if ($aktiv->kadastr_pdf)
                <p>
                    <strong>Кадастр файл:</strong>
                    <a href="{{ asset($aktiv->kadastr_pdf) }}" target="_blank">Просмотреть файл</a>
                </p>
            @else
                <p>Кадастр файл мавжуд эмас (Файл отсутствует).</p>
            @endif

            @if ($aktiv->hokim_qarori_pdf)
                <p>
                    <strong>Ҳоким қарори файл:</strong>
                    <a href="{{ asset($aktiv->hokim_qarori_pdf) }}" target="_blank">Просмотреть файл</a>
                </p>
            @else
                <p>Ҳоким қарори файл мавжуд эмас (Файл отсутствует).</p>
            @endif

            @if ($aktiv->transfer_basis_pdf)
                <p>
                    <strong>Трансфер асоси файл:</strong>
                    <a href="{{ asset($aktiv->transfer_basis_pdf) }}" target="_blank">Просмотреть файл</a>
                </p>
            @else
                <p>Трансфер асоси файл мавжуд эмас (Файл отсутствует).</p>
            @endif
        </div>
    </div>


    @if (auth()->user()->roles()->first()->name == 'Super Admin')
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('aktivs.status_invest_moderator') }}" method="POST" class="needs-validation"
                    novalidate>
                    @csrf

                    <input type="hidden" name="id" value="{{ $aktiv->id }}">

                    <div class="mb-3">
                        <label for="status_invest_moderator" class="form-label fw-bold">
                            Invest Moderator Status
                        </label>
                        <select name="status_invest_moderator" id="status_invest_moderator" class="form-select" required>
                            <option value="" disabled selected>Choose Status...</option>
                            @foreach ($aktiv_moderator_statuses as $aktiv_moderator_status)
                                <option value="{{ $aktiv_moderator_status }}"
                                    {{ $aktiv->status_invest_moderator == $aktiv_moderator_status ? 'selected' : '' }}>
                                    {{ ucfirst($aktiv_moderator_status) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Please select a status.
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Saqlash
                    </button>

                </form>
            </div>
        </div>
    @endif

    {{-- Comments Section --}}
    <div class="comments mt-4">
        <h3 class="text-primary">Comments</h3>

        {{-- Display comments --}}
        <div class="comments-container">
            @foreach ($aktiv->comments as $comment)
                <div class="comment-item mb-3 {{ $comment->user_id === auth()->id() ? 'my-comment' : '' }}">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="comment-author">{{ $comment->user->name }}</strong>
                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="comment-content bg-light p-3 rounded mt-2">
                        <p>{{ $comment->content }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Add comment --}}
        @auth
            <form action="{{ route('comments.store', $aktiv->id) }}" method="POST" class="mt-4">
                @csrf
                <div class="form-group">
                    <label for="content">Add Comment</label>
                    <textarea id="content" name="content" class="form-control" rows="3" placeholder="Write your comment..."
                        required></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Post Comment</button>
            </form>
        @endauth
    </div>




    {{-- Add some styling --}}
    <style>
        .comments-container {
            max-height: 400px;
            overflow-y: auto;
        }

        .comment-item {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
        }

        .comment-item.my-comment {
            background-color: #f1f8ff;
        }

        .comment-author {
            font-weight: bold;
            color: #007bff;
        }

        .comment-content {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .comment-content p {
            margin: 0;
        }

        .comment-item .text-muted {
            font-size: 0.85rem;
        }

        .comment-item .comment-author {
            color: #333;
        }
    </style>


    <!-- Map Section -->
    <div class="card shadow-sm p-4 mb-4 mt-4">
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

        @if (auth()->user()->roles[0]->name == 'Manager')
            <form action="{{ route('aktivs.destroy', $aktiv) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Ўчириш" onclick="return confirm('Сиз ростдан ҳам бу объектни ўчиришни истайсизми?');">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </form>
        @endif
    </div>
@endsection

@section('styles')
    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">

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

        /* Swiper Styles */
        .swiper-container {
            width: 100%;
            padding-bottom: 50px;
        }

        .swiper-slide {
            /* Adjust the width to mimic col-3 (25%) or col-6 (50%) */
            width: 25%;
            /* For col-3 */
            /* width: 50%; */
            /* For col-6 */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 10px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .swiper-slide {
                width: 50%;
                /* Show 2 slides per view on smaller screens */
            }

            .card-img-top {
                height: auto !important;
                object-fit: cover;
            }
        }

        @media (max-width: 576px) {
            .swiper-slide {
                width: 100%;
                /* Show 1 slide per view on extra small screens */
            }
        }
    </style>
@endsection

@section('scripts')
    <!-- GLightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <!-- HEIC2ANY JS for HEIC image conversion -->
    <script src="https://cdn.jsdelivr.net/npm/heic2any/dist/heic2any.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Swiper
            const swiper = new Swiper('.swiper-container', {
                loop: false,
                slidesPerView: 4, // For col-3 equivalent (4 slides per view)
                spaceBetween: 15,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                // Responsive breakpoints
                breakpoints: {
                    768: {
                        slidesPerView: 2, // For tablet devices
                    },
                    576: {
                        slidesPerView: 1, // For mobile devices
                    },
                },
            });

            // Convert and display HEIC images
            document.querySelectorAll('.heic-image').forEach(async (img) => {
                const heicUrl = img.getAttribute('data-heic');
                try {
                    const response = await fetch(heicUrl);
                    const blob = await response.blob();
                    const convertedImage = await heic2any({
                        blob,
                        toType: 'image/jpeg',
                    });
                    img.src = URL.createObjectURL(convertedImage);
                } catch (error) {
                    console.error('Error converting HEIC image:', error);
                }
            });

            // Initialize GLightbox
            const lightbox = GLightbox({
                selector: '.glightbox',
                loop: true,
            });

            // Map Initialization
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
                    if (a.latitude && a.longitude && a.id !== currentAktiv.id) {
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

            // Initialize the map
            initMap();
        });
    </script>

    <!-- Include the Google Maps JavaScript API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAnUwWTguBMsDU8UrQ7Re-caVeYCmcHQY&libraries=geometry">
    </script>
@endsection
