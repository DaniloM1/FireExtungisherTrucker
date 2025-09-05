<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Location') }}
        </h2>
    </x-slot>

    <!-- Poruke o uspjehu i greškama -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Glavni sadržaj stranice -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-200">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Edit Location Form') }}</h3>
                    <form method="POST" action="{{ route('locations.update', $location) }}">
                        @csrf
                        @method('PUT')

                        <!-- Prikaz kompanije (read-only) -->
                        <div class="mb-4">
                            <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Kompanija') }}
                            </label>
                            <input type="text" name="company_name" id="company_name" value="{{ $location->company->name }}" readonly
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            <!-- Skriveni input za company_id -->
                            <input type="hidden" name="company_id" value="{{ $location->company_id }}">
                        </div>

                        <!-- Name Field -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Naziv Lokacije') }}
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $location->name) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Address Field -->
                        <div class="mb-4">
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Adresa') }}
                            </label>
                            <input type="text" name="address" id="address" value="{{ old('address', $location->address) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div class="mb-4">
                            <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Grad') }}
                            </label>
                            <input type="text" name="city" id="city" value="{{ old('city', $location->city) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('PIB') }}
                            </label>
                            <input type="text" name="pib" id="pib" value="{{ old('pib', $location->pib) }}" autocomplete="off"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">

                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Maticni broj') }}
                                </label>
                                <input type="text" name="maticni" id="maticni" value="{{ old('maticni', $location->maticni) }}" autocomplete="off"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Kontakt osoba') }}
                                </label>
                                <input type="text" name="contact" id="contact" value="{{ old('contact', $location->contact) }}" autocomplete="off"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Kontakt broj') }}
                                </label>
                                <input type="text" name="kontakt_broj" id="kontakt_broj" value="{{ old('kontakt_broj', $location->kontakt_broj) }}" autocomplete="off"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div class="mb-4">
                                <label for="gmap_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Google Maps link (zalepi ovde, auto popunjava lat/lng)
                                </label>
                                <input type="url" id="gmap_link"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="https://maps.google.com/... ili 44.2424, 24.2421" autocomplete="off">
                            </div>
                            <div id="gmap_status" class="mt-1 text-sm"></div>

                        <!-- Latitude Field -->
                        <div class="mb-4">
                            <label for="latitude" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Latitude') }}
                            </label>
                            <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $location->latitude) }}"
                               autocomplete="off" readonly tabindex="-1"
                                   class=" readonly mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Longitude Field -->
                        <div class="mb-4">
                            <label for="longitude" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Longitude') }}
                            </label>
                            <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $location->longitude) }}"
                               autocomplete="off" readonly tabindex="-1"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Submit i Cancel dugmad -->
                        <div class="flex gap-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Izmeni Lokaciju') }}
                            </button>
                            <a href="{{ route('companies.locations.index', ['company' => $location->company_id]) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Ponisti') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const gmapInput = document.getElementById('gmap_link');
            const latInput   = document.getElementById('latitude');
            const lngInput   = document.getElementById('longitude');
            const status     = document.getElementById('gmap_status');

            function extractLatLng(value) {
                // 1) Plain coords: "LAT, LNG" or "(LAT, LNG)"
                let m = value.match(/([-+]?\d{1,3}(?:\.\d+)?)[\s,]+([-+]?\d{1,3}(?:\.\d+)?)/);
                if (m) {
                    return [ m[1], m[2] ];
                }
                // 2) URL: !3dLAT!4dLNG
                let all = [...value.matchAll(/!3d(-?\d+\.\d+)!4d(-?\d+\.\d+)/g)];
                if (all.length) {
                    let mm = all.pop();
                    return [ mm[1], mm[2] ];
                }
                // 3) URL: @LAT,LNG
                m = value.match(/@(-?\d+\.\d+),(-?\d+\.\d+)/);
                if (m) return [ m[1], m[2] ];
                // 4) URL: q=LAT,LNG
                m = value.match(/[?&]q=(-?\d+\.\d+),(-?\d+\.\d+)/);
                if (m) return [ m[1], m[2] ];
                // 5) URL: ll=LAT,LNG
                m = value.match(/[?&]ll=(-?\d+\.\d+),(-?\d+\.\d+)/);
                if (m) return [ m[1], m[2] ];
                // 6) URL: center=LAT,LNG
                m = value.match(/[?&]center=(-?\d+\.\d+),(-?\d+\.\d+)/);
                if (m) return [ m[1], m[2] ];
                return [ null, null ];
            }

            function resetFields() {
                status.innerHTML = '';
                latInput.value = '';
                lngInput.value = '';
                latInput.classList.remove('border-red-500');
                lngInput.classList.remove('border-red-500');
            }

            gmapInput?.addEventListener('input', function () {
                const v = this.value.trim();
                if (!v) {
                    resetFields();
                    return;
                }

                const [lat, lng] = extractLatLng(v);

                if (lat && lng) {
                    latInput.value = lat;
                    lngInput.value = lng;
                    latInput.classList.remove('border-red-500');
                    lngInput.classList.remove('border-red-500');
                    status.innerHTML = `<span class="inline-flex items-center px-2 py-1 rounded bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300">
                <i class="fas fa-check-circle mr-1"></i> Lokacija prepoznata
            </span>`;
                } else {
                    latInput.value = '';
                    lngInput.value = '';
                    latInput.classList.add('border-red-500');
                    lngInput.classList.add('border-red-500');
                    status.innerHTML = `<span class="inline-flex items-center px-2 py-1 rounded bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300">
                <i class="fas fa-times-circle mr-1"></i> Nije validan link ili koordinate
            </span>`;
                }
            });
        });
    </script>
</x-app-layout>
