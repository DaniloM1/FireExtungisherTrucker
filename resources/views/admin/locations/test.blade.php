<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lokacije') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Filter forma -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 mb-6">
                <form method="GET" action="{{ route('locations.test') }}">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Naziv lokacije</label>
                            <input type="text" name="name" id="name" value="{{ request('name') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Adresa</label>
                            <input type="text" name="address" id="address" value="{{ request('address') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Grad</label>
                            <input type="text" name="city" id="city" value="{{ request('city') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="company" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Firma</label>
                            <select name="company" id="company"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Izaberi firmu --</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ request('company') == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }} ({{ $company->city }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end space-x-2">
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
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

            <!-- Prikaz lokacija -->
            @include('admin.locations._list')
        </div>
{{--{{dd($locations)}}--}}
    </div>
    <x-map-card
        :locations="$locations"
        title="Lokacije"
        width="max-w-5xl"
        height="h-200"
    />
    </div>
</x-app-layout>
