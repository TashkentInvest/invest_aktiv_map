

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
    fetch('/api/markersing')
        .then(response => response.json())
        .then(data => {
            const markersData = data.lots;
            window.markers = markersData; // Make markers globally accessible

            let targetMarkerData = null;

            markersData.forEach(markerData => {
                const lat = parseFloat(markerData.lat);
                const lng = parseFloat(markerData.lng);

                if (!isNaN(lat) && !isNaN(lng)) {
                    const position = { lat, lng };
                    const title = markerData.property_name || 'No Title';

                    const marker = new google.maps.Marker({
                        position: position,
                        map: map,
                        title: title
                    });

                    marker.addListener('click', function () {
                        const sidebar = document.getElementById('info-sidebar');
                        const isInUSD = sidebar.getAttribute('data-currency') === 'USD';
                        updateSidebarContent(markerData, isInUSD, usdRate);
                        sidebar.classList.add('open');
                    });

                    // Check if URL parameters match this marker
                    if (urlLat && urlLng && lat === urlLat && lng === urlLng) {
                        targetMarkerData = markerData;
                        map.setCenter({ lat, lng });
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
    let lotPriceFormatted, lotPricePerSotixFormatted;
    try {
        if (isInUSD && usdRate) {
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
        } else {
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
        lotPriceFormatted = priceUZS;
        lotPricePerSotixFormatted = lotPricePerSotixUZS;
    }

    // Generate QR Code URL
    const qrCodeUrl = `${baseUrl}/api/lot/qr-code/${markerData.lat}/${markerData.lng}`;

    sidebar.innerHTML = `
        <span class="close-btn">&times;</span>
        <div class="info-content">
            ${markerData.main_image ? `<img class="custom_sidebar_image" src="${markerData.main_image}" alt="Marker Image"/>` : ''}
            <button id="toggle-currency-btn">${isInUSD ? 'Valyutani tahrirlash UZS' : 'Valyutani tahrirlash USD'}</button>
            <h4 class="custom_sidebar_title"><b>${markerData.property_name || 'No Title'}</b></h4>
            <table>
                 <tr>
                    <th class="sidebar_key">Lot raqami</th>
                    <td>${markerData.lot_number || 'N/A'}</td>
                </tr>
                <tr>
                    <th class="sidebar_key">Mulk turi</th>
                    <td>${markerData.property_group || 'N/A'}</td>
                </tr>
                <tr>
                    <th class="sidebar_key">Maqsadi</th>
                    <td>${markerData.property_category || 'N/A'}</td>
                </tr>
                <tr>
                    <th class="sidebar_key">Foydalanish bo‘yicha ogohlantirish</th>
                    <td>${markerData.build_types || 'N/A'}</td>
                </tr>
                <tr>
                    <th class="sidebar_key">Hududi</th>
                    <td>${markerData.region || 'N/A'}</td>
                </tr>
                <tr>
                    <th class="sidebar_key">Manzili</th>
                    <td>${markerData.address || 'N/A'}</td>
                </tr>
                 <tr>
                    <th class="sidebar_key">Boshlang'ich narxi</th>
                    <td id="price-td">${lotPriceFormatted}</td>
                </tr>
                <tr>
                    <th class="sidebar_key">Yer maydoni (kvm²)</th>
                    <td>${markerData.land_area || 'N/A'}</td>
                </tr>
                 <tr>
                    <th class="sidebar_key">1 sotix uchun narx</th>
                    <td>${lotPricePerSotixFormatted || 'N/A'}</td>
                </tr>
            </table>
             <div id="qr-code-container">
                <img src="${qrCodeUrl}" alt="QR Code" type="image/svg+xml" />
                <a href="${qrCodeUrl}" download="qr_code.svg">QR Kodni yuklab olish</a>
            </div>
            <a target="_blank" href="${markerData.lot_link || '#'}" class="btn-link">Lotni ko'rish</a>
        </div>
    `;
}

function setupEventListeners() {
    document.addEventListener('click', function (event) {
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
function handleDistricts(map) {
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