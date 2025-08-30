<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <i class="fas fa-clipboard-check mr-2 text-green-500"></i>
            Detalji pregleda / testa
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <a href="{{ route('location_checks.index') }}"
               class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                <i class="fas fa-arrow-left mr-2"></i> Nazad na listu
            </a>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b bg-gray-50 dark:bg-gray-700 border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 flex items-center gap-3">
                            #{{ $locationCheck->id }}
                            @hasrole('super_admin|admin')
                            <a href="{{ route('location_checks.edit', $locationCheck) }}"
                               class="text-gray-600 dark:text-gray-300 hover:text-gray-900 ml-2" title="Uredi">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endhasrole
                        </h3>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $locationCheck->type === 'test'
                                ? 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200'
                                : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                            {{ ucfirst($locationCheck->type) }}
                        </span>
                    </div>
                </div>

                <div class="p-8">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                    <i class="fas fa-calendar-day mr-2"></i> Poslednji termin
                                </dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $locationCheck->last_performed_date?->format('d.m.Y') ?? '‑' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                    <i class="fas fa-calendar-check mr-2"></i> Sledeći termin
                                </dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $locationCheck->next_due_date?->format('d.m.Y') ?? '‑' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                    <i class="fas fa-user mr-2"></i> Inspektor
                                </dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $locationCheck->inspector->name ?? 'Nije dodeljen' }}
                                </dd>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                    <i class="fas fa-building mr-2"></i> Kompanija
                                </dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $locationCheck->location->company->name ?? '‑' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2"></i> Lokacija
                                </dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $locationCheck->location->name }} – {{ $locationCheck->location->city }}
                                </dd>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                <i class="fas fa-align-left mr-2"></i> Opis
                            </dt>
                            @php
                            $description = $locationCheck->description ?: 'Nema opisa.';
                            $descriptionWithLinks = preg_replace(
                                '/(https?:\/\/[^\s]+)/',
                                '<a href="$1" target="_blank" class="text-blue-600 dark:text-blue-400 underline">Otvori link</a>',
                                e($description)
                            );
                        @endphp
                        
                        <dd class="mt-2 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-800 dark:text-gray-200 whitespace-pre-line">
                            {!! $descriptionWithLinks !!}
                        </dd>
                        
                        
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
