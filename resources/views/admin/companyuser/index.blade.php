<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ auth()->user()->company->name ?? '-' }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <!-- Statistika servisa -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 sm:p-6 flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 rounded-full p-3 mr-4">
                        <i class="fa-solid fa-gears fa-xl text-blue-600 dark:text-blue-300"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $serviceStats['total'] }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-300">Ukupno servisa</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 sm:p-6 flex items-center">
                    <div class="flex-shrink-0 bg-orange-100 dark:bg-orange-900 rounded-full p-3 mr-4">
                        <i class="fa-solid fa-fire-extinguisher fa-xl text-orange-600 dark:text-orange-300"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $serviceStats['pp_devices'] }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-300">PP uređaji</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 sm:p-6 flex items-center">
                    <div class="flex-shrink-0 bg-cyan-100 dark:bg-cyan-900 rounded-full p-3 mr-4">
                        <i class="fa-solid fa-faucet-drip fa-xl text-cyan-600 dark:text-cyan-300"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $serviceStats['hydrants'] }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-300">Hidranti</div>
                    </div>
                </div>

            </div>

            <!-- Tabs -->
            <div x-data="{ tab: 'locations' }">
                <div x-data="{ tab: 'locations' }">
                    <div class="mb-4 flex flex-wrap gap-2 justify-center sm:justify-start">
                        <!-- Lokacije -->
                        <button @click="tab = 'locations'"
                                :class="tab === 'locations' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200'"
                                class="px-4 py-2 rounded-lg font-medium focus:outline-none transition flex items-center justify-center w-12 sm:w-auto">
                            <!-- Ikonica za mobilni -->
                            <i class="fa-solid fa-building sm:mr-2"></i>
                            <!-- Tekst samo na većim ekranima -->
                            <span class="hidden sm:inline">Lokacije</span>
                        </button>
                
                        <!-- Servisi -->
                        <button @click="tab = 'services'"
                                :class="tab === 'services' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200'"
                                class="px-4 py-2 rounded-lg font-medium focus:outline-none transition flex items-center justify-center w-12 sm:w-auto">
                            <i class="fa-solid fa-wrench sm:mr-2"></i>
                            <span class="hidden sm:inline">Poslednji servisi</span>
                        </button>
                
                        <!-- Mapa -->
                        <button @click="tab = 'map'; $nextTick(() => window.dispatchEvent(new CustomEvent('tab-switch', {detail: 'leaflet-map-all'})))"
                                :class="tab === 'map' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200'"
                                class="px-4 py-2 rounded-lg font-medium focus:outline-none transition flex items-center justify-center w-12 sm:w-auto">
                            <i class="fa-solid fa-map sm:mr-2"></i>
                            <span class="hidden sm:inline">Mapa</span>
                        </button>
                    </div>
                

                <!-- Lokacije Tab -->
                <div x-show="tab === 'locations'" x-cloak class="bg-white dark:bg-gray-800 rounded-b-xl shadow p-4 sm:p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Lokacije</h3>
                    <form method="GET" action="{{ route('company.service-events.index') }}" class="mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Naziv lokacije
                                </label>
                                <input type="text" name="name" id="name" value="{{ request('name') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Adresa
                                </label>
                                <input type="text" name="address" id="address" value="{{ request('address') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Grad
                                </label>
                                <input type="text" name="city" id="city" value="{{ request('city') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end space-x-2">
                            <a href="{{ route('company.service-events.index') }}"
                               class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 flex items-center gap-2"
                            >
                                <i class="fa-solid fa-filter-circle-xmark"></i> Poništi
                            </a>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center gap-2">
                                <i class="fa-solid fa-magnifying-glass"></i> Pretraži
                            </button>
                        </div>
                    </form>



                    @include('admin.locations._list')
                    <x-map-card
                        :locations="$locations"
                        title="Lokacije"
                        width="max-w-5xl"
                        height="h-200"
                    />
                </div>


                <!-- Servisi Tab -->
                <div x-show="tab === 'services'" x-cloak class="bg-white dark:bg-gray-800 rounded-b-xl shadow p-4 sm:p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Poslednji servisi</h3>
                    @include('admin.service-events._list')

            </div>
                <div x-show="tab === 'map'" x-cloak class="bg-white dark:bg-gray-800 rounded-b-xl shadow p-4 sm:p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">
                        Sve lokacije na mapi
                    </h3>
                    <x-map-card
                        :locations="$locationsMap"
                        title="Sve lokacije"
                        width="max-w-5xl"
                        height="h-200"
                        map-id="leaflet-map-all"
                    />
                </div>
            </div>
                <!-- Kraj tabova -->
        </div>
    </div>


        </div>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let map;
            let mapDiv = document.getElementById('leaflet-map'); // proveri ID ako je custom
            let locations = @json($locations);

            // Provera da li je mapa u tab-u koji je možda sakriven
            function showMap() {
                if (!map) {
                    map = L.map(mapDiv).setView([44.8, 20.5], 8);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);
                    locations.forEach(loc => {
                        if (loc.latitude && loc.longitude) {
                            L.marker([loc.latitude, loc.longitude])
                                .addTo(map)
                                .bindPopup(loc.name + '<br>' + (loc.address ?? '') + '<br>' + (loc.city ?? ''));
                        }
                    });
                    // Auto-fit all markers
                    let bounds = locations
                        .filter(l => l.latitude && l.longitude)
                        .map(l => [l.latitude, l.longitude]);
                    if (bounds.length) map.fitBounds(bounds, {padding: [32,32]});
                } else {
                    // Ako već postoji, samo osveži veličinu
                    map.invalidateSize();
                }
            }

            // Ako je mapa odmah vidljiva
            if (window.getComputedStyle(mapDiv).display !== 'none') {
                setTimeout(showMap, 200);
            }

            // Ako koristiš Alpinejs tabove:
            document.addEventListener('alpine:init', () => {
                document.addEventListener('tab-switch', function(e) {
                    if (e.detail === 'map') {
                        setTimeout(showMap, 200);
                    }
                });
            });
        });
    </script>

</x-app-layout>
