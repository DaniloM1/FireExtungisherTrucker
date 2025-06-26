@props([
    'locations',
    'autoTheme' => false,   // prati dark klasu
])

@php
    $mapId  = 'leaflet-map-' . uniqid();

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
    document.addEventListener('DOMContentLoaded', () => {

        /* 1. filtriraj lokacije s koordinatama */
        const mapDiv = document.getElementById(@json($mapId));
        if (!mapDiv) return;

        const locs  = @json($locArr);
        const valid = locs.filter(l => l.latitude && l.longitude);
        if (!valid.length) return;

        /* 2. odaberi sloj – pastel light ili tamni */
        const prefersDark = (
            @json($autoTheme) &&
            document.documentElement.classList.contains('dark')
    );

        const TILE_URL = prefersDark
            ? 'https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png'   // tamnosiva
            : 'https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.png';       // nova pastel-light

        const ATTRIB  = '&copy; OpenStreetMap &copy; Stadia Maps';

        /* 3. mapa + pinovi */
        const center = [parseFloat(valid[0].latitude), parseFloat(valid[0].longitude)];
        const map    = L.map(mapDiv).setView(center, 9);
        L.tileLayer(TILE_URL, { attribution: ATTRIB }).addTo(map);

        const bounds = [];
        valid.forEach(loc => {
            const lat = parseFloat(loc.latitude);
            const lng = parseFloat(loc.longitude);

            const popup = `
            <strong><a href="${loc.url}">${loc.name}</a></strong><br>
            ${loc.address ?? ''}<br>
            <a href="https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}"
               target="_blank" rel="noopener">🚗 Ruta</a>
        `;
            L.marker([lat, lng]).addTo(map).bindPopup(popup);
            bounds.push([lat, lng]);
        });

        if (bounds.length > 1) map.fitBounds(bounds, { padding: [30, 30] });
    });
</script>
