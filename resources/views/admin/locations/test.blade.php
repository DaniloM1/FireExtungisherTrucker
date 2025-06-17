<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Locations') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter Forma -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 mb-6">
                <form method="GET" action="{{ route('locations.test') }}">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Location Name
                            </label>
                            <input type="text" name="name" id="name" value="{{ request('name') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Address
                            </label>
                            <input type="text" name="address" id="address" value="{{ request('address') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                City
                            </label>
                            <input type="text" name="city" id="city" value="{{ request('city') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="company" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Company
                            </label>
                            <select name="company" id="company" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                                <option value="">{{ __('Select a Company') }}</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ request('company') == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }} ({{ $company->city }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="service_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Service Date
                            </label>
                            <input type="date" name="next_service_date" id="service_date" value="{{ request('service_date') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end space-x-2">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                        >
                            <i class="fa fa-search mr-2"></i>Pretraži
                        </button>
                        <a href="{{ route('locations.test') }}"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-100 rounded-lg shadow-sm hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-red-400 transition flex items-center"
                            title="Poništi filtere">
                            <i class="fa-solid fa-filter-circle-xmark mr-2"></i>
                        </a>


                    </div>
                </form>
            </div>

            <!-- Prikaz rezultata -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($locations as $location)
                    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-200">
                            {{ $location->name }}
                        </h3>
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            {{ $location->address }}, {{ $location->city }}
                        </p>
                        @if($location->company)
                            <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">
                                <strong>Company:</strong> {{ $location->company->name }}
                            </p>
                        @endif
                        @if($location->serviceEvents->isNotEmpty())
                            @php
                                // Prikazujemo datum narednog servisa iz prvog servisnog događaja
                                $nextServiceDate = $location->serviceEvents->first()->next_service_date ?? null;
                            @endphp
                            <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">
                                <strong>Next Service:</strong>
                                {{ $nextServiceDate ? \Carbon\Carbon::parse($nextServiceDate)->format('d.m.Y') : 'N/A' }}
                            </p>
                        @endif
                        <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">
                            <strong>Devices:</strong> {{ $location->devices->count() }}
                        </p>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center text-gray-500">
                        No locations found.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $locations->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
