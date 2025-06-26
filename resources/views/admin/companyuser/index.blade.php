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



                    @include('admin.locations._list')

                </div>


                <!-- Servisi Tab -->
                <div x-show="tab === 'services'" x-cloak class="bg-white dark:bg-gray-800 rounded-b-xl shadow p-4 sm:p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Poslednji servisi</h3>
                    @include('admin.service-events._list')

            </div> <!-- Kraj tabova -->
        </div>
    </div>

        </div>
    <!-- Map card – kompaktan i dark-mode spreman -->
    <x-map-card
        :locations="$locations"
        title="Lokacije"
        width="max-w-5xl"
        height="h-200"
    />





    <script src="//unpkg.com/alpinejs" defer></script>
</x-app-layout>
