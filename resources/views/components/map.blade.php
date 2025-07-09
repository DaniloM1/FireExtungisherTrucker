@props([
    'locations',
    'autoTheme'     => false,
    'mapId'         => null,
    'highlightIds'  => [],      //  <<< NOVO
])

@php
    $mapId = $mapId ?: 'leaflet-map-'.uniqid();

    // kolekcija | paginator | niz  → niz (tvoj stari kod sam zadržao)
    if ($locations instanceof \Illuminate\Pagination\LengthAwarePaginator) {
        $locArr = $locations->items();
    } elseif ($locations instanceof \Illuminate\Support\Collection) {
        $locArr = $locations->all();
    } elseif (is_array($locations)) {
        $locArr = $locations;
    } else {
        $locArr = [];
    }


    $locArr = array_map(function ($m) {
        $row = $m instanceof \Illuminate\Database\Eloquent\Model
            ? $m->toArray()
            : $m;

        // Postavi URL u zavisnosti od role
        if (auth()->user()->hasRole('super_admin|admin')) {
            $row['url'] = route('locations.show', $row['id']);
        } else {
            $row['url'] = route('company.locations.show', $row['id']);
        }

        return $row;
    }, $locArr);


// dd([
//    'highlightIds' => $highlightIds,
//    'locArr_ids'   => collect($locArr)->pluck('id'),
//]);
@endphp

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<div id="{{ $mapId }}" style="width:100%;height:400px"></div>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mapDiv       = document.getElementById(@json($mapId));
        const locations    = @json($locArr);
        const highlightIds = new Set(@json($highlightIds));   //  <<< NOVO
        const valid        = locations.filter(l => l.latitude && l.longitude);

        if (!mapDiv || !valid.length) return;

        let map = null, bounds = [];

        function setupMap () {
            if (!map) {
                const prefersDark = (
                    @json($autoTheme) &&
                    document.documentElement.classList.contains('dark')
            );
                const lightURL = 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png';
                const darkURL  = 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png';
                const TILE_URL = prefersDark ? darkURL : lightURL;


                map = L.map(mapDiv);
                L.tileLayer(TILE_URL, { attribution: '© OpenStreetMap • © CartoDB' }).addTo(map);

                /* Pin ikonice */
                var greenPin = new L.Icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                    iconSize: [20, 33],
                    iconAnchor: [10, 33],
                    popupAnchor: [1, -27],
                    shadowSize: [33, 33]

                });

                var bluePin = new L.Icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png',
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                    iconSize: [20, 33],
                    iconAnchor: [10, 33],
                    popupAnchor: [1, -27],
                    shadowSize: [33, 33]

                });



                valid.forEach(loc => {
                    const lat  = parseFloat(loc.latitude);
                    const lng  = parseFloat(loc.longitude);
                    const html = `<strong><a href="${loc.url}">${loc.name}</a></strong><br>
                              ${loc.address ?? ''}<br>
                              <a href="https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}" target="_blank" rel="noopener">🚗 Ruta</a>`;

                    /* zelena ako je ID u highlightIds */
                    const icon = highlightIds.has(loc.id) ? greenPin : bluePin;

                    L.marker([lat, lng], { icon }).addTo(map).bindPopup(html);
                    bounds.push([lat, lng]);
                });
            }

            setTimeout(() => {
                map.invalidateSize();
                if (bounds.length > 1) map.fitBounds(bounds, { padding:[30,30] });
                else if (bounds.length === 1) map.setView(bounds[0], 13);
            }, 100);
        }

        if (window.getComputedStyle(mapDiv).display !== 'none') {
            setupMap();
        }
        window.addEventListener('tab-switch', e => {
            if (e.detail === @json($mapId)) setupMap();
        });
    });
</script>
