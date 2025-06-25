@props(['locations'])

@php
    // Napravi unique id za svaki prikaz (može i sa uniqid(), ali ovako je čistije)
    $mapId = 'leaflet-map-' . uniqid();
@endphp

    <!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

<div id="{{ $mapId }}" style="width: 100%; height: 400px;"></div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Uvek koristi tačan id
        const mapDiv = document.getElementById(@json($mapId));

        // Primi podatke iz Blade-a (pretpostavlja se da svaka lokacija ima latitude, longitude, title)
        const locations = @json($locations);

        if (!locations.length) return;

        // Prvi marker kao centar
        const center = [locations[0].latitude ?? locations[0].lat, locations[0].longitude ?? locations[0].lng];

        // Inicijalizuj mapu
        const map = L.map(mapDiv).setView(center, 8);

        // OSM tile-ovi
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Dodaj markere (podrži oba naziva: lat/lng i latitude/longitude)
        locations.forEach(function(loc) {
            const lat = loc.latitude ?? loc.lat;
            const lng = loc.longitude ?? loc.lng;
            L.marker([lat, lng])
                .addTo(map)
                .bindPopup(loc.title || '');
        });

        // Fituj sve pinove ako ih ima više
        if (locations.length > 1) {
            const bounds = locations.map(loc => [
                loc.latitude ?? loc.lat,
                loc.longitude ?? loc.lng
            ]);
            map.fitBounds(bounds, {padding: [30, 30]});
        }
    });
</script>
