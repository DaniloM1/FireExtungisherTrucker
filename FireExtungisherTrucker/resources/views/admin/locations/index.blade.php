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
                    Company <span class="mx-2">&rarr;</span> Locations
                </nav>
            </div>

    </x-slot>

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
                        <h3 class="text-lg font-semibold">{{ __('Location List') }}</h3>
                        <a href="{{ route('locations.create', $company->id) }}"
                           class=" hover:underline">
                            <i class="fas fa-plus"></i> {{ __('Add Location') }}
                        </a>
                    </div>

                    <!-- Responzivni prikaz tablice -->
                    <div class="overflow-x-auto">
                        <!-- Desktop prikaz -->
                        <table class="min-w-full hidden md:table divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Name') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Address') }}
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($locations as $location)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $location->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $location->address }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-4">
                                            <!-- Ikonice za Category -->
                                            <a href="{{ route('locations.devices.index', $location->id) }}"
                                               class="text-black dark:text-white hover:underline"
                                               title="Fire Extinguisher">
                                                <i class="fas fa-fire-extinguisher"></i>
                                            </a>
                                            <a href="{{ route('locationsx.groups.index', $location->id) }}"
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
                                    <div class="text-lg font-semibold">{{ $location->name }}</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">{{ $location->address }}</div>
                                    <div class="mt-2">

                                    </div>
                                    <div class="mt-4 flex items-center space-x-4"">
                                    <a href="{{ route('locations.devices.index', $location->id) }}"
                                            class="text-black dark:text-white hover:underline"
                                            title="Fire Extinguisher">
                                            <i class="fas fa-fire-extinguisher"></i>
                                        </a>
                                        {{--                                        href="{{ route('locations.fireExtinguisher', $location->id) }}"--}}
                                        {{--                                        href="{{ route('locations.objectGroups', $location->id) }}"--}}
                                    <a href="{{ route('locationsx.groups.index', $location->id) }}"

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
