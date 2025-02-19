<!DOCTYPE html>
<html lang="en">

<head>
    <title>Toshkent Invest Projects</title>

    <!-- Meta Tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Toshkent Invest Projects" />
    <meta name="keywords" content="Invest, Toshkent, Tashkent Invest, Investitsiya, Aksiyadorlik jamiyati" />
    <meta name="author" content="Tashkent Invest" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.toshkentinvest.uz" />
    <meta property="og:title" content="Toshkent Invest Projects" />
    <meta property="og:description" content="Toshkent Invest" />
    <meta property="og:image" content="{{ asset('assets/projects-map/images/og-image.png') }}" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Toshkent Invest Projects" />
    <meta name="twitter:description" content="Toshkent Invest" />
    <meta name="twitter:image" content="{{ asset('assets/projects-map/images/twitter-image.png') }}" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/projects-map/images/logo.png') }}" type="image/x-icon" />

    <!-- Include SimpleBar CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.css">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/projects-map/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/projects-map/fonts/material.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/projects-map/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('assets/projects-map/css/custom.style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/projects-map/css/icon.css') }}" />

    <script src="https://cdn.jsdelivr.net/npm/whatwg-fetch@3.6.2/dist/fetch.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@babel/standalone@7.19.3/babel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>



    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />


    <!-- Custom Styles -->
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            position: relative;
            max-width: 400px;
            text-align: center;
        }

        .modal .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            right: 20px;
            top: 15px;
            cursor: pointer;
        }

        .modal .close:hover,
        .modal .close:focus {
            color: #000;
        }

        .modal .modal-text {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .modal .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .modal .social-icons a {
            color: inherit;
            text-decoration: none;
        }

        .modal .social-icons i {
            font-size: 30px;
            transition: color 0.3s;
        }

        .modal .social-icons i:hover {
            color: #007bff;
        }

        .telegram {
            color: #0088cc;
        }

        .facebook {
            color: #3b5998;
        }

        .instagram {
            color: #e4405f;
        }

        /* Sidebar Styles */
        #info-sidebar {
            position: fixed;
            top: 0;
            right: -400px;
            width: 400px;
            height: 100%;
            background-color: #fff;
            overflow-y: auto;
            transition: right 0.3s ease;
            z-index: 1000;
            padding: 20px;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.3);
        }

        #info-sidebar.open {
            right: 0;
        }

        #info-sidebar .close-btn {
            position: absolute;
            top: 15px;
            left: 15px;
            font-size: 24px;
            cursor: pointer;
        }

        #info-sidebar .info-content img.custom_sidebar_image {
            margin-top: 15px;
            width: 300px;
            /* height: auto; */
            margin-bottom: 15px;
        }

        #info-sidebar .custom_sidebar_title {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: #007bff;
        }

        #info-sidebar table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        #info-sidebar table th,
        #info-sidebar table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        #info-sidebar .btn-link {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        #info-sidebar .btn-link:hover {
            background-color: #0056b3;
        }

        #toggle-currency-btn {
            margin-bottom: 15px;
            background-color: #007bff;
            color: #fff;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #toggle-currency-btn:hover {
            background-color: #0056b3;
        }

        /* QR Code Styles */
        #qr-code-container {
            text-align: center;
            margin-top: 20px;
        }

        #qr-code-container img {
            width: 200px;
            height: 200px;
            margin-bottom: 10px;
        }

        #qr-code-container a {
            display: inline-block;
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        #qr-code-container a:hover {
            background-color: #0056b3;
        }

        /* Responsive Adjustments */
        @media (max-width: 767px) {
            #info-sidebar {
                width: 100%;
            }
        }

        /* Map Styles */
        #map {
            width: 100%;
            /* height: calc(100vh - 70px); */
        }
    </style>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr"
    data-pc-theme="light">

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p class="modal-text">Пожалуйста, следите за нами в социальных сетях для получения дополнительной информации
            </p>
            <div class="social-icons">
                <a href="https://t.me/toshkentinvestuz" target="_blank" title="Telegram">
                    <i class="fab fa-telegram telegram"></i>
                </a>
                <a href="https://www.facebook.com/profile.php?id=61567396581686" target="_blank" title="Facebook">
                    <i class="fab fa-facebook facebook"></i>
                </a>
                <a href="https://www.instagram.com/toshkentinvest" target="_blank" title="Instagram">
                    <i class="fab fa-instagram instagram"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Page Loader -->
    <div class="page-loader">
        <div class="bar"></div>
    </div>

    <!-- Sidebar -->
    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="{{ route('aktivs.index') }}" class="b-brand text-primary">
                    <img src="{{ asset('assets/projects-map/images/logo.png') }}" class="img-fluid logo-lg custom_logo"
                        alt="logo" />
                </a>
            </div>
            <div class="navbar-content px-3">
                <ul class="pc-navbar">
                    <li class="pc-item pc-caption"><label>Xarita</label>
                        <a class="pc-link" href="{{ route('aktivs.index') }}">Xarita</a>
                    </li>
                </ul>
                <!-- District Information -->
                <div id="district-info">
                    <div id="district-name">Toshkent</div>
                    <table id="info-table" class="table">
                        <thead>
                            <tr>
                                <th colspan="2">Ma'lumotlar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Maydoni</td>
                                <td id="maydoni">43.5 km²</td>
                            </tr>
                            <tr>
                                <td>Aholi soni</td>
                                <td id="aholiSoni">3 mln</td>
                            </tr>
                            <tr>
                                <td>Tumanlar soni</td>
                                <td id="TumanlarSoni">12</td>
                            </tr>
                            <tr>
                                <td>Mahalla soni</td>
                                <td id="MahallaSoni">585</td>
                            </tr>
                            <tr>
                                <td>Savdodagi obyektlar</td>
                                <td id="savdodaTurganJamiSoni">---</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <ul class="pc-navbar">
                    <li class="pc-item pc-caption"><label>Marker Types</label></li>
                    <li class="pc-item">
                        <div class="legend-item" style="display: flex; align-items: center; gap: 8px;">
                            <!-- Marker Icon -->
                            <span
                                class="legend-icon"
                                style="
                                    display: inline-block;
                                    width: 12px;
                                    height: 12px;
                                    background-color: #FF0000;
                                    border-radius: 50%;
                                    box-shadow: 0 0 3px rgba(0,0,0,0.3);
                                "
                                title="Yer"
                            ></span>
                            <!-- Marker Text -->
                            <span class="legend-text" style="font-size: 14px; color: #333;">Yer (Red Marker)</span>
                        </div>
                    </li>
                    <li class="pc-item">
                        <div class="legend-item" style="display: flex; align-items: center; gap: 8px;">
                            <span
                                class="legend-icon"
                                style="
                                    display: inline-block;
                                    width: 12px;
                                    height: 12px;
                                    background-color: #FFFF00;
                                    border-radius: 50%;
                                    box-shadow: 0 0 3px rgba(0,0,0,0.3);
                                "
                                title="TurarBino"
                            ></span>
                            <span class="legend-text" style="font-size: 14px; color: #333;">TurarBino (Yellow Marker)</span>
                        </div>
                    </li>
                    <li class="pc-item">
                        <div class="legend-item" style="display: flex; align-items: center; gap: 8px;">
                            <span
                                class="legend-icon"
                                style="
                                    display: inline-block;
                                    width: 12px;
                                    height: 12px;
                                    background-color: #1a81bd;
                                    border-radius: 50%;
                                    box-shadow: 0 0 3px rgba(0,0,0,0.3);
                                "
                                title="NoturarBino"
                            ></span>
                            <span class="legend-text" style="font-size: 14px; color: #333;">NoturarBino (Green Marker)</span>
                        </div>
                    </li>
                </ul>

            </div>
        </div>
    </nav>


    <!-- Header -->
    <header class="pc-header">
        <div class="header-wrapper">
            <div class="me-auto pc-mob-drp">
                <ul class="list-unstyled">
                    <li class="pc-h-item pc-sidebar-collapse">
                        <a href="#" class="pc-head-link ms-0" id="sidebar-hide"><i
                                class="ti ti-menu-2"></i></a>
                    </li>
                    <li class="pc-h-item pc-sidebar-popup" id="hide_in_mobile">
                        <a href="#" class="pc-head-link ms-0" id="mobile-collapse"><i
                                class="ti ti-menu-2"></i></a>
                    </li>
                    <li class="pc-h-item">
                        <select id="xml-selector" class="form-select form-control">
                            <option id="testTashkent" value="tashkent">Toshkent shahri</option>
                            <option value="bektemir.xml">Bektemir</option>
                            <option value="chilonzor.xml">Chilonzor</option>
                            <option value="mirabod.xml">Mirobod</option>
                            <option value="mirzo_ulugbek.xml">Mirzo Ulug‘bek</option>
                            <option value="olmazor.xml">Olmazor</option>
                            <option value="sergeli.xml">Sergeli</option>
                            <option value="shayhontaxur.xml">Shayxontohur</option>
                            <option value="uchtepa.xml">Uchtepa</option>
                            <option value="yakkasaroy.xml">Yakkasaroy</option>
                            <option value="yashnabod.xml">Yashnobod</option>
                            <option value="yunusabod.xml">Yunusobod</option>
                            <option value="yangihayot.xml">Yangihayot</option>
                        </select>
                    </li>
                </ul>


            </div>
        </div>
    </header>

    <!-- Map Container -->
    <div id="map"></div>

    <!-- Info Sidebar -->
    <div id="info-sidebar" data-currency="UZS">
        <span class="close-btn">&times;</span>
        <!-- Content will be injected here -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js"></script>
    <script src="{{ asset('assets/projects-map/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/projects-map/js/plugins/feather.min.js') }}"></script>


    <!-- Your existing scripts -->
    <script src="{{ asset('assets/projects-map/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/projects-map/js/plugins/feather.min.js') }}"></script>

    <!-- Initialize Modal -->
    <script type="text/babel">
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById("myModal");
            const closeButton = document.querySelector(".modal .close");
            const modalShown = localStorage.getItem('modalShown');

            if (!modalShown) {
                modal.style.display = "flex";
                localStorage.setItem('modalShown', 'true');
            }

            closeButton.onclick = function () {
                modal.style.display = "none";
            };

            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            };
        });
    </script>

    <!-- Main JavaScript -->
    <script>
        const baseUrl = "{{ url('') }}";
        let usdRate = null; // Declare usdRate at the global scope

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Google Maps
            const script = document.createElement('script');
            script.src =
                `https://maps.googleapis.com/maps/api/js?key=AIzaSyAAnUwWTguBMsDU8UrQ7Re-caVeYCmcHQY&libraries&callback=initMap`;
            script.async = true;
            script.defer = true;
            document.head.appendChild(script);
        });



        function initMap() {
            const urlParams = new URLSearchParams(window.location.search);
            const urlLat = parseFloat(urlParams.get('lat'));
            const urlLng = parseFloat(urlParams.get('lng'));

            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: urlLat && urlLng ? 15 : 12,
                center: {
                    lat: urlLat || 41.311,
                    lng: urlLng || 69.279
                },
                mapTypeId: google.maps.MapTypeId.HYBRID
            });

            // Fetch USD exchange rate and then fetch markers
            fetchUsdRate()
                .then(rate => {
                    usdRate = rate;
                    fetchMarkers(map, usdRate, urlLat, urlLng);
                    setupEventListeners(); // Move event listener setup here
                })
                .catch(error => {
                    console.error('Error fetching USD rate:', error);
                    // Proceed without usdRate
                    fetchMarkers(map, usdRate, urlLat, urlLng);
                    setupEventListeners(); // Ensure event listeners are set
                });

            // Handle district selection and KML processing
            handleDistrict(map);
        }

        async function fetchUsdRate() {
            try {
                const response = await fetch('https://cbu.uz/uz/arkhiv-kursov-valyut/json/');
                const rates = await response.json();
                const usdRateObj = rates.find(rate => rate.Ccy === 'USD');
                if (usdRateObj && usdRateObj.Rate) {
                    return parseFloat(usdRateObj.Rate);
                } else {
                    throw new Error('USD rate not found in API response');
                }
            } catch (error) {
                console.error('Error fetching USD rate:', error);
                return null; // Return null if fetching failed
            }
        }

        function fetchMarkers(map, usdRate, urlLat, urlLng) {
            fetch('/api/aktivs')
                .then(response => response.json())
                .then(data => {
                    const markersData = data.lots;
                    window.markers = markersData; // Make markers globally accessible

                    let targetMarkerData = null;

                    markersData.forEach(markerData => {
                        const lat = parseFloat(markerData.lat);
                        const lng = parseFloat(markerData.lng);

                        if (!isNaN(lat) && !isNaN(lng)) {
                            const position = {
                                lat,
                                lng
                            };
                            const title = markerData.property_name || 'No Title';


                            // Determine icon color based on building_type
                            let iconUrl;
                            console.log(markerData.building_type);
                            if (markerData.building_type == 'yer') {
                                // Red icon
                                iconUrl = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
                            } else if (markerData.building_type == 'TurarBino') {
                                // Yellow icon
                                iconUrl = 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png';
                            } else if (markerData.building_type == 'NoturarBino') {
                                iconUrl = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';

                            } else {
                                iconUrl = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';

                            }


                            const marker = new google.maps.Marker({
                                position: position,
                                map: map,
                                title: title,
                                icon: iconUrl
                            });

                            // const marker = new google.maps.Marker({
                            //     position: position,
                            //     map: map,
                            //     title: title
                            // });

                            marker.addListener('click', function() {
                                const sidebar = document.getElementById('info-sidebar');
                                const isInUSD = sidebar.getAttribute('data-currency') === 'USD';
                                updateSidebarContent(markerData, isInUSD, usdRate);
                                sidebar.classList.add('open');
                            });

                            // Check if URL parameters match this marker
                            if (urlLat && urlLng && lat === urlLat && lng === urlLng) {
                                targetMarkerData = markerData;
                                map.setCenter({
                                    lat,
                                    lng
                                });
                                map.setZoom(15);
                            }
                        }
                    });

                    // Open sidebar if URL parameters match a marker
                    if (targetMarkerData) {
                        const sidebar = document.getElementById('info-sidebar');
                        const isInUSD = sidebar.getAttribute('data-currency') === 'USD';
                        updateSidebarContent(targetMarkerData, isInUSD, usdRate);
                        sidebar.classList.add('open');
                    }
                })
                .catch(error => console.error('Error fetching markers:', error));
        }

        function updateSidebarContent(markerData, isInUSD, usdRate) {
            const sidebar = document.getElementById('info-sidebar');
            const area = parseFloat(markerData.land_area) || 0;
            const priceUZS = parseFloat(markerData.start_price) || 0;

            // Calculate lot price per sotix
            const lotPricePerSotixUZS = area > 0 ? priceUZS / (area * 100) : 0;

            // Convert price and per-sotix based on currency
            let lotPriceFormatted = 'N/A';
            let lotPricePerSotixFormatted = 'N/A';

            try {
                if (isInUSD && usdRate && priceUZS > 0) {
                    const priceUSD = priceUZS / usdRate;
                    const pricePerSotixUSD = lotPricePerSotixUZS / usdRate;

                    lotPriceFormatted = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'USD'
                    }).format(priceUSD);

                    lotPricePerSotixFormatted = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'USD'
                    }).format(pricePerSotixUSD);
                } else if (priceUZS > 0) {
                    lotPriceFormatted = new Intl.NumberFormat('uz-UZ', {
                        style: 'currency',
                        currency: 'UZS',
                        minimumFractionDigits: 0
                    }).format(priceUZS);

                    lotPricePerSotixFormatted = new Intl.NumberFormat('uz-UZ', {
                        style: 'currency',
                        currency: 'UZS',
                        minimumFractionDigits: 0
                    }).format(lotPricePerSotixUZS);
                }
            } catch (error) {
                console.error('Error formatting currency:', error);
            }

            // Generate QR Code URL
            const qrCodeUrl = `${baseUrl}/api/lot/qr-code/${markerData.lat}/${markerData.lng}`;

            sidebar.innerHTML = `
        <span class="close-btn">&times;</span>
        <div class="info-content">
            <img class="custom_sidebar_image" src="${markerData.main_image}" alt="Marker Image"/>
            <button id="toggle-currency-btn">${isInUSD ? 'Valyutani tahrirlash UZS' : 'Valyutani tahrirlash USD'}</button>
            <h4 class="custom_sidebar_title"><b>${markerData.property_name || 'No Title'}</b></h4>
            <table>
                <tr>
                    <th class="sidebar_key">Lot raqami</th>
                    <td>${markerData.lot_number || 'N/A'}</td>
                </tr>
                <tr>
                    <th class="sidebar_key">Manzili</th>
                    <td>${markerData.address || 'N/A'}</td>
                </tr>
                <tr>
                    <th class="sidebar_key">Yer maydoni (kv)</th>
                    <td>${markerData.land_area || 'N/A'}</td>
                </tr>
                ${priceUZS > 0 ? `
                            <tr>
                                <th class="sidebar_key">Boshlang'ich narxi</th>
                                <td id="price-td">${lotPriceFormatted}</td>
                            </tr>
                            <tr>
                                <th class="sidebar_key">1 sotix uchun narx</th>
                                <td>${lotPricePerSotixFormatted}</td>
                            </tr>` : ''}
                <tr>
                    <th class="sidebar_key">Yaratilgan foydalanuvchi</th>
                    <td>${markerData.user_name || 'N/A'}</td>
                </tr>
                <tr>
                    <th class="sidebar_key">Email</th>
                    <td>${markerData.user_email || 'N/A'}</td>
                </tr>
            </table>

            <a target="_blank" href="${markerData.lot_link || '#'}" class="btn-link">Aktivni ko'rish</a>
        </div>
    `;
        }



        function setupEventListeners() {
            document.addEventListener('click', function(event) {
                if (event.target.matches('.close-btn')) {
                    const sidebar = document.getElementById('info-sidebar');
                    sidebar.classList.remove('open');
                } else if (event.target.matches('#toggle-currency-btn')) {
                    const sidebar = document.getElementById('info-sidebar');
                    const isInUSD = sidebar.getAttribute('data-currency') === 'USD';
                    sidebar.setAttribute('data-currency', isInUSD ? 'UZS' : 'USD');
                    event.target.textContent = isInUSD ? 'Valyutani tahrirlash USD' : 'Valyutani tahrirlash UZS';

                    const currentTitle = sidebar.querySelector('.custom_sidebar_title b').textContent;
                    const markerData = window.markers.find(marker => marker.property_name === currentTitle);

                    if (markerData) {
                        if (usdRate !== null || !isInUSD) {
                            updateSidebarContent(markerData, !isInUSD, usdRate);
                        } else {
                            alert('USD rate is not available at the moment. Please try again later.');
                        }
                    }
                }
            });
        }


        // Handle District Selection and KML Files
        function handleDistrict(map) {
            let polygons = {};
            let currentHighlight = null;

            const defaultColor = '#c7a5a594';
            const highlightColor = '#EEF5FF';

            const kmlFileNames = [
                'bektemir.xml', 'chilonzor.xml', 'mirabod.xml', 'mirzo_ulugbek.xml', 'olmazor.xml',
                'sergeli.xml', 'shayhontaxur.xml', 'uchtepa.xml', 'yakkasaroy.xml', 'yashnabod.xml',
                'yunusabod.xml', 'yangihayot.xml'
            ];

            kmlFileNames.forEach(fileName => {
                processKML(fileName, defaultColor, map, polygons);
            });

            document.getElementById('xml-selector').addEventListener('change', function(event) {
                const selectedFile = event.target.value;
                if (selectedFile) {
                    if (currentHighlight && currentHighlight !== 'tashkent') {
                        setPolygonColor(currentHighlight, defaultColor, polygons);
                    }

                    if (selectedFile === 'tashkent') {
                        map.setCenter({
                            lat: 41.311,
                            lng: 69.279
                        });
                        map.setZoom(12);
                        fetchDistrictInfo('tashkent');
                        currentHighlight = 'tashkent';
                    } else {
                        processKML(selectedFile, highlightColor, map, polygons);
                        currentHighlight = selectedFile;
                        fetchDistrictInfo(selectedFile);
                    }
                }
            });

            function processKML(fileName, color, map, polygons) {
                fetch(`{{ asset('xml-map') }}/${fileName}`)
                    .then(response => response.text())
                    .then(kmlText => {
                        const paths = parseKML(kmlText);
                        addPolygon(fileName, [paths], color, map, polygons);
                        const bounds = new google.maps.LatLngBounds();
                        paths.forEach(coord => bounds.extend(new google.maps.LatLng(coord.lat, coord.lng)));
                        map.fitBounds(bounds);
                    })
                    .catch(error => console.error(`Error fetching ${fileName}:`, error));
            }

            function addPolygon(fileName, paths, fillColor, map, polygons) {
                if (polygons[fileName]) {
                    polygons[fileName].forEach(polygon => polygon.setMap(null));
                }

                const polygonArray = paths.map(path => {
                    const polygon = new google.maps.Polygon({
                        paths: path,
                        strokeColor: '#fff',
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: fillColor,
                        fillOpacity: 0.35,
                        map: map
                    });
                    return polygon;
                });

                polygons[fileName] = polygonArray;
            }

            function setPolygonColor(fileName, color, polygons) {
                if (polygons[fileName]) {
                    polygons[fileName].forEach(polygon => polygon.setOptions({
                        fillColor: color
                    }));
                }
            }

            function parseKML(kmlText) {
                const parser = new DOMParser();
                const xmlDoc = parser.parseFromString(kmlText, "application/xml");
                const coordinates = xmlDoc.getElementsByTagName('coordinates')[0]?.textContent.trim();
                return coordinates ? coordinates.split(' ').map(coord => {
                    const [lng, lat] = coord.split(',').map(Number);
                    return {
                        lat,
                        lng
                    };
                }) : [];
            }

            function fetchDistrictInfo(districtFile) {
                const districtInfo = {
                    'bektemir.xml': {
                        name: 'Bektemir',
                        maydoni: '32.0 (km²)',
                        aholiSoni: '60,5 ming',
                        TumanlarSoni: '20',
                        MahallaSoni: '18',
                        savdodaTurganJamiSoni: 'N/A'
                    },
                    'chilonzor.xml': {
                        name: 'Chilonzor',
                        maydoni: '30,0 (km²)',
                        aholiSoni: '275,1 ming',
                        TumanlarSoni: '45',
                        MahallaSoni: '45',
                        savdodaTurganJamiSoni: 'N/A'
                    },
                    'mirabod.xml': {
                        name: 'Mirobod',
                        maydoni: '17,0 (km²)',
                        aholiSoni: '152,2 ming',
                        TumanlarSoni: '30',
                        MahallaSoni: '39',
                        savdodaTurganJamiSoni: 'N/A'
                    },
                    'mirzo_ulugbek.xml': {
                        name: 'Mirzo Ulug‘bek',
                        maydoni: '59,06 (km²)',
                        aholiSoni: '331,2 ming',
                        TumanlarSoni: '35',
                        MahallaSoni: '70',
                        savdodaTurganJamiSoni: 'N/A'
                    },
                    'olmazor.xml': {
                        name: 'Olmazor',
                        maydoni: '34,0 (km²)',
                        aholiSoni: '404,4 ming',
                        TumanlarSoni: '50',
                        MahallaSoni: '64',
                        savdodaTurganJamiSoni: 'N/A'
                    },
                    'sergeli.xml': {
                        name: 'Sergeli',
                        maydoni: '54,75 (km²)',
                        aholiSoni: '168,2 ming',
                        TumanlarSoni: '55',
                        MahallaSoni: '46',
                        savdodaTurganJamiSoni: 'N/A'
                    },
                    'shayhontaxur.xml': {
                        name: 'Shayxontohur',
                        maydoni: '27,0 (km²)',
                        aholiSoni: '365,4 ming',
                        TumanlarSoni: '15',
                        MahallaSoni: '51',
                        savdodaTurganJamiSoni: 'N/A'
                    },
                    'uchtepa.xml': {
                        name: 'Uchtepa',
                        maydoni: '28,0 (km²)',
                        aholiSoni: '299,4 ming',
                        TumanlarSoni: '60',
                        MahallaSoni: '60',
                        savdodaTurganJamiSoni: 'N/A'
                    },
                    'yakkasaroy.xml': {
                        name: 'Yakkasaroy',
                        maydoni: '14,0 (km²)',
                        aholiSoni: '133,4 ming',
                        TumanlarSoni: '40',
                        MahallaSoni: '21',
                        savdodaTurganJamiSoni: 'N/A'
                    },
                    'yashnabod.xml': {
                        name: 'Yashnobod',
                        maydoni: '67,42 (km²)',
                        aholiSoni: '300,1 ming',
                        TumanlarSoni: '25',
                        MahallaSoni: '67',
                        savdodaTurganJamiSoni: 'N/A'
                    },
                    'yunusabod.xml': {
                        name: 'Yunusobod',
                        maydoni: '41,0 (km²)',
                        aholiSoni: '376,1 ming',
                        TumanlarSoni: '30',
                        MahallaSoni: '64',
                        savdodaTurganJamiSoni: 'N/A'
                    },
                    'yangihayot.xml': {
                        name: 'Yangihayot',
                        maydoni: '44,2 (km²)',
                        aholiSoni: '174,7 ming',
                        TumanlarSoni: '52',
                        MahallaSoni: '30',
                        savdodaTurganJamiSoni: 'N/A'
                    },
                    'tashkent': {
                        name: 'Tashkent',
                        maydoni: '43,5 (km²)',
                        aholiSoni: '3 mln',
                        TumanlarSoni: '12',
                        MahallaSoni: '585',
                        savdodaTurganJamiSoni: 'N/A'
                    } // Static info for Tashkent
                };

                // Get information for the selected district
                const info = districtInfo[districtFile] || {
                    name: '',
                    maydoni: 'N/A',
                    aholiSoni: 'N/A',
                    TumanlarSoni: 'N/A',
                    MahallaSoni: 'N/A',
                    savdodaTurganJamiSoni: 'N/A'
                };

                updateInfoTable(info);
            }

            function updateInfoTable(data) {
                // Create the info array conditionally
                const info = [{
                        metric: 'Maydoni',
                        value: data.maydoni
                    },
                    {
                        metric: 'Aholi Soni',
                        value: data.aholiSoni
                    },
                    // Conditionally include 'Tumanlar soni' only if the name is 'Tashkent'
                    ...(data.name === 'Tashkent' ? [{
                        metric: 'Tumanlar soni',
                        value: data.TumanlarSoni
                    }] : []),
                    {
                        metric: 'Mahalla soni',
                        value: data.MahallaSoni
                    },
                    {
                        metric: 'Savdodagi obyektlar',
                        value: data.savdodaTurganJamiSoni
                    }
                ];

                // Update the district name
                document.getElementById('district-name').textContent = data.name || 'N/A';

                // Update the table with the provided info
                updateTable(info);
            }

            function updateTable(info) {
                // Get the table body
                const tableBody = document.getElementById('info-table').getElementsByTagName('tbody')[0];
                tableBody.innerHTML = ''; // Clear existing rows

                // Add rows to the table
                info.forEach(item => {
                    const row = document.createElement('tr');
                    const metricCell = document.createElement('td');
                    metricCell.textContent = item.metric;
                    const valueCell = document.createElement('td');
                    valueCell.textContent = item.value;
                    row.appendChild(metricCell);
                    row.appendChild(valueCell);
                    tableBody.appendChild(row);
                });
            }

        }
    </script>
</body>

</html>
