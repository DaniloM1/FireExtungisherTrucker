<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Location Checks') }}
        </h2>

    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Filter forma -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 mb-6">
                <form method="GET" action="{{ route('location_checks.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pretraga</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                   placeholder="Naziv, tip, lokacija..."
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500" />
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tip</label>
                            <select name="type" id="type"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Izaberi tip --</option>
                                <option value="inspection" {{ request('type') == 'inspection' ? 'selected' : '' }}>Inspekcija</option>
                                <option value="test" {{ request('type') == 'test' ? 'selected' : '' }}>Test</option>
                            </select>
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lokacija</label>
                            <input type="text" name="location" id="location" value="{{ request('location') }}"
                                   placeholder="Naziv lokacije"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500" />
                        </div>

                        <div>

                            {{-- Ostavi prazno ili možeš staviti nešto drugo ako treba --}}
                        </div>

                    </div>

                    <div class="mt-4 flex justify-end space-x-2">
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                            <i class="fa fa-search mr-2"></i>Pretraži
                        </button>
                        <a href="{{ route('location_checks.index') }}"
                           class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-100 rounded-lg shadow-sm hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-red-400 transition flex items-center"
                           title="Poništi filtere">
                            <i class="fa-solid fa-filter-circle-xmark mr-2"></i>Poništi filtere
                        </a>
                    </div>
                </form>
            </div>
            <div class=" shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Header s naslovom i linkom za dodavanje nove lokacije -->

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">{{ __('Lista Inspekcija') }}</h3>
                        <a href="{{ route('location_checks.create') }}"
                           class=" hover:underline">
                            <i class="fas fa-plus"></i> {{ __('Dodaj Inspekciju') }}
                        </a>
                    </div>
                </div>
            </div>
            <!-- Lista Location Checks -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($locationChecks as $check)
                    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-5 flex flex-col h-full">
                        <div class="flex justify-between items-start">
                            <a href="{{ route('location_checks.show', $check->id) }}"
                               class="text-lg font-bold text-blue-700 dark:text-blue-400 hover:underline truncate max-w-[70%]"
                               title="{{ $check->name }}">
                                {{ $check->name }}
                            </a>

                            <div class="flex items-center space-x-2">
                                @hasrole('super_admin|admin')
                                <a href="{{ route('location_checks.edit', $check->id) }}"
                                   class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white"
                                   title="Izmeni">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                @endhasrole
                            </div>
                        </div>

                        <div class="mt-2 space-y-2">
                            <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-1"
                               title="{{ $check->location->name ?? 'Nepoznata lokacija' }}">
                                <i class="fa fa-map-marker-alt"></i>
                                {{ $check->location->name ?? 'Nepoznata lokacija' }}
                            </p>

                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <strong>Tip:</strong> {{ ucfirst($check->type) }}
                            </p>

                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <strong>Poslednja inspekcija:</strong> {{ $check->last_performed_date ?? '-' }}
                            </p>

                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <strong>Sledeći termin:</strong> {{ $check->next_due_date ?? '-' }}
                            </p>

                            <p class="text-sm text-gray-600 dark:text-gray-400 truncate" title="{{ $check->inspector->name ?? 'Nije dodeljen' }}">
                                <strong>Inspektor:</strong> {{ $check->inspector->name ?? 'Nije dodeljen' }}
                            </p>
                        </div>

                        @if($check->description)
                            <div class="mt-auto pt-3">
                                <button type="button"
                                        onclick="document.getElementById('desc-{{ $check->id }}').classList.toggle('hidden')"
                                        class="text-blue-600 dark:text-blue-400 hover:underline self-start text-sm transition-colors duration-200">
                                    Više informacija
                                </button>
                                @php
                                $desc = $check->description ?: 'Nema opisa.';
                                $descWithLinks = preg_replace(
                                    '/(https?:\/\/[^\s]+)/',
                                    '<a href="$1" target="_blank" class="text-blue-600 dark:text-blue-400 underline">link</a>',
                                    e($desc)
                                );
                            @endphp

                            <div id="desc-{{ $check->id }}"
                                class="mt-2 text-sm text-gray-700 dark:text-gray-300 hidden break-words whitespace-pre-line">
                                {!! $descWithLinks !!}
                            </div>

                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center text-gray-500 dark:text-gray-300 select-none">
                        Nema pronađenih zapisa.
                    </div>
                @endforelse
            </div>

            @if($locationChecks->hasPages())
                <div class="mt-6">
                    {{ $locationChecks->appends(request()->query())->links() }}
                </div>
            @endif
            <div class="mt-6">
                {{ $locationChecks->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
