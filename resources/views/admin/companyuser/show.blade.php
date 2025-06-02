<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalji Servisnog Događaja') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Evidencioni broj</dt>
                        <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $serviceEvent->evid_number }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Datum servisa</dt>
                        <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $serviceEvent->service_date }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Sledeći servis</dt>
                        <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $serviceEvent->next_service_date }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kategorija</dt>
                        <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ ucfirst($serviceEvent->category) }}</dd>
                    </div>

                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Opis</dt>
                        <dd class="mt-1 text-gray-900 dark:text-gray-100 whitespace-pre-line">
                            {{ $serviceEvent->description ?: 'Nema dodatnog opisa.' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Trošak</dt>
                        <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100">
                            {{ number_format($serviceEvent->cost, 2, ',', '.') }} RSD
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                        <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100">
                            {{ ucfirst($serviceEvent->status) }}
                        </dd>
                    </div>

                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Lokacije</dt>
                        <dd class="mt-1 text-gray-900 dark:text-gray-100">
                            <ul class="list-disc pl-5">
                                @foreach ($serviceEvent->locations as $location)
                                    <li>{{ $location->name }} ({{ $location->company->name }})</li>
                                @endforeach
                            </ul>
                        </dd>
                    </div>
                </dl>

                <div class="mt-6 text-right">
                    <a href="{{ route('company.service-events.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                        <i class="fas fa-arrow-left mr-2"></i> Nazad na listu
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
