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
                <a href="{{ route('companies.index', $company->id) }}" class="hover:underline">
                    Kompanija
                </a>
                <span class="mx-2">&rarr;</span>
                <span class="text-gray-700 dark:text-gray-300">
                Lokacije
            </span>
            </nav>
        </div>
    </x-slot>
    <div class="py-6 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 mb-6">
        <button
            onclick="document.getElementById('mapSection').scrollIntoView({ behavior: 'smooth' })"
            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow-sm transition"
        >
            <i class="fas fa-map-marked-alt mr-2"></i> Prikaži mapu
        </button>
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

                    @include('admin.locations._list')
                </div>
            </div>
        </div>
        <div id="mapSection" class="mt-8">
            <x-map-card
                :locations="$locations instanceof \Illuminate\Pagination\LengthAwarePaginator
                ? collect($locations->items())
                : $locations"
                title="Lokacije na karti"
                width="max-w-5xl"
                height="h-200"
                :show-list="false"
            />
        </div>
    </div>
</x-app-layout>
