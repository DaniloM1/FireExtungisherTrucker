<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($locations as $location)
        @php
            $hasCoords = $location->latitude && $location->longitude;
        @endphp
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-5 flex flex-col h-full">
            <div class="flex justify-between items-start">
                <div>
                    <a href="@role('super_admin|admin')
                                 {{ route('locations.show', $location->id) }}
                             @else
                                 {{ route('company.locations.show', $location->id) }}
                             @endrole"
                       class="text-lg font-bold text-blue-700 dark:text-blue-400 hover:underline">
                        {{ $location->name }}
                    </a>
                </div>
                <div class="flex items-center space-x-2">
                    {{-- indikator koordinata --}}
                    <span
                        class="flex items-center text-gray-400"
                        title="{{ $hasCoords ? __('Validne koordinate') : __('Nema koordinata') }}"
                    >
                        <i class="fas fa-map-marker-alt text-xs {{ $hasCoords ? 'opacity-75' : 'opacity-25' }}"></i>
                    </span>

                    {{-- dugme za edit samo za super_admin/admin --}}
                    @hasrole('super_admin|admin')
                    <a href="{{ route('locations.edit', $location->id) }}"
                       class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white"
                       title="{{ __('Edit') }}">
                        <i class="fas fa-edit text-sm"></i>
                    </a>
                    @endhasrole
                </div>
            </div>

            @hasrole('super_admin|admin')
            @if($location->company)
                <a href="{{ route('companies.show', $location->company->id) }}"
                   class="text-sm text-gray-700 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-300 block mt-1 mb-2">
                    <i class="fa fa-building text-xs mr-1"></i>
                    {{ $location->company->name }}
                </a>
            @endif
            @endhasrole

            <p class="text-xs text-gray-500 dark:text-gray-400">
                <i class="fa fa-map-marker-alt mr-1"></i>
                {{ $location->address }}, {{ $location->city }}
            </p>

            <div class="flex items-center gap-4 mt-3">
                <div class="flex items-center gap-4 mt-3">
                    {{-- Aparati --}}
                    <a href="@role('super_admin|admin'){{ route('locations.devices.index', $location->id) }}@else{{ route('company.locations.devices.index', $location->id) }}@endrole"
                       class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-3 py-1 rounded-md text-xs font-medium hover:bg-gray-200 dark:hover:bg-gray-600"
                       title="{{ __('Pogledaj aparate') }}">
                        Aparati: <span class="font-bold">{{ $location->devices_count ?? $location->devices->count() }}</span>
                    </a>

                    {{-- Hidranti --}}
                    <a href="@role('super_admin|admin'){{ route('locations.hydrants.index', $location->id) }}@else{{ route('company.locations.hydrants.index', $location->id) }}@endrole"
                       class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-3 py-1 rounded-md text-xs font-medium hover:bg-gray-200 dark:hover:bg-gray-600"
                       title="{{ __('Pogledaj hidrante') }}">
                        Hidranti: <span class="font-bold">{{ $location->hydrants_count ?? $location->hydrants->count() }}</span>
                    </a>
                </div>

            </div>

            @php
                $nextServiceEvent = $location->serviceEvents()
                    ->where('service_events.status', 'active')
                    ->where('service_events.next_service_date', '>=', now())
                    ->orderBy('service_events.next_service_date')
                    ->first();
            @endphp
            <div class="mt-3">
                <span class="text-sm text-gray-700 dark:text-gray-300">
                    <strong>Sledeći servis:</strong>
                    @if($nextServiceEvent)
                        <a href="{{ auth()->user()->hasRole('super_admin|admin')
                            ? route('service-events.show', $nextServiceEvent->id)
                            : route('company.service-events.show', $nextServiceEvent->id) }}"
                           class="text-blue-700 dark:text-blue-400 underline hover:no-underline font-semibold"
                           title="Prikaži servisni događaj">
                            {{ \Carbon\Carbon::parse($nextServiceEvent->next_service_date)->format('d.m.Y') }}
                        </a>
                    @else
                        <span class="text-gray-400">Nema dostupnog datuma</span>
                    @endif
                </span>
            </div>
        </div>
    @empty
        <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center text-gray-500 dark:text-gray-300">
            Nema pronađenih lokacija.
        </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $locations->appends(request()->query())->links() }}
</div>
