<x-app-layout>
    <x-slot name="header">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">
                    {{ $company->name }} |  {{ $company->pib }}
                </h3>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ $company->address }}
                </p>
            </div>
            <div class="mt-4">
                <nav class="text-sm text-gray-500">
                    Kompanija <span class="mx-2">&rarr;</span> Lokacije
                </nav>
            </div>
    </x-slot>
    <div class="py-6 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 mb-6">

    <!-- Polje za pretragu -->
        <form method="GET" action="{{ route('companies.locations.index', $company->id) }}" class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Naziv Lokacije
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
{{--                <div>--}}
{{--                    <label for="next_service_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">--}}
{{--                        Next Service Date--}}
{{--                    </label>--}}
{{--                    <input type="date" name="next_service_date" id="next_service_date" value="{{ request('next_service_date') }}"--}}
{{--                           class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">--}}
{{--                </div>--}}
            </div>

            <div class="mt-4 flex justify-end space-x-2">
                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                >
                    <i class="fa fa-search mr-2"></i>Pretraži
                </button>
                <a href="{{ route('companies.locations.index', $company->id) }}"
                   class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-100 rounded-lg shadow-sm hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-red-400 transition flex items-center"
                   title="Poništi filtere">
                    <i class="fa-solid fa-filter-circle-xmark mr-2"></i>
                </a>
            </div>
        </form>
    </div>



    <!-- Opcionalne poruke (success, error) -->
    <div class="max-w-7xl mx-auto mt-4">
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <!-- Glavni box s tamnijom pozadinom za kontrast -->
            <div class=" shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Header s naslovom i linkom za dodavanje nove lokacije -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">{{ __('Lista lokacija') }}</h3>
                        <a href="{{ route('companies.locations.create', $company->id) }}"
                           class=" hover:underline">
                            <i class="fas fa-plus"></i> {{ __('Dodaj Lokaciju') }}
                        </a>
                    </div>

                    <!-- Responzivni prikaz tablice -->
                    <div class="overflow-x-auto">
                        <!-- Desktop prikaz -->
                        <table class="min-w-full hidden md:table divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Naziv') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Adresa') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Grad') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Sledeci servis') }}
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Akcije') }}
                                </th>

                            </tr>

                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($locations as $location)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('locations.show', $location->id) }}"
                                           class="text-blue-700 dark:text-blue-300 font-medium hover:underline">
                                            {{ $location->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $location->address }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $location->city }}</td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($location->next_service_date)
                                            <a href="{{ route('service-events.show', $location->serviceEvents->first()->id) }}" class="text-white-500 underline">
                                                {{ \Carbon\Carbon::parse($location->next_service_date)->format('d.m.Y') }}
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-4">
                                            <!-- Ikonice za Category -->
                                            <a href="{{ route('locations.devices.index', $location->id) }}"
                                               class="text-black dark:text-white hover:underline"
                                               title="Fire Extinguisher">
                                                <i class="fas fa-fire-extinguisher"></i>
                                            </a>
                                            <a href="{{ route('locations.hydrants.index', $location->id) }}"
                                               class="text-black dark:text-white hover:underline"
                                               title="{{ __('Hydrants') }}">
                                                <i class="fas  fa-h-square
"></i>
                                            </a>
                                            <a href="{{ route('locations.groups.index', $location->id) }}"
                                               class="text-black dark:text-white hover:underline"
                                               title="Groups">
                                                <i class="fa-solid fa-layer-group"></i>
                                            </a>
                                            <!-- Akcijske ikonice -->
                                            <a href="{{ route('locations.edit', $location->id) }}"
                                               class="text-black dark:text-white hover:underline"
                                               title="{{ __('Edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <a href="{{ route('locations.destroy', $location->id) }}"
                                               onclick="event.preventDefault(); if(confirm('{{ __('Are you sure?') }}')) { document.getElementById('delete-location-{{ $location->id }}').submit(); }"
                                               class="text-black dark:text-white hover:underline"
                                               title="{{ __('Delete') }}">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                        <form id="delete-location-{{ $location->id }}" action="{{ route('locations.destroy', $location->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">
                                        {{ __('No locations found.') }}
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        <!-- Mobile prikaz -->
                        <div class="block md:hidden">
                            @forelse ($locations as $location)
                                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 mb-4">
                                    <div class="text-lg font-semibold">
                                        <a href="{{ route('locations.show', $location->id) }}"
                                           class="text-blue-700 dark:text-blue-300 hover:underline">
                                            {{ $location->name }}
                                        </a>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">{{ $location->address }}</div>
                                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                        @if($location->next_service_date)
                                            Sledeći servis:
                                            <a href="{{ route('service-events.show', $location->serviceEvents->first()->id) }}" class="text-blue-500 hover:underline">
                                                {{ \Carbon\Carbon::parse($location->next_service_date)->format('d.m.Y') }}
                                            </a>
                                        @else
                                            Sledeći servis: N/A
                                        @endif
                                    </div>
                                    <div class="mt-2">

                                    </div>
                                    <div class="mt-4 flex items-center space-x-4">
                                    <a href="{{ route('locations.devices.index', $location->id) }}"
                                            class="text-black dark:text-white hover:underline"
                                            title="Fire Extinguisher">
                                            <i class="fas fa-fire-extinguisher"></i>
                                        </a>
                                    <a href="{{ route('locations.hydrants.index', $location->id) }}"
                                       class="text-black dark:text-white hover:underline"
                                       title="{{ __('Hydrants') }}">
                                        <i class="fas  fa-h-square
"></i>
                                    </a>
                                        {{--                                        href="{{ route('locations.fireExtinguisher', $location->id) }}"--}}
                                        {{--                                        href="{{ route('locations.objectGroups', $location->id) }}"--}}
                                    <a href="{{ route('locations.groups.index', $location->id) }}"

                                       class="ml-2 text-black dark:text-white hover:underline"
                                            title="Object Groups">
                                            <i class="fa-solid fa-layer-group"></i>
                                        </a>
                                        <a href="{{ route('locations.edit', $location->id) }}"
                                           class="text-black dark:text-white hover:underline"
                                           title="{{ __('Edit') }}">
                                            <i class="fas fa-edit"></i> {{ __('') }}
                                        </a>
                                        <a href="{{ route('locations.destroy', $location->id) }}"
                                           onclick="event.preventDefault(); if(confirm('{{ __('Are you sure?') }}')) { document.getElementById('delete-location-mobile-{{ $location->id }}').submit(); }"
                                           class="text-black dark:text-white hover:underline"
                                           title="{{ __('Delete') }}">
                                            <i class="fas fa-trash"></i> {{ __('') }}
                                        </a>
                                        <form id="delete-location-mobile-{{ $location->id }}" action="{{ route('locations.destroy', $location->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-gray-500 dark:text-gray-300">
                                    {{ __('No locations found.') }}
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $locations->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
