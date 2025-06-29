@props([
    'locations',
    'autoTheme' => false,
    'mapId' => null,
])

@php
    $mapId  = $mapId ?: 'leaflet-map-'.uniqid();

    $locArr = $locations instanceof \Illuminate\Pagination\LengthAwarePaginator
        ? $locations->items()
        : (is_array($locations) ? $locations : []);

    $locArr = array_map(function ($m) {
        $row        = $m instanceof \Illuminate\Database\Eloquent\Model ? $m->toArray() : $m;
        $row['url'] = route('locations.show', $row['id']);
        return $row;
    }, $locArr);
@endphp

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<div id="{{ $mapId }}" style="width:100%;height:400px"></div>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mapDiv = document.getElementById(@json($mapId));
        const locations = @json($locArr);
        const valid = locations.filter(l => l.latitude && l.longitude);

        if (!mapDiv || !valid.length) return;

        let map = null, bounds = [];

        function setupMap() {
            if (!map) {
                const prefersDark = (
                    @json($autoTheme) &&
                    document.documentElement.classList.contains('dark')
            );
                const lightURL = 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png';
                // const darkURL  = lightURL;
                const darkURL  = 'https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}.png';

                const TILE_URL = prefersDark ? darkURL : lightURL;
                const ATTRIB   = '&copy; OpenStreetMap, &copy; CartoDB, &copy; Stamen';
                map = L.map(mapDiv);
                L.tileLayer(TILE_URL, { attribution: ATTRIB }).addTo(map);

                bounds = [];
                valid.forEach(loc => {
                    const lat = parseFloat(loc.latitude);
                    const lng = parseFloat(loc.longitude);
                    const html = `<strong><a href="${loc.url}">${loc.name}</a></strong><br>
                    ${loc.address ?? ''}<br>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}" target="_blank" rel="noopener">🚗 Ruta</a>`;
                    L.marker([lat, lng]).addTo(map).bindPopup(html);
                    bounds.push([lat, lng]);
                });
            }

            setTimeout(() => {
                map.invalidateSize();
                if (bounds.length > 1) {
                    map.fitBounds(bounds, {padding:[30,30]});
                } else if (bounds.length === 1) {
                    map.setView(bounds[0], 13);
                }
            }, 100);
        }

        // Ako je mapa odmah vidljiva, inicijalizuj je odmah
        if (window.getComputedStyle(mapDiv).display !== 'none') {
            setupMap();
        }

        // Kad tab postane aktivan (event iz Alpine tabova)
        window.addEventListener('tab-switch', function(e) {
            if (e.detail === @json($mapId)) {
                setupMap();
            }
        });
    });
</script>
