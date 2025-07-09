<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kompanije') }}
        </h2>
    </x-slot>

    <!-- Success/Error poruke -->
    <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-100 p-4 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Search form -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        <form id="searchForm" action="{{ route('companies.index') }}" method="GET" class="flex bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="{{ __('Pretraži po nazivu, gradu ili PIB') }}"
                class="flex-grow px-4 py-2 border-0 focus:ring-0 bg-transparent text-gray-900 dark:text-gray-100"
            />
            <button type="submit" class="px-4 bg-blue-500 hover:bg-blue-600 text-white">
                <i class="fas fa-search"></i>
            </button>
            <a href="{{ route('companies.index') }}"
               class="px-4 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-500"
               title="{{ __('Poništi filtere') }}">
                <i class="fa-solid fa-filter-circle-xmark"></i>
            </a>
        </form>
    </div>

    <!-- Lista kompanija kao kartice -->
    <div class="py-6 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('Lista Kompanija') }}</h3>
                <a href="{{ route('companies.create') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                    <i class="fas fa-plus mr-1"></i> {{ __('Dodaj Kompaniju') }}
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($companies as $company)
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5 flex flex-col">
                        <div class="flex justify-between items-start">
                            <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ $company->name }}
                            </h4>
                            @hasrole('super_admin|admin')
                            <a href="{{ route('companies.edit', $company->id) }}"
                               class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                               title="{{ __('Izmeni') }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endhasrole
                        </div>

                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            <i class="fa fa-id-card mr-1"></i>
                            {{ __('PIB') }}: <span class="font-medium">{{ $company->pib }}</span>
                        </p>

                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            <i class="fa fa-map-marker-alt mr-1"></i>
                            {{ $company->address }}, {{ $company->city }}
                        </p>

                        <div class="mt-4 flex flex-wrap gap-2">
                            <div class="flex items-center bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-3 py-1 rounded-md text-xs">
                                <i class="fas fa-envelope mr-1"></i>
                                <a href="mailto:{{ $company->contact_email }}"
                                   class="truncate hover:underline">
                                    {{ $company->contact_email }}
                                </a>
                                <button type="button"
                                        onclick="navigator.clipboard.writeText('{{ $company->contact_email }}')"
                                        class="ml-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                        title="{{ __('Kopiraj email') }}">
                                    <i class="fas fa-copy text-xs"></i>
                                </button>
                            </div>
                            <a href="tel:{{ $company->contact_phone }}"
                               class="flex items-center bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-3 py-1 rounded-md text-xs hover:bg-gray-200 dark:hover:bg-gray-600"
                               title="{{ __('Pozovi') }}">
                                <i class="fas fa-phone mr-1"></i> {{ $company->contact_phone }}
                            </a>
                            <a href="{{ route('companies.locations.index', $company->id) }}"
                               class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium shadow"
                               title="{{ __('Lokacije') }}">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                {{ $company->locations_count ?? $company->locations->count() }} Lokacija
                            </a>

                        </div>

                        <button type="button"
                                onclick="document.getElementById('info-{{ $company->id }}').classList.toggle('hidden')"
                                class="mt-4 text-blue-600 dark:text-blue-400 hover:underline self-start text-sm">
                            {{ __('Više informacija') }}
                        </button>
                        <div id="info-{{ $company->id }}" class="mt-2 text-sm text-gray-700 dark:text-gray-300 hidden space-y-1">
                            @if($company->maticni_broj)
                                <div><strong>{{ __('Matični broj') }}:</strong> {{ $company->maticni_broj }}</div>
                            @endif
                            @if($company->website)
                                <div>
                                    <strong>{{ __('Web') }}:</strong>
                                    <a href="{{ $company->website }}" target="_blank" class="underline">
                                        {{ Str::limit($company->website, 30) }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center text-gray-500 dark:text-gray-300">
                        {{ __('Nema pronađenih kompanija.') }}
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $companies->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
