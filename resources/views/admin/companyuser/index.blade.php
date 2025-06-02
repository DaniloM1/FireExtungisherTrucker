<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ auth()->user()->company->name ?? '-' }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Statistika servisa -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 rounded-full p-3 mr-4">
                        <i class="fa-solid fa-gears fa-xl text-blue-600 dark:text-blue-300"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $serviceStats['total'] }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-300">Ukupno servisa</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 flex items-center">
                    <div class="flex-shrink-0 bg-orange-100 dark:bg-orange-900 rounded-full p-3 mr-4">
                        <i class="fa-solid fa-fire-extinguisher fa-xl text-orange-600 dark:text-orange-300"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $serviceStats['pp_devices'] }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-300">PP uređaji</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 flex items-center">
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
                <div class="mb-4 flex space-x-2">
                    <button @click="tab = 'locations'" :class="tab === 'locations' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200'"
                            class="px-4 py-2 rounded-t-lg font-medium focus:outline-none transition">Lokacije</button>
                    <button @click="tab = 'services'" :class="tab === 'services' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200'"
                            class="px-4 py-2 rounded-t-lg font-medium focus:outline-none transition">Poslednji servisi</button>
                </div>

                <!-- Lokacije Tab -->
                <div x-show="tab === 'locations'" class="bg-white dark:bg-gray-800 rounded-b-xl shadow p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Lokacije</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Naziv</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Grad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">PP uređaji</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Hidranti</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($locations as $location)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $location->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $location->city }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $location->devices_count }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $location->hydrants_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        Nema lokacija za prikaz.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Servisi Tab -->
                <div x-show="tab === 'services'" class="bg-white dark:bg-gray-800 rounded-b-xl shadow p-6" x-cloak>
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Poslednjih 5 servisa</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Evid. broj</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Datum servisa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Kategorija</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Lokacije</th>
                                <th class="px-6 py-3 text-right"></th>
                            </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($recentServiceEvents as $event)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $event->evid_number }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $event->service_date }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($event->category) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                        @foreach ($event->locations as $loc)
                                            <span class="block">{{ $loc->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('company.service-events.show', $event->id) }}"
                                           class="text-blue-600 hover:text-blue-800 font-medium">Detalji</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        Nema servisnih događaja za prikaz.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- Kraj tabova -->

        </div>
    </div>

    <!-- Alpine.js za tabove -->
    <script src="//unpkg.com/alpinejs" defer></script>
</x-app-layout>
