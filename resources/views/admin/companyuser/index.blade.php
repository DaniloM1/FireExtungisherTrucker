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
                <div class="mb-4 flex flex-wrap gap-2">
                    <button @click="tab = 'locations'"
                            :class="tab === 'locations' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200'"
                            class="px-4 py-2 rounded-t-lg font-medium focus:outline-none transition w-full sm:w-auto">
                        Lokacije
                    </button>
                    <button @click="tab = 'services'"
                            :class="tab === 'services' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200'"
                            class="px-4 py-2 rounded-t-lg font-medium focus:outline-none transition w-full sm:w-auto">
                        Poslednji servisi
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

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Naziv</th>
                                <th class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Grad</th>
                                <th class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">PP uređaji</th>
                                <th class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Hidranti</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($locations as $location)
                                <tr>
                                    <td class="px-2 sm:px-6 py-4 text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                        <a href="{{ route('company.locations.show', $location->id) }}">
                                            {{ $location->name }}
                                        </a>
                                    </td>
                                    <td class="px-2 sm:px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $location->city }}</td>
                                    <td class="px-2 sm:px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $location->devices_count }}</td>
                                    <td class="px-2 sm:px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $location->hydrants_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-2 sm:px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        Nema lokacija za prikaz.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{ $locations->links() }}
                    </div>
                </div>

                <!-- Servisi Tab -->
                <div x-show="tab === 'services'" x-cloak class="bg-white dark:bg-gray-800 rounded-b-xl shadow p-4 sm:p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Poslednji servisi</h3>
                    {{-- MOBILE LISTA --}}
                    <div class="block md:hidden space-y-4">
                        @forelse ($recentServiceEvents as $event)
                            <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 shadow">
                                <div class="flex justify-between items-center mb-2">
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Evid. broj</div>
                                    <div class="font-semibold text-blue-600 dark:text-blue-300">{{ $event->evid_number }}</div>
                                </div>
                                <div class="flex flex-wrap gap-2 text-xs mb-1">
                                    <div class="flex-1">
                                        <span class="text-gray-500 dark:text-gray-400">Servis:</span>
                                        <span class="text-gray-900 dark:text-gray-100">
                                            {{ $event->service_date ? \Carbon\Carbon::parse($event->service_date)->format('d.m.Y') : '-' }}
                                        </span>
                                    </div>

                                    <div class="flex-1">
                                        <span class="text-gray-500 dark:text-gray-400">Sledeći:</span>
                                        <span class="font-semibold text-blue-700 dark:text-blue-300">{{ $event->next_service_date ? \Carbon\Carbon::parse($event->next_service_date)->format('d.m.Y') : '-' }}</span>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">Kategorija:
                                    <span class="text-gray-900 dark:text-gray-100 font-medium">{{ ucfirst($event->category) }}</span>
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mb-2">Lokacije:
                                    @foreach ($event->locations as $loc)
                                        <span class="inline-block bg-gray-100 dark:bg-gray-700 rounded px-2 py-1 mx-1 text-gray-700 dark:text-gray-200">{{ $loc->name }}</span>
                                    @endforeach
                                </div>
                                <div class="flex justify-end">
                                    <a href="{{ route('company.service-events.show', $event->id) }}"
                                       class="text-blue-600 dark:text-blue-300 hover:underline font-medium text-sm">Detalji</a>
                                </div>
                            </div>
                        @empty
                            <div class="text-gray-500 dark:text-gray-400 text-center">Nema servisnih događaja za prikaz.</div>
                        @endforelse
                    </div>
                    {{-- DESKTOP TABELA --}}
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Evid. broj</th>
                                <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Datum servisa</th>
                                <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Sledeći servis</th>
                                <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Kategorija</th>
                                <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Lokacije</th>
                                <th class="px-2 sm:px-4 py-3 text-right"></th>
                            </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($recentServiceEvents as $event)
                                <tr>
                                    <td class="px-2 sm:px-4 py-4 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $event->evid_number }}
                                    </td>
                                    <td class="px-2 sm:px-4 py-4 text-sm">
                        <span class="inline-block px-2 py-1 rounded bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            {{ $event->service_date ? \Carbon\Carbon::parse($event->service_date)->format('d.m.Y') : '-' }}
                        </span>
                                    </td>
                                    <td class="px-2 sm:px-4 py-4 text-sm">
                        <span class="inline-block px-2 py-1 rounded bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200">
                            {{ $event->next_service_date ? \Carbon\Carbon::parse($event->next_service_date)->format('d.m.Y') : '-' }}
                        </span>
                                    </td>
                                    <td class="px-2 sm:px-4 py-4 text-sm text-gray-900 dark:text-gray-100">
                                        {{ ucfirst($event->category) }}
                                    </td>
                                    <td class="px-2 sm:px-4 py-4 text-sm text-gray-900 dark:text-gray-100">
                                        @foreach ($event->locations as $loc)
                                            <span class="inline-block bg-gray-100 dark:bg-gray-700 rounded px-2 py-1 mr-1">{{ $loc->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="px-2 sm:px-4 py-4 text-right">
                                        <a href="{{ route('company.service-events.show', $event->id) }}"
                                           class="text-blue-600 dark:text-blue-300 hover:underline font-medium">Detalji</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-2 sm:px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                                        Nema servisnih događaja za prikaz.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{$recentServiceEvents->links()}}
                    </div>
                </div>



                <!-- Novi tab: Računi i prilozi -->

            </div> <!-- Kraj tabova -->
        </div>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
</x-app-layout>
