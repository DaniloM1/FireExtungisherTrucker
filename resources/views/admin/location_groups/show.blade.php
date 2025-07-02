<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <div class="text-xl font-bold text-blue-700 dark:text-blue-300 tracking-tight">
                    Grupa lokacija:
                    <span class="ml-2 text-gray-800 dark:text-gray-100">{{ $locationGroup->name }}</span>
                </div>
                <nav class="sm:block text-xs text-gray-400 dark:text-gray-500 mt-1" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1">
                        <li>
                            <a href="{{ route('location-groups.index') }}" class="hover:underline">Grupe lokacija</a>
                        </li>
                        <svg class="w-3 h-3 inline mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <li>
                            <span>{{ $locationGroup->name }}</span>
                        </li>
                    </ol>
                </nav>
                <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $locationGroup->description }}</div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('location-groups.edit', $locationGroup) }}"
                   class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 text-sm flex items-center gap-1"
                   title="Izmeni grupu">
                    <i class="fas fa-edit"></i> Izmeni
                </a>
                <a href="{{ route('service-events.group-service', $locationGroup->id) }}"
                   class="px-3 py-2 rounded bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600 text-sm flex items-center"
                   title="Servis grupe">
                    <i class="fa fa-hammer"> </i>Kreiraj servis
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Lokacije u grupi -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                        <i class="fas fa-map-marked-alt mr-2 text-blue-500"></i>
                        Lokacije u grupi ({{ $locationGroup->locations->count() }})
                    </h3>
                </div>

                @if($locationGroup->locations->isEmpty())
                    <div class="text-gray-400 dark:text-gray-500 text-center py-6">Nema lokacija u ovoj grupi.</div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @foreach($locationGroup->locations as $location)
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                <div>
                                    <div class="font-bold text-blue-700 dark:text-blue-300 text-lg flex items-center gap-1">
                                        <i class="fas fa-location-dot"></i> {{ $location->name }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        Kompanija: <span class="font-semibold">{{ $location->company->name ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="mt-2 text-sm text-gray-700 dark:text-gray-300 flex flex-col gap-1">
                                    @if($location->city)
                                        <span><i class="fas fa-city mr-1"></i> {{ $location->city }}</span>
                                    @endif
                                    @if($location->address)
                                        <span><i class="fas fa-map-marker-alt mr-1"></i> {{ $location->address }}</span>
                                    @endif
                                    @if($location->pib)
                                        <span><i class="fas fa-file-invoice mr-1"></i> PIB: {{ $location->pib }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Mapa svih lokacija u grupi -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">
                    <i class="fas fa-map-location-dot text-blue-500 mr-2"></i> Mapa grupe
                </h3>
                <x-map-card
                    :locations="$locationGroup->locations"
                    title="Lokacije u grupi"
                    width="max-w-3xl"
                    height="h-96"
                />
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    @endpush
</x-app-layout>
